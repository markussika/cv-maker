<x-app-layout>
    

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
                        'partial' => 'templates.previews.classic',
                    ],
                    'modern' => [
                        'title' => 'Modern',
                        'description' => 'Bold headings and clear hierarchies.',
                        'preview' => 'from-blue-200 via-blue-100 to-slate-50',
                        'partial' => 'templates.previews.modern',
                    ],
                    'creative' => [
                        'title' => 'Creative',
                        'description' => 'Playful colour accents that stand out.',
                        'preview' => 'from-pink-200 via-purple-200 to-sky-100',
                        'partial' => 'templates.previews.creative',
                    ],
                    'minimal' => [
                        'title' => 'Minimal',
                        'description' => 'Airy spacing with quiet confidence.',
                        'preview' => 'from-white via-slate-50 to-slate-100',
                        'partial' => 'templates.previews.minimal',
                    ],
                    'elegant' => [
                        'title' => 'Elegant',
                        'description' => 'Fine lines with soft serif accents.',
                        'preview' => 'from-amber-100 via-rose-50 to-white',
                        'partial' => 'templates.previews.elegant',
                    ],
                    'corporate' => [
                        'title' => 'Corporate',
                        'description' => 'Structure and clarity for leadership roles.',
                        'preview' => 'from-slate-300 via-slate-200 to-white',
                        'partial' => 'templates.previews.corporate',
                    ],
                    'gradient' => [
                        'title' => 'Gradient',
                        'description' => 'Vivid blends for creative roles.',
                        'preview' => 'from-emerald-200 via-teal-200 to-cyan-100',
                        'partial' => 'templates.previews.gradient',
                    ],
                    'darkmode' => [
                        'title' => 'Dark Mode',
                        'description' => 'High contrast with refined details.',
                        'preview' => 'from-slate-900 via-slate-800 to-black',
                        'partial' => 'templates.previews.darkmode',
                    ],
                    'futuristic' => [
                        'title' => 'Futuristic',
                        'description' => 'Sharp angles with neon accents.',
                        'preview' => 'from-indigo-300 via-purple-300 to-slate-100',
                        'partial' => 'templates.previews.futuristic',
                    ],
                ];

                $templateKey = $cvData['template'] ?? 'classic';
                $templateInfo = $templateMeta[$templateKey] ?? [
                    'title' => ucfirst($templateKey),
                    'description' => 'Ready-to-print layout for your story.',
                    'preview' => 'from-slate-200 via-white to-slate-100',
                    'partial' => null,
                ];

                $fullName = trim(($cvData['first_name'] ?? '') . ' ' . ($cvData['last_name'] ?? ''));
                $email = $cvData['email'] ?? null;
                $phone = $cvData['phone'] ?? null;
                $city = $cvData['city'] ?? null;
                $country = $cvData['country'] ?? null;
                $location = trim(collect([$city, $country])->filter()->join(', '));

                $initials = collect([
                    $cvData['first_name'] ?? null,
                    $cvData['last_name'] ?? null,
                ])
                    ->filter(function ($value) {
                        return is_string($value) && trim($value) !== '';
                    })
                    ->map(function ($value) {
                        return mb_substr(trim($value), 0, 1);
                    })
                    ->implode('');
                if ($initials === '') {
                    $initials = 'CV';
                }

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
                $experiences = array_values(array_filter($experiences, function ($exp) {
                    return is_array($exp);
                }));

                $educationItems = $cvData['education'] ?? [];
                if ($educationItems && !is_array($educationItems)) {
                    $educationItems = (array) $educationItems;
                }
                if (is_array($educationItems) && array_keys($educationItems) !== range(0, count($educationItems) - 1)) {
                    $educationItems = [$educationItems];
                }
                $educationItems = array_values(array_filter($educationItems, function ($edu) {
                    return is_array($edu);
                }));

                $hobbies = $cvData['hobbies'] ?? [];
                if ($hobbies && !is_array($hobbies)) {
                    $hobbies = (array) $hobbies;
                }
                $hobbies = array_values(array_filter($hobbies, function ($hobby) {
                    return is_string($hobby) && trim($hobby) !== '';
                }));

                $skills = $cvData['skills'] ?? [];
                if ($skills && !is_array($skills)) {
                    $skills = (array) $skills;
                }
                $skills = array_values(array_filter(array_map(function ($skill) {
                    if (is_array($skill)) {
                        $label = $skill['name'] ?? $skill['title'] ?? null;
                        return is_string($label) ? trim($label) : null;
                    }

                    return is_string($skill) ? trim($skill) : null;
                }, $skills), function ($skill) {
                    return is_string($skill) && $skill !== '';
                }));

                $languages = $cvData['languages'] ?? [];
                if ($languages && !is_array($languages)) {
                    $languages = (array) $languages;
                }
                if (is_array($languages) && array_keys($languages) !== range(0, count($languages) - 1)) {
                    $languages = [$languages];
                }
                $languages = array_values(array_filter(array_map(function ($language) {
                    if (!is_array($language)) {
                        if (is_string($language)) {
                            return ['name' => trim($language), 'level' => null];
                        }

                        return null;
                    }

                    $name = isset($language['name']) ? trim((string) $language['name']) : '';
                    $level = isset($language['level']) ? trim((string) $language['level']) : '';

                    if ($name === '') {
                        return null;
                    }

                    return ['name' => $name, 'level' => $level !== '' ? $level : null];
                }, $languages), function ($language) {
                    return is_array($language) && ($language['name'] ?? null);
                }));

                $headline = is_string($cvData['headline'] ?? null) ? trim($cvData['headline']) : null;
                $summaryText = is_string($cvData['summary'] ?? null) ? trim($cvData['summary']) : null;
                $website = is_string($cvData['website'] ?? null) ? trim($cvData['website']) : null;
                $linkedin = is_string($cvData['linkedin'] ?? null) ? trim($cvData['linkedin']) : null;
                $github = is_string($cvData['github'] ?? null) ? trim($cvData['github']) : null;
                $profileImage = is_string($cvData['profile_image'] ?? null) ? trim($cvData['profile_image']) : null;
                if ($profileImage === '') {
                    $profileImage = null;
                }

                $profileImageFilesystemPath = null;
                $profileImageStoragePath = null;
                if ($profileImage) {
                    $isAbsoluteProfileUrl = filter_var($profileImage, FILTER_VALIDATE_URL) !== false;
                    $isDataUri = is_string($profileImage) && str_starts_with($profileImage, 'data:');

                    if (! $isAbsoluteProfileUrl && ! $isDataUri) {
                        $storagePath = preg_replace('#^/?storage/#', '', $profileImage);
                        $storagePath = ltrim((string) $storagePath, '/');

                        try {
                            $publicDisk = \Illuminate\Support\Facades\Storage::disk('public');

                            if ($storagePath !== '' && $publicDisk->exists($storagePath)) {
                                $profileImage = $publicDisk->url($storagePath);
                                if (method_exists($publicDisk, 'path')) {
                                    try {
                                        $profileImageFilesystemPath = $publicDisk->path($storagePath);
                                    } catch (\Throwable $pathException) {
                                        $profileImageFilesystemPath = null;
                                    }
                                }
                                $profileImageStoragePath = $storagePath;
                            } elseif ($publicDisk->exists(ltrim($profileImage, '/'))) {
                                $relativePath = ltrim($profileImage, '/');
                                $profileImage = $publicDisk->url($relativePath);
                                if (method_exists($publicDisk, 'path')) {
                                    try {
                                        $profileImageFilesystemPath = $publicDisk->path($relativePath);
                                    } catch (\Throwable $pathException) {
                                        $profileImageFilesystemPath = null;
                                    }
                                }
                                $profileImageStoragePath = $relativePath;
                            } else {
                                $profileImage = null;
                            }
                        } catch (\Throwable $e) {
                            $profileImage = null;
                            $profileImageFilesystemPath = null;
                            $profileImageStoragePath = null;
                        }
                    }

                    if (! $isDataUri && $profileImage) {
                        try {
                            $embedded = null;
                            $mimeType = null;

                            if ($profileImageStoragePath) {
                                $publicDisk ??= \Illuminate\Support\Facades\Storage::disk('public');

                                try {
                                    $contents = $publicDisk->get($profileImageStoragePath);
                                    if (is_string($contents) && $contents !== '') {
                                        try {
                                            $mimeType = $publicDisk->mimeType($profileImageStoragePath);
                                        } catch (\Throwable $mimeException) {
                                            $mimeType = null;
                                        }

                                        if (! is_string($mimeType) || trim($mimeType) === '') {
                                            try {
                                                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                                                $detected = $finfo->buffer($contents);
                                                if (is_string($detected) && trim($detected) !== '') {
                                                    $mimeType = $detected;
                                                }
                                            } catch (\Throwable $finfoException) {
                                                $mimeType = null;
                                            }
                                        }

                                        $mimeType = is_string($mimeType) && trim($mimeType) !== '' ? trim($mimeType) : 'image/png';
                                        $embedded = 'data:' . $mimeType . ';base64,' . base64_encode($contents);
                                    }
                                } catch (\Throwable $diskException) {
                                    $embedded = null;
                                }
                            }

                            if (! $embedded && $profileImageFilesystemPath && is_readable($profileImageFilesystemPath)) {
                                $contents = @file_get_contents($profileImageFilesystemPath);
                                if ($contents !== false) {
                                    $mimeType = @mime_content_type($profileImageFilesystemPath) ?: 'image/png';
                                    $embedded = 'data:' . $mimeType . ';base64,' . base64_encode($contents);
                                }
                            }

                            if ($embedded) {
                                $profileImage = $embedded;
                            }
                        } catch (\Throwable $e) {
                            // fall back to the resolved URL if embedding fails
                        }
                    }
                }

                $socialLinks = collect([
                    ['label' => 'Website', 'url' => $website],
                    ['label' => 'LinkedIn', 'url' => $linkedin],
                    ['label' => 'GitHub', 'url' => $github],
                ])->filter(function ($item) {
                    return is_string($item['url']) && $item['url'] !== '';
                })->values();
            @endphp

            <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
                <section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm space-y-8">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">{{ __('Overview') }}</p>
                        <div class="mt-4 flex flex-col gap-6 sm:flex-row sm:items-start">
                            <div class="flex h-24 w-24 flex-shrink-0 items-center justify-center overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 text-2xl font-semibold text-slate-600 shadow-sm">
                                @if ($profileImage)
                                    <img src="{{ $profileImage }}" alt="{{ $fullName ?: __('Profile photo') }}" class="h-full w-full object-cover">
                                @else
                                    <span>{{ $initials }}</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h1 class="text-3xl font-semibold text-slate-900">{{ $fullName ?: __('Untitled CV') }}</h1>
                                @if ($headline)
                                    <p class="mt-2 text-lg text-slate-500">{{ $headline }}</p>
                                @endif
                                @if ($summaryText)
                                    <p class="mt-4 text-sm leading-relaxed text-slate-600">{{ $summaryText }}</p>
                                @endif
                                @if ($socialLinks->isNotEmpty())
                                    <div class="mt-4 flex flex-wrap gap-2 text-xs">
                                        @foreach ($socialLinks as $link)
                                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-slate-600 transition hover:border-blue-500 hover:text-blue-600">
                                                <span class="inline-flex h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                <span>{{ $link['label'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="mt-4 flex flex-wrap gap-3 text-sm text-slate-600">
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
                        <div class="relative mt-4 h-52 overflow-hidden rounded-2xl bg-gradient-to-br {{ $templateInfo['preview'] }} shadow-inner shadow-slate-400/20">
                            @if (!empty($templateInfo['partial']) && view()->exists($templateInfo['partial']))
                                @include($templateInfo['partial'])
                            @else
                                <div class="p-4">
                                    <div class="h-2 w-24 rounded-full bg-white/70"></div>
                                    <div class="mt-4 space-y-2">
                                        <div class="h-2 w-28 rounded-full bg-white/60"></div>
                                        <div class="h-2 w-32 rounded-full bg-white/40"></div>
                                        <div class="h-16 rounded-2xl border border-white/50 bg-white/30"></div>
                                    </div>
                                </div>
                            @endif
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

                    @if (!empty($skills))
                        <div class="rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm space-y-3">
                            <p class="text-xs uppercase tracking-[0.35em] text-slate-400">{{ __('Skills & tools') }}</p>
                            <ul class="flex flex-wrap gap-2 text-xs font-medium text-slate-600">
                                @foreach ($skills as $skill)
                                    <li class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">{{ $skill }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($languages))
                        <div class="rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm space-y-3">
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
