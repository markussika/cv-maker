@props([
    'intent' => 'login',
])

@php
    $intent = in_array($intent, ['login', 'register'], true) ? $intent : 'login';
    $googleLabel = $intent === 'register' ? __('Sign up with Google') : __('Continue with Google');
    $appleLabel = $intent === 'register' ? __('Sign up with Apple') : __('Continue with Apple');
@endphp

<div {{ $attributes->class(['space-y-3']) }}>
    <a
        href="{{ route('oauth.redirect', ['provider' => 'google', 'intent' => $intent]) }}"
        class="group flex w-full items-center justify-center gap-3 rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-blue-500 hover:text-blue-600"
    >
        <span class="inline-flex h-5 w-5 items-center justify-center">
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
        href="{{ route('oauth.redirect', ['provider' => 'apple', 'intent' => $intent]) }}"
        class="group flex w-full items-center justify-center gap-3 rounded-full border border-slate-900 bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-black"
    >
        <span class="inline-flex h-5 w-5 items-center justify-center">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5 fill-current">
                <path d="M16.365 1.43c0 1.14-.418 2.107-1.255 2.9-.753.715-1.664 1.16-2.655 1.091-.03-1.105.42-2.048 1.287-2.86.766-.74 1.7-1.164 2.623-1.22zm4.635 17.087c-.5 1.15-1.095 2.226-1.785 3.228-.964 1.373-1.838 2.353-2.624 2.94-.838.63-1.737.95-2.7.962-.69.013-1.523-.198-2.5-.632-.977-.437-1.875-.65-2.69-.65-.846 0-1.77.213-2.77.65-1 .434-1.802.656-2.404.664-.93.04-1.85-.3-2.76-1.025-.924-.736-1.744-1.87-2.46-3.405-.75-1.6-1.125-3.158-1.125-4.676 0-1.721.371-3.205 1.115-4.45.584-.995 1.362-1.79 2.333-2.384.97-.606 2.015-.92 3.136-.94.616 0 1.423.204 2.422.611.998.406 1.64.612 1.926.612.21 0 .92-.248 2.13-.743 1.143-.467 2.108-.66 2.898-.581 2.142.173 3.756.99 4.84 2.448-1.92 1.162-2.873 2.8-2.858 4.914.016 1.639.63 3 1.84 4.086.55.52 1.16.92 1.828 1.2-.146.414-.3.82-.462 1.217z" />
            </svg>
        </span>
        {{ $appleLabel }}
    </a>
</div>
