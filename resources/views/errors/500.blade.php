@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-gray-100 via-red-50 to-orange-100 flex items-center justify-center px-4">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <h1 class="text-9xl font-bold text-gray-500">500</h1>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Kesalahan Server</h2>
            <p class="text-gray-600 mb-8">
                Terjadi kesalahan pada server. Tim kami telah diberitahu tentang masalah ini. Silakan coba lagi nanti.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="{{ url('/') }}" 
               class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                Kembali ke Beranda
            </a>
            
            <div class="text-sm text-gray-500">
                <p>Jika masalah berlanjut, silakan hubungi administrator.</p>
            </div>
        </div>
    </div>
</div>
@endsection
