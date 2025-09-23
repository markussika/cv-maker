<x-guest-layout>
    <div class="space-y-8">
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.35em] text-slate-500">{{ __('Get started') }}</p>
            <h1 class="text-3xl font-semibold text-slate-900">{{ __('Create your CV Maker account') }}</h1>
            <p class="text-sm text-slate-500">{{ __('Sign up to unlock saved resumes, reusable templates, and tailored guidance.') }}</p>
        </div>

        @if (session('oauth_error'))
            <div class="rounded-2xl border border-red-200 bg-red-50/80 px-4 py-3 text-sm text-red-700">
                {{ session('oauth_error') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-slate-50/80 px-5 py-4 text-sm text-slate-600 shadow-sm">
            <p class="flex items-center gap-2 font-semibold text-slate-700">
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                    <svg viewBox="0 0 20 20" aria-hidden="true" class="h-4 w-4"><path fill="currentColor" d="M16.707 5.293a1 1 0 0 0-1.414 0L8 12.586 4.707 9.293a1 1 0 0 0-1.414 1.414l4 4a1 1 0 0 0 1.414 0l8-8a1 1 0 0 0 0-1.414Z"/></svg>
                </span>
                {{ __('Everything you need to launch standout applications.') }}
            </p>
            <ul class="mt-3 space-y-2 text-slate-500">
                <li class="flex items-start gap-2">
                    <span class="mt-1 inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                        <svg viewBox="0 0 20 20" aria-hidden="true" class="h-3 w-3"><path fill="currentColor" d="M16.707 5.293a1 1 0 0 0-1.414 0L8 12.586 4.707 9.293a1 1 0 0 0-1.414 1.414l4 4a1 1 0 0 0 1.414 0l8-8a1 1 0 0 0 0-1.414Z"/></svg>
                    </span>
                    <span>{{ __('Create unlimited CV versions and export them anytime.') }}</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-1 inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                        <svg viewBox="0 0 20 20" aria-hidden="true" class="h-3 w-3"><path fill="currentColor" d="M16.707 5.293a1 1 0 0 0-1.414 0L8 12.586 4.707 9.293a1 1 0 0 0-1.414 1.414l4 4a1 1 0 0 0 1.414 0l8-8a1 1 0 0 0 0-1.414Z"/></svg>
                    </span>
                    <span>{{ __('Swap between modern templates without re-entering information.') }}</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-1 inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                        <svg viewBox="0 0 20 20" aria-hidden="true" class="h-3 w-3"><path fill="currentColor" d="M16.707 5.293a1 1 0 0 0-1.414 0L8 12.586 4.707 9.293a1 1 0 0 0-1.414 1.414l4 4a1 1 0 0 0 1.414 0l8-8a1 1 0 0 0 0-1.414Z"/></svg>
                    </span>
                    <span>{{ __('Speed through sign-up by linking your Google or Apple account.') }}</span>
                </li>
            </ul>
        </div>

        <x-auth.social-providers intent="register" />

        <div class="flex items-center gap-4 text-xs uppercase tracking-[0.35em] text-slate-400">
            <span class="flex-1 border-t border-slate-200"></span>
            {{ __('or use email') }}
            <span class="flex-1 border-t border-slate-200"></span>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-slate-600">{{ __('Full name') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="mt-2 block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200/60" placeholder="Alex Morgan">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-600">{{ __('Email address') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="mt-2 block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200/60" placeholder="you@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-600">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-2 block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200/60" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-600">{{ __('Confirm password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-2 block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200/60" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="mt-2 inline-flex w-full items-center justify-center gap-2 rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition hover:-translate-y-0.5 hover:bg-blue-700">
                {{ __('Create account') }}
            </button>
        </form>

        <p class="text-center text-sm text-slate-500">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">{{ __('Sign in instead') }}</a>
        </p>
    </div>
</x-guest-layout>
