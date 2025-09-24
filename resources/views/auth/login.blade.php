<x-guest-layout>
    <div class="createit-card-stack">
        <div class="createit-card-heading">
            <p class="createit-eyebrow">{{ __('Welcome back') }}</p>
            <h1 class="createit-title">{{ __('Sign in to CreateIt') }}</h1>
            <p class="createit-subtitle">{{ __('Pick up where you left off with saved resumes, playful templates, and creative suggestions.') }}</p>
        </div>

        @if (session('status'))
            <div class="createit-alert createit-alert--success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('oauth_error'))
            <div class="createit-alert createit-alert--error">
                {{ session('oauth_error') }}
            </div>
        @endif

        <x-auth.social-providers intent="login" />

        <div class="createit-divider">
            <span class="createit-divider__line"></span>
            {{ __('or continue with email') }}
            <span class="createit-divider__line"></span>
        </div>

        <form method="POST" action="{{ route('login') }}" class="createit-form">
            @csrf

            <div class="createit-field">
                <label for="email" class="createit-label">{{ __('Email address') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="createit-input" placeholder="you@example.com">
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="createit-field">
                <label for="password" class="createit-label">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="createit-input" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="createit-form__meta">
                <label class="createit-checkbox__label" for="remember_me">
                    <input id="remember_me" type="checkbox" class="createit-checkbox" name="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="createit-link" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <button type="submit" class="createit-button">
                {{ __('Log in') }}
            </button>
        </form>

        <p class="createit-text-muted">
            {{ __('New to CreateIt?') }}
            <a href="{{ route('register') }}" class="createit-link">{{ __('Create an account') }}</a>
        </p>
    </div>
</x-guest-layout>
