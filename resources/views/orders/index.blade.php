@extends('layouts.app')

@section('title', 'Order History - Rumah Makan Cita Rasa')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 mb-4">📋 Order History</h1>
            <p class="text-lg md:text-xl text-gray-600 mb-8">Riwayat pesanan Anda</p>
        </div>
    </div>
</section>

<div class="py-6 md:py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($orders->count() > 0)
            <div class="grid grid-cols-1 gap-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-orange-50 to-yellow-50 border-b">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Total</p>
                                        <p class="text-xl font-bold text-orange-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        @if($order->status == 'paid')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Paid
                                            </span>
                                        @elseif($order->status == 'pending')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                <i class="fas fa-ellipsis-h mr-1"></i>{{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-4 sm:px-6 py-4">
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
                                    <span class="text-gray-600">Transaction ID:</span>
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
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-20 w-20 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada order</h3>
                    <p class="text-gray-500 mb-6">Anda belum melakukan pemesanan apapun</p>
                    <a href="{{ route('menus.index') }}" class="inline-flex items-center px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition text-sm font-semibold">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

