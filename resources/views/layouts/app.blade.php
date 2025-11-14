<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Rumah Makan Cita Rasa')</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo/logo1.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/logo1.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo/logo1.png') }}">


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        
        <!-- SweetAlert2 CSS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        @include('layouts.navigation')
        <div class="min-h-screen bg-gray-100" style="padding-top: 64px;">
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
        
        @stack('scripts')
    </body>
</html>
