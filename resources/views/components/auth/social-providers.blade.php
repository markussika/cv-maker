@props([
    'intent' => 'login',
])

@php
    $intent = in_array($intent, ['login', 'register'], true) ? $intent : 'login';
    $googleLabel = $intent === 'register' ? __('Sign up with Google') : __('Continue with Google');
    $githubLabel = $intent === 'register' ? __('Sign up with GitHub') : __('Continue with GitHub');
@endphp

<div {{ $attributes->class(['createit-social']) }}>
    <a
        href="{{ route('oauth.redirect', ['provider' => 'google', 'intent' => $intent]) }}"
        class="createit-social__button createit-social__button--google"
    >
        <span class="createit-social__icon">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5">
                <path fill="#EA4335" d="M12 10.8v3.84h5.34a4.624 4.624 0 0 1-2 3.03l3.23 2.51c1.88-1.73 2.96-4.28 2.96-7.31 0-.7-.06-1.37-.18-2.02z" />
                <path fill="#34A853" d="M4.88 14.32l-.75.57-2.58 2C3.4 20.9 7.34 23.5 12 23.5c3.24 0 5.96-1.07 7.95-2.89l-3.23-2.51c-.89.6-2.03.96-3.72.96-2.86 0-5.29-1.93-6.16-4.52z" />
                <path fill="#4A90E2" d="M4.88 9.68a7.2 7.2 0 0 1 0-4.36V4.75L2.3 2.72A11.96 11.96 0 0 0 0 12c0 1.94.46 3.78 1.3 5.28l3.58-2.96a7.17 7.17 0 0 1 0-4.64z" />
                <path fill="#FBBC05" d="M12 4.5c1.77 0 2.97.76 3.65 1.4l2.67-2.62C17.96 1.18 15.24 0 12 0 7.34 0 3.4 2.6 1.3 6.72l3.58 2.96C5.83 6.43 8.26 4.5 12 4.5z" />
            </svg>
        </span>
        {{ $googleLabel }}
    </a>

    <a
        href="{{ route('oauth.redirect', ['provider' => 'github', 'intent' => $intent]) }}"
        class="createit-social__button createit-social__button--github"
    >
        <span class="createit-social__icon">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5 fill-current">
                <path d="M12 .5a11.5 11.5 0 0 0-3.64 22.41c.58.11.79-.25.79-.56 0-.28-.01-1.02-.02-2-3.22.7-3.9-1.55-3.9-1.55-.53-1.35-1.28-1.71-1.28-1.71-1.05-.72.08-.7.08-.7 1.16.08 1.78 1.2 1.78 1.2 1.04 1.77 2.72 1.26 3.38.96.11-.76.4-1.26.73-1.55-2.57-.29-5.27-1.29-5.27-5.73 0-1.27.45-2.31 1.2-3.13-.12-.3-.52-1.5.11-3.13 0 0 .97-.31 3.18 1.2a10.9 10.9 0 0 1 5.8 0c2.2-1.51 3.17-1.2 3.17-1.2.63 1.63.23 2.83.12 3.13.75.82 1.2 1.86 1.2 3.13 0 4.45-2.7 5.43-5.28 5.72.42.36.79 1.07.79 2.17 0 1.57-.01 2.83-.01 3.22 0 .31.21.68.8.56A11.5 11.5 0 0 0 12 .5Z" />
            </svg>
        </span>
        {{ $githubLabel }}
    </a>
</div>
