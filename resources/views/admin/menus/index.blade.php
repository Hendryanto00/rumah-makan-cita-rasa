@extends('layouts.admin')

@section('title', 'Menu')
@section('page-title', 'Daftar Menu')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-4 md:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Menu</h2>
            <p class="text-sm text-gray-600 mt-1">Buat menu baru untuk ditambahkan ke katalog</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="w-full sm:w-auto px-4 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white font-medium transition-colors text-sm md:text-base text-center">
            <i class="fas fa-plus mr-2"></i>Tambah Menu
        </a>
    </div>
    
    <!-- Search and Filter -->
    <div class="px-4 md:px-6 py-4 border-b border-gray-200 bg-gray-50">
        <form method="GET" action="{{ route('admin.menus.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       name="search"
                       id="search-input"
                       placeholder="Cari menu, kategori, atau deskripsi..." 
                       class="w-full pl-12 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-white"
                       value="{{ request('search') }}">
            </div>
            <button type="submit" class="sm:w-auto px-6 bg-orange-500 hover:bg-orange-600 text-white py-2.5 rounded-lg transition-colors text-sm md:text-base font-medium whitespace-nowrap">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            <div class="sm:w-56 relative">
                <select name="category" id="category-filter" class="w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-white appearance-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            <div class="sm:w-52 relative">
                <select name="status" id="status-filter" class="w-full pl-4 pr-10 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-sm md:text-base bg-white appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </form>
    </div>
    <div class="overflow-x-auto hidden md:block">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Kategori</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Harga</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Stok</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Status</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($menus as $menu)
                <tr>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        @php
                            $slug = \Illuminate\Support\Str::slug($menu->name);
                            $possible = ['jpg','jpeg','png','webp'];
                            $found = null;
                            foreach ($possible as $ext) {
                                if (file_exists(public_path("images/menu/{$slug}.{$ext}"))) { $found = $ext; break; }
                            }
                            $imageUrl = $found ? asset("images/menu/{$slug}.{$found}") : asset('images/rumah-makan.jpg');
                        @endphp
                        <img src="{{ $imageUrl }}"
                             alt="{{ $menu->name }}"
                             class="h-16 w-16 md:h-20 md:w-20 rounded object-cover" />
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-gray-900">{{ $menu->name }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-gray-500 hidden md:table-cell">{{ $menu->category->name ?? '-' }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-gray-500 hidden md:table-cell">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap text-gray-500 hidden md:table-cell">{{ $menu->stock }}</td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                        @if($menu->is_active)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            @php
                                $editParams = ['menu' => $menu, 'page' => request('page', 1)];
                                if(request('search')) $editParams['search'] = request('search');
                                if(request('category')) $editParams['category'] = request('category');
                                if(request('status')) $editParams['status'] = request('status');
                                $editUrl = route('admin.menus.edit', $editParams);
                                
                                $destroyParams = ['page' => request('page', 1)];
                                if(request('search')) $destroyParams['search'] = request('search');
                                if(request('category')) $destroyParams['category'] = request('category');
                                if(request('status')) $destroyParams['status'] = request('status');
                                $destroyUrl = route('admin.menus.destroy', $menu) . '?' . http_build_query($destroyParams);
                            @endphp
                            <a href="{{ $editUrl }}" class="px-2 md:px-3 py-1 rounded bg-indigo-600 hover:bg-indigo-700 text-white text-xs md:text-sm">Edit</a>
                            <form action="{{ $destroyUrl }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 md:px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-xs md:text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 md:px-6 py-6 text-center">
                        <div class="py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="fas fa-search text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">Menu tidak ditemukan</p>
                            @if(request()->hasAny(['search', 'category', 'status']))
                                <p class="text-xs text-gray-400 mt-1">Coba ubah filter pencarian Anda</p>
                            @else
                                <p class="text-xs text-gray-400 mt-1">Belum ada menu yang ditambahkan</p>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>

    <!-- Mobile cards list -->
    <div class="md:hidden divide-y">
        @forelse($menus as $menu)
        @php
            $slug = \Illuminate\Support\Str::slug($menu->name);
            $possible = ['jpg','jpeg','png','webp'];
            $found = null;
            foreach ($possible as $ext) {
                if (file_exists(public_path("images/menu/{$slug}.{$ext}"))) { $found = $ext; break; }
            }
            $imageUrl = $found ? asset("images/menu/{$slug}.{$found}") : asset('images/rumah-makan.jpg');
        @endphp
        <div class="flex items-center gap-3 p-4">
            <img src="{{ $imageUrl }}" alt="{{ $menu->name }}" class="h-16 w-16 rounded object-cover flex-shrink-0" />
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <p class="font-semibold text-gray-900 truncate">{{ $menu->name }}</p>
                    @if($menu->is_active)
                        <span class="ml-2 px-2 py-0.5 text-[10px] font-semibold rounded-full bg-green-100 text-green-800 flex-shrink-0">Aktif</span>
                    @else
                        <span class="ml-2 px-2 py-0.5 text-[10px] font-semibold rounded-full bg-gray-100 text-gray-800 flex-shrink-0">Nonaktif</span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-0.5">{{ $menu->category->name ?? '-' }} • Rp {{ number_format($menu->price, 0, ',', '.') }} • Stok: {{ $menu->stock }}</p>
                <div class="flex items-center gap-2 mt-2">
                    @php
                        $editParams = ['menu' => $menu, 'page' => request('page', 1)];
                        if(request('search')) $editParams['search'] = request('search');
                        if(request('category')) $editParams['category'] = request('category');
                        if(request('status')) $editParams['status'] = request('status');
                        $editUrl = route('admin.menus.edit', $editParams);
                        
                        $destroyParams = ['page' => request('page', 1)];
                        if(request('search')) $destroyParams['search'] = request('search');
                        if(request('category')) $destroyParams['category'] = request('category');
                        if(request('status')) $destroyParams['status'] = request('status');
                        $destroyUrl = route('admin.menus.destroy', $menu) . '?' . http_build_query($destroyParams);
                    @endphp
                    <a href="{{ $editUrl }}" class="px-3 py-1 rounded bg-indigo-600 hover:bg-indigo-700 text-white text-xs">Edit</a>
                    <form action="{{ $destroyUrl }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-xs">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <i class="fas fa-search text-gray-400 text-2xl"></i>
            </div>
            <p class="text-sm text-gray-500 font-medium">Menu tidak ditemukan</p>
            @if(request()->hasAny(['search', 'category', 'status']))
                <p class="text-xs text-gray-400 mt-1">Coba ubah filter pencarian Anda</p>
            @else
                <p class="text-xs text-gray-400 mt-1">Belum ada menu yang ditambahkan</p>
            @endif
        </div>
        @endforelse
    </div>

    <div class="px-4 md:px-6 py-4 border-t border-gray-200">
        {{ $menus->links() }}
    </div>
</div>
@push('styles')
<style>
    /* Remove default browser dropdown arrow for all selects */
    #category-filter,
    #status-filter {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: none !important;
        background-repeat: no-repeat;
        background-position: right center;
    }
    
    /* For Firefox */
    #category-filter::-moz-focus-inner,
    #status-filter::-moz-focus-inner {
        border: 0;
    }
    
    /* For IE */
    #category-filter::-ms-expand,
    #status-filter::-ms-expand {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Delete form confirmation
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e){
            if (!window.Swal) return; // fallback silently if Swal not loaded
            e.preventDefault();
            // Save scroll position before showing confirmation
            sessionStorage.setItem('menu_scroll_position', window.pageYOffset || document.documentElement.scrollTop);
            Swal.fire({
                title: 'Hapus menu ini?',
                text: 'Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
    
    // Auto-submit filter on change
    const categoryFilter = document.getElementById('category-filter');
    const statusFilter = document.getElementById('status-filter');
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function() {
            document.querySelector('form[action="{{ route("admin.menus.index") }}"]').submit();
        });
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            document.querySelector('form[action="{{ route("admin.menus.index") }}"]').submit();
        });
    }
    
    // Search with debounce (auto-submit after user stops typing)
    // Only submit if user actually typed something (not programmatic changes)
    const searchInput = document.getElementById('search-input');
    let searchTimeout;
    let isUserTyping = false;
    
    if (searchInput) {
        const searchForm = document.querySelector('form[action="{{ route("admin.menus.index") }}"]');
        
        // Track when user is actually typing
        searchInput.addEventListener('focus', function() {
            isUserTyping = true;
        });
        
        searchInput.addEventListener('blur', function() {
            isUserTyping = false;
        });
        
        searchInput.addEventListener('input', function(e) {
            // Only auto-submit if user is actually typing (not programmatic)
            if (isUserTyping && e.isTrusted) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    if (document.activeElement === searchInput && searchForm) {
                        searchForm.submit();
                    }
                }, 800);
            }
        });
        
        // Also submit on Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                if (searchForm) {
                    searchForm.submit();
                }
            }
        });
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


