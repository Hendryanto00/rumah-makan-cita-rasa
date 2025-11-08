<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        // Handle GET requests (health checks from Midtrans)
        if ($request->isMethod('get')) {
            Log::info('Midtrans health check received');
            return response()->json(['message' => 'OK'], 200);
        }
        
        Log::info('Midtrans POST notification received', [
            'headers' => $request->headers->all(),
            'all' => $request->all()
        ]);
        
        try {
            $notification = $request->all();
            
            // Extract order_id from the notification
            $orderIdStr = $notification['order_id'] ?? '';
            
            // Parse order_id (format: ORDER-{order_id}-{timestamp})
            if (preg_match('/ORDER-(\d+)-/', $orderIdStr, $matches)) {
                $orderId = $matches[1];
            } else {
                Log::error('Invalid order ID format', ['order_id' => $orderIdStr]);
                return response()->json(['message' => 'Invalid order ID'], 400);
            }
            
            $order = Order::findOrFail($orderId);
            
            DB::beginTransaction();
            
            // Update payment status based on notification
            $transactionStatus = $notification['transaction_status'];
            $fraudStatus = $notification['fraud_status'] ?? 'accept';
            
            Log::info('Processing notification', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);
            
            $payment = $order->payment;
            
            if (!$payment) {
                Log::error('Payment not found for order', ['order_id' => $orderId]);
                DB::rollBack();
                return response()->json(['message' => 'Payment not found'], 404);
            }
            
            // Update payment method from notification
            if (isset($notification['payment_type'])) {
                $paymentType = $notification['payment_type'];
                // Map Midtrans payment types to readable names
                $paymentMethodMap = [
                    'credit_card' => 'Credit Card',
                    'bca_klikpay' => 'BCA KlikPay',
                    'bca_klikbca' => 'KlikBCA',
                    'bri_epay' => 'BRI E-Pay',
                    'mandiri_clickpay' => 'Mandiri Clickpay',
                    'permata_va' => 'Permata VA',
                    'bca_va' => 'BCA VA',
                    'bni_va' => 'BNI VA',
                    'bri_va' => 'BRI VA',
                    'mandiri_va' => 'Mandiri VA',
                    'cimb_va' => 'CIMB VA',
                    'eci' => 'BCA KlikPay',
                    'bca_klikbca' => 'KlikBCA',
                    'gopay' => 'GoPay',
                    'shopee_pay' => 'ShopeePay',
                    'qris' => 'QRIS',
                    'indomaret' => 'Indomaret',
                    'alfamart' => 'Alfamart',
                ];
                
                $paymentMethod = $paymentMethodMap[$paymentType] ?? ucfirst(str_replace('_', ' ', $paymentType));
                $payment->payment_method = $paymentMethod;
                Log::info('Payment method updated', [
                    'order_id' => $orderId,
                    'payment_type' => $paymentType,
                    'payment_method' => $paymentMethod
                ]);
            }
            
            // Map Midtrans statuses to database enum values
            // transaction_status possible values: pending, settlement, capture, deny, expire, cancel, refund, partial_refund, partial_charge_back, charge_back
            // payment_status enum: 'pending', 'sukses', 'gagal'
            // order status enum: 'pending', 'paid', 'diproses', 'selesai', 'batal'
            
            switch ($transactionStatus) {
                case 'settlement':
                case 'capture':
                    // Payment successful
                    if ($fraudStatus == 'accept') {
                        $payment->payment_status = 'sukses';
                        $payment->transaction_id = $notification['transaction_id'] ?? $payment->transaction_id;
                        $payment->paid_at = now();
                        $payment->save(); // This will include the updated payment_method if it was set above
                        
                        // Update order status to paid
                        $order->status = 'paid';
                        $order->save();
                        
                        // Clear cart after successful payment
                        if ($order->user && $order->user->cart) {
                            $order->user->cart->items()->delete();
                        }
                        
                        Log::info('Payment successful', ['order_id' => $orderId]);
                    }
                    break;
                    
                case 'pending':
                    // Payment is pending
                    $payment->payment_status = 'pending';
                    $payment->transaction_id = $notification['transaction_id'] ?? $payment->transaction_id;
                    $payment->save(); // This will include the updated payment_method if it was set above
                    
                    $order->status = 'pending';
                    $order->save();
                    
                    Log::info('Payment pending', ['order_id' => $orderId]);
                    break;
                    
                case 'deny':
                case 'expire':
                case 'cancel':
                case 'refund':
                case 'charge_back':
                    // Payment failed - kembalikan stock menu
                    $payment->payment_status = 'gagal';
                    $payment->transaction_id = $notification['transaction_id'] ?? $payment->transaction_id;
                    $payment->save(); // This will include the updated payment_method if it was set above
                    
                    $order->status = 'batal';
                    $order->save();
                    
                    // Kembalikan stock menu yang sudah dikurangi saat order dibuat
                    $order->load('details.menu');
                    foreach ($order->details as $detail) {
                        $menu = Menu::find($detail->menu_id);
                        if ($menu) {
                            $menu->stock += $detail->quantity;
                            $menu->save();
                        }
                    }
                    
                    Log::info('Payment failed', ['order_id' => $orderId, 'status' => $transactionStatus]);
                    break;
                    
                default:
                    Log::warning('Unknown transaction status', [
                        'order_id' => $orderId,
                        'status' => $transactionStatus
                    ]);
                    break;
            }
            
            // Handle fraud_status denial
            if ($fraudStatus == 'deny') {
                $payment->payment_status = 'gagal';
                $payment->save(); // This will include the updated payment_method if it was set above
                
                // Simpan status order sebelumnya untuk cek apakah stock sudah dikembalikan
                $previousOrderStatus = $order->status;
                $order->status = 'batal';
                $order->save();
                
                // Kembalikan stock menu jika belum dikembalikan (jika order status sebelumnya bukan 'batal')
                if ($previousOrderStatus !== 'batal' && 
                    !in_array($transactionStatus, ['deny', 'expire', 'cancel', 'refund', 'charge_back'])) {
                    $order->load('details.menu');
                    foreach ($order->details as $detail) {
                        $menu = Menu::find($detail->menu_id);
                        if ($menu) {
                            $menu->stock += $detail->quantity;
                            $menu->save();
                        }
                    }
                }
                
                Log::info('Payment denied by fraud status', ['order_id' => $orderId]);
            }
            
            DB::commit();
            
            return response()->json(['message' => 'OK'], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment notification error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'notification' => $notification ?? null
            ]);
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }
}
