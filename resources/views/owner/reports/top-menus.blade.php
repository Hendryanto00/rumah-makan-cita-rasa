@extends('layouts.owner')

@section('title', 'Laporan Menu Terlaris')
@section('page-title', 'Laporan Menu Terlaris')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 rounded-2xl shadow-lg p-6 md:p-8 text-white">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Laporan Menu Terlaris</h1>
                <p class="text-orange-100">Analisis menu dengan performa terbaik</p>
            </div>
            <div class="flex items-center gap-3 bg-white/20 backdrop-blur rounded-xl px-4 py-3">
                    <i class="fas fa-chart-line text-2xl"></i>
                    <div>
                        <p class="text-xs text-orange-100">Periode</p>
                        <p class="text-sm font-bold">{{ $start instanceof \Carbon\Carbon ? $start->format('d M') : \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ $end instanceof \Carbon\Carbon ? $end->format('d M Y') : \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                    </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-5">
        <form method="GET" action="{{ route('owner.reports.top-menus') }}" id="filterForm" class="flex flex-col lg:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt mr-2 text-orange-500"></i>Tanggal Mulai
                </label>
                <input type="date" 
                       id="start_date" 
                       name="start_date" 
                       value="{{ $startDate }}"
                       class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2.5 text-gray-700 transition"
                       max="{{ now()->format('Y-m-d') }}">
            </div>
            <div class="flex-1 w-full">
                <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt mr-2 text-orange-500"></i>Tanggal Akhir
                </label>
                <input type="date" 
                       id="end_date" 
                       name="end_date" 
                       value="{{ $endDate }}"
                       class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2.5 text-gray-700 transition"
                       max="{{ now()->format('Y-m-d') }}">
            </div>
            <button type="submit" class="w-full lg:w-auto px-8 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i>
                <span>Filter</span>
            </button>
        </form>
        <div class="mt-4 p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg border border-orange-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Periode Laporan</p>
                    <p class="text-sm font-bold text-gray-900">
                        {{ $start instanceof \Carbon\Carbon ? $start->format('d M Y') : \Carbon\Carbon::parse($startDate)->format('d M Y') }} 
                        - 
                        {{ $end instanceof \Carbon\Carbon ? $end->format('d M Y') : \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-600 mb-1">Total Omzet Periode</p>
                    <p class="text-lg font-bold text-orange-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Menu Terlaris Berdasarkan Jumlah Terjual -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg md:text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-fire"></i>
                    Menu Terlaris (Berdasarkan Jumlah Terjual)
                </h2>
                <span class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold text-white">
                    Top 20
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Terjual</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Omzet</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Pesanan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($topMenusByQuantity as $index => $menu)
                    <tr class="hover:bg-orange-50 transition-colors {{ $index < 3 ? 'bg-orange-50/50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($index === 0)
                                <div class="flex flex-col items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-yellow-400 text-white font-bold text-xl shadow-lg">
                                        <i class="fas fa-crown"></i>
                                    </span>
                                    <span class="text-xs font-semibold text-gray-600">#1</span>
                                </div>
                            @elseif($index === 1)
                                <div class="flex flex-col items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-300 text-white font-bold text-xl shadow-lg">
                                        <i class="fas fa-medal"></i>
                                    </span>
                                    <span class="text-xs font-semibold text-gray-600">#2</span>
                                </div>
                            @elseif($index === 2)
                                <div class="flex flex-col items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-orange-400 text-white font-bold text-xl shadow-lg">
                                        <i class="fas fa-award"></i>
                                    </span>
                                    <span class="text-xs font-semibold text-gray-600">#3</span>
                                </div>
                            @else
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-700 font-bold">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fas fa-utensils text-orange-600 text-lg"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-900 block">{{ $menu->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold">
                                {{ $menu->category_name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-700">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex flex-col items-end">
                                <span class="text-base font-bold text-gray-900">{{ number_format($menu->total_sold ?? 0, 0, ',', '.') }}</span>
                                <span class="text-xs text-gray-500">pcs</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-base font-bold text-green-600">Rp {{ number_format($menu->total_revenue ?? 0, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-semibold">
                                <i class="fas fa-shopping-bag text-xs"></i>
                                {{ number_format($menu->order_count ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                <p class="text-sm text-gray-500">Tidak ada data pada periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Mobile list -->
        <div class="md:hidden divide-y">
            @forelse($topMenusByQuantity as $index => $menu)
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
            <div class="p-6 text-center text-sm text-gray-500">Tidak ada data pada periode ini</div>
            @endforelse
        </div>
    </div>
    
    <!-- Menu Kontributor Omzet Terbesar -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg md:text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-dollar-sign"></i>
                    Menu Kontributor Omzet Terbesar
                </h2>
                <span class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold text-white">
                    Top 20
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Terjual</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Omzet</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Kontribusi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($topMenusByRevenue as $index => $menu)
                    <tr class="hover:bg-green-50 transition-colors {{ $index < 3 ? 'bg-green-50/50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($index === 0)
                                <div class="flex flex-col items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-yellow-400 text-white font-bold text-xl shadow-lg">
                                        <i class="fas fa-crown"></i>
                                    </span>
                                    <span class="text-xs font-semibold text-gray-600">#1</span>
                                </div>
                            @elseif($index === 1)
                                <div class="flex flex-col items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-300 text-white font-bold text-xl shadow-lg">
                                        <i class="fas fa-medal"></i>
                                    </span>
                                    <span class="text-xs font-semibold text-gray-600">#2</span>
                                </div>
                            @elseif($index === 2)
                                <div class="flex flex-col items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-orange-400 text-white font-bold text-xl shadow-lg">
                                        <i class="fas fa-award"></i>
                                    </span>
                                    <span class="text-xs font-semibold text-gray-600">#3</span>
                                </div>
                            @else
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-700 font-bold">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fas fa-utensils text-green-600 text-lg"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-900 block">{{ $menu->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold">
                                {{ $menu->category_name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-700">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-sm text-gray-600">{{ number_format($menu->total_sold ?? 0, 0, ',', '.') }} pcs</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-base font-bold text-green-600">Rp {{ number_format($menu->total_revenue ?? 0, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 bg-gray-200 rounded-full h-3 overflow-hidden">
                                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-300" style="width: {{ min($menu->contribution_percentage, 100) }}%"></div>
                                </div>
                                <span class="text-sm font-bold text-gray-900 min-w-[50px] text-right">{{ number_format($menu->contribution_percentage, 1) }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                <p class="text-sm text-gray-500">Tidak ada data pada periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Mobile list -->
        <div class="md:hidden divide-y">
            @forelse($topMenusByRevenue as $index => $menu)
            <div class="p-4 flex items-start justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 font-semibold">{{ $index + 1 }}</span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $menu->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $menu->category_name ?? '-' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Kontribusi</p>
                    <p class="text-sm font-semibold text-gray-900">{{ number_format($menu->contribution_percentage, 1) }}%</p>
                    <p class="text-xs text-gray-500 mt-1">Omzet</p>
                    <p class="text-sm font-bold text-green-600">Rp {{ number_format($menu->total_revenue ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-sm text-gray-500">Tidak ada data pada periode ini</div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const filterForm = document.getElementById('filterForm');
        
        if (startDateInput && endDateInput && filterForm) {
            // Auto submit ketika salah satu tanggal berubah
            startDateInput.addEventListener('change', function() {
                // Validasi: end_date harus >= start_date
                if (endDateInput.value && endDateInput.value < startDateInput.value) {
                    endDateInput.value = startDateInput.value;
                }
                filterForm.submit();
            });
            
            endDateInput.addEventListener('change', function() {
                // Validasi: end_date harus >= start_date
                if (startDateInput.value && endDateInput.value < startDateInput.value) {
                    endDateInput.value = startDateInput.value;
                }
                filterForm.submit();
            });
        }
    });
</script>
@endpush
@endsection
