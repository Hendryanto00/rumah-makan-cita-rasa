@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-4 md:px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Edit Kategori</h2>
        <p class="text-sm text-gray-600 mt-1">Perbarui informasi kategori dan pindahkan menu jika diperlukan</p>
    </div>
    
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-4 md:p-6">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- Nama Kategori -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name"
                       value="{{ old('name', $category->name) }}"
                       required
                       class="w-full px-3 md:px-4 py-2 md:py-2.5 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base @error('name') border-red-500 @enderror"
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
                          class="w-full px-3 md:px-4 py-2 md:py-2.5 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base resize-none @error('description') border-red-500 @enderror"
                          placeholder="Deskripsi kategori (maksimal 1000 karakter)">{{ old('description', $category->description) }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Maksimal 1000 karakter</p>
            </div>
            
            <!-- Menu terkait -->
            @if($category->menus_count > 0)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 md:p-4 rounded-r-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400 text-lg md:text-xl"></i>
                    </div>
                    <div class="ml-2 md:ml-3 flex-1 min-w-0">
                        <h3 class="text-sm font-medium text-yellow-800 mb-3">
                            Kategori ini memiliki {{ $category->menus_count }} menu
                        </h3>
                        
                        <!-- Pilih Menu yang akan dipindahkan -->
                        <div class="mb-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                                <label class="block text-xs sm:text-sm font-medium text-yellow-800">
                                    Pilih menu yang ingin dipindahkan
                                </label>
                                <div class="flex gap-2 flex-shrink-0">
                                    <button type="button" onclick="selectAllMenus()" class="text-xs text-yellow-700 hover:text-yellow-900 font-medium whitespace-nowrap px-2 py-1 rounded hover:bg-yellow-100 transition-colors">
                                        <i class="fas fa-check-square mr-1"></i>Pilih Semua
                                    </button>
                                    <button type="button" onclick="deselectAllMenus()" class="text-xs text-yellow-700 hover:text-yellow-900 font-medium whitespace-nowrap px-2 py-1 rounded hover:bg-yellow-100 transition-colors">
                                        <i class="fas fa-square mr-1"></i>Batal Pilih
                                    </button>
                                </div>
                            </div>
                            
                            <div class="max-h-60 overflow-y-auto border-2 border-yellow-200 rounded-lg bg-white p-2 md:p-3 space-y-2">
                                @foreach($category->menus as $menu)
                                <label class="flex items-center p-2 hover:bg-yellow-50 rounded cursor-pointer transition-colors">
                                    <input type="checkbox" 
                                           name="selected_menus[]" 
                                           value="{{ $menu->id }}"
                                           class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500 focus:ring-2 flex-shrink-0"
                                           {{ old('selected_menus') && in_array($menu->id, old('selected_menus')) ? 'checked' : '' }}>
                                    <span class="ml-2 md:ml-3 text-xs sm:text-sm text-gray-700 flex-1 min-w-0">
                                        <span class="block truncate">{{ $menu->name }}</span>
                                        <span class="text-gray-500 text-xs">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Pilih Kategori Tujuan -->
                        <div>
                            <label for="move_menus_to" class="block text-xs sm:text-sm font-medium text-yellow-800 mb-2">
                                Pindahkan ke kategori
                            </label>
                            <div class="relative">
                                <select name="move_menus_to" 
                                        id="move_menus_to"
                                        class="w-full px-3 md:px-4 py-2 md:py-2.5 pr-8 md:pr-10 rounded-xl border-2 border-yellow-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-xs sm:text-sm md:text-base bg-white appearance-none cursor-pointer">
                                    <option value="">-- Pilih kategori (opsional) --</option>
                                    @foreach($allCategories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('move_menus_to') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 md:pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-yellow-700 leading-relaxed">
                                <i class="fas fa-info-circle mr-1"></i>
                                <span class="block sm:inline">Pilih menu di atas, lalu pilih kategori tujuan. Menu yang tidak dipilih akan tetap di kategori ini.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-3"></i>
                    <p class="text-sm font-medium text-green-800">
                        Kategori ini tidak memiliki menu terkait
                    </p>
                </div>
            </div>
            @endif
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

@push('styles')
<style>
    /* Remove default browser dropdown arrow */
    #move_menus_to {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: none !important;
    }
    
    #move_menus_to::-moz-focus-inner {
        border: 0;
    }
    
    #move_menus_to::-ms-expand {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
function selectAllMenus() {
    document.querySelectorAll('input[name="selected_menus[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAllMenus() {
    document.querySelectorAll('input[name="selected_menus[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}

// Disable submit if move_menus_to is selected but no menu is selected
document.querySelector('form').addEventListener('submit', function(e) {
    const moveTo = document.getElementById('move_menus_to').value;
    const selectedMenus = document.querySelectorAll('input[name="selected_menus[]"]:checked');
    
    if (moveTo && selectedMenus.length === 0) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Silakan pilih menu yang ingin dipindahkan terlebih dahulu.',
            confirmButtonColor: '#f97316'
        });
        return false;
    }
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

