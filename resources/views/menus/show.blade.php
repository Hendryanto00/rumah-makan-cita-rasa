@extends('layouts.app')

@section('title', $menu->name . ' - Rumah Makan Cita Rasa')

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
                <span class="text-4xl md:text-6xl">🍽️</span>
            </div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-4 drop-shadow-lg">
                {{ $menu->name }}
            </h1>
            <p class="text-lg md:text-xl text-orange-50 mb-8 max-w-2xl mx-auto">
                {{ $menu->category->name }}
            </p>
            <div class="flex flex-wrap justify-center gap-2 text-sm md:text-base">
                <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full font-medium">
                    <i class="fas fa-tag mr-2"></i>{{ $menu->category->name }}
                </span>
                @if($menu->stock > 0)
                    <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full font-medium">
                        <i class="fas fa-box mr-2"></i>Stok: {{ $menu->stock }}
                    </span>
                @endif
                @php
                    $averageRating = $menu->reviews()->where('status', 'approved')->avg('rating');
                    $reviewCount = $menu->reviews()->where('status', 'approved')->count();
                @endphp
                @if($averageRating)
                    <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm text-white rounded-full font-medium">
                        <i class="fas fa-star mr-2"></i>{{ number_format($averageRating, 1) }}/5 ({{ $reviewCount }} review)
                    </span>
                @endif
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

<div class="py-6 md:py-12 bg-white -mt-1">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-4 md:mb-6">
            <a href="{{ route('menus.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 transition-colors font-medium">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="text-sm md:text-base font-medium">Kembali ke Menu</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <!-- Menu Image & Info -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div>
                    @php
                        $slug = \Illuminate\Support\Str::slug($menu->name);
                        $possible = ['jpg','jpeg','png','webp'];
                        $found = null;
                        foreach ($possible as $ext) {
                            $filePath = public_path("images/menu/{$slug}.{$ext}");
                            if (file_exists($filePath) && is_file($filePath)) { 
                                $found = $ext; 
                                break; 
                            }
                        }
                        $imageUrl = $found ? asset("images/menu/{$slug}.{$found}") : asset('images/rumah-makan.jpg');
                    @endphp
                    <img src="{{ $imageUrl }}" 
                        alt="{{ $menu->name }}"
                        class="w-full h-56 md:h-72 lg:h-96 object-cover">
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
                            <button type="button" onclick="openAddToCartModal({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->stock }})" class="flex-1 bg-orange-600 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg hover:bg-orange-700 transition text-sm md:text-base {{ $menu->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $menu->stock <= 0 ? 'disabled' : '' }}>
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
                        <input type="number" name="quantity" id="modal-quantity" value="1" min="1" max="999" class="w-16 text-center border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500" onchange="validateQuantity()">
                        <button type="button" onclick="increaseQuantity()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <p id="stock-info" class="text-xs text-gray-500 mt-1"></p>
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
let currentMenuStock = null;

function openAddToCartModal(menuId, menuName, menuStock) {
    currentMenuId = menuId;
    currentMenuName = menuName;
    currentMenuStock = menuStock;
    document.getElementById('modal-menu-id').value = menuId;
    document.getElementById('modal-quantity').value = 1;
    document.getElementById('modal-notes').value = '';
    // Set max attribute based on stock
    const quantityInput = document.getElementById('modal-quantity');
    quantityInput.setAttribute('max', menuStock);
    // Show stock info
    const stockInfo = document.getElementById('stock-info');
    if (stockInfo) {
        stockInfo.textContent = `Stok tersedia: ${menuStock} item`;
    }
    document.getElementById('addToCartModal').classList.remove('hidden');
}

function closeAddToCartModal() {
    document.getElementById('addToCartModal').classList.add('hidden');
}

