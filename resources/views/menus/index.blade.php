@extends('layouts.app')

@section('title', 'Menu - Rumah Makan Cita Rasa')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-orange-400 via-orange-500 to-red-500 py-16 md:py-24 overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white opacity-5 rounded-full"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-block mb-4 animate-bounce">
                <span class="text-4xl md:text-6xl">✨</span>
            </div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-4 drop-shadow-lg">
                Our <span class="text-yellow-200">Delicious</span> Menu
            </h1>
            <p class="text-lg md:text-xl text-orange-50 mb-8 max-w-2xl mx-auto">
                Temukan berbagai hidangan lezat dan minuman segar dengan cita rasa autentik yang menggugah selera
            </p>
            <div class="flex flex-wrap justify-center gap-2 text-sm md:text-base">
                <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full font-medium">🍽️ Hidangan Lezat</span>
                <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full font-medium">🥤 Minuman Segar</span>
                <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full font-medium">⭐ Cita Rasa Autentik</span>
            </div>
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

<div class="py-6 md:py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Search and Filter -->
        <div class="mb-8 md:mb-12 -mt-8 md:-mt-12 relative z-20">
            <div class="max-w-5xl mx-auto">
                <div class="bg-white rounded-2xl shadow-2xl p-4 md:p-6 border border-gray-100">
                    <div class="flex flex-col md:flex-row gap-3 md:gap-4">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="search-input"
                                   placeholder="Cari menu favorit Anda..." 
                                   class="w-full pl-12 pr-4 py-3 md:py-4 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-gray-50 focus:bg-white"
                                   value="{{ request('search') }}">
                        </div>
                        <div class="md:w-56 relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-filter text-gray-400"></i>
                            </div>
                            <select id="category-filter" class="w-full pl-12 pr-12 py-3 md:py-4 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <button id="search-btn" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 md:px-8 py-3 md:py-4 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 text-sm md:text-base font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-search mr-2"></i>
                            <span class="hidden sm:inline">Cari</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @include('menus.partials.menu-grid')
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="mt-8">
            @include('menus.partials.pagination')
        </div>
    </div>
</div>

<!-- Add to Cart Modal -->
<div id="addToCartModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Tambah ke Keranjang</h3>
                <button onclick="closeAddToCartModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="addToCartForm">
                @csrf
                <input type="hidden" name="menu_id" id="modal-menu-id">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="decreaseQuantity()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" name="quantity" id="modal-quantity" value="1" min="1" class="w-16 text-center border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                        <button type="button" onclick="increaseQuantity()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea name="notes" id="modal-notes" rows="3" placeholder="Contoh: Banyakin porsi, level pedas sedang, jangan pakai udang, dll" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" onclick="closeAddToCartModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-shopping-cart mr-2"></i>Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentMenuId = null;
let currentMenuName = null;

function openAddToCartModal(menuId, menuName) {
    currentMenuId = menuId;
    currentMenuName = menuName;
    document.getElementById('modal-menu-id').value = menuId;
    document.getElementById('modal-quantity').value = 1;
    document.getElementById('modal-notes').value = '';
    document.getElementById('addToCartModal').classList.remove('hidden');
}

function closeAddToCartModal() {
    document.getElementById('addToCartModal').classList.add('hidden');
}

function increaseQuantity() {
    const input = document.getElementById('modal-quantity');
    input.value = parseInt(input.value) + 1;
}

