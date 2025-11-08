@extends('layouts.admin')

@section('title', 'Profil Admin')
@section('page-title', 'Profil Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Update Profile Information -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <section>
            <header>
                <h2 class="text-xl font-semibold text-gray-900 mb-1">
                    Informasi Profil
                </h2>
                <p class="text-sm text-gray-600">
                    Perbarui informasi profil, nomor handphone, dan alamat akun Anda.
                </p>
            </header>

            <form id="adminProfileForm" method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input id="name" name="name" type="text" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" 
                           value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" 
                           value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-sm text-gray-800">
                                Alamat email Anda belum terverifikasi.
                                <button form="send-verification" class="underline text-orange-600 hover:text-orange-700">
                                    Klik di sini untuk mengirim ulang email verifikasi.
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Link verifikasi email telah dikirim ke alamat email Anda.',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: true,
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#f97316'
                                    });
                                </script>
                            @endif
                        </div>
                    @endif
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Handphone</label>
                    <input id="phone" name="phone" type="text" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" 
                           value="{{ old('phone', $user->phone) }}" autocomplete="tel" />
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="address" name="address" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" 
                        rows="3">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="px-4 md:px-6 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white transition-colors font-medium text-sm md:text-base">
                        Simpan
                    </button>
                </div>
            </form>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>
        </section>
    </div>

    <!-- Update Password -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <section>
            <header>
                <h2 class="text-xl font-semibold text-gray-900 mb-1">
                    Perbarui Kata Sandi
                </h2>
                <p class="text-sm text-gray-600">
                    Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.
                </p>
            </header>

            <form id="passwordUpdateForm" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password" class="block text-sm font-medium text-gray-700">Kata Sandi Saat Ini</label>
                    <div class="relative">
                        <input id="update_password_current_password" name="current_password" type="password" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 pr-10" 
                               autocomplete="current-password" />
                        <button type="button" onclick="togglePassword('update_password_current_password', 'eyeIcon1')" 
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-orange-500">
                            <i id="eyeIcon1" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('current_password', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="update_password_password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                    <div class="relative">
                        <input id="update_password_password" name="password" type="password" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 pr-10" 
                               autocomplete="new-password" />
                        <button type="button" onclick="togglePassword('update_password_password', 'eyeIcon2')" 
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-orange-500">
                            <i id="eyeIcon2" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 pr-10" 
                               autocomplete="new-password" />
                        <button type="button" onclick="togglePassword('update_password_password_confirmation', 'eyeIcon3')" 
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-orange-500">
                            <i id="eyeIcon3" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        Simpan Kata Sandi
                    </button>

                </div>
            </form>
        </section>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const profileForm = document.getElementById('adminProfileForm');
    const passwordForm = document.getElementById('passwordUpdateForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e){
            e.preventDefault();
            if (typeof Swal === 'undefined') { profileForm.submit(); return; }
            Swal.fire({
                title: 'Simpan perubahan profil?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, simpan',
                cancelButtonText: 'Batal'
            }).then((result) => { if (result.isConfirmed) profileForm.submit(); });
        });
    }
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e){
            e.preventDefault();
            if (typeof Swal === 'undefined') { passwordForm.submit(); return; }
            Swal.fire({
                title: 'Ubah kata sandi?',
                text: 'Pastikan mengingat kata sandi baru Anda.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, ubah',
                cancelButtonText: 'Batal'
            }).then((result) => { if (result.isConfirmed) passwordForm.submit(); });
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

@if(session('status') === 'password-updated')
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Kata sandi berhasil diperbarui.',
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

