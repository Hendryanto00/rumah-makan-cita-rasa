@extends('layouts.admin')

@section('title', 'Edit Menu')
@section('page-title', 'Edit Menu')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form id="menuEditForm" method="POST" action="{{ route('admin.menus.update', $menu) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')
            <input type="hidden" name="page" value="{{ $currentPage ?? request('page', 1) }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Menu</label>
                    <input type="text" name="name" value="{{ old('name', $menu->name) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" />
                    @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $menu->price) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" />
                    @error('price')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $menu->stock) }}" required min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" />
                    @error('stock')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">{{ old('description', $menu->description) }}</textarea>
                @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gambar Saat Ini</label>
                    @php
                        $slug = \Illuminate\Support\Str::slug($menu->name);
                        $ext = null;
                        foreach (['jpg','jpeg','png','webp'] as $e) {
                            $filePath = public_path("images/menu/{$slug}.{$e}");
                            if (file_exists($filePath) && is_file($filePath)) { 
                                $ext = $e; 
                                break; 
                            }
                        }
                        $currentImage = $ext ? asset("images/menu/{$slug}.{$ext}") : asset('images/rumah-makan.jpg');
                    @endphp
                    <img id="imagePreview" src="{{ $currentImage }}" alt="{{ $menu->name }}" class="mt-2 h-32 w-32 rounded-lg object-cover border" />

                    <label class="block text-sm font-medium text-gray-700 mt-4">Gambar Baru (opsional)</label>
                    <input id="imageInput" type="file" name="image" accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer focus:outline-none" />
                    @error('image')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    <p class="mt-1 text-xs text-gray-500">Pratinjau akan ditampilkan di atas setelah memilih file.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <label class="inline-flex items-center mt-2">
                        <input type="checkbox" name="is_active" value="1" class="rounded text-orange-600 focus:ring-orange-500" {{ old('is_active', $menu->is_active) ? 'checked' : '' }} />
                        <span class="ml-2 text-sm text-gray-700">Aktifkan menu</span>
                    </label>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('admin.menus.index', ['page' => $currentPage ?? request('page', 1)]) }}" class="w-full sm:w-auto px-4 md:px-6 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors font-medium text-center text-sm md:text-base">Batal</a>
                <button type="submit" class="w-full sm:w-auto px-4 md:px-6 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white transition-colors font-medium text-sm md:text-base">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');
    const form = document.getElementById('menuEditForm');
    if (input) {
        input.addEventListener('change', function(){
            const file = this.files && this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => { preview.src = e.target.result; };
                reader.readAsDataURL(file);
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            if (typeof Swal === 'undefined') { form.submit(); return; }
            Swal.fire({
                title: 'Simpan perubahan menu?',
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
@endsection


