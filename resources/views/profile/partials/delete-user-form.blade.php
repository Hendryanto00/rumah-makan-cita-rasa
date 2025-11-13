<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun Anda, silakan unduh data atau informasi yang ingin Anda simpan.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Hapus Akun?',
                    html: 'Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $dispatch('open-modal', 'confirm-user-deletion');
                    }
                });
            } else {
                $dispatch('open-modal', 'confirm-user-deletion');
            }
        "
    >Hapus Akun</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form id="deleteAccountForm" method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Apakah Anda yakin ingin menghapus akun Anda?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Kata Sandi" class="sr-only" />

                <div class="relative">
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-3/4 pr-10"
                        placeholder="Kata Sandi"
                    />

                    <!-- Toggle Show/Hide Password -->
                    <button type="button" onclick="togglePassword('password', 'eyeIcon')" 
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-orange-500">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <x-danger-button type="button" onclick="confirmDeleteAccount()" class="ms-3">
                    Hapus Akun
                </x-danger-button>
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

            function confirmDeleteAccount() {
                const form = document.getElementById('deleteAccountForm');
                const passwordInput = document.getElementById('password');
                
                if (!passwordInput.value) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Silakan masukkan kata sandi Anda.',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                    return;
                }

                if (typeof Swal === 'undefined') {
                    form.submit();
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Hapus Akun',
                    html: 'Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus sekarang',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        </script>
    </x-modal>
</section>
