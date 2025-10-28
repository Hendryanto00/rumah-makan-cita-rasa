@extends('layouts.app')

@section('title', 'Menu - Rumah Makan Cita Rasa')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 mb-4">✨ Our Menu ✨</h1>
            <p class="text-xl text-gray-600 mb-8">Discover our delicious dishes and beverages</p>
        </div>
    </div>
</section>

<div class="py-6 md:py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Search and Filter -->
        <div class="mb-6 md:mb-8">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row gap-3 md:gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               id="search-input"
                               placeholder="Cari menu, kategori, atau deskripsi..." 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm md:text-base"
                               value="{{ request('search') }}">
                    </div>
                    <div class="md:w-48">
                        <select id="category-filter" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm md:text-base">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button id="search-btn" class="bg-orange-500 text-white px-4 md:px-6 py-3 rounded-lg hover:bg-orange-600 transition text-sm md:text-base">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
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
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    closeAddToCartModal();
                    
                    // Show success message
                    showNotification(data.message, 'success');
                    
                    // Update cart count if cart icon exists
                    updateCartCount(data.cart_count);
                } else {
                    showNotification(data.message || 'Gagal menambahkan ke keranjang', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                showNotification('Terjadi kesalahan saat menambahkan ke keranjang', 'error');
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
    
});
</script>
@endsection
