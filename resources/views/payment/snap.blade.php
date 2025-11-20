<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pembayaran - Rumah Makan Cita Rasa</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo/logo1.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/logo1.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/logo1.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @php
        $manifestPath = public_path('build/manifest.json');
        $manifestExists = file_exists($manifestPath);
        $cssFile = null;
        $jsFile = null;
        
        if ($manifestExists) {
            try {
                $manifest = json_decode(file_get_contents($manifestPath), true);
                $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
                $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
            } catch (\Exception $e) {
                // Manifest exists but can't be read
            }
        }
    @endphp
    
    @if($manifestExists && $cssFile && $jsFile)
        <!-- Production: Load from manifest -->
        <link rel="stylesheet" href="{{ url('build/' . $cssFile) }}">
        <script src="{{ url('build/' . $jsFile) }}" defer></script>
    @else
        <!-- Development: Use Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <!-- Midtrans Snap Script -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    
    <style>
        /* Ensure testing instructions are always visible */
        .testing-instructions {
            position: relative;
            top: auto;
            z-index: 10;
        }

        @media (min-width: 768px) {
            .testing-instructions {
                position: sticky;
                top: 20px;
            }
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

            <!-- Info Box - includes testing info and user guidance -->
            <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4 mb-4 shadow-md testing-instructions space-y-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mr-3 mt-1 text-xl"></i>
                    <div class="flex-1">
                        <p class="text-base text-blue-900 font-bold mb-2">
                            Mode Testing (Sandbox) <span class="inline-block bg-amber-200 text-amber-900 text-xs font-semibold px-2 py-0.5 rounded ml-2 uppercase tracking-wide">Mohon dibaca</span>
                        </p>
                        <p class="text-sm text-blue-800 mb-3">
                            Sistem menggunakan Midtrans sandbox untuk testing. <strong>Mode ini hanya mendukung pembayaran kartu kredit testing.</strong> Mohon <strong>jangan memilih metode lain</strong> karena tidak akan berfungsi.
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
                                    <span><strong class="text-blue-800">Expiry:</strong> Tanggal masa depan, contoh 01/28 atau 10/28</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex items-start border-t border-blue-200 pt-4 mt-4">
                    <i class="fas fa-credit-card text-blue-600 mr-3 mt-1 text-xl"></i>
                    <div class="flex-1 text-sm text-blue-900 space-y-2">
                        <p class="text-base font-semibold text-blue-800">Panduan Kartu Kredit (Testing)</p>
                        <p>1. Klik <strong>Bayar Sekarang</strong>, masuk ke jendela Snap, lalu pilih metode <strong>Kartu Kredit</strong>. Jangan pilih metode lain karena mode testing sandbox tidak mendukungnya.</p>
                        <p>2. Masukkan data uji di atas (nomor kartu, CVV, dan tanggal kadaluarsa masa depan), kemudian ikuti instruksi OTP simulasi hingga pembayaran selesai.</p>
                        <p>3. Jika ingin mengganti metode lain, klik ikon <strong>panah melingkar</strong> di pojok kanan atas jendela Snap atau tutup jendela (ikon ❌) dan tekan kembali <strong>Bayar Sekarang</strong>.</p>
                        <p class="text-xs text-blue-700">Catatan: Jendela pembayaran memiliki batas waktu. Bila tertutup otomatis, ulangi langkah di atas.</p>
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
        const payButton = document.getElementById('pay-button');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const refreshTokenUrl = '{{ route('order.refresh-snap-token', $order) }}';

        async function refreshSnapTokenWithFeedback() {
            paymentProcessed = false;
            payButton.disabled = true;
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyiapkan ulang...';

            try {
                const response = await fetch(refreshTokenUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({})
                });

                if (!response.ok) {
                    throw new Error('Gagal memperbarui token');
                }

                const data = await response.json();
                snapToken = data.snap_token;

                setTimeout(() => {
                    Swal.fire({
                        title: 'Pembayaran Dibatalkan',
                        text: 'Anda menutup jendela pembayaran. Klik Bayar Sekarang untuk memilih metode lain.',
                        icon: 'info',
                        confirmButtonColor: '#f97316',
                        confirmButtonText: 'OK'
                    });
                }, 400);
            } catch (error) {
                console.error('Refresh Snap token error:', error);
                Swal.fire({
                    title: 'Gagal Menyiapkan Ulang',
                    text: 'Silakan muat ulang halaman atau coba lagi.',
                    icon: 'error',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: 'OK'
                });
            } finally {
                payButton.disabled = false;
                payButton.innerHTML = '<i class="fas fa-credit-card mr-2"></i>Bayar Sekarang';
            }
        }
        
        // Handle pay button click
        payButton.addEventListener('click', function() {
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
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fas fa-credit-card mr-2"></i>Bayar Sekarang';
                    
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
                    refreshSnapTokenWithFeedback();
                }
            });
        });
    </script>
</body>
</html>

