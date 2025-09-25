@php
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Storage;
    use Throwable;

    $value = fn(string $key, $default = null) => data_get($cv, $key, $default);

    $firstName = $value('first_name');
    $lastName = $value('last_name');
    $fullName = collect([$firstName, $lastName])
        ->filter(fn ($item) => is_string($item) && trim($item) !== '')
        ->map(fn ($item) => trim($item))
        ->implode(' ');
    $fullName = $fullName !== '' ? $fullName : null;

    $headline = $value('headline') ?? $value('title');
    $summary = $value('summary') ?? $value('about');

    $email = $value('email');
    $phone = $value('phone');
    $website = $value('website');
    $profileImage = $value('profile_image');
    $city = $value('city');
    $country = $value('country');
    $location = collect([$city, $country])
        ->filter(fn ($item) => is_string($item) && trim($item) !== '')
        ->map(fn ($item) => trim($item))
        ->implode(', ');
    $location = $location !== '' ? $location : null;

    $birthdayRaw = $value('birthday');
    $birthdayFormatted = null;
    if ($birthdayRaw instanceof Carbon) {
        $birthdayFormatted = $birthdayRaw->translatedFormat('F j, Y');
    } elseif (is_string($birthdayRaw) && trim($birthdayRaw) !== '') {
        try {
            $birthdayFormatted = Carbon::parse($birthdayRaw)->translatedFormat('F j, Y');
        } catch (Throwable $exception) {
            $birthdayFormatted = $birthdayRaw;
        }
    }

    $formatMonthYear = function ($value) {
        if (!is_string($value) || trim($value) === '') {
            return null;
        }

        $value = trim($value);

        try {
            if (preg_match('/^\d{4}-\d{2}$/', $value)) {
                return Carbon::createFromFormat('Y-m', $value)->translatedFormat('M Y');
            }

            return Carbon::parse($value)->translatedFormat('M Y');
        } catch (Throwable $exception) {
            return $value;
        }
    };

    $formatYear = function ($value) use ($formatMonthYear) {
        if (!is_string($value) || trim($value) === '') {
            return null;
        }

        $value = trim($value);

        try {
            if (preg_match('/^\d{4}$/', $value)) {
                return Carbon::createFromFormat('Y', $value)->translatedFormat('Y');
            }

            return $formatMonthYear($value);
        } catch (Throwable $exception) {
            return $value;
        }
    };

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
        if ($collection->isEmpty()) {
            return collect();
        }

        if ($collection->isAssoc()) {
            $collection = collect([$collection->all()]);
        }

        return $collection
            ->map(function ($item) {
                if ($item instanceof \Illuminate\Support\Collection) {
                    return $item->toArray();
                }

                if (is_object($item)) {
                    return collect(get_object_vars($item))->toArray();
                }

                return is_array($item) ? $item : [];
            })
            ->filter(fn ($item) => !empty(array_filter($item, fn ($value) => is_array($value) ? !empty($value) : trim((string) $value) !== '')))
            ->values();
    };

    $experienceItems = $normaliseCollection($value('work_experience', $value('experience', [])))->map(function ($experience) use ($formatMonthYear) {
        $role = $experience['position'] ?? $experience['role'] ?? null;
        $company = $experience['company'] ?? null;
        $location = collect([
            $experience['city'] ?? null,
            $experience['country'] ?? null,
        ])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => trim($item))
            ->implode(', ');
        $location = $location !== '' ? $location : null;

        $fromRaw = $experience['from'] ?? null;
        $toRaw = $experience['to'] ?? null;
        $from = $formatMonthYear($fromRaw);
        $isCurrent = !empty($experience['currently']);
        $to = $isCurrent ? __('Present') : $formatMonthYear($toRaw);
        $period = collect([$from, $to])->filter()->implode(' – ');

        $summary = $experience['achievements'] ?? $experience['description'] ?? null;

        return [
            'role' => $role,
            'company' => $company,
            'location' => $location,
            'from' => $from,
            'to' => $to,
            'from_raw' => $fromRaw,
            'to_raw' => $toRaw,
            'is_current' => $isCurrent,
            'period' => $period !== '' ? $period : null,
            'summary' => is_string($summary) && trim($summary) !== '' ? trim($summary) : null,
        ];
    })->filter(function ($item) {
        return ($item['role'] ?? null) || ($item['company'] ?? null) || ($item['summary'] ?? null);
    })->values();

    $educationItems = $normaliseCollection($value('education', []))->map(function ($education) use ($formatYear) {
        $institution = $education['institution'] ?? $education['school'] ?? null;
        $degree = $education['degree'] ?? null;
        $field = $education['field'] ?? null;
        $location = collect([
            $education['city'] ?? null,
            $education['country'] ?? null,
        ])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => trim($item))
            ->implode(', ');
        $location = $location !== '' ? $location : null;

        $start = $formatYear($education['start_year'] ?? $education['from'] ?? null);
        $end = $formatYear($education['end_year'] ?? $education['to'] ?? null);
        $period = collect([$start, $end])->filter()->implode(' – ');

        return [
            'institution' => $institution,
            'degree' => $degree,
            'field' => $field,
            'location' => $location,
            'start' => $start,
            'end' => $end,
            'period' => $period !== '' ? $period : null,
        ];
    })->filter(function ($item) {
        return ($item['institution'] ?? null) || ($item['degree'] ?? null) || ($item['field'] ?? null);
    })->values();

    $skillsItems = collect($value('skills', []))
        ->map(function ($item) {
            if (is_string($item)) {
                return trim($item);
            }

            if (is_array($item)) {
                $label = $item['name'] ?? $item['title'] ?? null;
                return is_string($label) ? trim($label) : null;
            }

            return null;
        })
        ->filter(fn ($item) => is_string($item) && $item !== '')
        ->values();

    $languageItems = collect($value('languages', []))
        ->map(function ($item) {
            if (is_string($item)) {
                return ['name' => trim($item), 'level' => null];
            }

            if (is_array($item)) {
                $name = isset($item['name']) ? trim((string) $item['name']) : null;
                $level = isset($item['level']) ? trim((string) $item['level']) : null;

                if ($name === '') {
                    $name = null;
                }

                if ($level === '') {
                    $level = null;
                }

                return $name ? ['name' => $name, 'level' => $level] : null;
            }

            return null;
        })
        ->filter()
        ->values();

    $hobbyItems = collect($value('hobbies', []))
        ->map(function ($item) {
            if (is_string($item)) {
                return trim($item);
            }

            if (is_array($item)) {
                $label = $item['name'] ?? $item['title'] ?? null;
                return is_string($label) ? trim($label) : null;
            }

            return null;
        })
        ->filter(fn ($item) => is_string($item) && $item !== '')
        ->values();

    if (is_string($profileImage) && trim($profileImage) !== '') {
        $profileImage = trim($profileImage);

        if (!filter_var($profileImage, FILTER_VALIDATE_URL)) {
            try {
                $profileImage = Storage::disk('public')->url($profileImage);
            } catch (Throwable $exception) {
                $profileImage = null;
            }
        }
    } else {
        $profileImage = null;
    }

    $templateData = [
        'name' => $fullName,
        'first_name' => $firstName,
        'last_name' => $lastName,
        'headline' => is_string($headline) && trim($headline) !== '' ? trim($headline) : null,
        'summary' => is_string($summary) && trim($summary) !== '' ? trim($summary) : null,
        'email' => $email,
        'phone' => $phone,
        'website' => $website,
        'location' => $location,
        'birthday' => $birthdayFormatted,
        'contacts' => array_values(array_filter([
            $email,
            $phone,
            $location,
            $birthdayFormatted,
            $website,
        ], fn ($item) => is_string($item) && trim($item) !== '')),
        'profile_image' => $profileImage,
        'experiences' => $experienceItems->all(),
        'education' => $educationItems->all(),
        'skills' => $skillsItems->all(),
        'languages' => $languageItems->all(),
        'hobbies' => $hobbyItems->all(),
        'template' => $value('template'),
    ];
@endphp