function decreaseQuantity() {
    const input = document.getElementById('modal-quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const searchBtn = document.getElementById('search-btn');
    const menuGrid = document.querySelector('.grid');
    const paginationContainer = document.getElementById('pagination-container');
    
    let searchTimeout;
    
    // Function to perform search
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        const categoryId = categoryFilter.value;
        
        // Build URL with parameters
        const url = new URL(window.location);
        url.searchParams.set('search', searchTerm);
        url.searchParams.set('category', categoryId);
        url.searchParams.delete('page'); // Reset to first page when searching
        
        // Update URL without page reload
        window.history.pushState({}, '', url);
        
        // Fetch new results
        fetch(url.toString(), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update menu grid
            if (data.menu_grid) {
                menuGrid.innerHTML = data.menu_grid;
            }
            
            // Update pagination
            if (data.pagination) {
                paginationContainer.innerHTML = data.pagination;
            } else {
                paginationContainer.innerHTML = '';
            }
        })
        .catch(error => {
            console.error('Search error:', error);
        });
    }
    
    // Search input with debounce
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 300); // 300ms delay
    });
    
    // Category filter change
    categoryFilter.addEventListener('change', performSearch);
    
    // Search button click
    searchBtn.addEventListener('click', performSearch);
    
    // Add to cart modal form submission
    const addToCartForm = document.getElementById('addToCartForm');
    
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = addToCartForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            
            // Get form data
            const formData = new FormData(addToCartForm);
            
            // Send AJAX request
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                // Check if response is ok
                if (!response.ok) {
                    // Try to parse JSON error response
                    return response.json().catch(() => {
                        // If not JSON, throw with status text
                        throw new Error(`Error ${response.status}: ${response.statusText}`);
                    }).then(data => {
                        throw new Error(data.message || 'Terjadi kesalahan saat menambahkan ke keranjang');
                    });
                }
                // Parse JSON response
                return response.json().catch(() => {
                    throw new Error('Invalid response format from server');
                });
            })
            .then(data => {
                if (data.success) {
                    // Close modal
                    closeAddToCartModal();
                    
                    // Reset form
                    addToCartForm.reset();
                    
                    // Show success message
                    showNotification(data.message, 'success');
                    
                    // Update cart count if cart icon exists
                    if (data.cart_count !== undefined) {
                        updateCartCount(data.cart_count);
                    }
                } else {
                    showNotification(data.message || 'Gagal menambahkan ke keranjang', 'error');
                }
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                showNotification(error.message || 'Terjadi kesalahan saat menambahkan ke keranjang', 'error');
            })
            .finally(() => {
                // Hide loading state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
    
    // Add to cart functionality (for old compatibility)
    function initializeAddToCart() {
        // No longer needed, modal handles everything
    }
    
    // Function to show notification
    function showNotification(message, type = 'success') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Function to update cart count
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(element => {
            element.textContent = count;
            if (count > 0) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        });
    }
    
    // Real-time menu updates polling
    let lastMenuCheck = new Date().toISOString();
    let menuUpdateInterval;
    
    function checkMenuUpdates() {
        fetch(`{{ route('api.menu-updates') }}?last_check=${encodeURIComponent(lastMenuCheck)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.menus && data.menus.length > 0) {
                // Update menu items in the grid
                data.menus.forEach(menu => {
                    updateMenuInGrid(menu);
                });
                
                // Show notification if there are updates
                if (data.menus.length > 0) {
                    // Optional: Show subtle notification
                    // showNotification('Menu telah diperbarui', 'info');
                }
            }
            
            // Update last check time
            if (data.timestamp) {
                lastMenuCheck = data.timestamp;
            }
        })
        .catch(error => {
            console.error('Menu update check error:', error);
        });
    }
    
    function updateMenuInGrid(menu) {
        // Find menu card by menu ID
        const menuCard = document.querySelector(`[data-menu-id="${menu.id}"]`);
        if (!menuCard) return;
        
        // Update stock badge (on image)
        const stockBadge = menuCard.querySelector('.stock-badge');
        const addToCartBtn = menuCard.querySelector('button[onclick*="openAddToCartModal"]');
        const menuImage = menuCard.querySelector('img');
        
        if (stockBadge) {
            if (menu.stock > 0) {
                if (menu.stock <= 10) {
                    // Menipis (stok <= 10)
                    stockBadge.innerHTML = `
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-500/90 backdrop-blur-sm text-white shadow-lg">
                            <i class="fas fa-exclamation-triangle mr-1"></i>Menipis
                        </span>
                    `;
                } else {
                    // Tersedia (stok > 10)
                    stockBadge.innerHTML = `
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-500/90 backdrop-blur-sm text-white shadow-lg">
                            <i class="fas fa-check-circle mr-1"></i>Tersedia
                        </span>
                    `;
                }
                // Remove grayscale from image if stock is available
                if (menuImage) {
                    menuImage.classList.remove('grayscale', 'opacity-75');
                }
                if (addToCartBtn) {
                    addToCartBtn.disabled = false;
                    addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            } else {
                // Habis
                stockBadge.innerHTML = `
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-500/90 backdrop-blur-sm text-white shadow-lg">
                        <i class="fas fa-times-circle mr-1"></i>Habis
                    </span>
                `;
                // Add grayscale to image when stock is out
                if (menuImage) {
                    menuImage.classList.add('grayscale', 'opacity-75');
                }
                if (addToCartBtn) {
                    addToCartBtn.disabled = true;
                    addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
        }
        
        // Update stock info in content area (below rating)
        const stockInfoElement = menuCard.querySelector('.stock-info-text');
        if (stockInfoElement) {
            if (menu.stock > 0) {
                stockInfoElement.innerHTML = `
                    <span class="text-green-600 font-semibold">
                        <i class="fas fa-box mr-1"></i>Stok: ${menu.stock}
                    </span>
                `;
            } else {
                stockInfoElement.innerHTML = `
                    <span class="text-red-600 font-semibold">
                        <i class="fas fa-box-open mr-1"></i>Stok Habis
                    </span>
                `;
            }
        }
        
        // Update price if changed
        const priceElement = menuCard.querySelector('.menu-price');
        if (priceElement) {
            const newPrice = new Intl.NumberFormat('id-ID').format(menu.price);
            priceElement.textContent = `Rp ${newPrice}`;
        }
    }
    
    // Start polling every 5 seconds
    if (typeof menuUpdateInterval === 'undefined') {
        menuUpdateInterval = setInterval(checkMenuUpdates, 5000);
    }
    
    // Stop polling when page is hidden (to save resources)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (menuUpdateInterval) clearInterval(menuUpdateInterval);
        } else {
            if (!menuUpdateInterval) {
                menuUpdateInterval = setInterval(checkMenuUpdates, 5000);
            }
        }
    });
    
});
</script>
@push('styles')
<style>
    /* Remove default browser dropdown arrow */
    #category-filter {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: none !important;
        background-repeat: no-repeat;
        background-position: right center;
    }
    
    /* For Firefox */
    #category-filter::-moz-focus-inner {
        border: 0;
    }
    
    /* For IE */
    #category-filter::-ms-expand {
        display: none;
    }
</style>
@endpush
@endsection
