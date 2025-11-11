<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\User;
use App\Models\Review;
use App\Models\Category;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Statistics
        $totalOrders = Order::count();
        $totalCustomers = User::whereHas('role', function($query) {
            $query->where('name', 'user');
        })->count();
        
        // Total Revenue (hanya dari pembayaran yang sukses dan sudah dibayar)
        $totalRevenue = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->sum('amount');
        
        // Revenue Today
        $revenueToday = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereDate('paid_at', today())
            ->sum('amount');
        
        // Revenue This Month
        $revenueThisMonth = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');
        
        // Revenue Last Month
        $revenueLastMonth = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereMonth('paid_at', now()->subMonth()->month)
            ->whereYear('paid_at', now()->subMonth()->year)
            ->sum('amount');
        
        // Calculate revenue growth
        $revenueGrowth = $revenueLastMonth > 0 
            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 2)
            : 0;
        
        // Order Statistics
        $pendingOrders = Order::where('status', 'pending')->count();
        $paidOrders = Order::where('status', 'paid')->count();
        $processingOrders = Order::where('status', 'diproses')->count();
        $completedOrders = Order::where('status', 'selesai')->count();
        $cancelledOrders = Order::where('status', 'batal')->count();
        
        // Successful Orders (with successful payment)
        $successfulOrders = Order::whereHas('payment', function($query) {
            $query->where('payment_status', 'sukses');
        })->count();
        
        // Average Order Value
        $averageOrderValue = $successfulOrders > 0 
            ? $totalRevenue / $successfulOrders 
            : 0;
        
        // Recent Orders
        $recentOrders = Order::with(['user', 'payment'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Top Selling Menus (dengan revenue)
        $topSellingMenus = Menu::select(
                'menus.id',
                'menus.name',
                'menus.price',
                'menus.description',
                'menus.stock',
                'menus.is_active',
                'menus.category_id',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue')
            )
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', 'sukses')
            ->whereNotNull('payments.paid_at')
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'menus.description', 'menus.stock', 'menus.is_active', 'menus.category_id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        // Revenue by Category
        $revenueByCategory = Category::select(
                'categories.id',
                'categories.name',
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue'),
                DB::raw('SUM(order_details.quantity) as total_sold')
            )
            ->join('menus', 'categories.id', '=', 'menus.category_id')
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', 'sukses')
            ->whereNotNull('payments.paid_at')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->get();
        
        // Sales Trend (Last 7 Days)
        $salesTrend = [];
        $dayNames = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        $dayNamesShort = [
            'Sunday' => 'Min',
            'Monday' => 'Sen',
            'Tuesday' => 'Sel',
            'Wednesday' => 'Rab',
            'Thursday' => 'Kam',
            'Friday' => 'Jum',
            'Saturday' => 'Sab'
        ];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayRevenue = Payment::where('payment_status', 'sukses')
                ->whereNotNull('paid_at')
                ->whereDate('paid_at', $date)
                ->sum('amount');
            
            $dayOrders = Order::whereHas('payment', function($query) use ($date) {
                $query->where('payment_status', 'sukses')
                      ->whereNotNull('paid_at')
                      ->whereDate('paid_at', $date);
            })->count();
            
            $dayName = $date->format('l');
            $salesTrend[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('d M'),
                'day_short' => $dayNamesShort[$dayName] ?? $date->format('D'),
                'day_full' => $dayNames[$dayName] ?? $dayName,
                'revenue' => $dayRevenue,
                'orders' => $dayOrders
            ];
        }
        
        // Sales Trend (Last 6 Months)
        $monthlySalesTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $monthRevenue = Payment::where('payment_status', 'sukses')
                ->whereNotNull('paid_at')
                ->whereBetween('paid_at', [$monthStart, $monthEnd])
                ->sum('amount');
            
            $monthOrders = Order::whereHas('payment', function($query) use ($monthStart, $monthEnd) {
                $query->where('payment_status', 'sukses')
                      ->whereNotNull('paid_at')
                      ->whereBetween('paid_at', [$monthStart, $monthEnd]);
            })->count();
            
            $monthlySalesTrend[] = [
                'month' => $month->format('M Y'),
                'month_short' => $month->format('M'),
                'revenue' => $monthRevenue,
                'orders' => $monthOrders
            ];
        }
        
        // Reviews Statistics
        $totalReviews = Review::count();
        $approvedReviews = Review::where('status', 'approved')->count();
        $averageRating = Review::where('status', 'approved')->avg('rating');
        $averageRating = $averageRating ? round($averageRating, 2) : 0;
        
        // Low Stock Items
        $lowStockMenus = Menu::where('stock', '<', 10)
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();
        
        // Active Menus
        $activeMenus = Menu::where('is_active', true)->count();
        $inactiveMenus = Menu::where('is_active', false)->count();
        
        return view('owner.dashboard', compact(
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'revenueToday',
            'revenueThisMonth',
            'revenueLastMonth',
            'revenueGrowth',
            'pendingOrders',
            'paidOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'successfulOrders',
            'averageOrderValue',
            'recentOrders',
            'topSellingMenus',
            'revenueByCategory',
            'salesTrend',
            'monthlySalesTrend',
            'totalReviews',
            'approvedReviews',
            'averageRating',
            'lowStockMenus',
            'activeMenus',
            'inactiveMenus'
        ));
    }
}

