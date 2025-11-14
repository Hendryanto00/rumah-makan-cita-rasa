@extends('layouts.admin')

@section('title', 'Kelola Review')
@section('page-title', 'Kelola Review')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-4 md:px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Kelola Review</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola review pelanggan untuk memastikan kualitas ulasan</p>
    </div>
    
    <div class="p-4 md:p-6">

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mb-4 sm:mb-6">
                        <div class="bg-blue-50 p-3 sm:p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-1.5 sm:p-2 bg-blue-100 rounded-lg flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3">
                                    <p class="text-xs sm:text-sm font-medium text-blue-600">Total Review</p>
                                    <p class="text-xl sm:text-2xl font-bold text-blue-900">{{ $reviews->total() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 p-3 sm:p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-1.5 sm:p-2 bg-yellow-100 rounded-lg flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3">
                                    <p class="text-xs sm:text-sm font-medium text-yellow-600">Menunggu</p>
                                    <p class="text-xl sm:text-2xl font-bold text-yellow-900">{{ $stats['pending'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-3 sm:p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-1.5 sm:p-2 bg-green-100 rounded-lg flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3">
                                    <p class="text-xs sm:text-sm font-medium text-green-600">Disetujui</p>
                                    <p class="text-xl sm:text-2xl font-bold text-green-900">{{ $stats['approved'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-red-100 p-3 sm:p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-1.5 sm:p-2 bg-red-200 rounded-lg flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3">
                                    <p class="text-xs sm:text-sm font-medium text-red-600">Disembunyikan</p>
                                    <p class="text-xl sm:text-2xl font-bold text-red-900">{{ $stats['hidden'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters and Search -->
                    <div class="mb-6">
                        <form id="filter-form" method="GET" class="flex flex-col sm:flex-row gap-3">
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Cari berdasarkan nama user atau menu..." 
                                       class="w-full pl-12 pr-4 py-2.5 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-white"
                                       onkeypress="if(event.key === 'Enter') { event.preventDefault(); document.getElementById('filter-form').submit(); }">
                            </div>
                            <div class="relative">
                                <select name="status" id="status-filter" class="w-full sm:w-auto min-w-[150px] pl-4 pr-10 py-2.5 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-white appearance-none cursor-pointer">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="hidden" {{ request('status') === 'hidden' ? 'selected' : '' }}>Disembunyikan</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Bulk Actions -->
                    <form id="bulk-form" method="POST" action="{{ route('admin.reviews.bulk-action') }}" class="mb-6">
                        @csrf
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            <div class="relative flex-1 sm:flex-none sm:min-w-[200px]">
                                <select name="action" id="bulk-action" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-white appearance-none cursor-pointer">
                                    <option value="">Aksi Massal</option>
                                    <option value="approve">Setujui yang Dipilih</option>
                                    <option value="hide">Sembunyikan yang Dipilih</option>
                                    <option value="unhide">Tampilkan yang Dipilih</option>
                                    <option value="reject">Tolak yang Dipilih</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                            <button type="submit" id="bulk-submit" class="px-6 py-2.5 bg-gray-500 text-white rounded-xl hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition text-sm md:text-base font-semibold whitespace-nowrap" disabled>
                                Terapkan
                            </button>
                        </div>
                    </form>

                    <!-- Reviews Table (Desktop) -->
                    <div class="overflow-x-auto hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 md:px-6 py-3 text-left">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </th>
                                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Penilaian</th>
                                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Komentar</th>
                                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">Tanggal</th>
                                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reviews as $review)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" name="review_ids[]" value="{{ $review->id }}" 
                                                   class="review-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $review->user->name }}</div>
                                            <div class="text-xs text-gray-500 hidden lg:block">{{ $review->user->email }}</div>
                                        </td>
                                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $review->menu->name }}</div>
                                            <div class="text-xs text-gray-500 hidden lg:block">{{ $review->menu->category->name }}</div>
                                        </td>
                                        <td class="px-4 md:px-6 py-4 whitespace-nowrap hidden lg:table-cell">
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
                                                <span class="ml-2 text-xs text-gray-600">({{ $review->rating }}/5)</span>
                                            </div>
                                        </td>
                                        <td class="px-4 md:px-6 py-4 hidden lg:table-cell">
                                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                                {{ $review->comment ?: 'Tidak ada komentar' }}
                                            </div>
                                        </td>
                                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                            @if($review->status === 'approved')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Disetujui
                                                </span>
                                            @elseif($review->status === 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Menunggu
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Disembunyikan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 md:px-6 py-4 whitespace-nowrap text-xs text-gray-500 hidden xl:table-cell">
                                            {{ $review->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                                                <a href="{{ route('admin.reviews.show', $review) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 text-xs">Lihat</a>
                                                
                                                @if($review->status === 'pending')
                                                    <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900 text-xs">Setujui</button>
                                                    </form>
                                                @endif
                                                
                                                @if($review->status === 'hidden')
                                                    <form method="POST" action="{{ route('admin.reviews.unhide', $review) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-blue-600 hover:text-blue-900 text-xs">Tampilkan</button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('admin.reviews.hide', $review) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900 text-xs">Sembunyikan</button>
                                                    </form>
                                                @endif
                                                
                                                <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline reject-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 reject-btn text-xs">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 md:px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-star text-6xl text-gray-300 mb-4"></i>
                                                <p class="text-sm text-gray-500 font-medium">Tidak ada review</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile cards list -->
                    <div class="md:hidden divide-y">
                        @forelse($reviews as $review)
                        <div class="p-4">
                            <div class="flex items-start gap-3 mb-3">
                                <input type="checkbox" name="review_ids[]" value="{{ $review->id }}" 
                                       class="review-checkbox mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500 flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900 text-sm">{{ $review->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $review->user->email }}</p>
                                        </div>
                                        @if($review->status === 'approved')
                                            <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-green-100 text-green-800 flex-shrink-0">
                                                Disetujui
                                            </span>
                                        @elseif($review->status === 'pending')
                                            <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-yellow-100 text-yellow-800 flex-shrink-0">
                                                Menunggu
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-red-100 text-red-800 flex-shrink-0">
                                                Disembunyikan
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 mb-1">{{ $review->menu->name }}</p>
                                    <p class="text-xs text-gray-500 mb-2">{{ $review->menu->category->name }}</p>
                                    <div class="flex items-center mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @else
                                                <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                        <span class="ml-1 text-xs text-gray-600">({{ $review->rating }}/5)</span>
                                    </div>
                                    @if($review->comment)
                                    <p class="text-xs text-gray-700 mb-2 line-clamp-2">{{ $review->comment }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mb-3">{{ $review->created_at->format('M d, Y') }}</p>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('admin.reviews.show', $review) }}" 
                                           class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-medium transition-colors">
                                            Lihat
                                        </a>
                                        
                                        @if($review->status === 'pending')
                                            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-medium transition-colors">
                                                    Setujui
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($review->status === 'hidden')
                                            <form method="POST" action="{{ route('admin.reviews.unhide', $review) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition-colors">
                                                    Tampilkan
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.reviews.hide', $review) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-xs font-medium transition-colors">
                                                    Sembunyikan
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline reject-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-medium transition-colors reject-btn">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-6 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="fas fa-star text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">Tidak ada review</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($reviews->hasPages())
                        <div class="mt-4 px-4 md:px-0">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Remove default browser dropdown arrow */
        #status-filter,
        #bulk-action {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: none !important;
        }
        
        #status-filter::-moz-focus-inner,
        #bulk-action::-moz-focus-inner {
            border: 0;
        }
        
        #status-filter::-ms-expand,
        #bulk-action::-ms-expand {
            display: none;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Auto-submit filter form when status changes
        document.getElementById('status-filter').addEventListener('change', function() {
            // Jika "Semua Status" dipilih, hapus parameter status dari URL
            if (this.value === '') {
                const form = document.getElementById('filter-form');
                const url = new URL(window.location.href);
                url.searchParams.delete('status');
                // Jika ada search, tetap pertahankan
                const searchValue = document.querySelector('input[name="search"]').value;
                if (searchValue) {
                    url.searchParams.set('search', searchValue);
                } else {
                    url.searchParams.delete('search');
                }
                window.location.href = url.toString();
            } else {
                document.getElementById('filter-form').submit();
            }
        });

        // Select all functionality
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.review-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkButton();
        });

        // Individual checkbox change
        document.querySelectorAll('.review-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkButton);
        });

        // Update bulk action button state
        function updateBulkButton() {
            const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
            const bulkSubmit = document.getElementById('bulk-submit');
            const bulkAction = document.getElementById('bulk-action');
            
            if (checkedBoxes.length > 0 && bulkAction.value) {
                bulkSubmit.disabled = false;
                bulkSubmit.classList.remove('bg-gray-500');
                bulkSubmit.classList.add('bg-blue-500');
            } else {
                bulkSubmit.disabled = true;
                bulkSubmit.classList.remove('bg-blue-500');
                bulkSubmit.classList.add('bg-gray-500');
            }
        }

        // Bulk action change
        document.getElementById('bulk-action').addEventListener('change', updateBulkButton);

        // Bulk form submission
        document.getElementById('bulk-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
            const action = document.getElementById('bulk-action').value;
            
            if (checkedBoxes.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih setidaknya satu review.',
                    confirmButtonColor: '#f97316'
                });
                return;
            }

            if (!action) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih aksi.',
                    confirmButtonColor: '#f97316'
                });
                return;
            }
            
            // Collect checked review IDs
            const reviewIds = Array.from(checkedBoxes).map(checkbox => checkbox.value);
            
            // Remove any existing hidden inputs for review_ids
            const existingInputs = this.querySelectorAll('input[name="review_ids[]"]');
            existingInputs.forEach(input => input.remove());
            
            // Add hidden inputs for each selected review ID
            reviewIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'review_ids[]';
                input.value = id;
                this.appendChild(input);
            });
            
            const actionText = action === 'approve' ? 'menyetujui' : action === 'hide' ? 'menyembunyikan' : action === 'unhide' ? 'menampilkan kembali' : 'menolak';
            const actionIcon = action === 'approve' ? 'success' : action === 'hide' ? 'warning' : action === 'unhide' ? 'info' : 'error';
            
            Swal.fire({
                icon: actionIcon,
                title: 'Konfirmasi',
                text: `Apakah Anda yakin ingin ${actionText} ${checkedBoxes.length} review?`,
                showCancelButton: true,
                confirmButtonColor: action === 'approve' ? '#10b981' : action === 'hide' ? '#f59e0b' : action === 'unhide' ? '#3b82f6' : '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Reject button with SweetAlert
        document.querySelectorAll('.reject-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi Penolakan',
                    text: 'Apakah Anda yakin ingin menolak dan menghapus review ini? Tindakan ini tidak dapat dibatalkan.',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, tolak dan hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
    @endpush
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: 'OK',
        confirmButtonColor: '#f97316'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: 'OK',
        confirmButtonColor: '#dc2626'
    });
</script>
@endif
@endsection
