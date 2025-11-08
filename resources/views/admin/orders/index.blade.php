@extends('layouts.admin')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-4 md:px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Daftar Pesanan</h2>
        <p class="text-sm text-gray-600 mt-1">Pantau semua pesanan pelanggan yang masuk ke sistem dan update status pesanan.</p>
    </div>
    
    <!-- Search and Filter -->
    <div class="px-4 md:px-6 py-4 border-b border-gray-200 bg-gray-50">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       name="search"
                       id="search-input"
                       placeholder="Cari ID pesanan, nama pelanggan, atau email..." 
                       class="w-full pl-12 pr-4 py-2.5 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-white"
                       value="{{ request('search') }}">
            </div>
            <div class="md:w-56 relative">
                <select name="status" id="status-filter" class="w-full pl-4 pr-12 py-2.5 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-white appearance-none cursor-pointer">
                    <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Sudah Bayar</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            <button type="submit" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-2.5 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 text-sm md:text-base font-semibold shadow-md hover:shadow-lg transform hover:scale-105 whitespace-nowrap">
                <i class="fas fa-search mr-2"></i>
                <span class="hidden sm:inline">Cari</span>
            </button>
        </form>
    </div>
    
    <!-- Orders Table (Desktop) -->
    <div class="overflow-x-auto hidden md:block">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Tanggal</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">#{{ $order->id }}</div>
                        <div class="text-xs text-gray-500">{{ $order->details->count() }} item</div>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                        <div class="text-xs text-gray-500 hidden lg:block">{{ $order->user->email }}</div>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                        @php
                            $orderDate = $order->order_date ?? $order->created_at;
                        @endphp
                        <div class="text-sm text-gray-900">{{ $orderDate->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $orderDate->format('H:i') }}</div>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'paid' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'diproses' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'selesai' => 'bg-green-100 text-green-800 border-green-200',
                                'batal' => 'bg-red-100 text-red-800 border-red-200',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'paid' => 'Sudah Bayar',
                                'diproses' => 'Diproses',
                                'selesai' => 'Selesai',
                                'batal' => 'Batal',
                            ];
                            $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            $label = $statusLabels[$order->status] ?? ucfirst($order->status);
                        @endphp
                        <span class="px-2 md:px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $color }}">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-orange-600 hover:text-orange-900">
                            <i class="fas fa-eye mr-1"></i>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 md:px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                            <p class="text-lg font-semibold text-gray-900 mb-2">Tidak ada pesanan</p>
                            <p class="text-sm text-gray-500">
                                @if(request()->hasAny(['search', 'status']))
                                    Tidak ada pesanan yang sesuai dengan filter yang dipilih
                                @else
                                    Belum ada pesanan yang masuk ke sistem
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile cards list -->
    <div class="md:hidden divide-y">
        @forelse($orders as $order)
        @php
            $orderDate = $order->order_date ?? $order->created_at;
            $statusColors = [
                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'paid' => 'bg-blue-100 text-blue-800 border-blue-200',
                'diproses' => 'bg-purple-100 text-purple-800 border-purple-200',
                'selesai' => 'bg-green-100 text-green-800 border-green-200',
                'batal' => 'bg-red-100 text-red-800 border-red-200',
            ];
            $statusLabels = [
                'pending' => 'Menunggu',
                'paid' => 'Sudah Bayar',
                'diproses' => 'Diproses',
                'selesai' => 'Selesai',
                'batal' => 'Batal',
            ];
            $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
            $label = $statusLabels[$order->status] ?? ucfirst($order->status);
        @endphp
        <div class="p-4">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <p class="font-semibold text-gray-900">#{{ $order->id }}</p>
                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full border {{ $color }} flex-shrink-0">
                            {{ $label }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500">{{ $order->details->count() }} item</p>
                </div>
            </div>
            <div class="space-y-2 mb-3">
                <div>
                    <p class="text-xs text-gray-500">Pelanggan</p>
                    <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Tanggal</p>
                    <p class="text-sm text-gray-900">{{ $orderDate->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Total</p>
                    <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.orders.show', $order) }}" 
               class="inline-flex items-center justify-center w-full px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-xs font-semibold transition-colors">
                <i class="fas fa-eye mr-2"></i>Lihat Detail
            </a>
        </div>
        @empty
        <div class="p-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
            </div>
            <p class="text-sm text-gray-500 font-medium">Tidak ada pesanan</p>
            @if(request()->hasAny(['search', 'status']))
                <p class="text-xs text-gray-400 mt-1">Coba ubah filter pencarian Anda</p>
            @else
                <p class="text-xs text-gray-400 mt-1">Belum ada pesanan yang masuk ke sistem</p>
            @endif
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="px-4 md:px-6 py-4 border-t border-gray-200">
        {{ $orders->links() }}
    </div>
</div>

@push('styles')
<style>
    /* Remove default browser dropdown arrow */
    #status-filter {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: none !important;
        background-repeat: no-repeat;
        background-position: right center;
    }
    
    /* For Firefox */
    #status-filter::-moz-focus-inner {
        border: 0;
    }
    
    /* For IE */
    #status-filter::-ms-expand {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Auto-submit filter on change
    const statusFilter = document.getElementById('status-filter');
    const searchForm = document.querySelector('form[action="{{ route("admin.orders.index") }}"]');
    
    if (statusFilter && searchForm) {
        statusFilter.addEventListener('change', function() {
            searchForm.submit();
        });
    }
    
    // Search with debounce (auto-submit after user stops typing)
    const searchInput = document.getElementById('search-input');
    let searchTimeout;
    
    if (searchInput && searchForm) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                searchForm.submit();
            }, 800);
        });
        
        // Also submit on Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                searchForm.submit();
            }
        });
    }
    
    // Real-time orders polling
    let lastOrderCheck = new Date().toISOString();
    let ordersUpdateInterval;
    let currentOrderCount = {{ $orders->count() }};
    let currentStatus = '{{ request("status", "all") }}';
    let currentSearch = '{{ request("search", "") }}';
    let latestOrderId = {{ $orders->first() ? $orders->first()->id : 0 }};
    
    function checkNewOrders() {
        const statusParam = currentStatus !== 'all' ? `&status=${currentStatus}` : '';
        const searchParam = currentSearch ? `&search=${encodeURIComponent(currentSearch)}` : '';
        
        fetch(`{{ route('api.orders-count') }}?last_check=${encodeURIComponent(lastOrderCheck)}${statusParam}${searchParam}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Check if there's a new order (by comparing latest order ID)
                if (data.latest_order_id && data.latest_order_id > latestOrderId) {
                    // New order detected, reload the page
                    window.location.reload();
                } else if (data.total_count !== currentOrderCount) {
                    // Count changed, might be new order or deleted order
                    if (data.total_count > currentOrderCount) {
                        // New order, reload
                        window.location.reload();
                    } else {
                        // Order deleted, update count
                        currentOrderCount = data.total_count;
                    }
                }
                
                // Update latest order ID if available
                if (data.latest_order_id) {
                    latestOrderId = data.latest_order_id;
                }
                
                // Update last check time
                if (data.timestamp) {
                    lastOrderCheck = data.timestamp;
                }
            }
        })
        .catch(error => {
            console.error('Orders update check error:', error);
        });
    }
    
    // Start polling every 3 seconds for admin (more frequent)
    if (typeof ordersUpdateInterval === 'undefined') {
        ordersUpdateInterval = setInterval(checkNewOrders, 3000);
    }
    
    // Stop polling when page is hidden (to save resources)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (ordersUpdateInterval) clearInterval(ordersUpdateInterval);
        } else {
            if (!ordersUpdateInterval) {
                ordersUpdateInterval = setInterval(checkNewOrders, 3000);
            }
        }
    });
    
    // Update current filters when form is submitted
    if (searchForm) {
        searchForm.addEventListener('submit', function() {
            currentStatus = statusFilter ? statusFilter.value : 'all';
            currentSearch = searchInput ? searchInput.value : '';
        });
    }
});
</script>
@endpush

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: 'OK',
        confirmButtonColor: '#f97316'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: 'OK',
        confirmButtonColor: '#dc2626'
    });
</script>
@endif
@endsection

