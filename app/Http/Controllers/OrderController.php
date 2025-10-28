<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Show orders that are either pending payment or successfully paid
        // Exclude failed/cancelled orders
        $orders = Order::where('user_id', $user->id)
            ->whereHas('payment', function($query) {
                $query->whereIn('payment_status', ['pending', 'sukses']);
            })
            ->with(['details.menu', 'payment'])
            ->latest()
            ->paginate(10);
        
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
            $total = $cart->items->sum('subtotal');
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending'
            ]);

            foreach ($cart->items as $ci) {
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

    public function continuePayment(Order $order)
    {
        $user = auth()->user();
        
        // Verify this order belongs to the current user
        if ($order->user_id !== $user->id) {
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
}