@extends('layouts.app')

@section('title', 'Keranjang - Rumah Makan Cita Rasa')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-orange-400 via-orange-500 to-red-500 py-16 md:py-24 overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white opacity-5 rounded-full"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-block mb-4 animate-bounce">
                <span class="text-4xl md:text-6xl">🛒</span>
            </div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-4 drop-shadow-lg">
                Keranjang <span class="text-yellow-200">Saya</span>
            </h1>
            <p class="text-lg md:text-xl text-orange-50 mb-8 max-w-2xl mx-auto">
                Review pesanan Anda sebelum checkout
            </p>
            <div class="flex flex-wrap justify-center gap-2 text-sm md:text-base">
                <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full font-medium">📝 Review Pesanan</span>
                <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full font-medium">💳 Checkout Aman</span>
                <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full font-medium">✨ Pengalaman Terbaik</span>
            </div>
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
        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
                <!-- Cart Items -->
                <div class="xl:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-4 sm:px-6 py-4 bg-gray-50 border-b">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Item dalam Keranjang</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                    <!-- Menu Image -->
                                    <div class="flex-shrink-0 w-full sm:w-auto">
                                        @php
                                            $slug = \Illuminate\Support\Str::slug($item->menu->name);
                                            $possible = ['jpg','jpeg','png','webp'];
                                            $found = null;
                                            foreach ($possible as $ext) {
                                                if (file_exists(public_path("images/menu/{$slug}.{$ext}"))) { $found = $ext; break; }
                                            }
                                            $imageUrl = $found ? asset("images/menu/{$slug}.{$found}") : asset('images/rumah-makan.jpg');
                                        @endphp
                                        <img src="{{ $imageUrl }}"
                                             alt="{{ $item->menu->name }}"
                                             class="h-16 w-16 sm:h-20 sm:w-20 rounded-lg object-cover mx-auto sm:mx-0"
                                             onerror="this.src='{{ asset('images/rumah-makan.jpg') }}'">
                                    </div>
                                    
                                    <!-- Menu Details -->
                                    <div class="flex-1 min-w-0 w-full sm:w-auto">
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 text-center sm:text-left">{{ $item->menu->name }}</h3>
                                        <p class="text-sm text-gray-500 text-center sm:text-left">{{ $item->menu->category->name }}</p>
                                        <p class="text-sm text-gray-600 mt-1 text-center sm:text-left">{{ Str::limit($item->menu->description, 80) }}</p>
                                        @if($item->notes)
                                        <div class="mt-2 text-xs text-blue-600 italic text-center sm:text-left">
                                            <i class="fas fa-sticky-note mr-1"></i>{{ $item->notes }}
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Controls and Price Container -->
                                    <div class="w-full sm:w-auto flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center space-x-2">
                                            <button class="quantity-btn bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-md transition-colors"
                                                    data-item-id="{{ $item->id }}"
                                                    data-action="decrease">
                                                <i class="fas fa-minus text-sm"></i>
                                            </button>
                                            <span class="quantity-display w-12 text-center font-semibold">{{ $item->quantity }}</span>
                                            <button class="quantity-btn bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-md transition-colors"
                                                    data-item-id="{{ $item->id }}"
                                                    data-action="increase">
                                                <i class="fas fa-plus text-sm"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Price -->
                                        <div class="text-center sm:text-right">
                                            <p class="text-base sm:text-lg font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                            <p class="text-xs sm:text-sm text-gray-500">Rp {{ number_format($item->menu->price, 0, ',', '.') }} per item</p>
                                        </div>
                                        
                                        <!-- Remove Button -->
                                        <button class="remove-item-btn text-red-500 hover:text-red-700 transition-colors"
                                                data-item-id="{{ $item->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Total Pesanan</span>
                                <span class="font-semibold">{{ $totalQuantity }} item</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total</span>
                                    <span class="text-orange-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <button class="checkout-btn w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 px-4 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl">
                            <i class="fas fa-credit-card mr-2"></i>
                            Checkout Sekarang
                        </button>
                        
                        <a href="{{ route('menus.index') }}" class="block w-full text-center mt-3 text-orange-600 hover:text-orange-700 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Lanjutkan Belanja
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-12 md:py-16">
                <div class="max-w-md mx-auto px-4">
                    <svg class="mx-auto h-16 md:h-20 w-16 md:w-20 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"/>
                    </svg>
                    <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-2">Keranjang Kosong</h3>
                    <p class="text-gray-500 mb-6 text-sm md:text-base">Belum ada item dalam keranjang Anda</p>
                    <a href="{{ route('menus.index') }}" class="inline-flex items-center px-4 md:px-6 py-2 md:py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition text-sm md:text-base">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@if($cartItems->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const action = this.dataset.action;
            const quantityDisplay = this.parentElement.querySelector('.quantity-display');
            const currentQuantity = parseInt(quantityDisplay.textContent);
            
            let newQuantity = currentQuantity;
            if (action === 'increase') {
                newQuantity = currentQuantity + 1;
            } else if (action === 'decrease') {
                newQuantity = currentQuantity - 1;
            }
            
            if (newQuantity !== currentQuantity) {
                if (newQuantity <= 0) {
                    // If quantity becomes 0 or less, remove the item
                    removeCartItem(itemId);
                } else {
                    updateCartItem(itemId, newQuantity);
                }
            }
        });
    });
    
    // Remove item
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            removeCartItem(itemId);
        });
    });
    
    function updateCartItem(itemId, quantity) {
        fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal mengupdate item',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengupdate item',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }
    
    function removeCartItem(itemId) {
        fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal menghapus item',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat menghapus item',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }
    
    // Checkout button
    const checkoutBtn = document.querySelector('.checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            Swal.fire({
                title: 'Checkout?',
                text: 'Apakah Anda yakin ingin melanjutkan ke proses checkout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Checkout!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch('{{ route("order.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Terjadi kesalahan saat checkout');
                            });
                        }
                        return response.json();
                    })
                    .catch(error => {
                        throw error;
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed && result.value.redirect_url) {
                    // Redirect to payment page
                    window.location.href = result.value.redirect_url;
                }
            }).catch((error) => {
                Swal.fire({
                    title: 'Error!',
                    text: error.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    }
});
</script>
@endif
@endsection