function increaseQuantity() {
    const input = document.getElementById('modal-quantity');
    const currentValue = parseInt(input.value);
    const maxStock = currentMenuStock || parseInt(input.getAttribute('max')) || 999;
    
    if (currentValue >= maxStock) {
        Swal.fire({
            icon: 'warning',
            title: 'Stok Tidak Cukup!',
            html: `Stok <strong>${currentMenuName}</strong> hanya tersedia <strong>${maxStock}</strong> item.<br>Anda tidak dapat memesan lebih dari stok yang tersedia.`,
            confirmButtonColor: '#f97316',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    input.value = currentValue + 1;
}

function decreaseQuantity() {
    const input = document.getElementById('modal-quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function validateQuantity() {
    const input = document.getElementById('modal-quantity');
    const quantity = parseInt(input.value);
    const maxStock = currentMenuStock || parseInt(input.getAttribute('max')) || 999;
    
    if (quantity > maxStock) {
        Swal.fire({
            icon: 'warning',
            title: 'Stok Tidak Cukup!',
            html: `Stok <strong>${currentMenuName}</strong> hanya tersedia <strong>${maxStock}</strong> item.<br>Anda tidak dapat memesan lebih dari stok yang tersedia.`,
            confirmButtonColor: '#f97316',
            confirmButtonText: 'OK'
        });
        input.value = maxStock;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Add to cart form submission
    const addToCartForm = document.getElementById('addToCartForm');
    
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate stock before submitting
            const quantityInput = document.getElementById('modal-quantity');
            const quantity = parseInt(quantityInput.value);
            const maxStock = currentMenuStock || parseInt(quantityInput.getAttribute('max')) || 999;
            
            if (quantity > maxStock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Tidak Cukup!',
                    html: `Stok <strong>${currentMenuName}</strong> hanya tersedia <strong>${maxStock}</strong> item.<br>Anda tidak dapat memesan lebih dari stok yang tersedia.`,
                    confirmButtonColor: '#f97316',
                    confirmButtonText: 'OK'
                });
                quantityInput.value = maxStock;
                return;
            }
            
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
            .then(response => {
                clearTimeout(timeoutId);
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
                clearTimeout(timeoutId);
                console.error('Add to cart error:', error);
                if (error.name === 'AbortError') {
                    showNotification('Request timeout. Silakan coba lagi.', 'error');
                } else {
                    showNotification(error.message || 'Terjadi kesalahan saat menambahkan ke keranjang', 'error');
                }
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
    
    // Real-time review updates polling
    let lastReviewCheck = new Date().toISOString();
    let reviewUpdateInterval;
    const menuId = {{ $menu->id }};
    const currentUserId = {{ auth()->check() ? auth()->id() : 'null' }};
    
    function checkReviewUpdates() {
        const apiUrl = @json(route('api.review-updates')) + `?menu_id=${menuId}&last_check=${encodeURIComponent(lastReviewCheck)}`;
        
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Handle deleted reviews
                if (data.deleted_review_ids && data.deleted_review_ids.length > 0) {
                    data.deleted_review_ids.forEach(reviewId => {
                        const reviewElement = document.querySelector(`[data-review-id="${reviewId}"]`);
                        if (reviewElement) {
                            reviewElement.style.transition = 'opacity 0.3s';
                            reviewElement.style.opacity = '0';
                            setTimeout(() => {
                                reviewElement.remove();
                                // Reload page to update rating summary
                                window.location.reload();
                            }, 300);
                        }
                    });
                }
                
                // Handle updated/new reviews
                if (data.reviews && data.reviews.length > 0) {
                    data.reviews.forEach(review => {
                        updateOrAddReview(review);
                    });
                    
                    // Reload page to update rating summary if there are new approved reviews
                    const hasNewApproved = data.reviews.some(r => r.status === 'approved');
                    if (hasNewApproved) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                }
                
                // Update last check time
                if (data.timestamp) {
                    lastReviewCheck = data.timestamp;
                }
            }
        })
        .catch(error => {
            console.error('Review update check error:', error);
        });
    }
    
    function updateOrAddReview(review) {
        const reviewElement = document.querySelector(`[data-review-id="${review.id}"]`);
        
        if (reviewElement) {
            // Update existing review
            // Update status badge if it's user's own review
            // Badge sudah ada di template, jadi kita hanya perlu update visibility
            if (review.is_own_review && review.status === 'pending') {
                // Badge sudah ada di template, tidak perlu menambahkan lagi
                // Cari badge yang berisi icon clock
                const allSpans = reviewElement.querySelectorAll('span');
                allSpans.forEach(span => {
                    const clockIcon = span.querySelector('.fa-clock');
                    if (clockIcon && span.textContent.includes('Menunggu Persetujuan')) {
                        span.style.display = 'flex';
                    }
                });
            } else if (review.status === 'approved') {
                // Hide pending badge if approved
                const allSpans = reviewElement.querySelectorAll('span');
                allSpans.forEach(span => {
                    const clockIcon = span.querySelector('.fa-clock');
                    if (clockIcon && span.textContent.includes('Menunggu Persetujuan')) {
                        span.style.display = 'none';
                    }
                });
            }
            
            // Update status message
            const statusMessage = reviewElement.querySelector('.review-status-message');
            if (statusMessage) {
                if (review.status === 'pending' && review.is_own_review) {
                    statusMessage.innerHTML = `
                        <p class="text-xs text-yellow-600 italic">
                            <i class="fas fa-info-circle mr-1"></i>
                            Review Anda sedang menunggu persetujuan admin
                        </p>
                    `;
                    statusMessage.style.display = 'block';
                } else if (review.status === 'approved') {
                    statusMessage.style.display = 'none';
                } else if (review.status === 'hidden' && review.is_own_review) {
                    statusMessage.innerHTML = `
                        <p class="text-xs text-red-600 italic">
                            <i class="fas fa-eye-slash mr-1"></i>
                            Review Anda telah disembunyikan oleh admin
                        </p>
                    `;
                    statusMessage.style.display = 'block';
                }
            }
            
            // If review is hidden and not user's own, hide it
            if (review.status === 'hidden' && !review.is_own_review) {
                reviewElement.style.transition = 'opacity 0.3s';
                reviewElement.style.opacity = '0';
                setTimeout(() => {
                    reviewElement.remove();
                }, 300);
            }
        } else {
            // Add new review if it's approved or user's own pending review
            if (review.status === 'approved' || (review.status === 'pending' && review.is_own_review)) {
                // Reload page to show new review with proper formatting
                window.location.reload();
            }
        }
    }
    
    // Start polling every 5 seconds
    if (typeof reviewUpdateInterval === 'undefined') {
        reviewUpdateInterval = setInterval(checkReviewUpdates, 5000);
    }
    
    // Stop polling when page is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (reviewUpdateInterval) {
                clearInterval(reviewUpdateInterval);
            }
        } else {
            if (typeof reviewUpdateInterval === 'undefined') {
                reviewUpdateInterval = setInterval(checkReviewUpdates, 5000);
            }
        }
    });
});
</script>
@endauth
@endsection
