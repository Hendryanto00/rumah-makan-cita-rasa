@props(['menu'])

@php
    // Get base URL for review routes
    $reviewsBaseUrl = url('/reviews');
@endphp

<div class="mt-8 bg-white rounded-lg shadow-sm border">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Reviews</h3>
        
        @php
        // Tampilkan review yang sudah approved + review pending milik user yang sedang login
        $query = $menu->reviews()->where(function($q) {
            $q->where('status', 'approved');
            if(auth()->check()) {
                $q->orWhere(function($subQ) {
                    $subQ->where('status', 'pending')
                         ->where('user_id', (int) auth()->id());
                });
            }
        })->with('user')->latest();
        
        $reviews = $query->paginate(5);
        $averageRating = $menu->reviews()->where('status', 'approved')->avg('rating');
        $totalReviews = $menu->reviews()->where('status', 'approved')->count();
        $hasUserPendingReview = auth()->check() && $menu->reviews()->where('status', 'pending')->where('user_id', (int) auth()->id())->exists();
        @endphp

        @if($reviews->count() > 0)
            @if($totalReviews > 0)
                <!-- Rating Summary -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @elseif($i <= $averageRating)
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="ml-2 text-2xl font-bold text-gray-900">{{ number_format($averageRating, 1) }}</span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">{{ $totalReviews }} {{ $totalReviews === 1 ? 'review' : 'reviews' }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reviews List -->
            <div class="space-y-4" id="reviews-list">
                @foreach($reviews as $review)
                    <div class="border-b border-gray-200 pb-4 last:border-b-0" data-review-id="{{ $review->id }}">
                        <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <h4 class="font-medium text-gray-900">{{ $review->user->name }}</h4>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
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
                                    @php
                                        $showPendingBadge = auth()->check() && (int) auth()->id() === (int) $review->user_id && $review->status === 'pending';
                                    @endphp
                                    @if($showPendingBadge)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 flex items-center gap-1">
                                            <i class="fas fa-clock text-xs"></i>
                                            Menunggu Persetujuan
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Dropdown Menu -->
                                <div class="relative dropdown-container">
                                    <button onclick="toggleDropdown(this)" class="p-1 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                        </svg>
                                    </button>
                                    
                                    <div id="dropdown-{{ $review->id }}" 
                                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border hidden">
                                        @auth
                                            @php
                                                $currentUserId = (int) auth()->id();
                                                $reviewUserId = (int) $review->user_id;
                                                $isOwner = $currentUserId === $reviewUserId;
                                            @endphp
                                            @if($isOwner)
                                                <button type="button" 
                                                        onclick="openEditModal({{ $review->id }}, {{ $review->rating }}, '{{ addslashes($review->comment ?? '') }}')"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Ubah Review
                                                </button>
                                                <button type="button" 
                                                        onclick="confirmDelete({{ $review->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus Review
                                                </button>
                                                
                                                <!-- Hidden form for delete -->
                                                <form id="delete-form-{{ $review->id }}" method="POST" action="{{ route('reviews.destroy', $review) }}" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @else
                                                <span class="block px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
                                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                    </svg>
                                                    Bukan review Anda
                                                </span>
                                            @endif
                                        @else
                                            <span class="block px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
                                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                                Login untuk mengelola
                                            </span>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="text-gray-700">{{ $review->comment }}</p>
                            @endif
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                                <div class="review-status-message">
                                    @php
                                        $showPendingMessage = auth()->check() && (int) auth()->id() === (int) $review->user_id && $review->status === 'pending';
                                    @endphp
                                    @if($showPendingMessage)
                                        <p class="text-xs text-yellow-600 italic">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Review Anda sedang menunggu persetujuan admin
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada review</h3>
                <p class="mt-1 text-sm text-gray-500">Jadilah yang pertama memberikan review untuk menu ini!</p>
            </div>
        @endif

        <!-- Write Review Button -->
        @auth
            <div class="mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('reviews.create', ['menu_id' => $menu->id]) }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Tulis Review
                </a>
            </div>
        @else
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-500">Masuk</a> untuk menulis review.
                </p>
            </div>
        @endauth
    </div>
</div>

<!-- Edit Review Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Ubah Review</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                
                <!-- Rating -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Penilaian</label>
                    <div class="flex items-center space-x-2" id="ratingContainer">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" 
                                       class="sr-only" 
                                       required>
                                <svg class="w-8 h-8 text-gray-300 hover:text-yellow-400 transition-colors" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Comment -->
                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                    <textarea name="comment" id="comment" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                              placeholder="Bagikan pengalaman Anda..."></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        Perbarui Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Base URL for reviews
const reviewsBaseUrl = @json($reviewsBaseUrl);

function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    const isHidden = dropdown.classList.contains('hidden');
    
    // Close all other dropdowns
    document.querySelectorAll('.dropdown-container .absolute').forEach(dd => {
        dd.classList.add('hidden');
    });
    
    // Toggle current dropdown
    if (isHidden) {
        dropdown.classList.remove('hidden');
    } else {
        dropdown.classList.add('hidden');
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown-container')) {
        document.querySelectorAll('.dropdown-container .absolute').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

// SweetAlert2 confirmation for delete (Bahasa Indonesia)
function confirmDelete(reviewId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Review ini akan dihapus dan tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form
            document.getElementById('delete-form-' + reviewId).submit();
        }
    });
}

// Modal functions
function openEditModal(reviewId, rating, comment) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    const commentField = document.getElementById('comment');
    
    // Set form action using base URL from Laravel
    form.action = `${reviewsBaseUrl}/${reviewId}`;
    
    // Set current values
    commentField.value = comment;
    
    // Set rating
    const ratingInputs = form.querySelectorAll('input[name="rating"]');
    ratingInputs.forEach((input, index) => {
        if (index + 1 === rating) {
            input.checked = true;
            updateStarDisplay(index);
        }
    });
    
    // Show modal
    modal.classList.remove('hidden');
    
    // Close dropdown
    document.querySelectorAll('.dropdown-container .absolute').forEach(dropdown => {
        dropdown.classList.add('hidden');
    });
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
}

// Star rating for modal
function updateStarDisplay(selectedIndex) {
    const stars = document.querySelectorAll('#ratingContainer svg');
    stars.forEach((star, index) => {
        if (index <= selectedIndex) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

// Add event listeners for modal star rating
document.addEventListener('DOMContentLoaded', function() {
    const modalStars = document.querySelectorAll('#ratingContainer input[name="rating"]');
    modalStars.forEach((star, index) => {
        star.addEventListener('change', function() {
            updateStarDisplay(index);
        });
    });
    
    // Close modal when clicking outside
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
});
</script>
