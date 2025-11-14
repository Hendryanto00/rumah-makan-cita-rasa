<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rumah Makan Cita Rasa') }}</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo/logo1.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/logo1.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo/logo1.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @php
            $manifestPath = public_path('build/manifest.json');
            $manifestExists = file_exists($manifestPath);
            $cssFile = null;
            $jsFile = null;
            
            if ($manifestExists) {
                try {
                    $manifest = json_decode(file_get_contents($manifestPath), true);
                    $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
                    $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
                } catch (\Exception $e) {
                    // Manifest exists but can't be read
                }
            }
        @endphp
        
        @if($manifestExists && $cssFile && $jsFile)
            <!-- Production: Load from manifest -->
            <link rel="stylesheet" href="{{ url('build/' . $cssFile) }}">
            <script src="{{ url('build/' . $jsFile) }}" defer></script>
        @else
            <!-- Development: Use Vite -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        
        <script>
            // Ensure CSRF token is refreshed on page load
            document.addEventListener('DOMContentLoaded', function() {
                const token = document.head.querySelector('meta[name="csrf-token"]');
                if (token && window.axios) {
                    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                }
            });
        </script>
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 
                    bg-cover bg-center relative"
                    style="background-image: url('{{ asset('images/bacgorund-login-register.png') }}');">

            <!-- Overlay biar form lebih jelas -->
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>

            <div class="relative z-10">
                <a href="/">
                    <x-application-logo class="w-16 h-16 sm:w-20 sm:h-20 fill-current text-gray-100" />
                </a>
            </div>

            <div class="relative z-10 w-full max-w-xs sm:max-w-sm mt-4 sm:mt-6 px-4 sm:px-6 py-3 sm:py-4 bg-white shadow-md overflow-hidden rounded-lg sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
