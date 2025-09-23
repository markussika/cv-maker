<x-app-layout>
    <x-slot name="header">
        {{ __('CV Preview') }}
    </x-slot>

    <div class="space-y-8">
        @if (session('status'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50/80 p-6 text-sm text-emerald-800 shadow-sm">
                {{ session('status') }}
            </div>
        @endif

        @if (!empty($cvData))
            @php
                $templateMeta = [
                    'classic' => [
                        'title' => 'Classic',
                        'description' => 'A balanced layout with timeless typography.',
                        'preview' => 'from-slate-200 via-white to-slate-100',
                    ],
                    'modern' => [
                        'title' => 'Modern',
                        'description' => 'Bold headings and clear hierarchies.',
                        'preview' => 'from-blue-200 via-blue-100 to-slate-50',
                    ],
                    'creative' => [
                        'title' => 'Creative',
                        'description' => 'Playful colour accents that stand out.',
                        'preview' => 'from-pink-200 via-purple-200 to-sky-100',
                    ],
                    'minimal' => [
                        'title' => 'Minimal',
                        'description' => 'Airy spacing with quiet confidence.',
                        'preview' => 'from-white via-slate-50 to-slate-100',
                    ],
                    'elegant' => [
                        'title' => 'Elegant',
                        'description' => 'Fine lines with soft serif accents.',
                        'preview' => 'from-amber-100 via-rose-50 to-white',
                    ],
                    'corporate' => [
                        'title' => 'Corporate',
                        'description' => 'Structure and clarity for leadership roles.',
                        'preview' => 'from-slate-300 via-slate-200 to-white',
                    ],
                    'gradient' => [
                        'title' => 'Gradient',
                        'description' => 'Vivid blends for creative roles.',
                        'preview' => 'from-emerald-200 via-teal-200 to-cyan-100',
                    ],
                    'darkmode' => [
                        'title' => 'Dark Mode',
                        'description' => 'High contrast with refined details.',
                        'preview' => 'from-slate-900 via-slate-800 to-black',
                    ],
                    'futuristic' => [
                        'title' => 'Futuristic',
                        'description' => 'Sharp angles with neon accents.',
                        'preview' => 'from-indigo-300 via-purple-300 to-slate-100',
                    ],
                ];

                $templateKey = $cvData['template'] ?? 'classic';
                $templateInfo = $templateMeta[$templateKey] ?? [
                    'title' => ucfirst($templateKey),
                    'description' => 'Ready-to-print layout for your story.',
                    'preview' => 'from-slate-200 via-white to-slate-100',
                ];

                $fullName = trim(($cvData['first_name'] ?? '') . ' ' . ($cvData['last_name'] ?? ''));
                $email = $cvData['email'] ?? null;
                $phone = $cvData['phone'] ?? null;
                $city = $cvData['city'] ?? null;
                $country = $cvData['country'] ?? null;
                $location = trim(collect([$city, $country])->filter()->join(', '));

                $birthday = $cvData['birthday'] ?? null;
                $birthdayFormatted = null;
                if (!empty($birthday)) {
                    try {
                        $birthdayFormatted = \Illuminate\Support\Carbon::parse($birthday)->translatedFormat('F j, Y');
                    } catch (\Throwable $exception) {
                        $birthdayFormatted = $birthday;
                    }
                }

                $experiences = $cvData['experience'] ?? [];
                if ($experiences && !is_array($experiences)) {
                    $experiences = (array) $experiences;
                }
                if (is_array($experiences) && array_keys($experiences) !== range(0, count($experiences) - 1)) {
                    $experiences = [$experiences];
                }
                $experiences = array_values(array_filter($experiences, fn ($exp) => is_array($exp)));

                $educationItems = $cvData['education'] ?? [];
                if ($educationItems && !is_array($educationItems)) {
                    $educationItems = (array) $educationItems;
                }
                if (is_array($educationItems) && array_keys($educationItems) !== range(0, count($educationItems) - 1)) {
                    $educationItems = [$educationItems];
                }
                $educationItems = array_values(array_filter($educationItems, fn ($edu) => is_array($edu)));

                $hobbies = $cvData['hobbies'] ?? [];
                if ($hobbies && !is_array($hobbies)) {
                    $hobbies = (array) $hobbies;
                }
                $hobbies = array_values(array_filter($hobbies, fn ($hobby) => is_string($hobby) && trim($hobby) !== ''));
            @endphp

            <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
                <section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm space-y-8">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">{{ __('Overview') }}</p>
                        <h1 class="mt-3 text-3xl font-semibold text-slate-900">{{ $fullName ?: __('Untitled CV') }}</h1>

                        <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-600">
                            @if ($email)
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">{{ $email }}</span>
                            @endif
                            @if ($phone)
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">{{ $phone }}</span>
                            @endif
                            @if ($location)
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">{{ $location }}</span>
                            @endif
                            @if ($birthdayFormatted)
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">{{ $birthdayFormatted }}</span>
                            @endif
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
                                    @php
                                        $position = $experience['position'] ?? null;
                                        $company = $experience['company'] ?? null;
                                        $experienceLocation = trim(collect([$experience['city'] ?? null, $experience['country'] ?? null])->filter()->join(', '));
                                        $periodFrom = $experience['from'] ?? null;
                                        $periodTo = $experience['to'] ?? null;
                                        $periodFromLabel = $periodFrom;
                                        $periodToLabel = $periodTo;

                                        try {
                                            if ($periodFrom) {
                                                $periodFromLabel = \Illuminate\Support\Carbon::createFromFormat('Y-m', $periodFrom)->translatedFormat('M Y');
                                            }
                                        } catch (\Throwable $exception) {
                                            $periodFromLabel = $periodFrom;
                                        }

                                        try {
                                            if ($periodTo) {
                                                $periodToLabel = \Illuminate\Support\Carbon::createFromFormat('Y-m', $periodTo)->translatedFormat('M Y');
                                            }
                                        } catch (\Throwable $exception) {
                                            $periodToLabel = $periodTo;
                                        }

                                        $isCurrent = !empty($experience['currently']);
                                        $achievements = $experience['achievements'] ?? null;
                                    @endphp
                                    <article class="rounded-2xl border border-slate-200 bg-slate-50/70 p-6 shadow-inner shadow-slate-200/60 space-y-2">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            @if ($position)
                                                <h3 class="text-lg font-semibold text-slate-900">{{ $position }}</h3>
                                            @endif
                                            <span class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $company ?? __('Company') }}</span>
                                        </div>
                                        @if ($experienceLocation)
                                            <p class="text-sm text-slate-500">{{ $experienceLocation }}</p>
                                        @endif
                                        @if ($periodFromLabel || $periodToLabel || $isCurrent)
                                            <p class="text-sm text-slate-600">
                                                {{ $periodFromLabel ?: __('Unknown') }}
                                                &ndash;
                                                {{ $isCurrent ? __('Present') : ($periodToLabel ?: __('Unknown')) }}
                                            </p>
                                        @endif
                                        @if ($achievements)
                                            <p class="text-sm text-slate-700 leading-relaxed">{{ $achievements }}</p>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (!empty($educationItems))
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-semibold text-slate-900">{{ __('Education') }}</h2>
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ __('Highlights') }}</span>
                            </div>
                            <div class="space-y-4">
                                @foreach ($educationItems as $education)
                                    @php
                                        $institution = $education['institution'] ?? $education['school'] ?? null;
                                        $degree = $education['degree'] ?? null;
                                        $field = $education['field'] ?? null;
                                        $start = $education['start_year'] ?? null;
                                        $end = $education['end_year'] ?? null;
                                    @endphp
                                    <article class="rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm space-y-1">
                                        @if ($institution)
                                            <h3 class="text-lg font-semibold text-slate-900">{{ $institution }}</h3>
                                        @endif
                                        <p class="text-sm text-slate-600">{{ collect([$degree, $field])->filter()->join(' · ') }}</p>
                                        @if ($start || $end)
                                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $start }} &ndash; {{ $end ?: __('Ongoing') }}</p>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>

                <aside class="space-y-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
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
                            <a href="{{ route('cv.download', $templateKey) }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-slate-400/40 transition hover:-translate-y-0.5 hover:bg-black">
                                {{ __('Download PDF') }}
                                <span aria-hidden="true">&darr;</span>
                            </a>
                            <a href="{{ route('cv.create', ['template' => $templateKey]) }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-5 py-2 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:bg-slate-50">
                                {{ __('Edit details') }}
                            </a>
                        </div>
                    </div>

                    @if (!empty($hobbies))
                        <div class="rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm space-y-3">
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

                    <div class="rounded-3xl border border-slate-200 bg-white/80 p-6 text-sm text-slate-600 shadow-sm">
                        <p class="font-semibold text-slate-900">{{ __('Tips') }}</p>
                        <ul class="mt-3 space-y-2 list-disc list-inside">
                            <li>{{ __('Return to the builder to adjust any section instantly.') }}</li>
                            <li>{{ __('Download again after each update to keep your files in sync.') }}</li>
                            <li>{{ __('Use the template selector to preview other layouts before exporting.') }}</li>
                        </ul>
                    </div>
                </aside>
            </div>
        @else
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900">{{ __('No CV data found') }}</h2>
                <p class="mt-2 text-sm text-slate-600">{{ __('Complete the builder to see a live preview of your CV.') }}</p>
                <a href="{{ route('cv.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow-lg hover:-translate-y-0.5 hover:bg-black">
                    {{ __('Go to CV builder') }}
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
