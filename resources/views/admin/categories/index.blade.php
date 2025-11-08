@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-4 md:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Daftar Kategori</h2>
            <p class="text-sm text-gray-600 mt-1">Kelola kategori untuk pengelompokan menu</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="w-full sm:w-auto px-4 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white font-medium transition-colors text-sm md:text-base text-center">
            <i class="fas fa-plus mr-2"></i>Tambah Kategori
        </a>
    </div>
    
    <!-- Search and Filter -->
    <div class="px-4 md:px-6 py-4 border-b border-gray-200 bg-gray-50">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-col gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       name="search"
                       id="search-input"
                       placeholder="Cari nama kategori atau deskripsi..." 
                       class="w-full pl-12 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-white"
                       value="{{ request('search') }}">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-lg transition-colors text-sm md:text-base font-medium">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
                @if(request('search'))
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors text-sm md:text-base font-medium">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
                @endif
            </div>
        </form>
    </div>
    
    <!-- Categories Table (Desktop) -->
    <div class="overflow-x-auto hidden md:block">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Deskripsi</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Menu</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $category->name }}</div>
                    </td>
                    <td class="px-4 md:px-6 py-4 hidden lg:table-cell">
                        <div class="text-sm text-gray-600 max-w-md">
                            {{ $category->description ? \Illuminate\Support\Str::limit($category->description, 100) : '-' }}
                        </div>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        <span class="px-2 md:px-3 py-1 text-xs font-semibold rounded-full {{ $category->menus_count > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $category->menus_count }} menu
                        </span>
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="px-2 md:px-4 py-1 md:py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors text-xs md:text-sm">
                                Edit
                            </a>
                            <button type="button" 
                                    onclick="confirmDelete({{ $category->id }}, '{{ addslashes($category->name) }}', {{ $category->menus_count }})"
                                    class="px-2 md:px-4 py-1 md:py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors text-xs md:text-sm">
                                Hapus
                            </button>
                            <form id="delete-form-{{ $category->id }}" 
                                  action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 md:px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-tags text-6xl text-gray-300 mb-4"></i>
                            <p class="text-lg font-semibold text-gray-900 mb-2">Tidak ada kategori</p>
                            <p class="text-sm text-gray-500 mb-4">
                                @if(request('search'))
                                    Tidak ada kategori yang sesuai dengan pencarian
                                @else
                                    Belum ada kategori yang dibuat
                                @endif
                            </p>
                            @if(!request('search'))
                            <a href="{{ route('admin.categories.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors">
                                <i class="fas fa-plus mr-2"></i>Tambah Kategori Pertama
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile cards list -->
    <div class="md:hidden divide-y divide-gray-200">
        @forelse($categories as $category)
        <div class="p-4">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1 min-w-0 pr-3">
                    <h3 class="text-base font-bold text-gray-900 mb-1">{{ $category->name }}</h3>
                    @if($category->description)
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $category->description }}</p>
                    @endif
                </div>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $category->menus_count > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }} flex-shrink-0 whitespace-nowrap">
                    {{ $category->menus_count }} menu
                </span>
            </div>
            <div class="flex items-center gap-2 mt-3">
                <a href="{{ route('admin.categories.edit', $category) }}" 
                   class="flex-1 px-2.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors text-xs text-center">
                    Edit
                </a>
                <button type="button" 
                        onclick="confirmDelete({{ $category->id }}, '{{ addslashes($category->name) }}', {{ $category->menus_count }})"
                        class="flex-1 px-2.5 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors text-xs text-center">
                    Hapus
                </button>
                <form id="delete-form-{{ $category->id }}" 
                      action="{{ route('admin.categories.destroy', $category) }}" 
                      method="POST" 
                      class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
        @empty
        <div class="p-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <i class="fas fa-tags text-gray-400 text-2xl"></i>
            </div>
            <p class="text-sm text-gray-500 font-medium">Tidak ada kategori</p>
            @if(request('search'))
                <p class="text-xs text-gray-400 mt-1">Coba ubah filter pencarian Anda</p>
            @else
                <p class="text-xs text-gray-400 mt-1">Belum ada kategori yang dibuat</p>
                <a href="{{ route('admin.categories.create') }}" 
                   class="inline-flex items-center mt-4 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors text-sm">
                    <i class="fas fa-plus mr-2"></i>Tambah Kategori Pertama
                </a>
            @endif
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
    <div class="px-4 md:px-6 py-4 border-t border-gray-200">
        {{ $categories->links() }}
    </div>
    @endif
</div>

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

@push('scripts')
<script>
function confirmDelete(categoryId, categoryName, menusCount) {
    if (menusCount > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Tidak Dapat Menghapus',
            html: `Kategori <strong>"${categoryName}"</strong> tidak dapat dihapus karena masih memiliki <strong>${menusCount} menu</strong>.<br><br>Pindahkan atau hapus menu terlebih dahulu.`,
            confirmButtonColor: '#f97316',
            confirmButtonText: 'Mengerti'
        });
        return;
    }
    
    Swal.fire({
        title: 'Hapus Kategori?',
        html: `Apakah Anda yakin ingin menghapus kategori <strong>"${categoryName}"</strong>?<br><br>Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit form
            document.getElementById('delete-form-' + categoryId).submit();
        }
    });
}
</script>
@endpush
@endsection

