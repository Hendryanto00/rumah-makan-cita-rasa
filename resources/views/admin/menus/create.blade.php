@extends('layouts.admin')

@section('title', 'Tambah Menu')
@section('page-title', 'Tambah Menu Baru')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-4 md:px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Tambah Menu Baru</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola kategori untuk pengelompokan menu</p>
    </div>
    
    <form id="menuCreateForm" method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data" class="p-4 md:p-6">
        @csrf

        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Menu <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ old('name') }}" 
                           required
                           class="w-full px-3 md:px-4 py-2 md:py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base @error('name') border-red-500 @enderror"
                           placeholder="Contoh: Nasi Goreng Spesial">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="category_id" 
                                id="category_id"
                                required
                                class="w-full px-3 md:px-4 py-2 md:py-2.5 pr-8 md:pr-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-white appearance-none cursor-pointer @error('category_id') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 md:pr-4 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                    @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           step="0.01" 
                           name="price" 
                           id="price"
                           value="{{ old('price') }}" 
                           required
                           class="w-full px-3 md:px-4 py-2 md:py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base @error('price') border-red-500 @enderror"
                           placeholder="Contoh: 25000">
                    @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="stock" 
                           id="stock"
                           value="{{ old('stock', 0) }}" 
                           required 
                           min="0"
                           class="w-full px-3 md:px-4 py-2 md:py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base @error('stock') border-red-500 @enderror"
                           placeholder="0">
                    @error('stock')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi <span class="text-gray-400 text-xs">(Opsional)</span>
                </label>
                <textarea name="description" 
                          id="description"
                          rows="4"
                          class="w-full px-3 md:px-4 py-2 md:py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base resize-none @error('description') border-red-500 @enderror"
                          placeholder="Deskripsi menu...">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 items-start">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pratinjau Gambar</label>
                    <img id="createImagePreview" src="" alt="Preview" class="hidden mt-2 h-32 w-32 rounded-lg object-cover border border-gray-300" />

                    <label for="createImageInput" class="block text-sm font-medium text-gray-700 mt-4">
                        Foto Menu <span class="text-gray-400 text-xs">(jpg, jpeg, png, webp)</span>
                    </label>
                    <input id="createImageInput" 
                           type="file" 
                           name="image" 
                           accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('image') border-red-500 @enderror" />
                    @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="inline-flex items-center mt-8">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               class="rounded text-orange-600 focus:ring-orange-500" 
                               {{ old('is_active', 1) ? 'checked' : '' }} />
                        <span class="ml-2 text-sm text-gray-700">Aktifkan menu</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 md:mt-8 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-4 md:pt-6 border-t border-gray-200">
            <a href="{{ route('admin.menus.index') }}" 
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
<script>
document.addEventListener('DOMContentLoaded', function(){
    const input = document.getElementById('createImageInput');
    const preview = document.getElementById('createImagePreview');
    const form = document.getElementById('menuCreateForm');
    if (input) {
        input.addEventListener('change', function(){
            const file = this.files && this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            // Save scroll position before showing confirmation
            sessionStorage.setItem('menu_scroll_position', window.pageYOffset || document.documentElement.scrollTop);
            if (typeof Swal === 'undefined') { form.submit(); return; }
            Swal.fire({
                title: 'Simpan menu baru?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    }
});
</script>

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

@push('styles')
<style>
    /* Remove default browser dropdown arrow */
    #category_id {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: none !important;
    }
    
    #category_id::-moz-focus-inner {
        border: 0;
    }
    
    #category_id::-ms-expand {
        display: none;
    }
</style>
@endpush
@endsection


