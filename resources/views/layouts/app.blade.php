<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name','CreateIt') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-100 text-slate-900">
    <div class="min-h-screen flex flex-col">
        {{-- Navigation --}}
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white/70 backdrop-blur border-b border-slate-200">
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center gap-3 text-slate-700 text-sm uppercase tracking-[0.3em]">
                        <span class="createit-dot"></span>
                        <span>{{ config('app.name', 'CreateIt') }}</span>
                    </div>
                    <div class="mt-3 text-2xl font-semibold text-slate-900">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endif

        <main class="flex-1 w-full">
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>

        <footer class="createit-footer border-t border-slate-200 mt-16">
            © {{ date('Y') }} {{ config('app.name', 'CreateIt') }}. {{ __('Crafted with Laravel.') }}
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
