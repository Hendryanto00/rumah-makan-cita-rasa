<x-guest-layout>
    <!-- Judul -->
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-2">
        Lupa Kata Sandi
    </h2>
    <p class="text-center text-gray-600 text-sm mb-6">
        Masukkan email Anda dan kami akan mengirimkan link untuk reset kata sandi
    </p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded">
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                <div>
                    <p class="text-sm font-medium text-green-800">
                        Kami telah mengirimkan link reset kata sandi ke email Anda!
                    </p>
                    <p class="text-sm text-green-700 mt-1">
                        Silakan cek kotak masuk email Anda (termasuk folder spam) untuk melihat link reset kata sandi.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm" 
                type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 mt-6">
            <a href="{{ route('login') }}" 
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-md shadow-sm text-center">
                Kembali ke Login
            </a>
            <x-primary-button class="bg-orange-500 hover:bg-orange-600 focus:ring-orange-400 w-full sm:w-auto">
                Kirim Link Reset
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
