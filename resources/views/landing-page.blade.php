@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-orange-400 via-orange-500 to-red-500 py-16 md:py-24 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-10 rounded-full animate-pulse"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white opacity-5 rounded-full"></div>
        </div>
        
        <div class="container mx-auto grid md:grid-cols-2 gap-8 md:gap-12 items-center px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center md:text-left animate-fade-in">
                <div class="inline-block mb-4 animate-bounce md:hidden">
                    <span class="text-4xl">✨</span>
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold mb-4 md:mb-6 text-white leading-tight drop-shadow-lg">
                    Kami menyediakan <span class="text-yellow-200">makanan terbaik</span> untuk Anda
                </h1>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-orange-50 mb-6 md:mb-8 leading-relaxed max-w-2xl mx-auto md:mx-0">
                    Kami hadir untuk memberikan pengalaman kuliner terbaik dengan menu beragam, 
                    rasa autentik, dan suasana yang nyaman. Setiap suapan bukan hanya mengenyangkan, 
                    tetapi juga menghadirkan kenangan manis yang ingin Anda ulangi kembali.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('menus.index') }}"  
                        class="bg-white text-orange-600 px-8 md:px-10 py-3 md:py-4 rounded-xl shadow-2xl hover:bg-orange-50 hover:scale-105 transition-all duration-300 text-base md:text-lg font-bold inline-flex items-center justify-center gap-2">
                        <span>Lihat Menu</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ url('/about') }}"  
                        class="bg-white/10 backdrop-blur-sm text-white px-8 md:px-10 py-3 md:py-4 rounded-xl border-2 border-white/30 hover:bg-white/20 hover:scale-105 transition-all duration-300 text-base md:text-lg font-semibold inline-flex items-center justify-center gap-2">
                        <span>Tentang Kami</span>
                        <i class="fas fa-info-circle"></i>
                    </a>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-red-600/20 rounded-2xl blur-2xl transform group-hover:scale-110 transition duration-700"></div>
                <img src="{{ asset('images/rumah-makan.jpg') }}" 
                    alt="Restaurant" 
                    class="relative rounded-2xl shadow-2xl w-full transform group-hover:scale-[1.02] transition duration-700 border-4 border-white/20">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
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

    {{-- Special Dishes --}}
    <section class="bg-gradient-to-b from-white to-gray-50 py-16 md:py-24" id="menu">
        <div class="container mx-auto text-center px-4 sm:px-6 lg:px-8">
            <div class="mb-12 md:mb-16">
                <div class="inline-block mb-4 animate-bounce">
                    <span class="text-3xl md:text-4xl">✨</span>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 text-gray-900">
                    <span class="text-orange-600">Hidangan Spesial</span> Kami
                </h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Nikmati hidangan istimewa dengan cita rasa yang tak terlupakan
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                {{-- Dish Item --}}
                @foreach([
                    ['img' => 'spicy-noodles.jpg', 'name' => 'Spicy Noodles', 'price' => 'Rp 25.000'],
                    ['img' => 'fried-rice.jpeg', 'name' => 'Fried Rice', 'price' => 'Rp 30.000'],
                    ['img' => 'satay.jpg', 'name' => 'Satay', 'price' => 'Rp 20.000'],
                    ['img' => 'salad.jpg', 'name' => 'Special Salad', 'price' => 'Rp 22.000'],
                ] as $dish)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2 border border-gray-100">
                    <div class="relative overflow-hidden h-48 md:h-56">
                        <img src="{{ asset('images/' . $dish['img']) }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                            alt="{{ $dish['name'] }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="px-3 py-1.5 rounded-full bg-white/90 backdrop-blur-sm text-orange-600 text-xs font-bold shadow-lg">
                                Spesial
                            </span>
                        </div>
                    </div>
                    <div class="p-5 md:p-6">
                        <h3 class="font-bold text-lg md:text-xl text-gray-900 mb-2 group-hover:text-orange-600 transition-colors">
                            {{ $dish['name'] }}
                        </h3>
                        <p class="text-orange-600 font-bold text-lg md:text-xl">
                            {{ $dish['price'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-12 md:mt-16">
                <a href="{{ route('menus.index') }}" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-8 py-4 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 text-base md:text-lg font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span>Lihat Semua Menu</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- Welcome Section --}}
    <section class="py-16 md:py-24 bg-gradient-to-br from-orange-50 via-white to-yellow-50 relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-orange-200/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-200/20 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto flex flex-col md:flex-row items-center gap-8 md:gap-12 lg:gap-16 px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="w-full md:w-1/2 relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-400/20 to-red-400/20 rounded-3xl blur-2xl transform group-hover:scale-110 transition duration-700"></div>
                <img src="{{ asset('images/rumah-makan2.jpeg') }}" 
                    alt="Food" 
                    class="relative rounded-2xl md:rounded-3xl shadow-2xl w-full transform group-hover:scale-[1.02] transition duration-700 border-4 border-white/50">
                <div class="absolute inset-0 rounded-2xl md:rounded-3xl bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>
            <div class="w-full md:w-1/2 text-center md:text-left">
                <div class="inline-block mb-4">
                    <span class="px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full text-sm font-semibold shadow-lg">
                        ✨ Tentang Kami
                    </span>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 md:mb-8 text-gray-900 leading-tight">
                    Selamat Datang di <span class="text-orange-600">Restoran Kami</span>
                </h2>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-700 mb-8 md:mb-10 leading-relaxed">
                    Kami mengerti waktu Anda berharga. Karena itu, kini Anda bisa melakukan pemesanan secara 
                    online dan cukup ambil pesanan di restoran. Rasakan kemudahan, kecepatan, dan nikmati makanan lezat tanpa ribet menunggu!
                </p>
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-gray-100">
                        <div class="text-3xl mb-2">⚡</div>
                        <h3 class="font-bold text-gray-900 mb-1">Pesan Online</h3>
                        <p class="text-sm text-gray-600">Mudah & Cepat</p>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-gray-100">
                        <div class="text-3xl mb-2">🍽️</div>
                        <h3 class="font-bold text-gray-900 mb-1">Ambil di Tempat</h3>
                        <p class="text-sm text-gray-600">Tanpa Antre</p>
                    </div>
                </div>
                <a href="{{ route('menus.index') }}" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-8 py-4 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 text-base md:text-lg font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span>Pesan Sekarang</span>
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="relative bg-gradient-to-br from-orange-600 via-orange-500 to-red-500 py-12 md:py-16 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 px-4 sm:px-6 lg:px-8 text-white relative z-10">
            {{-- Logo & Deskripsi --}}
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="relative">
                        <img src="{{ asset('images/logo/logo1.png') }}" alt="Logo" class="h-16 w-16 md:h-20 md:w-20 rounded-full border-4 border-white/30 shadow-xl">
                        <div class="absolute inset-0 rounded-full bg-white/20 blur-xl"></div>
                    </div>
                    <span class="text-xl md:text-2xl font-extrabold drop-shadow-lg">Cita Rasa</span>
                </div>
                <p class="text-sm md:text-base leading-relaxed mb-6 opacity-95">
                    Nikmati aneka menu lezat dengan kualitas terbaik.  
                    Pesan online sekarang, ambil langsung di tempat tanpa perlu antre lama.
                </p>
            </div>

            {{-- Navigation --}}
            <div>
                <h4 class="font-bold mb-6 text-lg md:text-xl">Tautan Cepat</h4>
                <ul class="space-y-3 text-sm md:text-base">
                    <li>
                        <a href="{{ route('menus.index') }}" 
                           class="hover:text-yellow-200 transition-colors duration-300 inline-flex items-center gap-2 group">
                            <i class="fas fa-utensils text-sm group-hover:translate-x-1 transition-transform"></i>
                            <span>Menu</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/about') }}" 
                           class="hover:text-yellow-200 transition-colors duration-300 inline-flex items-center gap-2 group">
                            <i class="fas fa-info-circle text-sm group-hover:translate-x-1 transition-transform"></i>
                            <span>Tentang Kami</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}" 
                           class="hover:text-yellow-200 transition-colors duration-300 inline-flex items-center gap-2 group">
                            <i class="fas fa-envelope text-sm group-hover:translate-x-1 transition-transform"></i>
                            <span>Hubungi Kami</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Opening Hours & Contact --}}
            <div>
                <h4 class="font-bold mb-6 text-lg md:text-xl">Jam Operasional</h4>
                <ul class="text-sm md:text-base opacity-95 mb-8 space-y-3">
                    <li class="flex items-start gap-3">
                        <div class="w-5 flex-shrink-0 flex items-center justify-center mt-0.5">
                            <i class="fas fa-calendar-week text-yellow-200 text-base"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold mb-0.5">Senin - Jumat</div>
                            <div class="opacity-90">10:30 - 21:30 WIB</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-5 flex-shrink-0 flex items-center justify-center mt-0.5">
                            <i class="fas fa-calendar-weekend text-yellow-200 text-base"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold mb-0.5">Sabtu - Minggu</div>
                            <div class="opacity-90">10:30 - 21:30 WIB</div>
                        </div>
                    </li>
                </ul>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                    <h5 class="font-semibold mb-2 text-sm">Butuh Bantuan?</h5>
                    <a href="https://wa.me/6281352270928" target="_blank" 
                       class="inline-flex items-center gap-2 text-sm hover:text-yellow-200 transition-colors duration-300 group">
                        <i class="fab fa-whatsapp text-lg group-hover:scale-110 transition-transform"></i>
                        <span>Hubungi Kami via WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="mt-12 md:mt-16 text-center text-xs md:text-sm border-t border-white/20 pt-6 md:pt-8 text-white opacity-90 px-4 relative z-10">
            <p>© {{ date('Y') }} Rumah Makan Cita Rasa. Hak cipta dilindungi.</p>
        </div>
    </footer>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 3000,
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
        timer: 5000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: 'OK',
        confirmButtonColor: '#f97316'
    });
</script>
@endif

@endsection
