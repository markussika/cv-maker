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
    <body class="font-sans antialiased bg-slate-950 text-slate-100">
        <div class="relative min-h-screen overflow-hidden">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(96,165,250,0.35),transparent_60%),radial-gradient(circle_at_bottom_left,rgba(14,165,233,0.3),transparent_55%),radial-gradient(circle_at_bottom_right,rgba(236,72,153,0.25),transparent_50%)]"></div>

            <div class="relative grid min-h-screen gap-12 md:grid-cols-[1.1fr,1fr]">
                <div class="hidden md:flex flex-col justify-between px-12 py-12 lg:px-16">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-3 text-slate-100/90">
                        <img src="{{ asset('images/apple-logo.svg') }}" alt="CV Maker logo" class="h-8 w-8">
                        <span class="text-lg font-semibold tracking-tight">CV Maker</span>
                    </a>

                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-slate-200/80">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            {{ __('Secure account access') }}
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-semibold leading-tight text-white">
                            {{ __('Build polished CVs in minutes') }}
                        </h1>
                        <p class="max-w-xl text-lg text-slate-200/80 leading-relaxed">
                            {{ __('Create, preview, and download professional resumes with guided steps, tailored templates, and smart suggestions for every section.') }}
                        </p>

                        <dl class="grid gap-6 sm:grid-cols-3 text-sm text-slate-200/80">
                            <div>
                                <dt class="text-xs uppercase tracking-[0.3em] text-slate-300/70">{{ __('Templates') }}</dt>
                                <dd class="mt-2 text-2xl font-semibold text-white">9+</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-[0.3em] text-slate-300/70">{{ __('Exports') }}</dt>
                                <dd class="mt-2 text-2xl font-semibold text-white">{{ __('Unlimited') }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-[0.3em] text-slate-300/70">{{ __('Support') }}</dt>
                                <dd class="mt-2 text-2xl font-semibold text-white">24/7</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="hidden lg:flex items-center gap-4 text-sm text-slate-200/60">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white font-semibold">{{ __('HR') }}</span>
                        <p class="max-w-sm italic">“{{ __('CV Maker helped our candidates submit polished resumes faster than ever before.') }}”</p>
                    </div>
                </div>

                <div class="flex items-center justify-center px-6 py-12 sm:px-10 lg:px-16">
                    <div class="w-full max-w-md rounded-3xl bg-white/95 p-8 shadow-2xl shadow-slate-900/20 ring-1 ring-white/40 text-slate-900">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
