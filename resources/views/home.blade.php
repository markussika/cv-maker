<x-app-layout>
    

    <div class="createit-hero">
        <h1 class="createit-hero__title">{{ __('Welcome to :name', ['name' => config('app.name', 'CreateIt')]) }}</h1>
        <p class="createit-hero__subtitle">
            {{ __('Create professional CVs online, customise every section, and download them as polished PDFs.') }}
        </p>

        <div class="createit-hero__actions">
            <a href="{{ route('cv.create') }}" class="createit-button--primary">{{ __('Create CV') }}</a>
            <a href="{{ route('cv.guide') }}" class="createit-button--outline">{{ __('CV Guide') }}</a>
            <a href="{{ route('cv.templates') }}" class="createit-button--ghost">{{ __('Templates') }}</a>
        </div>

        @auth
            <div class="createit-hero__meta">
                <a href="{{ route('dashboard') }}" class="createit-link">{{ __('Go to Dashboard →') }}</a>
            </div>
        @else
            <div class="createit-hero__meta">
                <a href="{{ route('login') }}" class="createit-link">{{ __('Login') }}</a>
                <span class="mx-2 text-slate-400">•</span>
                <a href="{{ route('register') }}" class="createit-link">{{ __('Register') }}</a>
            </div>
        @endauth
    </div>
</x-app-layout>
