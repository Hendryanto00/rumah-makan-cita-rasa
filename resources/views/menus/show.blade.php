@extends('layouts.app')

@section('title', $menu->name . ' - Rumah Makan Cita Rasa')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 py-8 md:py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">{{ $menu->name }}</h1>
            <p class="text-base md:text-lg text-gray-600">{{ $menu->category->name }}</p>
        </div>
    </div>
</section>

<div class="py-6 md:py-12 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-4 md:mb-6">
            <a href="{{ route('menus.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="text-sm md:text-base font-medium">Kembali ke Menu</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <!-- Menu Image & Info -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('images/menu/' . strtolower(str_replace(' ', '-', $menu->name)) . '.jpg') }}" 
                         alt="{{ $menu->name }}"
                         class="w-full h-48 md:h-64 object-cover"
                         onerror="this.src='{{ asset('images/rumah-makan.jpg') }}'">
                </div>
                
                <div class="p-4 md:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900">{{ $menu->name }}</h1>
                        <span class="px-2 md:px-3 py-1 text-xs md:text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800 self-start sm:self-auto">
                            {{ $menu->category->name }}
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-4 text-sm md:text-base">{{ $menu->description }}</p>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-2">
                        <div class="text-2xl md:text-3xl font-bold text-orange-600">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </div>
                        <div class="text-xs md:text-sm text-gray-500">
                            Stock: {{ $menu->stock }} porsi
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                        @auth
                            <a href="{{ route('reviews.create', ['menu_id' => $menu->id]) }}" 
                               class="flex-1 bg-orange-500 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg hover:bg-orange-600 transition text-center text-sm md:text-base">
                                <i class="fas fa-star mr-1 md:mr-2"></i>
                                <span class="hidden sm:inline">Write a Review</span>
                                <span class="sm:hidden">Review</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="flex-1 bg-orange-500 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg hover:bg-orange-600 transition text-center text-sm md:text-base">
                                <i class="fas fa-star mr-1 md:mr-2"></i>
                                <span class="hidden sm:inline">Login to Review</span>
                                <span class="sm:hidden">Login</span>
                            </a>
                        @endauth
                        
                        @auth
                            <button type="button" onclick="openAddToCartModal({{ $menu->id }}, '{{ $menu->name }}')" class="flex-1 bg-orange-600 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg hover:bg-orange-700 transition text-sm md:text-base">
                                <i class="fas fa-shopping-cart mr-1 md:mr-2"></i>
                                <span class="hidden sm:inline">Add to Cart</span>
                                <span class="sm:hidden">Cart</span>
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="flex-1 bg-orange-600 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg hover:bg-orange-700 transition text-center text-sm md:text-base">
                                <i class="fas fa-shopping-cart mr-1 md:mr-2"></i>
                                <span class="hidden sm:inline">Add to Cart</span>
                                <span class="sm:hidden">Cart</span>
                            </a>
                        @endauth
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

@auth
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
    // Add to cart form submission
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
            
            // Send AJAX request with timeout
            const controller = new AbortController();
            const timeoutId = setTimeout(() => {
                controller.abort();
                showNotification('Request timeout. Silakan coba lagi.', 'error');
            }, 10000); // 10 second timeout
            
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                body: formData,
                signal: controller.signal,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(() => clearTimeout(timeoutId))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    closeAddToCartModal();
                    
                    // Reset form
                    addToCartForm.reset();
                    
                    // Show success message
                    showNotification(data.message, 'success');
                    
                    // Update cart count if cart icon exists
                    updateCartCount(data.cart_count);
                } else {
                    showNotification(data.message || 'Gagal menambahkan ke keranjang', 'error');
                }
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                showNotification('Terjadi kesalahan saat menambahkan ke keranjang', 'error');
            })
            .finally(() => {
                // Hide loading state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
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
@endauth
@endsection
