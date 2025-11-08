@extends('layouts.app')

@section('title', 'Contact Us - Rumah Makan Cita Rasa')

@section('content')
    {{-- Hero Contact --}}
    <section class="relative bg-gradient-to-br from-orange-400 via-orange-500 to-red-500 py-16 md:py-24 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-10 rounded-full animate-pulse"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
        </div>
        
        <div class="container mx-auto grid md:grid-cols-2 gap-8 md:gap-12 items-center px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Text -->
            <div class="text-center md:text-left">
                <div class="inline-block mb-4">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold shadow-lg">
                        📍 Hubungi Kami
                    </span>
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight mb-4 md:mb-6 drop-shadow-lg">
                    Hubungi <span class="text-yellow-200">Rumah Makan Cita Rasa</span>
                </h1>
                <p class="text-base sm:text-lg md:text-xl text-orange-50 leading-relaxed mb-6 md:mb-8 max-w-2xl mx-auto md:mx-0">
                    Kami siap melayani reservasi, pemesanan, maupun pertanyaan Anda.  
                    Silakan hubungi kami melalui informasi di bawah ini atau kunjungi langsung lokasi kami.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="https://wa.me/6281352270928" target="_blank"
                        class="bg-white text-orange-600 px-8 md:px-10 py-3 md:py-4 rounded-xl shadow-2xl hover:bg-orange-50 hover:scale-105 transition-all duration-300 text-base md:text-lg font-bold inline-flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp text-xl"></i>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                    <a href="{{ route('menus.index') }}" 
                        class="bg-white/10 backdrop-blur-sm text-white px-8 md:px-10 py-3 md:py-4 rounded-xl border-2 border-white/30 hover:bg-white/20 hover:scale-105 transition-all duration-300 text-base md:text-lg font-semibold inline-flex items-center justify-center gap-2">
                        <span>Lihat Menu</span>
                        <i class="fas fa-utensils"></i>
                    </a>
                </div>
            </div>

            <!-- Map -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-red-600/20 rounded-2xl blur-2xl transform group-hover:scale-110 transition duration-700"></div>
                <div class="relative overflow-hidden rounded-2xl shadow-2xl border-4 border-white/20">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.363491272818!2d112.92138547496502!3d0.865145799126474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3201eb003f62e161%3A0xde2f0a2682e6e3d9!2sRumah%20Makan%20Cita%20Rasa!5e0!3m2!1sen!2sid!4v1758092256632!5m2!1sen!2sid" 
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade" class="transform group-hover:scale-[1.01] transition duration-700"></iframe>
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

    {{-- Info Kontak --}}
    <section class="py-16 md:py-24 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <div class="inline-block mb-4">
                    <span class="text-3xl md:text-4xl">📍</span>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                    <span class="text-orange-600">Informasi Kontak</span>
                </h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Hubungi kami kapan saja, kami siap melayani Anda
                </p>
            </div>
            <div class="grid md:grid-cols-2 gap-6 md:gap-8 lg:gap-12 max-w-6xl mx-auto">
                <!-- Detail Kontak -->
                <div class="bg-white p-6 md:p-8 lg:p-10 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-store text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-orange-600">Rumah Makan Cita Rasa</h3>
                    </div>
                    <ul class="space-y-5 md:space-y-6">
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-orange-600"></i>
                            </div>
                            <div class="flex-1">
                                <strong class="block text-base md:text-lg text-gray-900 mb-1">Alamat:</strong>
                                <span class="text-sm md:text-base text-gray-700">
                                    Jl. Kom Yos Sudarso No.04, Putussibau Kota,<br>
                                    Kec. Putussibau Utara, Kab. Kapuas Hulu,<br>
                                    Kalimantan Barat 78711
                                </span>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-orange-600"></i>
                            </div>
                            <div class="flex-1">
                                <strong class="block text-base md:text-lg text-gray-900 mb-1">Jam Operasional:</strong>
                                <span class="text-sm md:text-base text-gray-700">Setiap hari, 10.30 – 21.30 WIB</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fab fa-whatsapp text-green-600 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <strong class="block text-base md:text-lg text-gray-900 mb-1">Telepon/WhatsApp:</strong>
                                <a href="https://wa.me/6281352270928" target="_blank"
                                    class="text-orange-600 font-semibold hover:text-orange-700 hover:underline text-sm md:text-base inline-flex items-center gap-2">
                                    <span>0813-5227-0928</span>
                                    <i class="fas fa-external-link-alt text-xs"></i>
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-pin text-orange-600"></i>
                            </div>
                            <div class="flex-1">
                                <strong class="block text-base md:text-lg text-gray-900 mb-1">Kode Lokasi:</strong>
                                <span class="text-sm md:text-base text-gray-700">VW8F+3H Putussibau Kota, Kapuas Hulu Regency, West Kalimantan</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Gambar Ilustrasi -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-400/20 to-red-400/20 rounded-2xl blur-2xl transform group-hover:scale-110 transition duration-700"></div>
                    <img src="{{ asset('images/rumah-makan2.jpeg') }}" 
                        alt="Hubungi Kami" 
                        class="relative rounded-2xl shadow-2xl w-full transform group-hover:scale-[1.02] transition duration-700 border-4 border-white/50">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
