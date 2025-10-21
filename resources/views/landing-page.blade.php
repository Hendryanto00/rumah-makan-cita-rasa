@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 text-center py-20">
        <div class="container mx-auto grid md:grid-cols-2 gap-12 items-center px-6">
            <div class="animate-fade-in">
                <h1 class="text-6xl font-extrabold mb-6 text-gray-800 leading-tight">
                    We provide the <span class="text-orange-600">best food</span> for you
                </h1>
                <p class="text-2xl text-gray-600 mb-8 leading-relaxed">
                    Kami hadir untuk memberikan pengalaman kuliner terbaik dengan menu beragam, 
                    rasa autentik, dan suasana yang nyaman. Setiap suapan bukan hanya mengenyangkan, 
                    tetapi juga menghadirkan kenangan manis yang ingin Anda ulangi kembali.
                </p>
                <a href="{{ route('menus.index') }}"  
                    class="bg-orange-500 text-white px-8 py-3 rounded-lg shadow-lg hover:bg-orange-600 hover:scale-105 transition transform duration-300">
                    Lihat Menu
                </a>
            </div>
            <div class="relative group">
                <img src="{{ asset('images/rumah-makan.jpg') }}" 
                    alt="Restaurant" 
                    class="rounded-xl shadow-2xl w-full transform group-hover:scale-105 transition duration-500">
            </div>
        </div>
    </section>

    {{-- Special Dishes --}}
    <section class="bg-white py-20" id="menu">
        <div class="container mx-auto text-center px-6">
            <h2 class="text-4xl font-bold mb-12 text-gray-800">✨ Our Special Dishes ✨</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Dish Item --}}
                @foreach([
                    ['img' => 'spicy-noodles.jpg', 'name' => 'Spicy Noodles', 'price' => 'Rp 25.000'],
                    ['img' => 'fried-rice.jpeg', 'name' => 'Fried Rice', 'price' => 'Rp 30.000'],
                    ['img' => 'satay.jpg', 'name' => 'Satay', 'price' => 'Rp 20.000'],
                    ['img' => 'salad.jpg', 'name' => 'Special Salad', 'price' => 'Rp 22.000'],
                ] as $dish)
                <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-xl transition duration-300 hover:-translate-y-2">
                    <img src="{{ asset('images/' . $dish['img']) }}" 
                        class="rounded-md mb-4 w-full h-44 object-cover" alt="">
                    <h3 class="font-bold text-lg text-gray-800">{{ $dish['name'] }}</h3>
                    <p class="text-orange-600 font-semibold mt-1">{{ $dish['price'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Welcome Section --}}
    <section class="py-20 bg-gradient-to-r from-yellow-50 via-white to-orange-50">
        <div class="container mx-auto flex flex-col md:flex-row items-center gap-12 px-6">
            <img src="{{ asset('images/rumah-makan2.jpeg') }}" 
                alt="Food" 
                class="w-full md:w-1/2 rounded-2xl shadow-xl transform hover:scale-105 transition duration-500">
            <div class="text-center md:text-left">
                <h2 class="text-5xl font-extrabold mb-6 text-gray-800">Welcome to Our Restaurant</h2>
                <p class="text-2xl text-gray-600 mb-8 leading-relaxed">
                    Kami mengerti waktu Anda berharga. Karena itu, kini Anda bisa melakukan pemesanan secara 
                    online dan cukup ambil pesanan di restoran. Rasakan kemudahan, kecepatan, dan nikmati makanan lezat tanpa ribet menunggu!
                </p>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-orange-300 border-t border-orange-200 py-12">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 px-6 text-white">

            {{-- Logo & Deskripsi --}}
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <img src="{{ asset('images/logo/logo1.png') }}" alt="Logo" class="h-200 w-20 rounded-full border-2 border-white">
                    <span class="text-xl font-bold">Cita Rasa</span>
                </div>
                <p class="text-sm leading-relaxed mb-4 opacity-90">
                    Nikmati aneka menu lezat dengan kualitas terbaik.  
                    Pesan online sekarang, ambil langsung di tempat tanpa perlu antre lama.
                </p>
            </div>

            {{-- Navigation --}}
            <div>
                <h4 class="font-semibold mb-4">Navigation</h4>
                <ul class="space-y-2 text-sm opacity-90">
                    <li><a href="{{ route('menus.index') }}" class="hover:text-yellow-300">Menu</a></li>
                    <li><a href="{{ url('/about') }}" class="hover:text-yellow-300">About Us</a></li>
                    <li><a href="{{ url('/contact') }}" class="hover:text-yellow-300">Contact Us</a></li>
                </ul>
            </div>

            {{-- Opening Hours & Social --}}
            <div>
                <h4 class="font-semibold mb-4">Opening Hours</h4>
                <ul class="text-sm opacity-90 mb-6">
                    <li>Monday - Friday <br> <span class="opacity-75">10:30 - 21:30 WIB</span></li>
                    <li class="mt-2">Saturday - Sunday <br> <span class="opacity-75">10:30 - 21:30 WIB</span></li>
                </ul>

                <h4 class="font-semibold mb-4">Contact Us</h4>
                <a href="https://wa.me/6281352270928" target="_blank" class="flex items-center space-x-2 text-sm hover:text-yellow-300">
                    <i class="fab fa-whatsapp text-xl"></i>
                    <span>Hubungi Kami</span>
                </a>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="mt-12 text-center text-sm border-t border-orange-300 pt-6 text-white opacity-75">
            <p>© {{ date('Y') }} Rumah Makan Cita Rasa. All rights reserved.</p>
        </div>
    </footer>


@endsection
