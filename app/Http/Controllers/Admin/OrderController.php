<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     * Admin dapat memantau semua pesanan pelanggan yang masuk ke sistem dan update status pesanan.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'details.menu', 'payment'])
            ->latest('order_date');

        // Filter by status
        $status = $request->input('status', 'all');
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Search by order ID or customer name
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%")
                                ->orWhere('email', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $orders = $query->paginate(15)->withQueryString();
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     * Admin dapat membaca detail lengkap pesanan (user, item, harga, status, dsb).
     */
    public function show(Request $request, $order)
    {
        // Get order by ID (handle both object and ID from route model binding)
        if (is_object($order) && $order instanceof Order) {
            $order = $order;
        } else {
            $order = Order::findOrFail($order);
        }
        
        $order->load(['user', 'details.menu', 'payment']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of the order.
     */
    public function updateStatus(Request $request, $order)
    {
        // Get order by ID (handle both object and ID from route model binding)
        if (is_object($order) && $order instanceof Order) {
            $order = $order;
        } else {
            $order = Order::findOrFail($order);
        }
        
        $request->validate([
            'status' => 'required|in:pending,paid,diproses,selesai,batal'
        ]);

        $oldStatus = $order->status;
        $order->update([
            'status' => $request->status
        ]);

        // Log activity
        ActivityLogger::log(
            'Ubah Status Pesanan',
            'orders',
            $order->id,
            sprintf('Mengubah status pesanan dari "%s" menjadi "%s".', $oldStatus, $order->status)
        );

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Status pesanan berhasil diperbarui');
    }
}

