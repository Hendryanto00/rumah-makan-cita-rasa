@extends('layouts.app')

@section('title', 'Dashboard - Rumah Makan Cita Rasa')

@section('content')
<section class="bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 text-center py-20">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-2">
                @auth
                    Selamat Datang, {{ Auth::user()->name }}, 👋
                @else
                    Selamat Datang di Rumah Makan Cita Rasa 👋
                @endauth
            </h2>
            <p class="text-gray-600 text-lg">Pesan makanan favoritmu sekarang juga!</p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-xl mx-auto mb-12">
            <input 
                type="text" 
                placeholder="Cari makanan atau minuman..." 
                class="w-full px-5 py-3 rounded-2xl border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
            >
        </div>

        <!-- Categories -->
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Kategori</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
            <div class="bg-white shadow-lg rounded-2xl p-6 text-center hover:shadow-xl transition">
                🍛 <p class="mt-3 font-semibold text-gray-700">Nasi</p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-6 text-center hover:shadow-xl transition">
                🍜 <p class="mt-3 font-semibold text-gray-700">Mie</p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-6 text-center hover:shadow-xl transition">
                🍗 <p class="mt-3 font-semibold text-gray-700">Ayam</p>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-6 text-center hover:shadow-xl transition">
                🥤 <p class="mt-3 font-semibold text-gray-700">Minuman</p>
            </div>
        </div>

        <!-- Menu Rekomendasi -->
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Menu Rekomendasi</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition p-6">
                <img src="{{ asset('images/menu/nasi-goreng.jpg') }}" alt="Nasi Goreng" 
                    class="rounded-xl w-full h-44 object-cover mb-4">
                <h4 class="text-xl font-semibold text-gray-800">Nasi Goreng Spesial</h4>
                <p class="text-sm text-gray-600 mt-2">Dengan topping ayam dan telur</p>
                <div class="flex justify-between items-center mt-5">
                    <span class="text-orange-600 font-bold text-lg">Rp25.000</span>
                    <button class="bg-orange-500 text-white px-5 py-2 rounded-xl hover:bg-orange-600 transition">
                        Pesan
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition p-6">
                <img src="{{ asset('images/menu/mie-ayam.jpg') }}" alt="Mie Ayam" 
                    class="rounded-xl w-full h-44 object-cover mb-4">
                <h4 class="text-xl font-semibold text-gray-800">Mie Ayam Cita Rasa</h4>
                <p class="text-sm text-gray-600 mt-2">Porsi jumbo, pakai bakso</p>
                <div class="flex justify-between items-center mt-5">
                    <span class="text-orange-600 font-bold text-lg">Rp20.000</span>
                    <button class="bg-orange-500 text-white px-5 py-2 rounded-xl hover:bg-orange-600 transition">
                        Pesan
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition p-6">
                <img src="{{ asset('images/menu/es-teh.jpg') }}" alt="Es Teh" 
                    class="rounded-xl w-full h-44 object-cover mb-4">
                <h4 class="text-xl font-semibold text-gray-800">Es Teh Manis</h4>
                <p class="text-sm text-gray-600 mt-2">Segar & cocok untuk semua menu</p>
                <div class="flex justify-between items-center mt-5">
                    <span class="text-orange-600 font-bold text-lg">Rp5.000</span>
                    <button class="bg-orange-500 text-white px-5 py-2 rounded-xl hover:bg-orange-600 transition">
                        Pesan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Cart -->
    <div class="fixed bottom-6 right-6 z-50">
        <div class="bg-orange-500 text-white rounded-full shadow-lg p-4 flex items-center space-x-3 cursor-pointer hover:bg-orange-600 transition">
            <span class="material-icons">shopping_cart</span>
            <span class="font-semibold">3</span> {{-- jumlah item contoh --}}
        </div>
    </div>
</section>
@endsection
