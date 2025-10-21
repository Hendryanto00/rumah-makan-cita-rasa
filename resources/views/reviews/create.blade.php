@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-gray-800 mb-2">✨ Write a Review ✨</h1>
                <p class="text-lg text-gray-600">Bagikan pengalaman Anda tentang menu ini</p>
            </div>
        </div>
    </section>

    <div class="py-12 bg-white">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
                <div class="p-8 text-gray-900">
                    @if($menu)
                        <div class="mb-8 p-6 bg-gradient-to-r from-orange-50 to-yellow-50 rounded-xl border border-orange-200">
                            <div class="flex items-center space-x-4">
                        <img src="{{ asset('images/menu/' . strtolower(str_replace(' ', '-', $menu->name)) . '.jpg') }}"
                             alt="{{ $menu->name }}"
                             class="w-16 h-16 object-cover rounded-lg"
                             onerror="this.src='{{ asset('images/rumah-makan.jpg') }}'">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $menu->name }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $menu->description }}</p>
                                    <p class="text-orange-600 font-bold mt-1">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <h4 class="font-bold">Validation Errors:</h4>
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        
                        @if($menu)
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        @else
                            <div class="mb-6">
                                <label for="menu_id" class="block text-sm font-medium text-gray-700 mb-3">Pilih Menu</label>
                                <select name="menu_id" id="menu_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 @error('menu_id') border-red-500 @enderror" required>
                                    <option value="">Pilih menu yang ingin direview...</option>
                                    @foreach(\App\Models\Menu::where('is_active', true)->get() as $menuOption)
                                        <option value="{{ $menuOption->id }}" {{ old('menu_id') == $menuOption->id ? 'selected' : '' }}>
                                            {{ $menuOption->name }} - Rp {{ number_format($menuOption->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('menu_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-6">
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-3">Rating *</label>
                            <div class="flex items-center space-x-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="rating" value="{{ $i }}" 
                                               class="sr-only" 
                                               {{ old('rating') == $i ? 'checked' : '' }}
                                               required>
                                        <svg class="w-10 h-10 {{ old('rating') >= $i ? 'text-yellow-400' : 'text-gray-300' }} group-hover:text-yellow-400 transition-colors duration-200" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            <div class="mt-2 text-sm text-gray-500">
                                <span id="rating-text">Pilih rating Anda</span>
                            </div>
                            @error('rating')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-8">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-3">Komentar (Opsional)</label>
                            <textarea name="comment" id="comment" rows="5" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 @error('comment') border-red-500 @enderror"
                                      placeholder="Bagikan pengalaman Anda tentang menu ini...">{{ old('comment') }}</textarea>
                            <div class="mt-1 text-sm text-gray-500">
                                <span id="char-count">0</span>/1000 karakter
                            </div>
                            @error('comment')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ $menu ? route('menus.show', $menu) : route('menus.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-xl transition">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                            <button type="submit" 
                                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg hover:shadow-xl">
                                <i class="fas fa-star mr-2"></i>
                                Kirim Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Interactive star rating
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('input[name="rating"]');
            const starSvgs = document.querySelectorAll('svg[class*="text-"]');
            const ratingText = document.getElementById('rating-text');
            const commentTextarea = document.getElementById('comment');
            const charCount = document.getElementById('char-count');
            
            const ratingTexts = {
                1: 'Sangat Buruk',
                2: 'Buruk', 
                3: 'Biasa',
                4: 'Bagus',
                5: 'Sangat Bagus'
            };
            
            stars.forEach((star, index) => {
                star.addEventListener('change', function() {
                    starSvgs.forEach((svg, svgIndex) => {
                        if (svgIndex <= index) {
                            svg.classList.remove('text-gray-300');
                            svg.classList.add('text-yellow-400');
                        } else {
                            svg.classList.remove('text-yellow-400');
                            svg.classList.add('text-gray-300');
                        }
                    });
                    
                    ratingText.textContent = ratingTexts[index + 1] || 'Pilih rating Anda';
                });
            });
            
            // Character count for comment
            commentTextarea.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length;
                
                if (length > 1000) {
                    charCount.classList.add('text-red-500');
                } else {
                    charCount.classList.remove('text-red-500');
                }
            });
        });
    </script>
@endsection