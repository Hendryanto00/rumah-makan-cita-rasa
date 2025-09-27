@extends('layouts.app')

@section('title', 'Contact Us - Rumah Makan Cita Rasa')

@section('content')
    {{-- Hero Contact --}}
    <section class="bg-gradient-to-r from-orange-100 via-yellow-50 to-red-50 py-20">
        <div class="container mx-auto grid md:grid-cols-2 gap-12 items-center px-6">
            <!-- Text -->
            <div>
                <h1 class="text-5xl font-extrabold text-gray-800 leading-tight mb-6">
                    Hubungi <span class="text-orange-600">Rumah Makan Cita Rasa</span>
                </h1>
                <p class="text-lg text-gray-600 leading-relaxed mb-8">
                    Kami siap melayani reservasi, pemesanan, maupun pertanyaan Anda.  
                    Silakan hubungi kami melalui informasi di bawah ini atau kunjungi langsung lokasi kami.
                </p>
                <a href="https://wa.me/6281352270928" 
                    class="bg-orange-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-orange-600 transition transform hover:scale-105 inline-block">
                    Hubungi via WhatsApp
                </a>
            </div>

            <!-- Map -->
            <div class="overflow-hidden rounded-2xl shadow-2xl">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.363491272818!2d112.92138547496502!3d0.865145799126474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3201eb003f62e161%3A0xde2f0a2682e6e3d9!2sRumah%20Makan%20Cita%20Rasa!5e0!3m2!1sen!2sid!4v1758092256632!5m2!1sen!2sid" 
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    {{-- Info Kontak --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 text-center mb-12">📍 Informasi Kontak</h2>
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Detail Kontak -->
                <div class="bg-orange-50 p-10 rounded-2xl shadow hover:shadow-xl transition">
                    <h3 class="text-2xl font-semibold text-orange-600 mb-6">Rumah Makan Cita Rasa</h3>
                    <ul class="space-y-6 text-gray-700">
                        <li>
                            <strong class="block text-lg">Alamat:</strong>
                            Jl. Kom Yos Sudarso No.04, Putussibau Kota,<br>
                            Kec. Putussibau Utara, Kab. Kapuas Hulu,<br>
                            Kalimantan Barat 78711
                        </li>
                        <li>
                            <strong class="block text-lg">Jam Operasional:</strong>
                            Setiap hari, 10.30 – 21.30 WIB
                        </li>
                        <li>
                            <strong class="block text-lg">Telepon/WhatsApp:</strong>
                            <a href="https://wa.me/6281352270928" 
                                class="text-orange-600 font-medium hover:underline">
                                0813-5227-0928
                            </a>
                        </li>
                        <li>
                            <strong class="block text-lg">Kode Lokasi Plus:</strong>
                            VW8F+3H Putussibau Kota, Kapuas Hulu Regency, West Kalimantan
                        </li>
                    </ul>
                </div>

                <!-- Gambar Ilustrasi -->
                <div class="relative group">
                    <img src="{{ asset('images/rumah-makan2.jpeg') }}" 
                        alt="Contact Us" 
                        class="rounded-2xl shadow-2xl w-full transform group-hover:scale-105 transition duration-500">
                </div>
            </div>
        </div>
    </section>
@endsection
