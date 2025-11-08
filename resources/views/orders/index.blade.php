@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Rumah Makan Cita Rasa')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-orange-400 via-orange-500 to-red-500 pt-24 pb-16 md:pt-32 md:pb-24 overflow-hidden" style="margin-top: 0;">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-10 rounded-full animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-block mb-4 animate-bounce">
                <span class="text-4xl md:text-5xl">📋</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 drop-shadow-lg">
                <span class="text-yellow-200">Riwayat Pesanan</span>
            </h1>
            <p class="text-lg md:text-xl text-orange-50 mb-8">Semua pesanan Anda dalam satu tempat</p>
        </div>
    </div>
    
    <!-- Wave Separator -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-12 md:h-20" viewBox="0 0 1200 120" preserveAspectRatio="none" fill="white">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"></path>
        </svg>
    </div>
</section>

<div class="py-6 md:py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($orders->count() > 0 || request('status'))
            <!-- Filter Bar -->
            <div class="mb-6 md:mb-8 mt-8 md:-mt-12 relative z-20">
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-2xl p-4 md:p-6 border border-gray-100">
                        @php 
                            $currentStatus = request('status', 'all'); 
                            $statuses = [
                                'all' => 'Semua Status',
                                'pending' => 'Menunggu',
                                'paid' => 'Sudah Bayar',
                                'diproses' => 'Diproses',
                                'selesai' => 'Selesai',
                                'batal' => 'Batal',
                            ];
                        @endphp
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-filter text-gray-400"></i>
                            </div>
                            <select id="status-filter" class="w-full pl-12 pr-12 py-3 md:py-4 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ $currentStatus === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 mt-4 md:mt-0">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-gray-200 overflow-hidden transition-all duration-300 transform hover:-translate-y-1">
                        <div class="px-4 sm:px-6 py-5 bg-gradient-to-r from-orange-50 via-yellow-50 to-orange-50 border-b border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900">Pesanan #{{ $order->id }}</h3>
                                    <p class="text-sm text-gray-600 mt-1"><i class="fas fa-calendar-alt mr-2"></i>{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 sm:gap-4 w-full sm:w-auto">
                                    <div class="text-left sm:text-right">
                                        <p class="text-xs sm:text-sm text-gray-500 font-medium">Total</p>
                                        <p class="text-lg sm:text-xl font-bold text-orange-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2 justify-start sm:justify-end">
                                        @php
                                            $status = $order->status;
                                            $labelMap = [
                                                'pending' => 'Menunggu',
                                                'paid' => 'Sudah Bayar',
                                                'diproses' => 'Diproses',
                                                'selesai' => 'Selesai',
                                                'batal' => 'Batal',
                                            ];
                                            $colorMap = [
                                                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'fa-clock'],
                                                'paid' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'fa-money-bill-wave'],
                                                'diproses' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800', 'icon' => 'fa-box'],
                                                'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'fa-check-circle'],
                                                'batal' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'fa-times-circle'],
                                            ];
                                            $cfg = $colorMap[$status] ?? ['bg'=>'bg-gray-100','text'=>'text-gray-800','icon'=>'fa-ellipsis-h'];
                                            $label = $labelMap[$status] ?? ucfirst($status);
                                        @endphp
                                        <span class="px-3 py-1.5 text-xs font-semibold rounded-full {{ $cfg['bg'] }} {{ $cfg['text'] }} shadow-sm">
                                            <i class="fas {{ $cfg['icon'] }} mr-1"></i>{{ $label }}
                                        </span>
                                        
                                        <a href="{{ route('orders.show', $order->id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl transition-all duration-300 text-xs sm:text-sm font-semibold shadow-md hover:shadow-lg transform hover:scale-105 w-full sm:w-auto justify-center">
                                            <i class="fas fa-eye mr-2"></i>Lihat Detail
                                        </a>
                                        <!-- Download Invoice Button -->
                                        <a href="{{ route('order.invoice', $order->id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl transition-all duration-300 text-xs sm:text-sm font-semibold shadow-md hover:shadow-lg transform hover:scale-105 w-full sm:w-auto justify-center"
                                           title="Unduh Nota PDF">
                                            <i class="fas fa-download mr-2"></i>
                                            Unduh Nota
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-4 sm:px-6 py-4">
                            <!-- Status Timeline -->
                            @php
                                $steps = ['pending','paid','diproses','selesai'];
                                $stepLabels = [
                                    'pending' => 'Menunggu',
                                    'paid' => 'Sudah Bayar',
                                    'diproses' => 'Diproses',
                                    'selesai' => 'Selesai',
                                ];
                                $current = array_search($order->status, $steps);
                            @endphp
                            <div class="mb-4 hidden sm:block">
                                <div class="flex items-center">
                                    @foreach($steps as $i => $step)
                                        @php
                                            $active = ($order->status === 'batal') ? false : $i <= $current;
                                            $title = $stepLabels[$step];
                                        @endphp
                                        <div class="flex items-center w-full">
                                            <div class="flex items-center justify-center h-8 w-8 rounded-full text-xs font-bold {{ $active ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-md' : 'bg-gray-200 text-gray-500' }}">
                                                {{ $i+1 }}
                                            </div>
                                            <div class="mx-2 text-xs font-medium {{ $active ? 'text-gray-900' : 'text-gray-400' }}">{{ $title }}</div>
                                            @if(!$loop->last)
                                                <div class="flex-1 h-1 {{ $active ? 'bg-orange-300' : 'bg-gray-200' }} rounded-full"></div>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($order->status === 'batal')
                                        <span class="ml-3 px-3 py-1 text-xs rounded-full bg-red-100 text-red-800 font-semibold shadow-sm">
                                            <i class="fas fa-times-circle mr-1"></i>Dibatalkan
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="space-y-3">
                                @foreach($order->details as $detail)
                                    <div class="flex justify-between items-center pb-3 border-b border-gray-100 last:border-0">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900">{{ $detail->menu->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $detail->quantity }}x @ Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                                @if($detail->notes)
                                                <p class="text-xs text-blue-600 italic mt-1">
                                                    <i class="fas fa-sticky-note mr-1"></i>{{ $detail->notes }}
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        @if($order->payment)
                        <div class="px-4 sm:px-6 py-3 bg-gray-50 border-t">
                            @if($order->payment->payment_status == 'pending')
                                <!-- Pending Payment - Show Continue Button -->
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>Menunggu Pembayaran
                                            </p>
                                            <p class="text-xs text-yellow-600 mt-1">Order akan dibatalkan otomatis jika tidak dibayar</p>
                                        </div>
                                        <a href="{{ route('order.continue-payment', $order->id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition text-sm font-semibold">
                                            <i class="fas fa-credit-card mr-2"></i>Lanjutkan Pembayaran
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-sm">
                                <div>
                                    <span class="text-gray-600">Metode Pembayaran:</span>
                                    <span class="font-medium text-gray-900">{{ $order->payment->payment_method }}</span>
                                </div>
                                @if($order->payment->transaction_id)
                                <div>
                                    <span class="text-gray-600">ID Transaksi:</span>
                                    <span class="font-medium text-gray-900">{{ $order->payment->transaction_id }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <div class="mb-6">
                        <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-gradient-to-br from-orange-100 to-red-100 mb-4">
                            <svg class="w-16 h-16 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">Belum Ada Pesanan</h3>
                    <p class="text-gray-600 mb-8 text-lg">Anda belum melakukan pemesanan apapun. Mulai pesan sekarang!</p>
                    <a href="{{ route('menus.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 text-base md:text-lg font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Mulai Belanja</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('status-filter');
    
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            
            // Build URL with current base
            const currentUrl = window.location.href.split('?')[0];
            const params = new URLSearchParams(window.location.search);
            
            // Remove existing status and page params
            params.delete('status');
            params.delete('page');
            
            // Add new status if not 'all'
            if (selectedStatus && selectedStatus !== 'all') {
                params.set('status', selectedStatus);
            }
            
            // Build final URL
            const queryString = params.toString();
            const finalUrl = queryString ? `${currentUrl}?${queryString}` : currentUrl;
            
            // Redirect to the new URL
            window.location.href = finalUrl;
        });
    }
});
</script>
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
@endsection

