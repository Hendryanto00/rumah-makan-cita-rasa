@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->id)
@section('page-title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pesanan
            </a>
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Pesanan #{{ $order->id }}</h2>
                <p class="text-sm text-gray-600 mt-1">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    @php
                        $orderDate = $order->order_date ?? $order->created_at;
                    @endphp
                    {{ $orderDate->format('d M Y, H:i') }}
                </p>
            </div>
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
            <span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full border {{ $color }}">
                {{ $label }}
            </span>
        </div>
        
        <!-- Status Timeline -->
        @php 
            $steps = ['pending', 'paid', 'diproses', 'selesai'];
            $current = in_array($order->status, $steps) ? array_search($order->status, $steps) : -1;
        @endphp
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex items-center">
                @foreach($steps as $i => $step)
                    @php 
                        $active = ($order->status !== 'batal') ? $i <= $current : false;
                        $stepLabel = $statusLabels[$step] ?? ucfirst($step);
                    @endphp
                    <div class="flex items-center flex-1">
                        <div class="flex flex-col items-center flex-1">
                            <div class="flex items-center justify-center h-10 w-10 rounded-full text-sm font-bold {{ $active ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-md' : 'bg-gray-200 text-gray-500' }}">
                                @if($active && $i === $current)
                                    <i class="fas fa-check"></i>
                                @else
                                    {{ $i + 1 }}
                                @endif
                            </div>
                            <div class="mt-2 text-xs font-medium {{ $active ? 'text-gray-900' : 'text-gray-400' }} text-center">
                                {{ $stepLabel }}
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div class="flex-1 h-1 mx-2 {{ $active ? 'bg-gradient-to-r from-orange-300 to-orange-400' : 'bg-gray-200' }}"></div>
                        @endif
                    </div>
                @endforeach
                @if($order->status === 'batal')
                    <div class="ml-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                            Dibatalkan
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer & Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-orange-600 mr-2"></i>
                    Informasi Pelanggan
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Nama</span>
                        <span class="text-sm font-medium text-gray-900">{{ $order->user->name }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Email</span>
                        <span class="text-sm font-medium text-gray-900">{{ $order->user->email }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-600">Tanggal Pesanan</span>
                        @php
                            $orderDate = $order->order_date ?? $order->created_at;
                        @endphp
                        <span class="text-sm font-medium text-gray-900">{{ $orderDate->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-shopping-bag text-orange-600 mr-2"></i>
                    Item Pesanan
                </h3>
                <div class="divide-y divide-gray-200">
                    @foreach($order->details as $detail)
                    <div class="py-4 flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3">
                                @php
                                    $slug = \Illuminate\Support\Str::slug($detail->menu->name);
                                    $possible = ['jpg','jpeg','png','webp'];
                                    $found = null;
                                    foreach ($possible as $ext) {
                                        if (file_exists(public_path("images/menu/{$slug}.{$ext}"))) { $found = $ext; break; }
                                    }
                                    $imageUrl = $found ? asset("images/menu/{$slug}.{$found}") : asset('images/rumah-makan.jpg');
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $detail->menu->name }}" class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $detail->menu->name }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $detail->quantity }}x @ Rp {{ number_format($detail->price, 0, ',', '.') }}
                                    </p>
                                    @if($detail->notes)
                                    <p class="text-xs text-blue-600 italic mt-2 flex items-center">
                                        <i class="fas fa-sticky-note mr-1"></i>
                                        {{ $detail->notes }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="ml-4 text-right">
                            <p class="text-lg font-semibold text-gray-900">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Information -->
            @if($order->payment)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-credit-card text-orange-600 mr-2"></i>
                    Informasi Pembayaran
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Metode Pembayaran</span>
                        <span class="text-sm font-medium text-gray-900">{{ $order->payment->payment_method }}</span>
                    </div>
                    @if($order->payment->transaction_id)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Transaction ID</span>
                        <span class="text-sm font-medium text-gray-900 font-mono">{{ $order->payment->transaction_id }}</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Tanggal Pembayaran</span>
                        <span class="text-sm font-medium text-gray-900">{{ $order->payment->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($order->payment->payment_status)
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-600">Status Pembayaran</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $order->payment->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->payment->payment_status) }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Summary & Actions -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-200">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-t-2 border-gray-300">
                        <span class="text-lg font-bold text-gray-900">Total</span>
                        <span class="text-xl font-extrabold text-orange-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-edit text-orange-600 mr-2"></i>
                    Update Status
                </h3>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-3">
                        <select name="status" id="status-select" class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm bg-white appearance-none cursor-pointer">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Sudah Bayar</option>
                            <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="batal" {{ $order->status === 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-lg transition-colors font-medium">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-center font-semibold transition-all">
                        <i class="fas fa-download mr-2"></i>
                        Download Nota PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Remove default browser dropdown arrow */
    #status-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: none !important;
        background-repeat: no-repeat;
        background-position: right center;
    }
    
    /* For Firefox */
    #status-select::-moz-focus-inner {
        border: 0;
    }
    
    /* For IE */
    #status-select::-ms-expand {
        display: none;
    }
</style>
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

