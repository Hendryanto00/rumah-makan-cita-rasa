@extends('layouts.app')

@section('title', 'Menu - Rumah Makan Cita Rasa')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl font-extrabold text-gray-800 mb-4">✨ Our Menu ✨</h1>
            <p class="text-xl text-gray-600 mb-8">Discover our delicious dishes and beverages</p>
        </div>
    </div>
</section>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Search and Filter -->
        <div class="mb-8">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               id="search-input"
                               placeholder="Cari menu, kategori, atau deskripsi..." 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                               value="{{ request('search') }}">
                    </div>
                    <div class="md:w-48">
                        <select id="category-filter" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button id="search-btn" class="bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @include('menus.partials.menu-grid')
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="mt-8">
            @include('menus.partials.pagination')
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const searchBtn = document.getElementById('search-btn');
    const menuGrid = document.querySelector('.grid');
    const paginationContainer = document.getElementById('pagination-container');
    
    let searchTimeout;
    
    // Function to perform search
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        const categoryId = categoryFilter.value;
        
        // Build URL with parameters
        const url = new URL(window.location);
        url.searchParams.set('search', searchTerm);
        url.searchParams.set('category', categoryId);
        url.searchParams.delete('page'); // Reset to first page when searching
        
        // Update URL without page reload
        window.history.pushState({}, '', url);
        
        // Fetch new results
        fetch(url.toString(), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update menu grid
            if (data.menu_grid) {
                menuGrid.innerHTML = data.menu_grid;
            }
            
            // Update pagination
            if (data.pagination) {
                paginationContainer.innerHTML = data.pagination;
            } else {
                paginationContainer.innerHTML = '';
            }
        })
        .catch(error => {
            console.error('Search error:', error);
        });
    }
    
    // Search input with debounce
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 300); // 300ms delay
    });
    
    // Category filter change
    categoryFilter.addEventListener('change', performSearch);
    
    // Search button click
    searchBtn.addEventListener('click', performSearch);
});
</script>
@endsection
