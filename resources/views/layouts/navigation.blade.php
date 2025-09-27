<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Brand / Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/logo/logo1.png') }}" alt="Logo" class="h-16 w-16 rounded-full border-2 border-white">
                <a href="{{ url('/') }}" class="ml-2 text-xl font-bold text-indigo-600">
                    Rumah Makan Cita Rasa
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex space-x-8 items-center">
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
                <a href="{{ url('/contact') }}" 
                    class="px-3 py-2 text-sm font-medium 
                    {{ request()->is('contact') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-500' }}">
                    Contact
                </a>
            </div>

            <!-- Right Side (Auth Links) -->
            <div class="hidden sm:flex items-center space-x-4">
                @auth
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
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 text-sm text-gray-700 hover:text-indigo-500">Login</a>
                    <a href="{{ route('register') }}" class="px-3 py-2 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Register</a>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
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
            <a href="{{ url('/contact') }}" class="block px-4 py-2 text-sm 
                {{ request()->is('contact') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                Contact
            </a>
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4 text-gray-700 font-medium">{{ Auth::user()->name }}</div>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                        Logout
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
