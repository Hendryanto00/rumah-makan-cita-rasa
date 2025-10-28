<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-md">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Brand / Logo -->
            <div class="flex items-center flex-1 min-w-0">
                <img src="{{ asset('images/logo/logo1.png') }}" alt="Logo" class="h-12 w-12 sm:h-16 sm:w-16 rounded-full border-2 border-white flex-shrink-0">
                <a href="{{ url('/') }}" class="ml-2 text-sm sm:text-xl font-bold text-indigo-600 truncate">
                    <span class="hidden sm:inline">Rumah Makan Cita Rasa</span>
                    <span class="sm:hidden">Cita Rasa</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex space-x-4 sm:space-x-6 lg:space-x-8 xl:space-x-10 items-center">
                <a href="{{ url('/') }}" 
                    class="px-3 py-2 text-sm font-medium 
                    {{ request()->is('/') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-500' }}">
                    Home
                </a>
                <a href="{{ url('/about') }}" 
                    class="px-3 py-2 text-sm font-medium 
                    {{ request()->is('about') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-500' }}">
                    About
                </a>
                <a href="{{ route('menus.index') }}" 
                    class="px-3 py-2 text-sm font-medium 
                    {{ request()->is('menu*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-500' }}">
                    Menu
                </a>
                <a href="{{ url('/contact') }}" 
                    class="px-3 py-2 text-sm font-medium 
                    {{ request()->is('contact') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-500' }}">
                    Contact
                </a>
            </div>

            <!-- Right Side (Auth Links) -->
            <div class="hidden sm:flex items-center space-x-3 sm:space-x-4 lg:space-x-6 ml-8 sm:ml-12 lg:ml-16">
                @auth
                    <!-- Cart Link -->
                    <a href="{{ route('cart.index') }}" class="relative px-3 py-2 text-sm text-gray-700 hover:text-indigo-500">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        @php
                            $cartCount = auth()->user()->cart ? auth()->user()->cart->items()->sum('quantity') : 0;
                        @endphp
                        <span class="cart-count absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount }}
                        </span>
                    </a>
                    
                    <!-- Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-receipt mr-2"></i>Order History
                            </a>
                            <div class="border-t my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-3 sm:px-4 py-2 text-xs sm:text-sm text-gray-700 hover:text-indigo-500 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="px-3 sm:px-4 py-2 text-xs sm:text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">Register</a>
                @endauth
            </div>

            <!-- Mobile Cart & Hamburger -->
            <div class="flex items-center space-x-1 sm:hidden">
                @auth
                    <!-- Mobile Cart Link -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500 hover:text-indigo-500 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        @php
                            $cartCount = auth()->user()->cart ? auth()->user()->cart->items()->sum('quantity') : 0;
                        @endphp
                        <span class="cart-count absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount }}
                        </span>
                    </a>
                @endauth
                
                <!-- Hamburger Button -->
                <button @click="open = ! open" class="p-2 rounded-md text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" class="block px-4 py-2 text-sm 
                {{ request()->is('/') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                Home
            </a>
            <a href="{{ url('/about') }}" class="block px-4 py-2 text-sm 
                {{ request()->is('about') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                About
            </a>
            <a href="{{ route('menus.index') }}" class="block px-4 py-2 text-sm 
                {{ request()->is('menu*') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                Menu
            </a>
            <a href="{{ url('/contact') }}" class="block px-4 py-2 text-sm 
                {{ request()->is('contact') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                Contact
            </a>
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4 text-gray-700 font-medium">{{ Auth::user()->name }}</div>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-user mr-2"></i>Profile
                </a>
                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-receipt mr-2"></i>Order History
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Login</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-indigo-600 hover:bg-indigo-700 hover:text-white">Register</a>
            </div>
        @endauth
    </div>
</nav>
