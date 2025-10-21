<x-guest-layout>
    <!-- Judul -->
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-2">
        Reset Kata Sandi
    </h2>
    <p class="text-center text-gray-600 text-sm mb-6">
        Masukkan kata sandi baru untuk akun Anda
    </p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm" 
                type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Kata Sandi Baru" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm pr-10" 
                    type="password" name="password" required autocomplete="new-password" />
                
                <!-- Toggle Show/Hide Password -->
                <button type="button" onclick="togglePassword('password', 'eyeIcon1')" 
                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-orange-500">
                    <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm pr-10"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                
                <!-- Toggle Show/Hide Password -->
                <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" 
                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-orange-500">
                    <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" 
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-md shadow-sm">
                Kembali ke Login
            </a>
            <x-primary-button class="bg-orange-500 hover:bg-orange-600 focus:ring-orange-400">
                Reset Kata Sandi
            </x-primary-button>
        </div>
    </form>

    <!-- Script Show Password -->
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.174-3.529M6.343 6.343A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-2.174 3.529M15 12a3 3 0 11-6 0 3 3 0 016 0z"/> 
                    <line x1="4" y1="4" x2="20" y2="20" stroke="currentColor" stroke-width="2" />
                `;
            } else {
                passwordInput.type = "password";
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
</x-guest-layout>
