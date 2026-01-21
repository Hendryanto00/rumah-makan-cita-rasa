<x-guest-layout>
    <!-- Judul -->
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-2">
        Buat Akun Baru
    </h2>
    <p class="text-center text-gray-600 text-sm mb-6">
        Silahkan isi form di bawah untuk mendaftar
    </p>

    <form method="POST" action="{{ route('register') }}" id="register-form" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name"
                class="block mt-1 w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email"
                class="block mt-1 w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm"
                type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone (optional) -->
        <div>
            <x-input-label for="phone" value="Telepon" />
            <x-text-input id="phone"
                class="block mt-1 w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm"
                type="text" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address (optional) -->
        <div>
            <x-input-label for="address" value="Alamat" />
            <textarea id="address" name="address"
                class="block mt-1 w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm"
                rows="3">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }" class="relative">
            <x-input-label for="password" value="Kata Sandi" />
            <input :type="show ? 'text' : 'password'" id="password" name="password"
                class="block mt-1 w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm"
                required autocomplete="new-password" />
            <button type="button" @click="show = !show"
                class="absolute inset-y-0 right-3 flex items-center text-gray-500 mt-6">
                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.593-4.263M9.88 9.88a3 3 0 104.24 4.24" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3l18 18" />
                </svg>
            </button>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div x-data="{ show: false }" class="relative">
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
            <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation"
                class="block mt-1 w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm"
                required autocomplete="new-password" />
            <button type="button" @click="show = !show"
                class="absolute inset-y-0 right-3 flex items-center text-gray-500 mt-6">
                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.593-4.263M9.88 9.88a3 3 0 104.24 4.24" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3l18 18" />
                </svg>
            </button>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Tombol -->
        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('login') }}"
                class="underline text-sm text-gray-600 hover:text-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400">
                Sudah terdaftar?
            </a>

            <x-primary-button id="register-button" type="submit" class="ms-3 bg-orange-500 hover:bg-orange-600 focus:ring-orange-400">
                <span id="register-button-text">Daftar</span>
                <span id="register-button-loading" class="hidden">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Mendaftar...
                </span>
            </x-primary-button>
        </div>
    </form>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('register-form');
        const submitButton = document.getElementById('register-button');
        const buttonText = document.getElementById('register-button-text');
        const buttonLoading = document.getElementById('register-button-loading');
        let isSubmitting = false;
        
        if (form && submitButton) {
            // Function to refresh CSRF token
            async function refreshCSRFToken() {
                try {
                    const response = await fetch('{{ route("csrf-token") }}', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        const newToken = data.token;
                        
                        // Update meta tag
                        const metaToken = document.head.querySelector('meta[name="csrf-token"]');
                        if (metaToken) {
                            metaToken.content = newToken;
                        }
                        
                        // Update form token
                        const csrfInput = form.querySelector('input[name="_token"]');
                        if (csrfInput) {
                            csrfInput.value = newToken;
                        }
                        
                        return true;
                    }
                } catch (error) {
                    console.error('Error refreshing CSRF token:', error);
                }
                return false;
            }
            
            // Refresh token secara berkala (setiap 2 menit untuk mencegah expired)
            setInterval(function() {
                refreshCSRFToken();
            }, 120000); // 2 menit
            
            // Prevent double submit
            form.addEventListener('submit', async function(e) {
                // Prevent double submit
                if (isSubmitting) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                
                // Refresh CSRF token sebelum submit untuk memastikan token masih valid
                await refreshCSRFToken();
                
                isSubmitting = true;
                
                // Disable button immediately and show loading
                submitButton.disabled = true;
                submitButton.setAttribute('disabled', 'disabled');
                submitButton.classList.add('opacity-75', 'cursor-not-allowed');
                buttonText.classList.add('hidden');
                buttonLoading.classList.remove('hidden');
                
                // Allow form to submit normally dengan token yang sudah di-refresh
            });
            
            // Re-enable button if form validation fails (page reloads with errors)
            // This is handled by page reload, so we don't need to do anything
        }
    });
    </script>
</x-guest-layout>
