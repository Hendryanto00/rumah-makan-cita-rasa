<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard') - Rumah Makan Cita Rasa</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo/Logo1.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/Logo1.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/Logo1.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-gradient-to-b from-orange-600 to-orange-700 text-white transition-transform duration-300 ease-in-out transform -translate-x-full lg:translate-x-0 shadow-xl fixed inset-y-0 left-0 z-50 lg:relative lg:z-auto">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-6 bg-orange-800 border-b border-orange-500">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo/logo1.png') }}" alt="Logo" class="h-8 w-8 rounded-full">
                        <span class="text-lg font-bold">Admin</span>
                    </div>
                    <button id="sidebar-toggle" class="lg:hidden text-orange-200 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('admin.profile') }}" class="flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('admin.profile*') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                        <i class="fas fa-user-circle w-5 mr-3"></i>
                        <span>Profil</span>
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('admin.dashboard') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.menus.index') }}" class="flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('admin.menus.*') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                        <i class="fas fa-utensils w-5 mr-3"></i>
                        <span>Kelola Menu</span>
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('admin.orders.*') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                        <i class="fas fa-shopping-cart w-5 mr-3"></i>
                        <span>Kelola Pesanan</span>
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('admin.categories.*') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                        <i class="fas fa-tags w-5 mr-3"></i>
                        <span>Kelola Kategori</span>
                    </a>
                    
                    <a href="{{ route('admin.reviews.index') }}" class="flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('admin.reviews.index') || request()->routeIs('admin.reviews.show') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                        <i class="fas fa-star w-5 mr-3"></i>
                        <span>Kelola Review</span>
                    </a>
                    <a href="{{ route('admin.reviews.statistics') }}" class="flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('admin.reviews.statistics') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        <span>Statistik Review</span>
                    </a>
                </nav>
                
                <!-- User Info -->
                <div class="px-4 py-4 border-t border-orange-500 bg-orange-800">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-orange-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-orange-200 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-white text-orange-600 hover:bg-orange-50 rounded-lg transition font-semibold">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-orange-200">
                <div class="flex items-center justify-between h-16 px-6">
                    <div class="flex items-center space-x-4">
                        <button id="mobile-sidebar-toggle" class="lg:hidden text-orange-600 hover:text-orange-700">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>
    
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        
        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }
        
        if (mobileSidebarToggle) {
            mobileSidebarToggle.addEventListener('click', toggleSidebar);
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }
        
        // Hide sidebar on mobile by default
        if (window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>

