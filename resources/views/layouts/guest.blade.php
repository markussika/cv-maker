<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CreateIt') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="createit-auth">
        <div class="createit-auth__background"></div>

        <div class="createit-auth__grid">
            <div class="createit-auth__info">
                <a href="{{ route('welcome') }}" class="createit-logo createit-logo--light">
                    <img src="{{ asset('images/createit-logo.svg') }}" alt="CreateIt logo" class="createit-logo__img">
                    <span class="createit-logo__text">CreateIt</span>
                </a>

                <div>
                    <div class="createit-auth__badge">
                        <span class="createit-dot"></span>
                        {{ __('Creative tools that stay simple') }}
                    </div>
                    <h1 class="createit-auth__headline">
                        {{ __('Craft bold resumes with CreateIt') }}
                    </h1>
                    <p class="createit-auth__description">
                        {{ __('Bring your personality into every CV with playful templates, smart suggestions, and lightning-fast exports that hiring teams remember.') }}
                    </p>

                    <dl class="createit-auth__stats">
                        <div>
                            <dt class="createit-auth__stat-label">{{ __('Templates') }}</dt>
                            <dd class="createit-auth__stat-value">9+</dd>
                        </div>
                        <div>
                            <dt class="createit-auth__stat-label">{{ __('Exports') }}</dt>
                            <dd class="createit-auth__stat-value">{{ __('Unlimited') }}</dd>
                        </div>
                        <div>
                            <dt class="createit-auth__stat-label">{{ __('Support') }}</dt>
                            <dd class="createit-auth__stat-value">24/7</dd>
                        </div>
                    </dl>
                </div>

                <div class="createit-auth__quote">
                    <span class="createit-quote-badge">{{ __('HR') }}</span>
                    <p class="max-w-sm italic">“{{ __('CreateIt keeps our candidates inspired to submit their best resumes every time.') }}”</p>
                </div>
            </div>

            <div class="createit-auth__card-wrapper">
                <div class="createit-auth__card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
