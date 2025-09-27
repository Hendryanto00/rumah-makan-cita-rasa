<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart;
        if (!$cart || $cart->items->isEmpty()) return back()->with('error', 'Keranjang kosong');

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
                ]);
            }

            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'snap',
                'payment_status' => 'pending',
                'amount' => $total,
            ]);
            
            // Midtrans config (dapat dari .env)
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

            DB::commit();

            // Kosongkan keranjang
            $cart->items()->delete();

            // kembalikan token ke view agar frontend memanggil snap.js
            return view('payment.snap', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}