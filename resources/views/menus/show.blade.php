@extends('layouts.app')

@section('title', $menu->name . ' - Rumah Makan Cita Rasa')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">{{ $menu->name }}</h1>
            <p class="text-lg text-gray-600">{{ $menu->category->name }}</p>
        </div>
    </div>
</section>

<div class="py-12 bg-white">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ url('/') }}" class="hover:text-orange-600">Home</a></li>
                <li>/</li>
                <li><a href="{{ route('menus.index') }}" class="hover:text-orange-600">Menu</a></li>
                <li>/</li>
                <li class="text-gray-900">{{ $menu->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Menu Image & Info -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('images/menu/' . strtolower(str_replace(' ', '-', $menu->name)) . '.jpg') }}" 
                         alt="{{ $menu->name }}"
                         class="w-full h-64 object-cover"
                         onerror="this.src='{{ asset('images/rumah-makan.jpg') }}'">
                </div>
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $menu->name }}</h1>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            {{ $menu->category->name }}
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-4">{{ $menu->description }}</p>
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="text-3xl font-bold text-orange-600">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </div>
                        <div class="text-sm text-gray-500">
                            Stock: {{ $menu->stock }} porsi
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        @auth
                            <a href="{{ route('reviews.create', ['menu_id' => $menu->id]) }}" 
                               class="flex-1 bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition text-center">
                                <i class="fas fa-star mr-2"></i>
                                Write a Review
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="flex-1 bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition text-center">
                                <i class="fas fa-star mr-2"></i>
                                Login to Review
                            </a>
                        @endauth
                        
                        <button class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div>
                <x-review-section :menu="$menu" />
            </div>
        </div>
    </div>
</div>
@endsection
