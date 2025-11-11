@extends('layouts.owner')

@section('title', 'Laporan Bulanan Penjualan')
@section('page-title', 'Laporan Bulanan Penjualan')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 rounded-2xl shadow-lg p-6 md:p-8 text-white">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Laporan Bulanan Penjualan</h1>
                <p class="text-orange-100">Analisis performa penjualan bulanan secara menyeluruh</p>
            </div>
            <div class="flex items-center gap-3 bg-white/20 backdrop-blur rounded-xl px-4 py-3">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                    <div>
                        <p class="text-xs text-orange-100">Periode Laporan</p>
                        <p class="text-lg font-bold">{{ $month instanceof \Carbon\Carbon ? $month->format('F Y') : \Carbon\Carbon::parse($selectedMonth . '-01')->format('F Y') }}</p>
                    </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-5">
        <form method="GET" action="{{ route('owner.reports.monthly') }}" id="filterForm" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt mr-2 text-orange-500"></i>Pilih Bulan
                </label>
                <input type="month" 
                       id="month" 
                       name="month" 
                       value="{{ $selectedMonth }}"
                       class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2.5 text-gray-700 transition"
                       max="{{ now()->format('Y-m') }}">
            </div>
            <button type="submit" class="w-full sm:w-auto px-8 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i>
                <span>Filter</span>
            </button>
        </form>
    </div>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl shadow-md border border-orange-200 p-6 hover:shadow-lg transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">
                        <i class="fas fa-shopping-cart text-orange-500"></i>
                        Total Pesanan
                    </p>
                    <p class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">{{ number_format($totalOrders, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500">pesanan</p>
                </div>
                <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fas fa-shopping-cart text-3xl text-orange-500"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-md border border-green-200 p-6 hover:shadow-lg transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">
                        <i class="fas fa-money-bill-wave text-green-500"></i>
                        Total Omzet
                    </p>
                    <p class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        @if($revenueGrowth > 0)
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                <i class="fas fa-arrow-up"></i>
                                +{{ number_format($revenueGrowth, 1) }}%
                            </span>
                        @elseif($revenueGrowth < 0)
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                                <i class="fas fa-arrow-down"></i>
                                {{ number_format($revenueGrowth, 1) }}%
                            </span>
                        @else
                            <span class="text-xs text-gray-500 font-semibold">0%</span>
                        @endif
                        <span class="text-xs text-gray-500">vs bulan lalu</span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fas fa-money-bill-wave text-3xl text-green-500"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-md border border-blue-200 p-6 hover:shadow-lg transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">
                        <i class="fas fa-users text-blue-500"></i>
                        Total Pelanggan
                    </p>
                    <p class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">{{ number_format($totalCustomers, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500">pelanggan unik</p>
                </div>
                <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fas fa-users text-3xl text-blue-500"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-md border border-purple-200 p-6 hover:shadow-lg transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">
                        <i class="fas fa-receipt text-purple-500"></i>
                        Rata-rata Pesanan
                    </p>
                    <p class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500">per pesanan</p>
                </div>
                <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fas fa-receipt text-3xl text-purple-500"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Ringkasan Harian -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
            <h2 class="text-lg md:text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-chart-bar"></i>
                Ringkasan Transaksi Harian
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3">
                @foreach($dailySummary as $day)
                <div class="text-center p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg hover:from-orange-50 hover:to-orange-100 border border-gray-200 hover:border-orange-300 transition-all duration-200 cursor-default">
                    <p class="text-xs font-semibold text-gray-500 mb-1 uppercase">{{ $day['day_name'] }}</p>
                    <p class="text-xl font-bold text-gray-900 mb-2">{{ $day['day'] }}</p>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-orange-600">Rp {{ number_format($day['revenue'] / 1000, 0, ',', '.') }}k</p>
                        <p class="text-xs text-gray-600">{{ $day['orders'] }} pesanan</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Menu Laris -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg md:text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-trophy"></i>
                    Menu Laris Bulan Ini
                </h2>
                <span class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold text-white">
                    Top 10
                </span>
            </div>
        </div>
        <!-- Desktop/tablet table -->
        <div class="overflow-x-auto hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Rank</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Menu</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Terjual</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Omzet</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($topMenus as $index => $menu)
                    <tr class="hover:bg-orange-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($index === 0)
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-yellow-400 text-white font-bold text-lg shadow-md">1</span>
                            @elseif($index === 1)
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-white font-bold text-lg shadow-md">2</span>
                            @elseif($index === 2)
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-orange-400 text-white font-bold text-lg shadow-md">3</span>
                            @else
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 font-semibold">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-utensils text-orange-600"></i>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $menu->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                                {{ $menu->category_name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-sm font-bold text-gray-900">{{ number_format($menu->total_sold ?? 0, 0, ',', '.') }}</span>
                            <span class="text-xs text-gray-500 ml-1">pcs</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-sm font-bold text-green-600">Rp {{ number_format($menu->total_revenue ?? 0, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                <p class="text-sm text-gray-500">Tidak ada data penjualan pada bulan ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Mobile list -->
        <div class="md:hidden divide-y">
            @forelse($topMenus as $index => $menu)
            <div class="p-4 flex items-start justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 font-semibold">{{ $index + 1 }}</span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $menu->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $menu->category_name ?? '-' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Terjual</p>
                    <p class="text-sm font-semibold text-gray-900">{{ number_format($menu->total_sold ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Omzet</p>
                    <p class="text-sm font-bold text-green-600">Rp {{ number_format($menu->total_revenue ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-sm text-gray-500">Tidak ada data bulan ini</div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const monthInput = document.getElementById('month');
        const filterForm = document.getElementById('filterForm');
        
        if (monthInput && filterForm) {
            monthInput.addEventListener('change', function() {
                filterForm.submit();
            });
        }
    });
</script>
@endpush
@endsection
