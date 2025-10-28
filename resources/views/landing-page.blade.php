@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 text-center py-12 md:py-20">
        <div class="container mx-auto grid md:grid-cols-2 gap-8 md:gap-12 items-center px-4 sm:px-6">
            <div class="animate-fade-in">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 md:mb-6 text-gray-800 leading-tight">
                    We provide the <span class="text-orange-600">best food</span> for you
                </h1>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-600 mb-6 md:mb-8 leading-relaxed">
                    Kami hadir untuk memberikan pengalaman kuliner terbaik dengan menu beragam, 
                    rasa autentik, dan suasana yang nyaman. Setiap suapan bukan hanya mengenyangkan, 
                    tetapi juga menghadirkan kenangan manis yang ingin Anda ulangi kembali.
                </p>
                <a href="{{ route('menus.index') }}"  
                    class="bg-orange-500 text-white px-6 md:px-8 py-2 md:py-3 rounded-lg shadow-lg hover:bg-orange-600 hover:scale-105 transition transform duration-300 text-sm md:text-base">
                    Lihat Menu
                </a>
            </div>
            <div class="relative group">
                <img src="{{ asset('images/rumah-makan.jpg') }}" 
                    alt="Restaurant" 
                    class="rounded-lg md:rounded-xl shadow-2xl w-full transform group-hover:scale-105 transition duration-500">
            </div>
        </div>
    </section>

    {{-- Special Dishes --}}
    <section class="bg-white py-12 md:py-20" id="menu">
        <div class="container mx-auto text-center px-4 sm:px-6">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-8 md:mb-12 text-gray-800">✨ Our Special Dishes ✨</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8">
                {{-- Dish Item --}}
                @foreach([
                    ['img' => 'spicy-noodles.jpg', 'name' => 'Spicy Noodles', 'price' => 'Rp 25.000'],
                    ['img' => 'fried-rice.jpeg', 'name' => 'Fried Rice', 'price' => 'Rp 30.000'],
                    ['img' => 'satay.jpg', 'name' => 'Satay', 'price' => 'Rp 20.000'],
                    ['img' => 'salad.jpg', 'name' => 'Special Salad', 'price' => 'Rp 22.000'],
                ] as $dish)
                <div class="bg-gray-50 p-4 md:p-6 rounded-lg md:rounded-xl shadow hover:shadow-xl transition duration-300 hover:-translate-y-1 md:hover:-translate-y-2">
                    <img src="{{ asset('images/' . $dish['img']) }}" 
                        class="rounded-md mb-3 md:mb-4 w-full h-32 sm:h-36 md:h-44 object-cover" alt="">
                    <h3 class="font-bold text-base md:text-lg text-gray-800">{{ $dish['name'] }}</h3>
                    <p class="text-orange-600 font-semibold mt-1 text-sm md:text-base">{{ $dish['price'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Welcome Section --}}
    <section class="py-12 md:py-20 bg-gradient-to-r from-yellow-50 via-white to-orange-50">
        <div class="container mx-auto flex flex-col md:flex-row items-center gap-8 md:gap-12 px-4 sm:px-6">
            <img src="{{ asset('images/rumah-makan2.jpeg') }}" 
                alt="Food" 
                class="w-full md:w-1/2 rounded-lg md:rounded-2xl shadow-xl transform hover:scale-105 transition duration-500">
            <div class="text-center md:text-left">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold mb-4 md:mb-6 text-gray-800">Welcome to Our Restaurant</h2>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-600 mb-6 md:mb-8 leading-relaxed">
                    Kami mengerti waktu Anda berharga. Karena itu, kini Anda bisa melakukan pemesanan secara 
                    online dan cukup ambil pesanan di restoran. Rasakan kemudahan, kecepatan, dan nikmati makanan lezat tanpa ribet menunggu!
                </p>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-orange-300 border-t border-orange-200 py-8 md:py-12">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 px-4 sm:px-6 text-white">

            {{-- Logo & Deskripsi --}}
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <img src="{{ asset('images/logo/logo1.png') }}" alt="Logo" class="h-16 w-16 md:h-20 md:w-20 rounded-full border-2 border-white">
                    <span class="text-lg md:text-xl font-bold">Cita Rasa</span>
                </div>
                <p class="text-sm leading-relaxed mb-4 opacity-90">
                    Nikmati aneka menu lezat dengan kualitas terbaik.  
                    Pesan online sekarang, ambil langsung di tempat tanpa perlu antre lama.
                </p>
            </div>

            {{-- Navigation --}}
            <div>
                <h4 class="font-semibold mb-4 text-base md:text-lg">Navigation</h4>
                <ul class="space-y-2 text-sm opacity-90">
                    <li><a href="{{ route('menus.index') }}" class="hover:text-yellow-300 transition-colors">Menu</a></li>
                    <li><a href="{{ url('/about') }}" class="hover:text-yellow-300 transition-colors">About Us</a></li>
                    <li><a href="{{ url('/contact') }}" class="hover:text-yellow-300 transition-colors">Contact Us</a></li>
                </ul>
            </div>

            {{-- Opening Hours & Social --}}
            <div>
                <h4 class="font-semibold mb-4 text-base md:text-lg">Opening Hours</h4>
                <ul class="text-sm opacity-90 mb-6">
                    <li>Monday - Friday <br> <span class="opacity-75">10:30 - 21:30 WIB</span></li>
                    <li class="mt-2">Saturday - Sunday <br> <span class="opacity-75">10:30 - 21:30 WIB</span></li>
                </ul>

                <h4 class="font-semibold mb-4 text-base md:text-lg">Contact Us</h4>
                <a href="https://wa.me/6281352270928" target="_blank" class="flex items-center space-x-2 text-sm hover:text-yellow-300 transition-colors">
                    <i class="fab fa-whatsapp text-lg md:text-xl"></i>
                    <span>Hubungi Kami</span>
                </a>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="mt-8 md:mt-12 text-center text-xs md:text-sm border-t border-orange-300 pt-4 md:pt-6 text-white opacity-75 px-4">
            <p>© {{ date('Y') }} Rumah Makan Cita Rasa. All rights reserved.</p>
        </div>
    </footer>


@endsection
