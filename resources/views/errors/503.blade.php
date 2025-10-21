@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-blue-100 via-indigo-50 to-purple-100 flex items-center justify-center px-4">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <h1 class="text-9xl font-bold text-blue-500">503</h1>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Layanan Tidak Tersedia</h2>
            <p class="text-gray-600 mb-8">
                Layanan sedang dalam pemeliharaan. Kami sedang melakukan pemeliharaan rutin. Silakan coba lagi dalam beberapa saat.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="{{ url('/') }}" 
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                Coba Lagi
            </a>
            
            <div class="text-sm text-gray-500">
                <p>Terima kasih atas kesabaran Anda.</p>
            </div>
        </div>
    </div>
</div>
@endsection
