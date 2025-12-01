@extends('layouts.owner')

@section('title', 'Dashboard Owner')
@section('page-title', 'Dashboard Owner')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="relative overflow-hidden rounded-2xl">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 via-orange-600 to-red-500"></div>
        <div class="absolute -right-24 -top-24 w-72 h-72 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-24 -bottom-24 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative p-6 md:p-8 text-white">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white/20 backdrop-blur">
                            <i class="fas fa-chart-line"></i>
                        </span>
                        <p class="uppercase tracking-wider text-xs text-white/80">Owner</p>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold">
                        Halo, {{ Auth::user()->name }} 👋
                    </h2>
                    <p class="text-white/80 mt-1 text-sm md:text-base">Pantau performa bisnis secara menyeluruh dengan dashboard statistik yang komprehensif.</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-white/80 text-xs">Tanggal</p>
                        <p class="text-2xl font-bold">{{ now()->format('d M Y') }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur shadow">
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Revenue -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-2">Semua waktu</p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>
        
        <!-- Revenue Today -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($revenueToday, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-2">{{ now()->format('d M Y') }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-day text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
        
        <!-- Revenue This Month -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        @if($revenueGrowth > 0)
                            <span class="text-xs text-green-600 font-semibold">+{{ number_format($revenueGrowth, 1) }}%</span>
                            <i class="fas fa-arrow-up text-xs text-green-600"></i>
                        @elseif($revenueGrowth < 0)
                            <span class="text-xs text-red-600 font-semibold">{{ number_format($revenueGrowth, 1) }}%</span>
                            <i class="fas fa-arrow-down text-xs text-red-600"></i>
                        @else
                            <span class="text-xs text-gray-500 font-semibold">0%</span>
                        @endif
                        <span class="text-xs text-gray-500">vs bulan lalu</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Orders -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pesanan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-2">{{ number_format($successfulOrders, 0, ',', '.') }} berhasil</p>
                </div>
                <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-2xl text-red-600"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Customers -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pelanggan</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalCustomers, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-xl text-pink-600"></i>
                </div>
            </div>
        </div>
        
        <!-- Average Order Value -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Rata-rata Nilai Pesanan</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-receipt text-xl text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <!-- Average Rating -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Rating Rata-rata</p>
                    <div class="flex items-center gap-2">
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($averageRating, 1) }}</p>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">{{ number_format($approvedReviews, 0, ',', '.') }} review</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-star text-xl text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sales Trend Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        <!-- Sales Trend (7 Days) -->
        <div class="bg-white rounded-2xl shadow">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-100">
                <h2 class="text-base sm:text-lg font-bold text-gray-900">Tren Penjualan (7 Hari Terakhir)</h2>
            </div>
            <div class="p-3 sm:p-4 md:p-6">
                <div class="relative w-full" style="height: 250px; min-height: 250px;">
                    <canvas id="salesTrendChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Monthly Sales Trend -->
        <div class="bg-white rounded-2xl shadow">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-100">
                <h2 class="text-base sm:text-lg font-bold text-gray-900">Tren Penjualan Bulanan (6 Bulan)</h2>
            </div>
            <div class="p-3 sm:p-4 md:p-6">
                <div class="relative w-full" style="height: 250px; min-height: 250px;">
                    <canvas id="monthlySalesTrendChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Status Overview -->
    <div class="bg-white rounded-2xl shadow">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">Status Pesanan</h2>
            <span class="text-xs text-gray-500">Ringkasan</span>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="text-center p-4 bg-yellow-50 rounded-xl">
                    <p class="text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
                    <p class="text-sm text-gray-600 mt-1">Pending</p>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-xl">
                    <p class="text-2xl font-bold text-blue-600">{{ $paidOrders }}</p>
                    <p class="text-sm text-gray-600 mt-1">Sudah Bayar</p>
                </div>
                <div class="text-center p-4 bg-indigo-50 rounded-xl">
                    <p class="text-2xl font-bold text-indigo-600">{{ $processingOrders }}</p>
                    <p class="text-sm text-gray-600 mt-1">Diproses</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-xl">
                    <p class="text-2xl font-bold text-green-600">{{ $completedOrders }}</p>
                    <p class="text-sm text-gray-600 mt-1">Selesai</p>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-xl">
                    <p class="text-2xl font-bold text-red-600">{{ $cancelledOrders }}</p>
                    <p class="text-sm text-gray-600 mt-1">Batal</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Top Selling Menus & Revenue by Category -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Selling Menus -->
        <div class="bg-white rounded-2xl shadow">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Menu Terlaris</h2>
            </div>
            <!-- Desktop/tablet table -->
            <div class="overflow-x-auto hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terjual</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($topSellingMenus as $menu)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $menu->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($menu->total_sold ?? 0, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($menu->total_revenue ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data penjualan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Mobile list -->
            <div class="md:hidden divide-y">
                @forelse($topSellingMenus as $menu)
                <div class="p-4 flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $menu->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Terjual: {{ number_format($menu->total_sold ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Pendapatan</p>
                        <p class="text-sm font-bold text-green-600">Rp {{ number_format($menu->total_revenue ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-sm text-gray-500">Belum ada data penjualan</div>
                @endforelse
            </div>
        </div>
        
        <!-- Revenue by Category -->
        <div class="bg-white rounded-2xl shadow">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Pendapatan per Kategori</h2>
            </div>
            <!-- Desktop/tablet table -->
            <div class="overflow-x-auto hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terjual</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($revenueByCategory as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($category->total_sold ?? 0, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($category->total_revenue ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data kategori</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Mobile list -->
            <div class="md:hidden divide-y">
                @forelse($revenueByCategory as $category)
                <div class="p-4 flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $category->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Terjual: {{ number_format($category->total_sold ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Pendapatan</p>
                        <p class="text-sm font-bold text-green-600">Rp {{ number_format($category->total_revenue ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-sm text-gray-500">Belum ada data kategori</div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Recent Orders & Low Stock -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h2>
            </div>
            <!-- Desktop/tablet table -->
            <div class="overflow-x-auto hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'yellow',
                                        'paid' => 'blue',
                                        'diproses' => 'indigo',
                                        'selesai' => 'green',
                                        'batal' => 'red'
                                    ];
                                    $color = $statusColors[$order->status] ?? 'gray';
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'paid' => 'Sudah Bayar',
                                        'diproses' => 'Diproses',
                                        'selesai' => 'Selesai',
                                        'batal' => 'Batal'
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada pesanan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Mobile list -->
            <div class="md:hidden divide-y">
                @forelse($recentOrders as $order)
                @php
                    $statusColors = [
                        'pending' => 'yellow',
                        'paid' => 'blue',
                        'diproses' => 'indigo',
                        'selesai' => 'green',
                        'batal' => 'red'
                    ];
                    $color = $statusColors[$order->status] ?? 'gray';
                    $statusLabels = [
                        'pending' => 'Menunggu',
                        'paid' => 'Sudah Bayar',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'batal' => 'Batal'
                    ];
                @endphp
                <div class="p-4 flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900">#{{ $order->id }} • {{ $order->user->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <span class="flex-shrink-0 px-2 py-0.5 rounded-full bg-{{ $color }}-100 text-{{ $color }}-800 text-[11px] font-semibold">{{ $statusLabels[$order->status] ?? ucfirst($order->status) }}</span>
                </div>
                @empty
                <div class="p-4 text-center text-sm text-gray-500">Tidak ada pesanan</div>
                @endforelse
            </div>
        </div>
        
        <!-- Low Stock Items -->
        <div class="bg-white rounded-2xl shadow">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-900">Stok Menipis</h2>
            </div>
            <!-- Desktop/tablet table -->
            <div class="overflow-x-auto hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($lowStockMenus as $menu)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $menu->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $menu->stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($menu->stock == 0)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Habis</span>
                                @elseif($menu->stock < 5)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Kritis</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menipis</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada menu dengan stok menipis</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Mobile list -->
            <div class="md:hidden divide-y">
                @forelse($lowStockMenus as $menu)
                <div class="p-4 flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $menu->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Stok: {{ $menu->stock }}</p>
                    </div>
                    @if($menu->stock == 0)
                        <span class="flex-shrink-0 px-2 py-0.5 rounded-full bg-red-100 text-red-800 text-[11px] font-semibold">Habis</span>
                    @elseif($menu->stock < 5)
                        <span class="flex-shrink-0 px-2 py-0.5 rounded-full bg-red-100 text-red-800 text-[11px] font-semibold">Kritis</span>
                    @else
                        <span class="flex-shrink-0 px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-800 text-[11px] font-semibold">Menipis</span>
                    @endif
                </div>
                @empty
                <div class="p-4 text-center text-sm text-gray-500">Tidak ada menu dengan stok menipis</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Function to detect mobile
    function isMobile() {
        return window.innerWidth < 640;
    }
    
    // Sales Trend Chart (7 Days)
    const salesTrendCtx = document.getElementById('salesTrendChart');
    let salesTrendChart;
    if (salesTrendCtx) {
        const salesTrendData = @json($salesTrend);
        const revenueValues = salesTrendData.map(i => i.revenue);
        const orderValues = salesTrendData.map(i => i.orders);
        const maxRevenue = Math.max(1, ...revenueValues);
        const maxOrders = Math.max(1, ...orderValues);

        salesTrendChart = new Chart(salesTrendCtx, {
            type: 'line',
            data: {
                labels: salesTrendData.map(item => item.day_short),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: revenueValues,
                    borderColor: 'rgba(234, 88, 12, 1)',
                    backgroundColor: 'rgba(234, 88, 12, 0.15)',
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointBackgroundColor: 'rgba(234, 88, 12, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1,
                    tension: 0.3,
                    yAxisID: 'y',
                }, {
                    label: 'Jumlah Pesanan',
                    data: orderValues,
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.15)',
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1,
                    tension: 0.3,
                    yAxisID: 'y1',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: { 
                            boxWidth: isMobile() ? 10 : 12,
                            font: {
                                size: isMobile() ? 10 : 12
                            },
                            padding: isMobile() ? 8 : 12
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                layout: {
                    padding: {
                        left: isMobile() ? 8 : 15,
                        right: isMobile() ? 8 : 15,
                        top: 10,
                        bottom: 10
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Pendapatan (Rp)',
                            padding: { top: 10, bottom: 10, left: isMobile() ? 0 : 5, right: 0 },
                            font: {
                                size: isMobile() ? 10 : 12,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                const n = Number(value);
                                if (n >= 1_000_000) return 'Rp ' + (n/1_000_000).toFixed(1) + 'M';
                                if (n >= 1_000) return 'Rp ' + (n/1_000).toFixed(0) + 'k';
                                return 'Rp ' + n;
                            },
                            font: {
                                size: isMobile() ? 9 : 11
                            },
                            maxRotation: isMobile() ? 45 : 0,
                            padding: isMobile() ? 3 : 8
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        suggestedMax: maxRevenue * 1.2
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Jumlah Pesanan',
                            padding: { top: 10, bottom: 10, left: 0, right: isMobile() ? 0 : 5 },
                            font: {
                                size: isMobile() ? 10 : 12,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            color: 'rgb(59, 130, 246)',
                            font: {
                                size: isMobile() ? 9 : 11
                            },
                            padding: isMobile() ? 3 : 8
                        },
                        suggestedMax: Math.ceil(maxOrders * 1.2)
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: isMobile() ? 9 : 11
                            },
                            maxRotation: isMobile() ? 45 : 0,
                            minRotation: isMobile() ? 45 : 0,
                            padding: isMobile() ? 3 : 8
                        }
                    }
                }
            }
        });
        
        // Resize chart on window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (salesTrendChart) {
                    salesTrendChart.resize();
                }
            }, 250);
        });
    }
    
    // Monthly Sales Trend Chart
    const monthlySalesTrendCtx = document.getElementById('monthlySalesTrendChart');
    let monthlySalesTrendChart;
    if (monthlySalesTrendCtx) {
        const monthlySalesTrendData = @json($monthlySalesTrend);
        const monthlyRevenues = monthlySalesTrendData.map(item => item.revenue);
        const monthlyOrders = monthlySalesTrendData.map(item => item.orders);
        const monthlyMax = Math.max(1, ...monthlyRevenues);
        const monthlyMaxOrders = Math.max(1, ...monthlyOrders);
        monthlySalesTrendChart = new Chart(monthlySalesTrendCtx, {
            type: 'line',
            data: {
                labels: monthlySalesTrendData.map(item => item.month_short),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: monthlyRevenues,
                    borderColor: 'rgba(234, 88, 12, 1)',
                    backgroundColor: 'rgba(234, 88, 12, 0.15)',
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: 'rgba(234, 88, 12, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1,
                    tension: 0.3,
                    yAxisID: 'y',
                }, {
                    label: 'Jumlah Pesanan',
                    data: monthlyOrders,
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.15)',
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1,
                    tension: 0.3,
                    yAxisID: 'y1',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: { 
                            boxWidth: isMobile() ? 10 : 12,
                            font: {
                                size: isMobile() ? 10 : 12
                            },
                            padding: isMobile() ? 8 : 12
                        }
                    }
                },
                layout: {
                    padding: {
                        left: isMobile() ? 8 : 15,
                        right: isMobile() ? 8 : 15,
                        top: 10,
                        bottom: 10
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Pendapatan (Rp)',
                            padding: { top: 10, bottom: 10, left: isMobile() ? 0 : 5, right: 0 },
                            font: {
                                size: isMobile() ? 10 : 12,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                const n = Number(value);
                                if (n >= 1_000_000) return 'Rp ' + (n/1_000_000).toFixed(1) + 'M';
                                if (n >= 1_000) return 'Rp ' + (n/1_000).toFixed(0) + 'k';
                                return 'Rp ' + n;
                            },
                            font: {
                                size: isMobile() ? 9 : 11
                            },
                            maxRotation: isMobile() ? 45 : 0,
                            padding: isMobile() ? 3 : 8
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        suggestedMax: monthlyMax * 1.2
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pesanan',
                            padding: { top: 10, bottom: 10, left: 0, right: isMobile() ? 0 : 5 },
                            font: {
                                size: isMobile() ? 10 : 12,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            color: 'rgb(59, 130, 246)',
                            font: {
                                size: isMobile() ? 9 : 11
                            },
                            padding: isMobile() ? 3 : 8
                        },
                        suggestedMax: Math.ceil(monthlyMaxOrders * 1.2)
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: isMobile() ? 9 : 11
                            },
                            maxRotation: isMobile() ? 45 : 0,
                            minRotation: isMobile() ? 45 : 0,
                            padding: isMobile() ? 3 : 8
                        }
                    }
                }
            }
        });
        
        // Resize chart on window resize
        let resizeTimer2;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer2);
            resizeTimer2 = setTimeout(function() {
                if (monthlySalesTrendChart) {
                    monthlySalesTrendChart.resize();
                }
            }, 250);
        });
    }
</script>
@endpush
@endsection

