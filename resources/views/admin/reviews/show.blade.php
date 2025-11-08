@extends('layouts.admin')

@section('title', 'Detail Review')
@section('page-title', 'Detail Review')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Review Information -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Review Information</h3>
                <div class="space-y-4">
                    <div>
                        <span class="font-medium text-gray-700">Rating:</span>
                        <div class="flex items-center mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                            <span class="ml-2 text-lg font-semibold text-gray-900">({{ $review->rating }}/5)</span>
                        </div>
                    </div>
                    
                    <div>
                        <span class="font-medium text-gray-700">Status:</span>
                        <span class="ml-2">
                            @if($review->status === 'approved')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Approved
                                </span>
                            @elseif($review->status === 'pending')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Hidden
                                </span>
                            @endif
                        </span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Date:</span>
                        <span class="ml-2 text-gray-900">{{ $review->created_at->format('M d, Y \a\t g:i A') }}</span>
                    </div>

                    @if($review->comment)
                        <div>
                            <span class="font-medium text-gray-700">Comment:</span>
                            <div class="mt-2 p-4 bg-white rounded border">
                                <p class="text-gray-900">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- User Information -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">User Information</h3>
                <div class="space-y-4">
                    <div>
                        <span class="font-medium text-gray-700">Name:</span>
                        <span class="ml-2 text-gray-900">{{ $review->user->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Email:</span>
                        <span class="ml-2 text-gray-900">{{ $review->user->email }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Member Since:</span>
                        <span class="ml-2 text-gray-900">{{ $review->user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Total Reviews:</span>
                        <span class="ml-2 text-gray-900">{{ $review->user->reviews()->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Information -->
        <div class="mt-6 bg-gray-50 p-6 rounded-lg">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Menu Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="font-medium text-gray-700">Menu Name:</span>
                    <span class="ml-2 text-gray-900">{{ $review->menu->name }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Category:</span>
                    <span class="ml-2 text-gray-900">{{ $review->menu->category->name }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Price:</span>
                    <span class="ml-2 text-gray-900">Rp {{ number_format($review->menu->price, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Status:</span>
                    <span class="ml-2">
                        @if($review->menu->is_active)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="mt-4">
                <span class="font-medium text-gray-700">Description:</span>
                <p class="mt-1 text-gray-900">{{ $review->menu->description }}</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex items-center justify-between">
            <a href="{{ route('admin.reviews.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Daftar Review
            </a>
            
            <div class="flex space-x-2">
                @if($review->status === 'pending')
                    <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline approve-form">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Approve Review
                        </button>
                    </form>
                @endif
                
                @if($review->status === 'hidden')
                    <form method="POST" action="{{ route('admin.reviews.unhide', $review) }}" class="inline unhide-form">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tampilkan Review
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.reviews.hide', $review) }}" class="inline hide-form">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Hide Review
                        </button>
                    </form>
                @endif
                
                <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline reject-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Reject Review
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Approve form with SweetAlert
    document.querySelectorAll('.approve-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi Persetujuan',
                text: 'Apakah Anda yakin ingin menyetujui review ini? Review akan tampil di publik.',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    // Hide form with SweetAlert
    document.querySelectorAll('.hide-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Penyembunyian',
                text: 'Apakah Anda yakin ingin menyembunyikan review ini? Review akan disembunyikan dari tampilan publik tetapi tetap tersimpan.',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, sembunyikan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    // Unhide form with SweetAlert
    document.querySelectorAll('.unhide-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi Menampilkan',
                text: 'Apakah Anda yakin ingin menampilkan kembali review ini? Review akan tampil di publik.',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, tampilkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    // Reject form with SweetAlert
    document.querySelectorAll('.reject-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
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
@endsection

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
