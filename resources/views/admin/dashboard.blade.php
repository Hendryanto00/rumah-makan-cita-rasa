@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

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
                            <i class="fas fa-user"></i>
                        </span>
                        <p class="uppercase tracking-wider text-xs text-white/80">Admin</p>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold">
                        Halo, {{ Auth::user()->name }} 👋
                    </h2>
                    <p class="text-white/80 mt-1 text-sm md:text-base">Pusat kendali untuk mengelola menu, kategori, pesanan, dan review pelanggan dengan mudah dan efisien.</p>
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
    
    <!-- Aksi Cepat -->
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Aksi Cepat</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.profile') }}" class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-pink-500 to-pink-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <i class="fas fa-user text-4xl mb-3"></i>
                <span class="font-semibold text-center">Profil Saya</span>
            </a>
            
            <a href="{{ route('admin.menus.index') }}" class="group flex flex-col items-center justify-center p-6 bg-blue-500 text-white rounded-xl shadow-md hover:shadow-lg hover:bg-blue-600 transition-all duration-300">
                <i class="fas fa-utensils text-4xl mb-3"></i>
                <span class="font-semibold text-center">Kelola Menu</span>
            </a>
            
            <a href="{{ route('admin.categories.create') }}" class="group flex flex-col items-center justify-center p-6 bg-green-500 text-white rounded-xl shadow-md hover:shadow-lg hover:bg-green-600 transition-all duration-300">
                <i class="fas fa-tag text-4xl mb-3"></i>
                <span class="font-semibold text-center">Tambah Kategori</span>
            </a>
            
            <a href="{{ route('admin.categories.index') }}" class="group flex flex-col items-center justify-center p-6 bg-purple-500 text-white rounded-xl shadow-md hover:shadow-lg hover:bg-purple-600 transition-all duration-300">
                <i class="fas fa-list text-4xl mb-3"></i>
                <span class="font-semibold text-center">Kelola Kategori</span>
            </a>
            
            <a href="{{ route('admin.reviews.index') }}" class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-orange-500 to-yellow-500 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <i class="fas fa-star text-4xl mb-3"></i>
                <span class="font-semibold text-center">Kelola Review</span>
            </a>
            
            <a href="{{ route('admin.reviews.statistics') }}" class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-indigo-500 to-blue-500 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <i class="fas fa-chart-bar text-4xl mb-3"></i>
                <span class="font-semibold text-center">Statistik Review</span>
            </a>
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
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h2>
                <a href="#" class="text-sm text-orange-600 hover:text-orange-700">Lihat Semua</a>
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
                                @endphp
                                @php
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
                <a href="{{ route('admin.menus.index') }}" class="text-sm text-orange-600 hover:text-orange-700">Lihat Semua</a>
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
    
    <!-- Top Selling Menus -->
    @if($topSellingMenus->count() > 0)
    <div class="bg-white rounded-2xl shadow">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Menu Terlaris</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @foreach($topSellingMenus as $menu)
                <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                    <p class="text-lg font-semibold text-gray-900">{{ $menu->name }}</p>
                    <p class="text-2xl font-bold text-orange-600 mt-2">{{ $menu->total_sold ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">terjual</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

