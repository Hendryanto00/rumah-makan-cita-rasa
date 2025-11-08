@extends('layouts.app')

@section('content')
    {{-- Hero About --}}
    <section class="relative bg-gradient-to-br from-orange-400 via-orange-500 to-red-500 py-16 md:py-24 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-10 rounded-full animate-pulse"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
        </div>
        
        <div class="container mx-auto grid md:grid-cols-2 gap-8 md:gap-12 items-center px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center md:text-left">
                <div class="inline-block mb-4">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold shadow-lg">
                        ✨ Tentang Kami
                    </span>
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight mb-4 md:mb-6 drop-shadow-lg">
                    Tentang <span class="text-yellow-200">Rumah Makan Cita Rasa</span>
                </h1>
                <p class="text-base sm:text-lg md:text-xl text-orange-50 leading-relaxed mb-6 md:mb-8 max-w-2xl mx-auto md:mx-0">
                    Berdiri sejak tahun 2005, Rumah Makan Cita Rasa berkomitmen 
                    menghadirkan cita rasa autentik dengan kualitas terbaik.  
                    Setiap hidangan kami dimasak dengan penuh perhatian, menggunakan 
                    bahan-bahan segar, serta resep turun-temurun yang menjaga rasa tetap istimewa.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ url('/contact') }}" 
                        class="bg-white text-orange-600 px-8 md:px-10 py-3 md:py-4 rounded-xl shadow-2xl hover:bg-orange-50 hover:scale-105 transition-all duration-300 text-base md:text-lg font-bold inline-flex items-center justify-center gap-2">
                        <span>Hubungi Kami</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('menus.index') }}" 
                        class="bg-white/10 backdrop-blur-sm text-white px-8 md:px-10 py-3 md:py-4 rounded-xl border-2 border-white/30 hover:bg-white/20 hover:scale-105 transition-all duration-300 text-base md:text-lg font-semibold inline-flex items-center justify-center gap-2">
                        <span>Lihat Menu</span>
                        <i class="fas fa-utensils"></i>
                    </a>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-red-600/20 rounded-2xl blur-2xl transform group-hover:scale-110 transition duration-700"></div>
                <img src="{{ asset('images/rumah-makan.jpg') }}" 
                    alt="Tentang Kami" 
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

    {{-- Visi Misi --}}
    <section class="py-16 md:py-24 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-12 md:mb-16">
                <div class="inline-block mb-4 animate-bounce">
                    <span class="text-3xl md:text-4xl">✨</span>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                    <span class="text-orange-600">Visi & Misi</span> Kami
                </h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Komitmen kami untuk memberikan yang terbaik
                </p>
            </div>
            <div class="grid md:grid-cols-2 gap-6 md:gap-8 lg:gap-12 max-w-6xl mx-auto">
                <div class="group bg-white p-6 md:p-8 lg:p-10 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full mb-6 shadow-lg">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-orange-600 mb-4 md:mb-6">Visi</h3>
                    <p class="text-gray-700 leading-relaxed text-base md:text-lg">
                        Menjadi rumah makan pilihan utama masyarakat dengan 
                        menyajikan hidangan berkualitas, pelayanan ramah, dan 
                        pengalaman kuliner yang berkesan.
                    </p>
                </div>
                <div class="group bg-white p-6 md:p-8 lg:p-10 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-full mb-6 shadow-lg">
                        <i class="fas fa-bullseye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-orange-600 mb-4 md:mb-6">Misi</h3>
                    <ul class="text-gray-700 space-y-3 md:space-y-4 text-left text-base md:text-lg">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Menyajikan makanan lezat dengan bahan segar dan higienis.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Memberikan pelayanan cepat, ramah, dan profesional.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Menjaga keaslian rasa.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Memberikan pengalaman makan yang nyaman dan hangat.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
