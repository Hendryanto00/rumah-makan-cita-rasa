@forelse($menus as $menu)
    <div class="group bg-white rounded-xl md:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1 md:hover:-translate-y-2">
        <!-- Image Container -->
        <div class="relative overflow-hidden">
            <img src="{{ asset('images/menu/' . strtolower(str_replace(' ', '-', $menu->name)) . '.jpg') }}"
                 alt="{{ $menu->name }}"
                 class="w-full h-48 md:h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                 onerror="this.src='{{ asset('images/rumah-makan.jpg') }}'">

            <!-- Category Badge -->
            <div class="absolute top-2 left-2 md:top-4 md:left-4">
                <span class="px-2 py-1 md:px-3 md:py-1 text-xs font-bold rounded-full bg-orange-500 text-white shadow-lg">
                    {{ $menu->category->name }}
                </span>
            </div>

            <!-- Price Badge -->
            <div class="absolute top-2 right-2 md:top-4 md:right-4">
                <span class="px-2 py-1 md:px-3 md:py-1 text-xs md:text-sm font-bold rounded-full bg-white text-orange-600 shadow-lg">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4 md:p-6">
            <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors">
                {{ $menu->name }}
            </h3>

            <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                {{ $menu->description }}
            </p>

            <!-- Rating -->
            <div class="flex items-center justify-between mb-4">
                @php
                    $averageRating = $menu->reviews()->avg('rating');
                    $reviewCount = $menu->reviews()->count();
                @endphp
                @if($averageRating)
                    <div class="flex items-center">
                        <div class="flex items-center mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($averageRating))
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 font-medium">{{ number_format($averageRating, 1) }} ({{ $reviewCount }} review)</span>
                    </div>
                @else
                    <span class="text-sm text-gray-400">Belum ada review</span>
                @endif

                <span class="text-sm text-gray-500">
                    Stock: {{ $menu->stock }}
                </span>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-2 md:space-x-3">
                <a href="{{ route('menus.show', $menu) }}"
                   class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-3 md:px-4 py-2 md:py-3 rounded-lg md:rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 text-center font-semibold shadow-lg hover:shadow-xl text-sm md:text-base">
                    <i class="fas fa-eye mr-1 md:mr-2"></i>
                    <span class="hidden sm:inline">Lihat Detail</span>
                    <span class="sm:hidden">Detail</span>
                </a>
                
                @auth
                    <button type="button" onclick="openAddToCartModal({{ $menu->id }}, '{{ $menu->name }}')" class="bg-gradient-to-r from-orange-600 to-red-600 text-white px-3 md:px-4 py-2 md:py-3 rounded-lg md:rounded-xl hover:from-orange-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-shopping-cart text-sm md:text-base"></i>
                    </button>
                @else
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-orange-600 to-red-600 text-white px-3 md:px-4 py-2 md:py-3 rounded-lg md:rounded-xl hover:from-orange-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-shopping-cart text-sm md:text-base"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
@empty
    <div class="col-span-full text-center py-16">
        <div class="max-w-md mx-auto">
            <svg class="mx-auto h-20 w-20 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.709M15 6.75a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Menu tidak ditemukan</h3>
            <p class="text-gray-500 mb-6">Coba ubah kata kunci pencarian atau filter kategori Anda</p>
            <a href="{{ route('menus.index') }}" class="inline-flex items-center px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                <i class="fas fa-refresh mr-2"></i>
                Lihat Semua Menu
            </a>
        </div>
    </div>
@endforelse
