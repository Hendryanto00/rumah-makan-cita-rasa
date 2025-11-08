@extends('layouts.admin')

@section('title', 'Statistik Review')
@section('page-title', 'Statistik Review')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 md:px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Statistik Review</h2>
            <p class="text-sm text-gray-600 mt-1">Lihat statistik total rating, jumlah review, distribusi bintang dan tren penilaian</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Reviews -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Review</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalReviews) }}</p>
                </div>
            </div>
        </div>

        <!-- Approved Reviews -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Review Disetujui</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($approvedReviews) }}</p>
                </div>
            </div>
        </div>

        <!-- Average Rating -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Rata-rata Rating</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($averageRating, 2) }}/5</p>
                </div>
            </div>
        </div>

        <!-- Pending Reviews -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu Persetujuan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($reviewsByStatus['pending']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Star Distribution -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 md:px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Distribusi Bintang</h3>
            <p class="text-sm text-gray-600 mt-1">Jumlah review berdasarkan rating bintang</p>
        </div>
        <div class="p-4 md:p-6">
            <div class="space-y-4">
                @for($i = 5; $i >= 1; $i--)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-700 mr-2">{{ $i }} Bintang</span>
                                <div class="flex">
                                    @for($j = 1; $j <= 5; $j++)
                                        @if($j <= $i)
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
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="text-sm text-gray-600">{{ $starDistribution[$i]['count'] }} review</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $starDistribution[$i]['percentage'] }}%</span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-yellow-400 h-3 rounded-full transition-all duration-500" style="width: {{ $starDistribution[$i]['percentage'] }}%"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Rating Trend & Top Rated Menus -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Rating Trend -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-4 md:px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Tren Penilaian (6 Bulan Terakhir)</h3>
                <p class="text-sm text-gray-600 mt-1">Rata-rata rating dan jumlah review per bulan</p>
            </div>
            <div class="p-4 md:p-6">
                <div class="space-y-4">
                    @foreach($ratingTrend as $trend)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ $trend['month'] }}</span>
                                <div class="flex items-center space-x-4">
                                    <span class="text-xs text-gray-500">{{ $trend['count'] }} review</span>
                                    <span class="text-sm font-semibold text-gray-900">
                                        @if($trend['average_rating'] > 0)
                                            {{ number_format($trend['average_rating'], 2) }}/5
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $trend['count'] > 0 ? min(($trend['count'] / max(array_column($ratingTrend, 'count'))) * 100, 100) : 0 }}%"></div>
                                </div>
                                @if($trend['average_rating'] > 0)
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($trend['average_rating']))
                                                <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @else
                                                <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top Rated Menus -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-4 md:px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Menu Terpopuler</h3>
                <p class="text-sm text-gray-600 mt-1">Menu dengan rating tertinggi</p>
            </div>
            <div class="p-4 md:p-6">
                @if($topRatedMenus->count() > 0)
                    <div class="space-y-4">
                        @foreach($topRatedMenus as $index => $menuReview)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $menuReview->menu->name ?? 'Menu tidak ditemukan' }}</p>
                                        <p class="text-xs text-gray-500">{{ $menuReview->review_count }} review</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($menuReview->avg_rating))
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
                                    <span class="text-sm font-semibold text-gray-900">{{ number_format($menuReview->avg_rating, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-star text-4xl text-gray-300 mb-3"></i>
                        <p class="text-sm text-gray-500">Belum ada review untuk menu</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reviews by Status Chart -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 md:px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Review Berdasarkan Status</h3>
            <p class="text-sm text-gray-600 mt-1">Distribusi review berdasarkan status</p>
        </div>
        <div class="p-4 md:p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Disetujui</p>
                            <p class="text-2xl font-bold text-green-900">{{ number_format($reviewsByStatus['approved']) }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-yellow-600">Menunggu</p>
                            <p class="text-2xl font-bold text-yellow-900">{{ number_format($reviewsByStatus['pending']) }}</p>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-600">Disembunyikan</p>
                            <p class="text-2xl font-bold text-red-900">{{ number_format($reviewsByStatus['hidden']) }}</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

