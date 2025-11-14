<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Menu Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Menu</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-700">Nama:</span>
                                    <span class="ml-2 text-gray-900">{{ $review->menu->name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Deskripsi:</span>
                                    <p class="mt-1 text-gray-900">{{ $review->menu->description }}</p>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Harga:</span>
                                    <span class="ml-2 text-gray-900">Rp {{ number_format($review->menu->price, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Kategori:</span>
                                    <span class="ml-2 text-gray-900">{{ $review->menu->category->name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Review Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Review</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-700">Penilaian:</span>
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                        <span class="ml-2 text-gray-600">({{ $review->rating }}/5)</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-700">Status:</span>
                                    <span class="ml-2">
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
                                    </span>
                                </div>

                                <div>
                                    <span class="font-medium text-gray-700">Pengulas:</span>
                                    <span class="ml-2 text-gray-900">{{ $review->user->name }}</span>
                                </div>

                                <div>
                                    <span class="font-medium text-gray-700">Tanggal:</span>
                                    <span class="ml-2 text-gray-900">{{ $review->created_at->format('d M Y \p\u\k\u\l H:i') }}</span>
                                </div>

                                @if($review->comment)
                                    <div>
                                        <span class="font-medium text-gray-700">Komentar:</span>
                                        <p class="mt-1 text-gray-900 bg-white p-3 rounded border">{{ $review->comment }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('reviews.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali ke Review
                        </a>
                        
                        <div class="flex space-x-2">
                            @if($review->canBeEditedBy(auth()->user()))
                                <a href="{{ route('reviews.edit', $review) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Ubah Review
                                </a>
                            @endif
                            
                            @if($review->canBeDeletedBy(auth()->user()))
                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
                                        Hapus Review
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
