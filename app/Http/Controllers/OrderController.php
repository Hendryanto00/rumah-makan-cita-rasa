<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Menu;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $status = $request->query('status'); // pending|paid|diproses|selesai|batal|all|null
        
        $ordersQuery = Order::where('user_id', $user->id)
            ->with(['details.menu', 'payment'])
            ->latest();

        if ($status && $status !== 'all') {
            $ordersQuery->where('status', $status);
        }
        
        // Optional: if user hanya ingin melihat yang punya pembayaran valid
        // tetap tampilkan semuanya karena history mencakup seluruh status
        $orders = $ordersQuery->paginate(10)->withQueryString();
        
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Keranjang kosong'], 400);
            }
            return back()->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();
        try {
            // Validasi stock sebelum membuat order
            foreach ($cart->items as $ci) {
                $menu = Menu::findOrFail($ci->menu_id);
                if ($menu->stock < $ci->quantity) {
                    DB::rollBack();
                    $message = "Stok menu '{$menu->name}' tidak cukup. Stok tersedia: {$menu->stock}, dibutuhkan: {$ci->quantity}";
                    if ($request->expectsJson()) {
                        return response()->json(['message' => $message], 400);
                    }
                    return back()->with('error', $message);
                }
            }

            $total = $cart->items->sum('subtotal');
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending'
            ]);

            foreach ($cart->items as $ci) {
                $menu = Menu::findOrFail($ci->menu_id);
                
                // Kurangi stock menu
                $menu->stock -= $ci->quantity;
                $menu->save();
                
                $order->details()->create([
                    'menu_id' => $ci->menu_id,
                    'quantity' => $ci->quantity,
                    'price' => $ci->menu->price,
                    'subtotal' => $ci->subtotal,
                    'notes' => $ci->notes,
                ]);
            }

            // Midtrans config
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $transaction = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount' => (int) $total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                    'item_details' => $order->details()->with('menu')->get()->map(function ($d) {
                        return [
                            'id' => $d->menu_id,
                            'price' => (int)$d->price,
                            'quantity' => (int)$d->quantity,
                            'name' => $d->menu->name
                        ];
                    })->toArray(),
            ];

            $snapToken = Snap::getSnapToken($transaction);

            // Save payment with snap_token
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'snap',
                'payment_status' => 'pending',
                'amount' => $total,
                'snap_token' => $snapToken,
            ]);

            DB::commit();

            // JANGAN langsung hapus keranjang - biarkan user bisa kembali ke keranjang jika batal bayar
            // Keranjang akan dihapus hanya setelah pembayaran berhasil (settlement)

            // Reload order with relationships for the view
            $order->load(['details.menu']);
            
            // Handle AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'order_id' => $order->id,
                    'redirect_url' => '/payment/snap?token=' . $snapToken . '&order=' . $order->id
                ]);
            }

            // Regular request - return view
            return view('payment.snap', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
            }
            
            throw $e;
        }
    }

    public function continuePayment(Request $request, $order)
    {
        $user = auth()->user();
        
        if (!$user) {
            Log::error('User not authenticated for continuePayment');
            abort(403, 'User not authenticated');
        }
        
        // Get order by ID (handle both object and ID from route model binding)
        if (is_object($order) && $order instanceof Order) {
            // Route model binding worked, use the order directly
            $order = $order;
        } else {
            // Route model binding didn't work, get order by ID
            $order = Order::findOrFail($order);
        }
        
        Log::info('continuePayment check', [
            'order_id' => $order->id,
            'order_user_id' => $order->user_id,
            'current_user_id' => $user->id,
            'match' => $order->user_id == $user->id,
            'request_route' => $request->route()->getName(),
            'request_url' => $request->fullUrl()
        ]);
        
        // Verify this order belongs to the current user
        if ($order->user_id != $user->id) {
            Log::warning('Unauthorized access attempt', [
                'order_id' => $order->id,
                'order_user_id' => $order->user_id,
                'current_user_id' => $user->id
            ]);
            abort(403, 'Unauthorized access to this order');
        }
        
        // Only allow continuing payment for pending orders
        if ($order->payment->payment_status !== 'pending') {
            return redirect()->route('orders.index')->with('error', 'Pembayaran untuk order ini tidak dapat dilanjutkan');
        }
        
        // Load the order with details
        $order->load(['details.menu']);
        
        // Get the stored snap token
        $snapToken = $order->payment->snap_token;
        
        if (!$snapToken) {
            // If no snap token stored, regenerate it
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;
            
            $transaction = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount' => (int) $order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => $order->details->map(function ($d) {
                    return [
                        'id' => $d->menu_id,
                        'price' => (int)$d->price,
                        'quantity' => (int)$d->quantity,
                        'name' => $d->menu->name
                    ];
                })->toArray(),
            ];
            
            $snapToken = Snap::getSnapToken($transaction);
            
            // Save the new token
            $order->payment->snap_token = $snapToken;
            $order->payment->save();
        }
        
        return view('payment.snap', compact('snapToken', 'order'));
    }
    
    public function downloadInvoice(Request $request, $order)
    {
        $user = auth()->user();
        
        if (!$user) {
            Log::error('User not authenticated for downloadInvoice');
            abort(403, 'User not authenticated');
        }
        
        // Get order by ID (handle both object and ID from route model binding)
        if (is_object($order) && $order instanceof Order) {
            // Route model binding worked, use the order directly
            $order = $order;
        } else {
            // Route model binding didn't work, get order by ID
            $order = Order::findOrFail($order);
        }
        
        Log::info('downloadInvoice check', [
            'order_id' => $order->id,
            'order_user_id' => $order->user_id,
            'current_user_id' => $user->id,
            'user_role' => $user->role->name ?? 'no role',
            'request_route' => $request->route()->getName(),
            'request_url' => $request->fullUrl()
        ]);
        
        // Allow admin to access any order invoice, or verify this order belongs to the current user
        $isAdmin = $user->role && $user->role->name === 'admin';
        if (!$isAdmin && $order->user_id != $user->id) {
            Log::warning('Unauthorized invoice download attempt', [
                'order_id' => $order->id,
                'order_user_id' => $order->user_id,
                'current_user_id' => $user->id,
                'is_admin' => $isAdmin
            ]);
            abort(403, 'Unauthorized access to this order');
        }
        
        // Load the order with all necessary relationships
        $order->load(['details.menu', 'user', 'payment']);
        
        // Generate PDF
        $pdf = Pdf::loadView('orders.invoice', compact('order'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial'
            ]);
        
        // Generate filename
        $filename = 'Invoice_Order_' . $order->id . '_' . $order->created_at->format('Y-m-d') . '.pdf';
        
        // Return PDF download
        return $pdf->download($filename);
    }

    public function show(Request $request, $order)
    {
        $user = auth()->user();
        
        if (!$user) {
            Log::error('User not authenticated for show order');
            abort(403, 'User not authenticated');
        }
        
        // Get order by ID (handle both object and ID from route model binding)
        if (is_object($order) && $order instanceof Order) {
            // Route model binding worked, use the order directly
            $order = $order;
        } else {
            // Route model binding didn't work, get order by ID
            $order = Order::findOrFail($order);
        }
        
        Log::info('show order check', [
            'order_id' => $order->id,
            'order_user_id' => $order->user_id,
            'current_user_id' => $user->id,
            'match' => $order->user_id == $user->id,
            'request_route' => $request->route()->getName(),
            'request_url' => $request->fullUrl()
        ]);
        
        if ($order->user_id != $user->id) {
            Log::warning('Unauthorized order view attempt', [
                'order_id' => $order->id,
                'order_user_id' => $order->user_id,
                'current_user_id' => $user->id
            ]);
            abort(403, 'Unauthorized access to this order');
        }
        
        $order->load(['details.menu', 'payment', 'user']);
        return view('orders.show', compact('order'));
    }
}