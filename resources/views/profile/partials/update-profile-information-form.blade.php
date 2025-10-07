@php
    $storedAvatar = $user->avatar_url;
    $displayAvatar = null;

    if (is_string($storedAvatar) && trim($storedAvatar) !== '') {
        $displayAvatar = filter_var($storedAvatar, FILTER_VALIDATE_URL)
            ? $storedAvatar
            : \Illuminate\Support\Facades\Storage::disk('public')->url($storedAvatar);
    }
@endphp

<section class="rounded-3xl border border-slate-200 bg-white/90 p-8 shadow-xl shadow-slate-900/5 backdrop-blur">
    <header class="flex flex-col gap-4 border-b border-slate-200 pb-6 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-start gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-500 text-white shadow-lg shadow-indigo-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 1 1 15 0v.75H4.5v-.75Z" />
                </svg>
            </span>
            <div>
                <h2 class="text-xl font-semibold text-slate-900">
                    {{ __('Profile Information') }}
                </h2>
                <p class="mt-2 text-sm text-slate-600">
                    {{ __("Update your account's profile information and email address.") }}
                </p>
            </div>
        </div>
        <span class="inline-flex items-center rounded-full bg-indigo-50 px-4 py-1 text-xs font-semibold uppercase tracking-wide text-indigo-600">
            {{ __('Personal details') }}
        </span>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 grid gap-6 sm:grid-cols-2" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="sm:col-span-1">
            <x-input-label for="name" :value="__('Name')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="name" name="name" type="text" class="mt-2 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="sm:col-span-1">
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 rounded-2xl bg-amber-50 px-4 py-3 text-sm text-amber-700">
                    <p class="font-medium">
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button form="send-verification" class="mt-2 inline-flex items-center gap-2 rounded-full bg-amber-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2 focus:ring-offset-amber-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25 12 13.5l9-5.25M4.5 19.5h15a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5h-15A1.5 1.5 0 0 0 3 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                        </svg>
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-amber-700">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="sm:col-span-2">
            <x-input-label for="profile_photo" :value="__('Profile photo')" class="text-sm font-semibold text-slate-700" />

            <div class="mt-3 flex flex-wrap items-center gap-5">
                <div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-2xl bg-slate-200 shadow-inner">
                    @if ($displayAvatar)
                        <img src="{{ $displayAvatar }}" alt="{{ __('Profile photo preview') }}" class="h-full w-full object-cover">
                    @else
                        <span class="text-lg font-semibold text-slate-500">
                            {{ \Illuminate\Support\Str::of($user->name)->trim()->take(2)->upper() ?: __('You') }}
                        </span>
                    @endif
                </div>

                <div class="flex-1 space-y-3">
                    <input
                        id="profile_photo"
                        name="profile_photo"
                        type="file"
                        accept="image/*"
                        class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-600 hover:file:bg-indigo-100"
                    >

                    <p class="text-xs text-slate-500">
                        {{ __('Upload a square image (max 2 MB) to personalize your profile and CV templates.') }}
                    </p>

                    @if ($displayAvatar)
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remove_profile_photo" value="1" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span>{{ __('Remove current photo') }}</span>
                        </label>
                    @endif
                </div>
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div class="flex flex-wrap items-center gap-3 sm:col-span-2">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-emerald-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
