<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name','CV Maker') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased bg-gradient-to-br from-gray-50 via-white to-gray-100 text-gray-900 min-h-screen flex flex-col">

    {{-- Navigation --}}
    @include('layouts.navigation')

    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 mt-12 text-center text-gray-500 text-sm">
        © {{ date('Y') }} CV Maker. Built with Laravel.
    </footer>
</body>
</html>
