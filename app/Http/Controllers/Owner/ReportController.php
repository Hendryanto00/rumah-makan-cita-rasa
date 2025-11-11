<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\User;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Laporan Harian Penjualan
     * Owner melihat laporan penjualan secara harian (jumlah penjualan, omzet, pelanggan, menu populer).
     */
    public function dailyReport(Request $request)
    {
        // Default ke hari ini jika tidak ada filter
        $selectedDate = $request->input('date', now()->format('Y-m-d'));
        try {
            $date = Carbon::parse($selectedDate);
        } catch (\Exception $e) {
            $selectedDate = now()->format('Y-m-d');
            $date = Carbon::parse($selectedDate);
        }
        
        // Total pesanan hari ini
        $totalOrders = Order::whereHas('payment', function($query) use ($date) {
            $query->where('payment_status', 'sukses')
                  ->whereNotNull('paid_at')
                  ->whereDate('paid_at', $date);
        })->count();
        
        // Total omzet hari ini
        $totalRevenue = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereDate('paid_at', $date)
            ->sum('amount');
        
        // Jumlah pelanggan unik yang berbelanja hari ini
        $totalCustomers = Order::whereHas('payment', function($query) use ($date) {
            $query->where('payment_status', 'sukses')
                  ->whereNotNull('paid_at')
                  ->whereDate('paid_at', $date);
        })->distinct('user_id')->count('user_id');
        
        // Menu populer hari ini (top 10)
        $popularMenus = Menu::select(
                'menus.id',
                'menus.name',
                'menus.price',
                'categories.name as category_name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue')
            )
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->leftJoin('categories', 'menus.category_id', '=', 'categories.id')
            ->where('payments.payment_status', 'sukses')
            ->whereNotNull('payments.paid_at')
            ->whereDate('payments.paid_at', $date)
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        // Detail pesanan hari ini
        $orders = Order::with(['user', 'details.menu', 'payment'])
            ->whereHas('payment', function($query) use ($date) {
                $query->where('payment_status', 'sukses')
                      ->whereNotNull('paid_at')
                      ->whereDate('paid_at', $date);
            })
            ->latest('order_date')
            ->get();
        
        // Rata-rata nilai pesanan
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        return view('owner.reports.daily', compact(
            'selectedDate',
            'date',
            'totalOrders',
            'totalRevenue',
            'totalCustomers',
            'popularMenus',
            'orders',
            'averageOrderValue'
        ));
    }
    
    /**
     * Download Daily Report as PDF
     */
    public function dailyReportPdf(Request $request)
    {
        $request->merge(['date' => $request->input('date', now()->format('Y-m-d'))]);
        // Reuse the logic from dailyReport
        $selectedDate = $request->input('date', now()->format('Y-m-d'));
        try {
            $date = Carbon::parse($selectedDate);
        } catch (\Exception $e) {
            $selectedDate = now()->format('Y-m-d');
            $date = Carbon::parse($selectedDate);
        }
        $totalOrders = Order::whereHas('payment', function($query) use ($date) {
            $query->where('payment_status', 'sukses')
                  ->whereNotNull('paid_at')
                  ->whereDate('paid_at', $date);
        })->count();
        $totalRevenue = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereDate('paid_at', $date)
            ->sum('amount');
        $totalCustomers = Order::whereHas('payment', function($query) use ($date) {
            $query->where('payment_status', 'sukses')
                  ->whereNotNull('paid_at')
                  ->whereDate('paid_at', $date);
        })->distinct('user_id')->count('user_id');
        $popularMenus = Menu::select(
                'menus.id','menus.name','menus.price','categories.name as category_name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue')
            )
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->leftJoin('categories', 'menus.category_id', '=', 'categories.id')
            ->where('payments.payment_status', 'sukses')
            ->whereNotNull('payments.paid_at')
            ->whereDate('payments.paid_at', $date)
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        $orders = Order::with(['user', 'details.menu', 'payment'])
            ->whereHas('payment', function($query) use ($date) {
                $query->where('payment_status', 'sukses')
                      ->whereNotNull('paid_at')
                      ->whereDate('paid_at', $date);
            })
            ->latest('order_date')
            ->get();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        if ($totalOrders == 0 && $totalRevenue == 0) {
            return redirect()->route('owner.reports.daily', ['date' => $selectedDate])
                ->with('error', 'Tidak ada data untuk tanggal tersebut.');
        }

        $pdf = Pdf::loadView('owner.reports.pdf.daily', compact(
            'selectedDate','date','totalOrders','totalRevenue','totalCustomers','popularMenus','orders','averageOrderValue'
        ))->setPaper('a4', 'portrait');

        $filename = 'laporan-harian-' . $date->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Laporan Bulanan Penjualan
     * Owner melihat laporan penjualan bulanan (total penjualan, menu laris, ringkasan transaksi).
     */
    public function monthlyReport(Request $request)
    {
        // Default ke bulan ini jika tidak ada filter
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        try {
            $month = Carbon::parse($selectedMonth . '-01');
        } catch (\Exception $e) {
            $selectedMonth = now()->format('Y-m');
            $month = Carbon::parse($selectedMonth . '-01');
        }
        $monthStart = $month->copy()->startOfMonth();
        $monthEnd = $month->copy()->endOfMonth();
        
        // Total pesanan bulan ini
        $totalOrders = Order::whereHas('payment', function($query) use ($monthStart, $monthEnd) {
            $query->where('payment_status', 'sukses')
                  ->whereNotNull('paid_at')
                  ->whereBetween('paid_at', [$monthStart, $monthEnd]);
        })->count();
        
        // Total omzet bulan ini
        $totalRevenue = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$monthStart, $monthEnd])
            ->sum('amount');
        
        // Jumlah pelanggan unik bulan ini
        $totalCustomers = Order::whereHas('payment', function($query) use ($monthStart, $monthEnd) {
            $query->where('payment_status', 'sukses')
                  ->whereNotNull('paid_at')
                  ->whereBetween('paid_at', [$monthStart, $monthEnd]);
        })->distinct('user_id')->count('user_id');
        
        // Menu laris bulan ini (top 10)
        $topMenus = Menu::select(
                'menus.id',
                'menus.name',
                'menus.price',
                'categories.name as category_name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue')
            )
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->leftJoin('categories', 'menus.category_id', '=', 'categories.id')
            ->where('payments.payment_status', 'sukses')
            ->whereNotNull('payments.paid_at')
            ->whereBetween('payments.paid_at', [$monthStart, $monthEnd])
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        // Ringkasan transaksi per hari dalam bulan
        $dailySummary = [];
        $currentDay = $monthStart->copy();
        while ($currentDay <= $monthEnd) {
            $dayRevenue = Payment::where('payment_status', 'sukses')
                ->whereNotNull('paid_at')
                ->whereDate('paid_at', $currentDay)
                ->sum('amount');
            
            $dayOrders = Order::whereHas('payment', function($query) use ($currentDay) {
                $query->where('payment_status', 'sukses')
                      ->whereNotNull('paid_at')
                      ->whereDate('paid_at', $currentDay);
            })->count();
            
            $dailySummary[] = [
                'date' => $currentDay->format('Y-m-d'),
                'day' => $currentDay->format('d'),
                'day_name' => $currentDay->format('D'),
                'revenue' => $dayRevenue,
                'orders' => $dayOrders
            ];
            
            $currentDay->addDay();
        }
        
        // Rata-rata nilai pesanan
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Perbandingan dengan bulan sebelumnya
        $prevMonth = $month->copy()->subMonth();
        $prevMonthStart = $prevMonth->copy()->startOfMonth();
        $prevMonthEnd = $prevMonth->copy()->endOfMonth();
        
        $prevMonthRevenue = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$prevMonthStart, $prevMonthEnd])
            ->sum('amount');
        
        $revenueGrowth = $prevMonthRevenue > 0 
            ? round((($totalRevenue - $prevMonthRevenue) / $prevMonthRevenue) * 100, 2)
            : 0;
        
        return view('owner.reports.monthly', compact(
            'selectedMonth',
            'month',
            'monthStart',
            'monthEnd',
            'totalOrders',
            'totalRevenue',
            'totalCustomers',
            'topMenus',
            'dailySummary',
            'averageOrderValue',
            'revenueGrowth',
            'prevMonthRevenue'
        ));
    }
    
    /**
     * Download Monthly Report as PDF
     */
    public function monthlyReportPdf(Request $request)
    {
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        try {
            $month = Carbon::parse($selectedMonth . '-01');
        } catch (\Exception $e) {
            $selectedMonth = now()->format('Y-m');
            $month = Carbon::parse($selectedMonth . '-01');
        }
        $monthStart = $month->copy()->startOfMonth();
        $monthEnd = $month->copy()->endOfMonth();

        $totalOrders = Order::whereHas('payment', function($query) use ($monthStart, $monthEnd) {
            $query->where('payment_status', 'sukses')
                  ->whereNotNull('paid_at')
                  ->whereBetween('paid_at', [$monthStart, $monthEnd]);
        })->count();
        $totalRevenue = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$monthStart, $monthEnd])
            ->sum('amount');
        $totalCustomers = Order::whereHas('payment', function($query) use ($monthStart, $monthEnd) {
            $query->where('payment_status', 'sukses')
                  ->whereNotNull('paid_at')
                  ->whereBetween('paid_at', [$monthStart, $monthEnd]);
        })->distinct('user_id')->count('user_id');
        $topMenus = Menu::select(
                'menus.id','menus.name','menus.price','categories.name as category_name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue')
            )
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->leftJoin('categories', 'menus.category_id', '=', 'categories.id')
            ->where('payments.payment_status', 'sukses')
            ->whereNotNull('payments.paid_at')
            ->whereBetween('payments.paid_at', [$monthStart, $monthEnd])
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        $dailySummary = [];
        $currentDay = $monthStart->copy();
        while ($currentDay <= $monthEnd) {
            $dayRevenue = Payment::where('payment_status', 'sukses')
                ->whereNotNull('paid_at')
                ->whereDate('paid_at', $currentDay)
                ->sum('amount');
            $dayOrders = Order::whereHas('payment', function($query) use ($currentDay) {
                $query->where('payment_status', 'sukses')
                      ->whereNotNull('paid_at')
                      ->whereDate('paid_at', $currentDay);
            })->count();
            $dailySummary[] = [
                'date' => $currentDay->format('Y-m-d'),
                'day' => $currentDay->format('d'),
                'day_name' => $currentDay->format('D'),
                'revenue' => $dayRevenue,
                'orders' => $dayOrders
            ];
            $currentDay->addDay();
        }
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $prevMonth = $month->copy()->subMonth();
        $prevMonthStart = $prevMonth->copy()->startOfMonth();
        $prevMonthEnd = $prevMonth->copy()->endOfMonth();
        $prevMonthRevenue = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$prevMonthStart, $prevMonthEnd])
            ->sum('amount');
        $revenueGrowth = $prevMonthRevenue > 0 
            ? round((($totalRevenue - $prevMonthRevenue) / $prevMonthRevenue) * 100, 2)
            : 0;

        if ($totalOrders == 0 && $totalRevenue == 0) {
            return redirect()->route('owner.reports.monthly', ['month' => $selectedMonth])
                ->with('error', 'Tidak ada data pada bulan tersebut.');
        }

        $pdf = Pdf::loadView('owner.reports.pdf.monthly', compact(
            'selectedMonth','month','monthStart','monthEnd','totalOrders','totalRevenue',
            'totalCustomers','topMenus','dailySummary','averageOrderValue','revenueGrowth','prevMonthRevenue'
        ))->setPaper('a4', 'portrait');

        $filename = 'laporan-bulanan-' . $month->format('Y-m') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Laporan Menu Terlaris
     * Owner melihat laporan khusus menu terbanyak terjual dan kontributor omzet terbesar dalam periode tertentu.
     */
    public function topMenusReport(Request $request)
    {
        // Default ke bulan ini jika tidak ada filter
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        try {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
        } catch (\Exception $e) {
            $startDate = now()->startOfMonth()->format('Y-m-d');
            $endDate = now()->endOfMonth()->format('Y-m-d');
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
        }
        
        // Validasi: end_date harus >= start_date
        if ($end->lt($start)) {
            $end = $start->copy();
            $endDate = $end->format('Y-m-d');
        }
        
        // Menu terlaris berdasarkan jumlah terjual
        $topMenusByQuantity = Menu::select(
                'menus.id',
                'menus.name',
                'menus.price',
                'categories.name as category_name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as order_count')
            )
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->leftJoin('categories', 'menus.category_id', '=', 'categories.id')
            ->where('payments.payment_status', 'sukses')
            ->whereNotNull('payments.paid_at')
            ->whereBetween('payments.paid_at', [$start, $end])
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(20)
            ->get();
        
        // Menu kontributor omzet terbesar
        $topMenusByRevenue = Menu::select(
                'menus.id',
                'menus.name',
                'menus.price',
                'categories.name as category_name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as order_count')
            )
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->leftJoin('categories', 'menus.category_id', '=', 'categories.id')
            ->where('payments.payment_status', 'sukses')
            ->whereNotNull('payments.paid_at')
            ->whereBetween('payments.paid_at', [$start, $end])
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->limit(20)
            ->get();
        
        // Total omzet periode
        $totalRevenue = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$start, $end])
            ->sum('amount');
        
        // Hitung persentase kontribusi untuk setiap menu
        foreach ($topMenusByRevenue as $menu) {
            $menu->contribution_percentage = $totalRevenue > 0 
                ? round(($menu->total_revenue / $totalRevenue) * 100, 2)
                : 0;
        }
        
        return view('owner.reports.top-menus', compact(
            'startDate',
            'endDate',
            'start',
            'end',
            'topMenusByQuantity',
            'topMenusByRevenue',
            'totalRevenue'
        ));
    }

    /**
     * Download Top Menus Report as PDF
     */
    public function topMenusReportPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        try {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
        } catch (\Exception $e) {
            $startDate = now()->startOfMonth()->format('Y-m-d');
            $endDate = now()->endOfMonth()->format('Y-m-d');
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
        }
        if ($end->lt($start)) {
            $end = $start->copy();
            $endDate = $end->format('Y-m-d');
        }
        $topMenusByQuantity = Menu::select(
                'menus.id','menus.name','menus.price','categories.name as category_name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as order_count')
            )
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->leftJoin('categories', 'menus.category_id', '=', 'categories.id')
            ->where('payments.payment_status', 'sukses')
            ->whereNotNull('payments.paid_at')
            ->whereBetween('payments.paid_at', [$start, $end])
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(20)
            ->get();
        $topMenusByRevenue = Menu::select(
                'menus.id','menus.name','menus.price','categories.name as category_name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as order_count')
            )
            ->join('order_details', 'menus.id', '=', 'order_details.menu_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->leftJoin('categories', 'menus.category_id', '=', 'categories.id')
            ->where('payments.payment_status', 'sukses')
            ->whereNotNull('payments.paid_at')
            ->whereBetween('payments.paid_at', [$start, $end])
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->limit(20)
            ->get();
        $totalRevenue = Payment::where('payment_status', 'sukses')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$start, $end])
            ->sum('amount');
        foreach ($topMenusByRevenue as $menu) {
            $menu->contribution_percentage = $totalRevenue > 0 
                ? round(($menu->total_revenue / $totalRevenue) * 100, 2)
                : 0;
        }

        if ($topMenusByQuantity->count() == 0 && $topMenusByRevenue->count() == 0) {
            return redirect()->route('owner.reports.top-menus', ['start_date' => $startDate, 'end_date' => $endDate])
                ->with('error', 'Tidak ada data pada periode tersebut.');
        }

        $pdf = Pdf::loadView('owner.reports.pdf.top-menus', compact(
            'startDate','endDate','start','end','topMenusByQuantity','topMenusByRevenue','totalRevenue'
        ))->setPaper('a4', 'portrait');

        $filename = 'laporan-menu-terlaris-' . $start->format('Ymd') . '-' . $end->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
}

