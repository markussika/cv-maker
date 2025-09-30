<x-app-layout>
    <div class="space-y-8">
        @if (session('status'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50/80 p-6 text-sm text-emerald-800 shadow-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($hasData)
            <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
                <section class="space-y-8 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">{{ __('Overview') }}</p>
                        <div class="mt-4 flex flex-col gap-6 sm:flex-row sm:items-start">
                            <div class="flex h-24 w-24 flex-shrink-0 items-center justify-center overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 text-2xl font-semibold text-slate-600 shadow-sm">
                                @if (!empty($profile['profile_image']))
                                    <img src="{{ $profile['profile_image'] }}" alt="{{ $profile['name'] ?? __('Profile photo') }}" class="h-full w-full object-cover">
                                @else
                                    <span>{{ $profile['initials'] ?? 'CV' }}</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h1 class="text-3xl font-semibold text-slate-900">{{ $profile['name'] }}</h1>
                                @if (!empty($profile['headline']))
                                    <p class="mt-2 text-lg text-slate-500">{{ $profile['headline'] }}</p>
                                @endif
                                @if (!empty($profile['summary']))
                                    <p class="mt-4 text-sm leading-relaxed text-slate-600">{{ $profile['summary'] }}</p>
                                @endif
                                @if (!empty($socialLinks))
                                    <div class="mt-4 flex flex-wrap gap-2 text-xs">
                                        @foreach ($socialLinks as $link)
                                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-slate-600 transition hover:border-blue-500 hover:text-blue-600">
                                                <span class="inline-flex h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                <span>{{ $link['label'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                @if (!empty($contactChips))
                                    <div class="mt-4 flex flex-wrap gap-3 text-sm text-slate-600">
                                        @foreach ($contactChips as $item)
                                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">{{ $item }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if (!empty($experiences))
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-semibold text-slate-900">{{ __('Experience') }}</h2>
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ __('Latest') }}</span>
                            </div>
                            <div class="space-y-4">
                                @foreach ($experiences as $experience)
                                    <article class="space-y-2 rounded-2xl border border-slate-200 bg-slate-50/70 p-6 shadow-inner shadow-slate-200/60">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            <div>
                                                @if (!empty($experience['role']))
                                                    <h3 class="text-lg font-semibold text-slate-900">{{ $experience['role'] }}</h3>
                                                @endif
                                                <p class="text-sm text-slate-500">
                                                    {{ $experience['company'] ?? __('Company') }}
                                                    @if (!empty($experience['company']) && !empty($experience['location']))
                                                        ·
                                                    @endif
                                                    {{ $experience['location'] ?? '' }}
                                                </p>
                                            </div>
                                            @if (!empty($experience['period']))
                                                <span class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $experience['period'] }}</span>
                                            @else
                                                <span class="text-xs uppercase tracking-[0.3em] text-slate-400">
                                                    {{ trim(($experience['from'] ?? '') . ' – ' . ($experience['to'] ?? '')) ?: __('Timing not specified') }}
                                                </span>
                                            @endif
                                        </div>
                                        @if (!empty($experience['summary']))
                                            <p class="text-sm text-slate-700 leading-relaxed">{{ $experience['summary'] }}</p>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (!empty($education))
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-semibold text-slate-900">{{ __('Education') }}</h2>
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ __('Highlights') }}</span>
                            </div>
                            <div class="space-y-4">
                                @foreach ($education as $educationItem)
                                    <article class="space-y-1 rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm">
                                        @if (!empty($educationItem['institution']))
                                            <h3 class="text-lg font-semibold text-slate-900">{{ $educationItem['institution'] }}</h3>
                                        @endif
                                        @if (!empty($educationItem['degree']) || !empty($educationItem['field']))
                                            <p class="text-sm text-slate-600">
                                                {{ $educationItem['degree'] ?? '' }}
                                                @if (!empty($educationItem['degree']) && !empty($educationItem['field']))
                                                    ·
                                                @endif
                                                {{ $educationItem['field'] ?? '' }}
                                            </p>
                                        @endif
                                        @if (!empty($educationItem['location']))
                                            <p class="text-sm text-slate-500">{{ $educationItem['location'] }}</p>
                                        @endif
                                        @if (!empty($educationItem['start']) || !empty($educationItem['end']))
                                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">
                                                {{ $educationItem['start'] ?? __('Unknown') }}
                                                &ndash;
                                                {{ $educationItem['end'] ?? __('Ongoing') }}
                                            </p>
                                        @elseif (!empty($educationItem['period']))
                                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $educationItem['period'] }}</p>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>

                <aside class="space-y-6">
                    @if (!empty($templateInfo))
                        <div class="space-y-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-slate-400">{{ __('Template') }}</p>
                            <h2 class="text-lg font-semibold text-slate-900">{{ $templateInfo['title'] }}</h2>
                            <p class="text-sm text-slate-600">{{ $templateInfo['description'] }}</p>
                            <div class="mt-4 h-36 rounded-2xl bg-gradient-to-br {{ $templateInfo['preview'] }} p-4 shadow-inner shadow-slate-400/20">
                                <div class="h-2 w-24 rounded-full bg-white/70"></div>
                                <div class="mt-4 space-y-2">
                                    <div class="h-2 w-28 rounded-full bg-white/60"></div>
                                    <div class="h-2 w-32 rounded-full bg-white/40"></div>
                                    <div class="h-16 rounded-2xl border border-white/50 bg-white/30"></div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 pt-2">
                                <a href="{{ route('cv.download', array_filter(['template' => $templateKey, 'cv' => request('cv')])) }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-slate-400/40 transition hover:-translate-y-0.5 hover:bg-black">
                                    {{ __('Download PDF') }}
                                    <span aria-hidden="true">&darr;</span>
                                </a>
                                <a href="{{ route('cv.create', ['template' => $templateKey]) }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-5 py-2 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:bg-slate-50">
                                    {{ __('Edit details') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (!empty($skills))
                        <div class="space-y-3 rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-slate-400">{{ __('Skills & tools') }}</p>
                            <ul class="flex flex-wrap gap-2 text-xs font-medium text-slate-600">
                                @foreach ($skills as $skill)
                                    <li class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">{{ $skill }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($languages))
                        <div class="space-y-3 rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-slate-400">{{ __('Languages') }}</p>
                            <ul class="space-y-2 text-sm text-slate-600">
                                @foreach ($languages as $language)
                                    <li class="flex items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-slate-50 px-3 py-2">
                                        <span>{{ $language['name'] }}</span>
                                        @if (!empty($language['level']))
                                            <span class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $language['level'] }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($hobbies))
                        <div class="space-y-3 rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.35em] text-slate-400">{{ __('Hobbies & Interests') }}</p>
                            <ul class="space-y-2 text-sm text-slate-600">
                                @foreach ($hobbies as $hobby)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-1 inline-flex h-1.5 w-1.5 flex-shrink-0 rounded-full bg-blue-500"></span>
                                        <span>{{ $hobby }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </aside>
            </div>
        @else
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900">{{ __('No CV data found') }}</h2>
                <p class="mt-2 text-sm text-slate-600">{{ __('Complete the builder to see a live preview of your CV.') }}</p>
                <a href="{{ route('cv.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow hover:-translate-y-0.5 hover:bg-black">
                    {{ __('Create your CV') }}
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
