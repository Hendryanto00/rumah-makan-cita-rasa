@forelse($menus as $menu)
    <div class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2 border border-gray-100" data-menu-id="{{ $menu->id }}">
        <!-- Image Container -->
        <div class="relative overflow-hidden h-56">
            @php
                $slug = \Illuminate\Support\Str::slug($menu->name);
                $possible = ['jpg','jpeg','png','webp'];
                $found = null;
                foreach ($possible as $ext) {
                    if (file_exists(public_path("images/menu/{$slug}.{$ext}"))) { $found = $ext; break; }
                }
                $imageUrl = $found ? asset("images/menu/{$slug}.{$found}") : asset('images/rumah-makan.jpg');
            @endphp
            <img src="{{ $imageUrl }}"
                 alt="{{ $menu->name }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 {{ $menu->stock <= 0 ? 'grayscale opacity-75' : '' }}">
            
            <!-- Overlay Gradient on Hover -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

            <!-- Category Badge -->
            <div class="absolute top-3 left-3 z-10">
                <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-xl backdrop-blur-sm">
                    {{ $menu->category->name }}
                </span>
            </div>

            <!-- Price Badge -->
            <div class="absolute top-3 right-3 z-10">
                <div class="px-3 py-1.5 rounded-xl bg-white/95 backdrop-blur-sm shadow-xl border border-white/50">
                    <span class="text-sm font-bold text-orange-600 menu-price">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            
            <!-- Stock Badge -->
            @if($menu->stock > 0)
                @if($menu->stock <= 10)
                    <div class="absolute bottom-3 right-3 z-10 stock-badge">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-500/90 backdrop-blur-sm text-white shadow-lg">
                            <i class="fas fa-exclamation-triangle mr-1"></i>Menipis
                        </span>
                    </div>
                @else
                    <div class="absolute bottom-3 right-3 z-10 stock-badge">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-500/90 backdrop-blur-sm text-white shadow-lg">
                            <i class="fas fa-check-circle mr-1"></i>Tersedia
                        </span>
                    </div>
                @endif
            @else
                <div class="absolute bottom-3 right-3 z-10 stock-badge">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-500/90 backdrop-blur-sm text-white shadow-lg">
                        <i class="fas fa-times-circle mr-1"></i>Habis
                    </span>
                </div>
            @endif
        </div>

        <!-- Content -->
        <div class="p-5">
            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors duration-300 line-clamp-1">
                {{ $menu->name }}
            </h3>

            <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed min-h-[2.5rem]">
                {{ $menu->description }}
            </p>

            <!-- Rating & Stock Info -->
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                @php
                    // Hanya hitung review yang sudah approved
                    $averageRating = $menu->reviews()->where('status', 'approved')->avg('rating');
                    $reviewCount = $menu->reviews()->where('status', 'approved')->count();
                @endphp
                @if($averageRating)
                    <div class="flex items-center gap-2">
                        <div class="flex items-center">
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
                        <span class="text-xs text-gray-600 font-medium">{{ number_format($averageRating, 1) }}</span>
                        <span class="text-xs text-gray-400">({{ $reviewCount }})</span>
                    </div>
                @else
                    <span class="text-xs text-gray-400 italic">Belum ada review</span>
                @endif
                
                <!-- Stock Info -->
                <div class="text-xs text-gray-600 stock-info-text">
                    @if($menu->stock > 0)
                        <span class="text-green-600 font-semibold">
                            <i class="fas fa-box mr-1"></i>Stok: {{ $menu->stock }}
                        </span>
                    @else
                        <span class="text-red-600 font-semibold">
                            <i class="fas fa-box-open mr-1"></i>Stok Habis
                        </span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <a href="{{ route('menus.show', $menu) }}"
                   class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2.5 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 text-center font-semibold text-sm shadow-md hover:shadow-lg transform hover:scale-[1.02] flex items-center justify-center gap-2">
                    <i class="fas fa-eye"></i>
                    <span>Detail</span>
                </a>
                
                @auth
                    <button type="button" onclick="openAddToCartModal({{ $menu->id }}, '{{ $menu->name }}')" 
                            class="px-4 py-2.5 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-xl hover:from-orange-700 hover:to-red-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed {{ $menu->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $menu->stock <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-4 py-2.5 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-xl hover:from-orange-700 hover:to-red-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-[1.02] flex items-center justify-center">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
@empty
    <div class="col-span-full text-center py-20">
        <div class="max-w-md mx-auto">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-gradient-to-br from-orange-100 to-red-100 mb-4">
                    <svg class="w-16 h-16 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">Menu tidak ditemukan</h3>
            <p class="text-gray-600 mb-8 text-lg">Coba ubah kata kunci pencarian atau filter kategori Anda untuk menemukan menu yang Anda cari</p>
            <a href="{{ route('menus.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 font-semibold">
                <i class="fas fa-refresh mr-2"></i>
                Lihat Semua Menu
            </a>
        </div>
    </div>
@endforelse
