<x-guest-layout>
    <div class="mb-6">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                <div>
                    <h3 class="text-sm font-semibold text-blue-800 mb-2">Verifikasi Email Diperlukan</h3>
                    <p class="text-sm text-blue-700">
                        Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirim ke email Anda.
                    </p>
                    <p class="text-sm text-blue-700 mt-2">
                        <strong>Penting:</strong> Silakan cek kotak masuk email Anda (termasuk folder spam) untuk melihat link verifikasi yang telah dikirimkan.
                    </p>
                </div>
            </div>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-green-800">
                            Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                        </p>
                        <p class="text-sm text-green-700 mt-1">
                            Silakan cek kotak masuk email Anda untuk melihat link verifikasi.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="mt-6 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <x-primary-button class="w-full sm:w-auto">
                <i class="fas fa-paper-plane mr-2"></i>
                Kirim Ulang Email Verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full sm:w-auto px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
