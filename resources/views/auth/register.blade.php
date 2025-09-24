<x-guest-layout>
    <div class="createit-card-stack">
        <div class="createit-card-heading">
            <p class="createit-eyebrow">{{ __('Get started') }}</p>
            <h1 class="createit-title">{{ __('Create your CreateIt account') }}</h1>
            <p class="createit-subtitle">{{ __('Save your favourite layouts, remix templates, and download polished resumes whenever inspiration hits.') }}</p>
        </div>

        @if (session('oauth_error'))
            <div class="createit-alert createit-alert--error">
                {{ session('oauth_error') }}
            </div>
        @endif

        <x-auth.social-providers intent="register" />

        <div class="createit-divider">
            <span class="createit-divider__line"></span>
            {{ __('or continue with email') }}
            <span class="createit-divider__line"></span>
        </div>

        <form method="POST" action="{{ route('register') }}" class="createit-form">
            @csrf

            <div class="createit-field">
                <label for="name" class="createit-label">{{ __('Full name') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="createit-input" placeholder="Alex Morgan">
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div class="createit-field">
                <label for="email" class="createit-label">{{ __('Email address') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="createit-input" placeholder="you@example.com">
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="createit-field">
                <label for="password" class="createit-label">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="createit-input" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="createit-field">
                <label for="password_confirmation" class="createit-label">{{ __('Confirm password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="createit-input" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <button type="submit" class="createit-button">
                {{ __('Create account') }}
            </button>
        </form>

        <p class="createit-text-muted">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="createit-link">{{ __('Sign in instead') }}</a>
        </p>
    </div>
</x-guest-layout>
