<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informasi Profil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Perbarui informasi profil, nomor handphone, dan alamat akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        Alamat email Anda belum terverifikasi.

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Link verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone" value="Nomor Handphone" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="address" value="Alamat" />
            <textarea id="address" name="address" 
                class="mt-1 block w-full border-gray-300 focus:border-orange-400 focus:ring focus:ring-orange-300 rounded-md shadow-sm" 
                rows="3">{{ old('address', $user->address) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan</x-primary-button>
        </div>
    </form>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const profileForm = document.querySelector('form[action="{{ route('profile.update') }}"]');
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
            }).then((result) => { 
                if (result.isConfirmed) {
                    profileForm.submit();
                }
            });
        });
    }
});

@if(session('success'))
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
@endif

@if(session('error'))
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
@endif
</script>
@endpush
