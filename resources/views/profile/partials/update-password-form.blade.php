<section class="rounded-3xl border border-slate-200 bg-white/90 p-8 shadow-xl shadow-slate-900/5 backdrop-blur">
    <header class="flex flex-col gap-4 border-b border-slate-200 pb-6 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-start gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500 to-indigo-500 text-white shadow-lg shadow-indigo-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-1.5 0h12a1.5 1.5 0 0 1 1.5 1.5v6.75a1.5 1.5 0 0 1-1.5 1.5h-12a1.5 1.5 0 0 1-1.5-1.5v-6.75a1.5 1.5 0 0 1 1.5-1.5Z" />
                </svg>
            </span>
            <div>
                <h2 class="text-xl font-semibold text-slate-900">
                    {{ __('Update Password') }}
                </h2>
                <p class="mt-2 text-sm text-slate-600">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </div>
        </div>
        <span class="inline-flex items-center rounded-full bg-violet-50 px-4 py-1 text-xs font-semibold uppercase tracking-wide text-violet-600">
            {{ __('Security') }}
        </span>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 grid gap-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
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
