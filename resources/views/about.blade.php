@extends('layouts.app')

@section('content')
    {{-- Hero About --}}
    <section class="bg-gradient-to-r from-orange-100 via-yellow-50 to-red-50 py-12 md:py-20">
        <div class="container mx-auto grid md:grid-cols-2 gap-8 md:gap-12 items-center px-4 sm:px-6">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-800 leading-tight mb-4 md:mb-6">
                    Tentang <span class="text-orange-600">Rumah Makan Cita Rasa</span>
                </h1>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed mb-6 md:mb-8">
                    Berdiri sejak tahun 2005, Rumah Makan Cita Rasa berkomitmen 
                    menghadirkan cita rasa autentik dengan kualitas terbaik.  
                    Setiap hidangan kami dimasak dengan penuh perhatian, menggunakan 
                    bahan-bahan segar, serta resep turun-temurun yang menjaga rasa tetap istimewa.
                </p>
                <a href="{{ url('/contact') }}" 
                    class="bg-orange-500 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg shadow-lg hover:bg-orange-600 transition transform hover:scale-105 text-sm md:text-base">
                    Hubungi Kami
                </a>
            </div>
            <div class="relative group">
                <img src="{{ asset('images/rumah-makan.jpg') }}" 
                    alt="About Us" 
                    class="rounded-lg md:rounded-2xl shadow-2xl w-full transform group-hover:scale-105 transition duration-500">
            </div>
        </div>
    </section>

    {{-- Visi Misi --}}
    <section class="py-12 md:py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-8 md:mb-12">✨ Visi & Misi ✨</h2>
            <div class="grid md:grid-cols-2 gap-6 md:gap-8 lg:gap-12">
                <div class="bg-orange-50 p-6 md:p-8 rounded-lg md:rounded-xl shadow hover:shadow-xl transition">
                    <h3 class="text-xl md:text-2xl font-semibold text-orange-600 mb-3 md:mb-4">Visi</h3>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                        Menjadi rumah makan pilihan utama masyarakat dengan 
                        menyajikan hidangan berkualitas, pelayanan ramah, dan 
                        pengalaman kuliner yang berkesan.
                    </p>
                </div>
                <div class="bg-orange-50 p-6 md:p-8 rounded-lg md:rounded-xl shadow hover:shadow-xl transition">
                    <h3 class="text-xl md:text-2xl font-semibold text-orange-600 mb-3 md:mb-4">Misi</h3>
                    <ul class="text-gray-600 space-y-2 md:space-y-3 text-left text-sm md:text-base">
                        <li>✅ Menyajikan makanan lezat dengan bahan segar dan higienis.</li>
                        <li>✅ Memberikan pelayanan cepat, ramah, dan profesional.</li>
                        <li>✅ Menjaga keaslian rasa.</li>
                        <li>✅ Memberikan pengalaman makan yang nyaman dan hangat.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
