<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Owner Dashboard') - Rumah Makan Cita Rasa</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo/logo1.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/logo1.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/logo1.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Chart.js for analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Scripts -->
    @php
        $manifestPath = public_path('build/manifest.json');
        $manifestExists = file_exists($manifestPath);
        $cssFile = null;
        $jsFile = null;
        
        if ($manifestExists) {
            try {
                $manifest = json_decode(file_get_contents($manifestPath), true);
                $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
                $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
            } catch (\Exception $e) {
                // Manifest exists but can't be read
            }
        }
    @endphp
    
    @if($manifestExists && $cssFile && $jsFile)
        <!-- Production: Load from manifest -->
        <link rel="stylesheet" href="{{ url('build/' . $cssFile) }}">
        <script src="{{ url('build/' . $jsFile) }}" defer></script>
    @else
        <!-- Development: Use Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
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
                        <span class="text-lg font-bold">Owner</span>
                    </div>
                    <button id="sidebar-toggle" class="lg:hidden text-orange-200 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('owner.profile') }}" class="flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('owner.profile*') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                        <i class="fas fa-user-circle w-5 mr-3"></i>
                        <span>Profil</span>
                    </a>
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('owner.dashboard') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <!-- Reports Section -->
                    <div class="pt-4">
                        <p class="px-4 text-xs font-semibold text-orange-200 uppercase tracking-wider mb-2">Laporan</p>
                        <div x-data="{ openDaily: false }" class="relative">
                            <div class="w-full flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('owner.reports.daily') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                                <a href="{{ route('owner.reports.daily') }}" class="flex items-center flex-1">
                                    <i class="fas fa-calendar-day w-5 mr-3"></i>
                                    <span>Laporan Harian</span>
                                </a>
                                <button type="button" @click.stop="openDaily = !openDaily" class="ml-2 p-1 rounded hover:bg-white/10">
                                    <i :class="openDaily ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs opacity-90"></i>
                                </button>
                            </div>
                            <div x-cloak x-show="openDaily" class="ml-8 mt-1">
                                <a href="#" data-report="daily" data-base="{{ route('owner.reports.daily.pdf') }}" class="report-download flex items-center px-3 py-2 text-xs text-orange-100 rounded-lg hover:bg-white/10 transition">
                                    <i class="fas fa-file-pdf w-4 mr-2"></i> Download PDF
                                </a>
                            </div>
                        </div>
                        <div x-data="{ openMonthly: false }" class="relative">
                            <div class="w-full flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('owner.reports.monthly') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                                <a href="{{ route('owner.reports.monthly') }}" class="flex items-center flex-1">
                                    <i class="fas fa-calendar-alt w-5 mr-3"></i>
                                    <span>Laporan Bulanan</span>
                                </a>
                                <button type="button" @click.stop="openMonthly = !openMonthly" class="ml-2 p-1 rounded hover:bg-white/10">
                                    <i :class="openMonthly ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs opacity-90"></i>
                                </button>
                            </div>
                            <div x-cloak x-show="openMonthly" class="ml-8 mt-1">
                                <a href="#" data-report="monthly" data-base="{{ route('owner.reports.monthly.pdf') }}" class="report-download flex items-center px-3 py-2 text-xs text-orange-100 rounded-lg hover:bg-white/10 transition">
                                    <i class="fas fa-file-pdf w-4 mr-2"></i> Download PDF
                                </a>
                            </div>
                        </div>
                        <div x-data="{ openTop: false }" class="relative">
                            <div class="w-full flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('owner.reports.top-menus') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                                <a href="{{ route('owner.reports.top-menus') }}" class="flex items-center flex-1">
                                    <i class="fas fa-chart-line w-5 mr-3"></i>
                                    <span>Menu Terlaris</span>
                                </a>
                                <button type="button" @click.stop="openTop = !openTop" class="ml-2 p-1 rounded hover:bg-white/10">
                                    <i :class="openTop ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs opacity-90"></i>
                                </button>
                            </div>
                            <div x-cloak x-show="openTop" class="ml-8 mt-1">
                                <a href="#" data-report="top-menus" data-base="{{ route('owner.reports.top-menus.pdf') }}" class="report-download flex items-center px-3 py-2 text-xs text-orange-100 rounded-lg hover:bg-white/10 transition">
                                    <i class="fas fa-file-pdf w-4 mr-2"></i> Download PDF
                                </a>
                            </div>
                        </div>
                        <!-- Activity Logs -->
                        <div class="border-t border-orange-500 my-2"></div>
                        <div x-data="{ openAct: false }" class="relative">
                            <div class="w-full flex items-center px-4 py-3 text-orange-100 rounded-lg hover:bg-orange-800 hover:text-white transition {{ request()->routeIs('owner.activity-logs.*') ? 'bg-orange-800 text-white shadow-md' : '' }}">
                                <a href="{{ route('owner.activity-logs.index') }}" class="flex items-center flex-1">
                                    <i class="fas fa-history w-5 mr-3"></i>
                                    <span>Aktivitas Sistem</span>
                                </a>
                                <button type="button" @click.stop="openAct = !openAct" class="ml-2 p-1 rounded hover:bg-white/10">
                                    <i :class="openAct ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs opacity-90"></i>
                                </button>
                            </div>
                            <div x-cloak x-show="openAct" class="ml-8 mt-1">
                                <a href="#" data-report="activity-logs" data-base="{{ route('owner.activity-logs.pdf') }}" class="report-download flex items-center px-3 py-2 text-xs text-orange-100 rounded-lg hover:bg-white/10 transition">
                                    <i class="fas fa-file-pdf w-4 mr-2"></i> Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
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

    <script>
        // Handle sidebar "Download PDF" to include current filters
        document.addEventListener('DOMContentLoaded', function(){
            const links = document.querySelectorAll('.report-download');
            links.forEach(link => {
                link.addEventListener('click', function(e){
                    e.preventDefault();
                    const type = this.getAttribute('data-report');
                    const base = this.getAttribute('data-base');
                    const params = new URLSearchParams();

                    if (type === 'daily') {
                        const dateInput = document.getElementById('date');
                        if (dateInput && dateInput.value) params.set('date', dateInput.value);
                    } else if (type === 'monthly') {
                        const monthInput = document.getElementById('month');
                        if (monthInput && monthInput.value) params.set('month', monthInput.value);
                    } else if (type === 'top-menus') {
                        const start = document.getElementById('start_date');
                        const end = document.getElementById('end_date');
                        if (start && start.value) params.set('start_date', start.value);
                        if (end && end.value) params.set('end_date', end.value);
                    } else if (type === 'activity-logs') {
                        const start = document.getElementById('start_date');
                        const end = document.getElementById('end_date');
                        const action = document.getElementById('action');
                        const table = document.getElementById('target_table');
                        const user = document.getElementById('user_id');
                        if (start && start.value) params.set('start_date', start.value);
                        if (end && end.value) params.set('end_date', end.value);
                        if (action && action.value) params.set('action', action.value);
                        if (table && table.value) params.set('target_table', table.value);
                        if (user && user.value) params.set('user_id', user.value);
                    }

                    const url = params.toString() ? `${base}?${params.toString()}` : base;
                    window.location.href = url;
                });
            });
        });
    </script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                confirmButtonColor: '#16a34a',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            Swal.fire({
                icon: 'error',
                title: 'Tidak Ada Data',
                text: @json(session('error')),
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif
    
    @stack('scripts')
</body>
</html>

