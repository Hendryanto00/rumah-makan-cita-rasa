@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id . ' - Rumah Makan Cita Rasa')

@section('content')
<section class="bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <a href="{{ route('orders.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pesanan
            </a>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">Detail Pesanan #{{ $order->id }}</h1>
        </div>
    </div>
    </section>

<div class="py-6 md:py-12 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white rounded-2xl shadow p-4 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                @php
                    $labelMap = [
                        'pending' => 'Pending',
                        'paid' => 'Sudah Bayar',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'batal' => 'Batal',
                    ];
                    $colorMap = [
                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                        'paid' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                        'diproses' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
                        'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                        'batal' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                    ];
                    $cfg = $colorMap[$order->status] ?? ['bg'=>'bg-gray-100','text'=>'text-gray-800'];
                    $label = $labelMap[$order->status] ?? ucfirst($order->status);
                @endphp
                <span class="self-start md:self-auto px-3 py-1 text-sm font-semibold rounded-full {{ $cfg['bg'] }} {{ $cfg['text'] }}">{{ $label }}</span>
            </div>

            <!-- Timeline (desktop) -->
            @php $steps=['pending','paid','diproses','selesai']; $current=array_search($order->status,$steps); @endphp
            <div class="hidden md:block mt-6">
                <div class="flex items-center">
                    @foreach($steps as $i=>$step)
                        @php $active = ($order->status !== 'batal') ? $i <= $current : false; @endphp
                        <div class="flex items-center w-full">
                            <div class="flex items-center justify-center h-8 w-8 rounded-full text-xs font-bold {{ $active ? 'bg-orange-500 text-white' : 'bg-gray-200 text-gray-500' }}">{{ $i+1 }}</div>
                            <div class="mx-2 text-xs {{ $active ? 'text-gray-800' : 'text-gray-400' }}">{{ $labelMap[$step] }}</div>
                            @if(!$loop->last)
                                <div class="flex-1 h-1 {{ $active ? 'bg-orange-300' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                    @endforeach
                    @if($order->status === 'batal')
                        <span class="ml-3 px-2 py-1 text-xs rounded bg-red-100 text-red-800 font-semibold">Dibatalkan</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Items -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow p-4 md:p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Item Pesanan</h2>
                <div class="divide-y">
                    @foreach($order->details as $detail)
                    <div class="py-4 grid grid-cols-1 sm:grid-cols-4 gap-2 items-start">
                        <div class="min-w-0 sm:col-span-3">
                            <p class="font-semibold text-gray-900">{{ $detail->menu->name }}</p>
                            <p class="text-sm text-gray-500">{{ $detail->quantity }}x @ Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                            @if($detail->notes)
                            <p class="text-xs text-blue-600 italic mt-1"><i class="fas fa-sticky-note mr-1"></i>{{ $detail->notes }}</p>
                            @endif
                        </div>
                        <div class="text-left sm:text-right sm:col-span-1">
                            <p class="font-semibold text-gray-900 whitespace-nowrap">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment & Summary -->
            <div class="bg-white rounded-2xl shadow p-4 md:p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900">Ringkasan</h2>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Total Pembayaran</span>
                    <span class="text-xl font-extrabold text-orange-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                @if($order->payment)
                <div class="border-t pt-4 space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Metode Pembayaran</span>
                        <span class="font-medium text-gray-900">{{ $order->payment->payment_method }}</span>
                    </div>
                    @if($order->payment->transaction_id)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Transaction ID</span>
                        <span class="font-medium text-gray-900 truncate">{{ $order->payment->transaction_id }}</span>
                    </div>
                    @endif
                </div>
                @endif
                <div class="pt-4">
                    <a href="{{ route('order.invoice', $order->id) }}" class="inline-flex items-center w-full justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                        <i class="fas fa-download mr-2"></i>Download Nota (PDF)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


