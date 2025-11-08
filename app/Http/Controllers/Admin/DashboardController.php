<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\User;
use App\Models\Review;
use App\Models\Category;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Order Statistics
        $pendingOrders = Order::where('status', 'pending')->count();
        $paidOrders = Order::where('status', 'paid')->count();
        $processingOrders = Order::where('status', 'diproses')->count();
        $completedOrders = Order::where('status', 'selesai')->count();
        $cancelledOrders = Order::where('status', 'batal')->count();
        
        // Recent Orders
        $recentOrders = Order::with(['user', 'payment'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Low Stock Items
        $lowStockMenus = Menu::where('stock', '<', 10)
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();
        
        // Top Selling Menus
        $topSellingMenus = Menu::select(
                'menus.id',
                'menus.name',
                'menus.price',
                'menus.description',
                'menus.stock',
                'menus.is_active',
                'menus.category_id',
                DB::raw('SUM(order_details.quantity) as total_sold')
            )
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', 'sukses')
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'menus.description', 'menus.stock', 'menus.is_active', 'menus.category_id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'pendingOrders',
            'paidOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'recentOrders',
            'lowStockMenus',
            'topSellingMenus'
        ));
    }
}

