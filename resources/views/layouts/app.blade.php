<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>
            <footer class="bg-[#15803D] text-white">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-sm flex flex-col sm:flex-row justify-between items-center">
                    <div>© {{ date('Y') }} Gedung Serba Guna Aulia</div>
                    <div class="flex gap-4 mt-2 sm:mt-0">
                        <a href="{{ route('login') }}" class="hover:underline">Masuk</a>
                        <a href="{{ route('home') }}#kontak" class="hover:underline">Kontak</a>
                        <a href="{{ route('home') }}#kalender" class="hover:underline">Pesan Gedung</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
