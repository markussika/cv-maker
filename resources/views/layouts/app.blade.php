<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name','CV Maker') }}</title>
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
                        <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                        <span>{{ config('app.name', 'CV Maker') }}</span>
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

        <footer class="bg-white border-t border-slate-200 py-6 mt-16 text-center text-slate-500 text-sm">
            © {{ date('Y') }} CV Maker. {{ __('Crafted with Laravel.') }}
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
