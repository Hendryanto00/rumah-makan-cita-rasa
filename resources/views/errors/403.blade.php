@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-red-100 via-orange-50 to-yellow-100 flex items-center justify-center px-4">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <h1 class="text-9xl font-bold text-red-500">403</h1>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Akses Ditolak</h2>
            <p class="text-gray-600 mb-8">
                Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="{{ url('/') }}" 
               class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                Kembali ke Beranda
            </a>
            
            <div class="text-sm text-gray-500">
                <p>Jika Anda yakin ini adalah kesalahan, silakan hubungi administrator.</p>
            </div>
        </div>
    </div>
</div>
@endsection
