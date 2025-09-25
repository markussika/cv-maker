<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Classic · {{ config('app.name', 'CreateIt') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('templates/css/classic.css') }}">
</head>
<body class="classic-template">
    {{-- Optional: preload shared helpers/data --}}
    @include('templates.partials.base-data', ['cv' => $cv])

    @php
        // Helper to safely read nested $cv values
        $value = fn(string $key, $default = null) => data_get($cv, $key, $default);

        // Names
        $firstName = $value('first_name');
        $lastName  = $value('last_name');
        $fullName  = collect([$firstName, $lastName])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => trim($item))
            ->implode(' ');
        $fullName = $fullName !== '' ? $fullName : null;

        // Meta
        $headline = $value('headline') ?? $value('title');
        $summary  = $value('summary')  ?? $value('about');

        // Contacts
        $email   = $value('email');
        $phone   = $value('phone');
        $website = $value('website');

        // Location
        $city    = $value('city');
        $country = $value('country');
        $location = collect([$city, $country])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => trim($item))
            ->implode(', ');
        $location = $location !== '' ? $location : null;

        // Birthday -> formatted (localized)
        $birthdayRaw = $value('birthday');
        $birthdayFormatted = null;
        if ($birthdayRaw instanceof \Illuminate\Support\Carbon) {
            $birthdayFormatted = $birthdayRaw->translatedFormat('F j, Y');
        } elseif (is_string($birthdayRaw) && trim($birthdayRaw) !== '') {
            try {
                $birthdayFormatted = \Illuminate\Support\Carbon::parse($birthdayRaw)->translatedFormat('F j, Y');
            } catch (\Throwable $exception) {
                $birthdayFormatted = $birthdayRaw;
            }
        }

        // Date formatters
        $formatMonthYear = function ($val) {
            if (!is_string($val) || trim($val) === '') return null;
            $val = trim($val);
            try {
                if (preg_match('/^\d{4}-\d{2}$/', $val)) {
                    return \Illuminate\Support\Carbon::createFromFormat('Y-m', $val)->translatedFormat('M Y');
                }
                return \Illuminate\Support\Carbon::parse($val)->translatedFormat('M Y');
            } catch (\Throwable $e) {
                return $val;
            }
        };

        $formatYear = function ($val) use ($formatMonthYear) {
            if (!is_string($val) || trim($val) === '') return null;
            $val = trim($val);
            try {
                if (preg_match('/^\d{4}$/', $val)) {
                    return \Illuminate\Support\Carbon::createFromFormat('Y', $val)->translatedFormat('Y');
                }
                return $formatMonthYear($val);
            } catch (\Throwable $e) {
                return $val;
            }
        };

        // Normalize helper for arrays/collections/json
        $normaliseCollection = function ($items) {
            if ($items instanceof \Illuminate\Support\Collection) {
                $items = $items->all();
            }
            if (is_string($items)) {
                $decoded = json_decode($items, true);
                $items = is_array($decoded) ? $decoded : [];
            }
            if (!is_array($items)) {
                return collect();
            }
            $collection = collect($items);
            if ($collection->isEmpty()) return collect();
            if ($collection->isAssoc()) {
                $collection = collect([$collection->all()]);
            }
            return $collection
                ->map(function ($item) {
                    if ($item instanceof \Illuminate\Support\Collection) return $item->toArray();
                    if (is_object($item)) return collect(get_object_vars($item))->toArray();
                    return is_array($item) ? $item : [];
                })
                ->filter(fn ($item) => !empty(array_filter($item, fn ($v) => is_array($v) ? !empty($v) : trim((string)$v) !== '')))
                ->values();
        };

        // Experience
        $experienceItems = $normaliseCollection($value('work_experience', $value('experience', [])))->map(function ($exp) use ($formatMonthYear) {
            $role    = $exp['position'] ?? $exp['role'] ?? null;
            $company = $exp['company'] ?? null;
            $loc = collect([$exp['city'] ?? null, $exp['country'] ?? null])
                ->filter(fn ($i) => is_string($i) && trim($i) !== '')
                ->map(fn ($i) => trim($i))
                ->implode(', ');
            $loc = $loc !== '' ? $loc : null;

            $fromRaw   = $exp['from'] ?? null;
            $toRaw     = $exp['to'] ?? null;
            $from      = $formatMonthYear($fromRaw);
            $isCurrent = !empty($exp['currently']);
            $to        = $isCurrent ? __('Present') : $formatMonthYear($toRaw);
            $period    = collect([$from, $to])->filter()->implode(' – ');

            $summary   = $exp['achievements'] ?? $exp['description'] ?? null;

            return [
                'role'       => $role,
                'company'    => $company,
                'location'   => $loc,
                'from'       => $from,
                'to'         => $to,
                'from_raw'   => $fromRaw,
                'to_raw'     => $toRaw,
                'is_current' => $isCurrent,
                'period'     => $period !== '' ? $period : null,
                'summary'    => is_string($summary) && trim($summary) !== '' ? trim($summary) : null,
            ];
        })->filter(fn ($i) => ($i['role'] ?? null) || ($i['company'] ?? null) || ($i['summary'] ?? null))
          ->values();

        // Education
        $educationItems = $normaliseCollection($value('education', []))->map(function ($edu) use ($formatYear) {
            $institution = $edu['institution'] ?? $edu['school'] ?? null;
            $degree      = $edu['degree'] ?? null;
            $field       = $edu['field'] ?? null;

            $loc = collect([$edu['city'] ?? null, $edu['country'] ?? null])
                ->filter(fn ($i) => is_string($i) && trim($i) !== '')
                ->map(fn ($i) => trim($i))
                ->implode(', ');
            $loc = $loc !== '' ? $loc : null;

            $start  = $formatYear($edu['start_year'] ?? $edu['from'] ?? null);
            $end    = $formatYear($edu['end_year']   ?? $edu['to']   ?? null);
            $period = collect([$start, $end])->filter()->implode(' – ');

            return [
                'institution' => $institution,
                'degree'      => $degree,
                'field'       => $field,
                'location'    => $loc,
                'start'       => $start,
                'end'         => $end,
                'period'      => $period !== '' ? $period : null,
            ];
        })->filter(fn ($i) => ($i['institution'] ?? null) || ($i['degree'] ?? null) || ($i['field'] ?? null))
          ->values();

        // Skills (accepts array of strings or objects with name/title)
        $skillsItems = collect($value('skills', []))
            ->map(function ($item) {
                if (is_string($item)) return trim($item);
                if (is_array($item)) {
                    $label = $item['name'] ?? $item['title'] ?? null;
                    return is_string($label) ? trim($label) : null;
                }
                return null;
            })
            ->filter(fn ($s) => is_string($s) && $s !== '')
            ->values();

        // Languages (string or {name, level})
        $languageItems = collect($value('languages', []))
            ->map(function ($item) {
                if (is_string($item)) {
                    return ['name' => trim($item), 'level' => null];
                }
                if (is_array($item)) {
                    $name  = isset($item['name'])  ? trim((string) $item['name'])  : null;
                    $level = isset($item['level']) ? trim((string) $item['level']) : null;
                    if ($name === '')  $name  = null;
                    if ($level === '') $level = null;
                    return $name ? ['name' => $name, 'level' => $level] : null;
                }
                return null;
            })
            ->filter()
            ->values();

        // Hobbies (string or {name/title})
        $hobbyItems = collect($value('hobbies', []))
            ->map(function ($item) {
                if (is_string($item)) return trim($item);
                if (is_array($item)) {
                    $label = $item['name'] ?? $item['title'] ?? null;
                    return is_string($label) ? trim($label) : null;
                }
                return null;
            })
            ->filter(fn ($h) => is_string($h) && $h !== '')
            ->values();

        // Profile image (url or storage path)
        $profileImage = $value('profile_image');
        if (is_string($profileImage) && trim($profileImage) !== '') {
            $profileImage = trim($profileImage);
            if (!filter_var($profileImage, FILTER_VALIDATE_URL)) {
                try {
                    $profileImage = \Illuminate\Support\Facades\Storage::disk('public')->url($profileImage);
                } catch (\Throwable $e) {
                    $profileImage = null;
                }
            }
        } else {
            $profileImage = null;
        }

        // Final data bag for the view
        $templateData = [
            'name'         => $fullName,
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'headline'     => is_string($headline) && trim($headline) !== '' ? trim($headline) : null,
            'summary'      => is_string($summary)  && trim($summary)  !== '' ? trim($summary)  : null,
            'email'        => $email,
            'phone'        => $phone,
            'website'      => $website,
            'location'     => $location,
            'birthday'     => $birthdayFormatted,
            'contacts'     => array_values(array_filter([
                $email,
                $phone,
                $location,
                $birthdayFormatted,
                $website,
            ], fn ($i) => is_string($i) && trim($i) !== '')),
            'profile_image'=> $profileImage,
            'experiences'  => $experienceItems->all(),
            'education'    => $educationItems->all(),
            'skills'       => $skillsItems->all(),
            'languages'    => $languageItems->all(),
            'hobbies'      => $hobbyItems->all(),
            'template'     => $value('template'),
        ];

        $data = $templateData; // alias used below
    @endphp

    <div class="page">
        <header>
            <div>
                <span class="badge">{{ __('Classic Resume') }}</span>
                <h1>{{ $data['name'] ?? __('Your Name') }}</h1>

                @if (!empty($data['headline'] ?? null))
                    <p>{{ $data['headline'] }}</p>
                @endif
            </div>

            <div class="contact">
                @foreach (($data['contacts'] ?? []) as $contact)
                    <div>{{ $contact }}</div>
                @endforeach
            </div>
        </header>

        <div class="layout">
            <aside class="sidebar">
                @if (!empty($data['profile_image'] ?? null))
                    <div class="profile-image">
                        <img src="{{ $data['profile_image'] }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    </div>
                @endif

                @if (!empty($data['summary'] ?? null))
                    <div class="section">
                        <h2>{{ __('Profile') }}</h2>
                        <div class="summary">{{ $data['summary'] }}</div>
                    </div>
                @endif

                @if (!empty($data['skills'] ?? []))
                    <div class="section">
                        <h2>{{ __('Skills') }}</h2>
                        <ul>
                            @foreach (($data['skills'] ?? []) as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!empty($data['languages'] ?? []))
                    <div class="section">
                        <h2>{{ __('Languages') }}</h2>
                        <ul>
                            @foreach (($data['languages'] ?? []) as $language)
                                <li>
                                    {{ $language['name'] ?? '' }}
                                    @if (!empty($language['level'] ?? null))
                                        <span class="meta">&mdash; {{ ucfirst($language['level']) }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!empty($data['hobbies'] ?? []))
                    <div class="section">
                        <h2>{{ __('Interests') }}</h2>
                        <ul>
                            @foreach (($data['hobbies'] ?? []) as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>

            <main>
                @if (!empty($data['experiences'] ?? []))
                    <div class="section">
                        <h2>{{ __('Experience') }}</h2>

                        @foreach (($data['experiences'] ?? []) as $experience)
                            <div class="item">
                                @if (!empty($experience['role'] ?? null))
                                    <h3>{{ $experience['role'] }}</h3>
                                @endif

                                <div class="meta">
                                    {{ $experience['company'] ?? '' }}
                                    @if (!empty(($experience['company'] ?? null)) && !empty(($experience['location'] ?? null)))
                                        &middot;
                                    @endif
                                    {{ $experience['location'] ?? '' }}
                                </div>

                                @if (!empty($experience['period'] ?? null))
                                    <div class="meta">{{ $experience['period'] }}</div>
                                @endif

                                @if (!empty($experience['summary'] ?? null))
                                    <p class="meta experience-summary">{{ $experience['summary'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (!empty($data['education'] ?? []))
                    <div class="divider"></div>

                    <div class="section">
                        <h2>{{ __('Education') }}</h2>

                        @foreach (($data['education'] ?? []) as $education)
                            <div class="item">
                                @if (!empty($education['degree'] ?? null))
                                    <h3>{{ $education['degree'] }}</h3>
                                @endif

                                <div class="meta">
                                    {{ $education['institution'] ?? '' }}
                                    @if (!empty(($education['institution'] ?? null)) && !empty(($education['location'] ?? null)))
                                        &middot;
                                    @endif
                                    {{ $education['location'] ?? '' }}
                                </div>

                                @if (!empty($education['period'] ?? null))
                                    <div class="meta">{{ $education['period'] }}</div>
                                @endif

                                @if (!empty($education['field'] ?? null))
                                    <div class="meta education-field">{{ $education['field'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>
