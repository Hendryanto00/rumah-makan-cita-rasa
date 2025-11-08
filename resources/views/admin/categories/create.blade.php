@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori Baru')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Tambah Kategori Baru</h2>
        <p class="text-sm text-gray-600 mt-1">Buat kategori baru untuk pengelompokan menu</p>
    </div>
    
    <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="space-y-6">
            <!-- Nama Kategori -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base @error('name') border-red-500 @enderror"
                       placeholder="Contoh: Makanan Utama, Minuman, Dessert">
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi <span class="text-gray-400 text-xs">(Opsional)</span>
                </label>
                <textarea name="description" 
                          id="description"
                          rows="4"
                          class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base resize-none @error('description') border-red-500 @enderror"
                          placeholder="Deskripsi kategori (maksimal 1000 karakter)">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Maksimal 1000 karakter</p>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="mt-6 md:mt-8 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-4 md:pt-6 border-t border-gray-200">
            <a href="{{ route('admin.categories.index') }}" 
               class="w-full sm:w-auto px-4 md:px-6 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors font-medium text-center text-sm md:text-base">
                Batal
            </a>
            <button type="submit" 
                    class="w-full sm:w-auto px-4 md:px-6 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white transition-colors font-medium text-sm md:text-base">
                Simpan
            </button>
        </div>
    </form>
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
@endsection

