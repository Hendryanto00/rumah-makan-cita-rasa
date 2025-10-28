<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pembayaran - Rumah Makan Cita Rasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo1.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Midtrans Snap Script -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    
    <style>
        /* Ensure testing instructions are always visible */
        .testing-instructions {
            position: sticky;
            top: 20px;
            z-index: 10;
        }
        
        /* Ensure snap container doesn't overflow */
        #snap-container {
            position: relative;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-2xl w-full">
            <!-- Header -->
            <div class="bg-white rounded-t-lg shadow-lg p-6 border-b">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Pembayaran</h1>
                        <p class="text-gray-600 mt-1">Silakan selesaikan pembayaran Anda</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Order ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $order->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Info Box - Moved to top so it's always visible -->
            <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4 mb-4 shadow-md testing-instructions">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mr-3 mt-1 text-xl"></i>
                    <div class="flex-1">
                        <p class="text-base text-blue-900 font-bold mb-2">Mode Testing (Sandbox)</p>
                        <p class="text-sm text-blue-800 mb-3">
                            Sistem menggunakan Midtrans sandbox untuk testing. Untuk pembayaran uji coba, gunakan kartu kredit testing berikut:
                        </p>
                        <div class="bg-white rounded-lg p-3 border border-blue-200">
                            <ul class="text-sm text-blue-900 space-y-2">
                                <li class="flex items-start">
                                    <i class="fas fa-credit-card text-blue-600 mr-2 mt-0.5"></i>
                                    <span><strong class="text-blue-800">Kartu:</strong> 4811 1111 1111 1114</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-lock text-blue-600 mr-2 mt-0.5"></i>
                                    <span><strong class="text-blue-800">CVV:</strong> 123</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-calendar text-blue-600 mr-2 mt-0.5"></i>
                                    <span><strong class="text-blue-800">Expiry:</strong> Setiap tanggal masa depan</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Container -->
            <div class="bg-white rounded-b-lg shadow-lg p-6">
                <!-- Order Summary -->
                <div class="mb-6 pb-6 border-b">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-3">
                        @foreach($order->details as $detail)
                        <div class="flex justify-between items-center">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $detail->menu->name }}</p>
                                <p class="text-sm text-gray-500">{{ $detail->quantity }}x @ Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-semibold text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 pt-4 border-t">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-orange-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Pay Button -->
                <div class="mb-6">
                    <button id="pay-button" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-4 px-6 rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl flex items-center justify-center">
                        <i class="fas fa-credit-card mr-2"></i>
                        Bayar Sekarang
                    </button>
                </div>
                
                <!-- Snap container (hidden, will be populated when button clicked) -->
                <div id="snap-container" style="display: none;">
                    <!-- Snap widget will be embedded here -->
                </div>

                <!-- Back Button -->
                <a href="{{ route('cart.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        let snapToken = '{{ $snapToken }}';
        let paymentProcessed = false;
        
        // Handle pay button click
        document.getElementById('pay-button').addEventListener('click', function() {
            if (paymentProcessed) return;
            
            // Disable button to prevent multiple clicks
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            
            // Show payment modal
            window.snap.pay(snapToken, {
                onSuccess: function(result) {
                    paymentProcessed = true;
                    
                    // Clear cart after successful payment
                    fetch('{{ route("cart.clear") }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(() => {
                        // Update cart count to 0
                        const cartCountElements = document.querySelectorAll('.cart-count');
                        cartCountElements.forEach(element => {
                            element.textContent = '0';
                            element.classList.add('hidden');
                        });
                        
                        // Handle success
                        Swal.fire({
                            title: 'Pembayaran Berhasil!',
                            text: 'Terima kasih telah melakukan pembayaran',
                            icon: 'success',
                            confirmButtonColor: '#f97316',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '{{ route("orders.index") }}';
                        });
                    });
                },
                onPending: function(result) {
                    paymentProcessed = true;
                    // Handle pending
                    Swal.fire({
                        title: 'Menunggu Pembayaran',
                        text: 'Pembayaran Anda sedang diproses',
                        icon: 'info',
                        confirmButtonColor: '#f97316',
                        confirmButtonText: 'OK'
                    });
                },
                onError: function(result) {
                    paymentProcessed = false;
                    // Re-enable button on error
                    const btn = document.getElementById('pay-button');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-credit-card mr-2"></i>Bayar Sekarang';
                    
                    // Handle error
                    Swal.fire({
                        title: 'Pembayaran Gagal',
                        text: 'Silakan coba lagi atau gunakan metode pembayaran lain',
                        icon: 'error',
                        confirmButtonColor: '#f97316',
                        confirmButtonText: 'OK'
                    });
                },
                onClose: function() {
                    paymentProcessed = false;
                    // Re-enable button when closed
                    const btn = document.getElementById('pay-button');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-credit-card mr-2"></i>Bayar Sekarang';
                    
                    // Handle close
                    Swal.fire({
                        title: 'Pembayaran Dibatalkan',
                        text: 'Anda membatalkan pembayaran',
                        icon: 'warning',
                        confirmButtonColor: '#f97316',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
</body>
</html>

