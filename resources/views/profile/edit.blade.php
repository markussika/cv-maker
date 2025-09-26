<x-app-layout>
    <div class="relative isolate overflow-hidden bg-slate-950 text-white">
        <div class="pointer-events-none absolute -left-24 top-0 h-80 w-80 rounded-full bg-indigo-500/40 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-[-10rem] right-0 h-96 w-96 rounded-full bg-blue-500/20 blur-3xl"></div>

        <section class="relative mx-auto max-w-6xl px-6 py-20">
            <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-indigo-200">
                <span class="h-2 w-2 rounded-full bg-indigo-400"></span>
                Account hub
            </p>
            <div class="mt-8 grid gap-8 lg:grid-cols-[1.25fr,0.75fr] lg:items-end">
                <div class="space-y-5">
                    <h1 class="text-4xl font-semibold tracking-tight sm:text-5xl">Manage your profile with confidence</h1>
                    <p class="max-w-2xl text-base text-slate-200 sm:text-lg">
                        Keep your personal details, security credentials, and privacy preferences up to date. A refreshed profile keeps recruiters informed and protects your account.
                    </p>
                    <div class="flex flex-wrap items-center gap-3 text-sm">
                        <span class="inline-flex items-center gap-2 rounded-full bg-indigo-500/30 px-4 py-2 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 1 1 15 0v.75H4.5v-.75Z" />
                            </svg>
                            {{ $user->name }}
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/30 px-4 py-2 font-medium text-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25 12 13.5l9-5.25M4.5 19.5h15a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5h-15A1.5 1.5 0 0 0 3 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                            </svg>
                            {{ $user->email }}
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/30 px-4 py-2 font-medium text-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v3.75l2.25 2.25m6-2.25a8.25 8.25 0 1 1-16.5 0 8.25 8.25 0 0 1 16.5 0Z" />
                            </svg>
                            Member since {{ optional($user->created_at)->format('M Y') ?? '—' }}
                        </span>
                    </div>
                </div>
                <div class="rounded-3xl border border-white/20 bg-white/10 p-8 backdrop-blur">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-indigo-200">Need a refresh?</h2>
                    <p class="mt-3 text-sm text-slate-100">
                        Review your details frequently to ensure your applications and saved templates stay aligned with your latest experience.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3 text-xs font-semibold uppercase tracking-wide text-slate-100">
                        <span class="rounded-full bg-white/10 px-3 py-1">Contact details</span>
                        <span class="rounded-full bg-white/10 px-3 py-1">Security</span>
                        <span class="rounded-full bg-white/10 px-3 py-1">Privacy</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="bg-slate-100 pb-16">
        <div class="mx-auto -mt-16 max-w-6xl space-y-10 px-6">
            <div class="grid gap-8 lg:grid-cols-2">
                @include('profile.partials.update-profile-information-form')
                @include('profile.partials.update-password-form')
            </div>

            <div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </section>
</x-app-layout>
