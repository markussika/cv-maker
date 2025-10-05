<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?: 'CV' }}</title>
    <style>
        @page { margin: 36px; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #111827;
        }
        h1, h2, h3, h4 { margin: 0; }
        p { margin: 0; }
        ul { margin: 0; padding: 0; list-style: none; }
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
    </style>
</head>
<body class="template-{{ $template ?? 'classic' }}">
@php
    $availableTemplates = $availableTemplates ?? ['classic', 'modern', 'creative', 'minimal', 'elegant', 'corporate', 'gradient', 'darkmode', 'futuristic'];
    $templateKey = in_array($template ?? '', $availableTemplates, true) ? $template : 'classic';

    $fullName = trim((string) (($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')));
    $initials = collect([
            $data['first_name'] ?? null,
            $data['last_name'] ?? null,
        ])
        ->filter(fn ($item) => is_string($item) && trim($item) !== '')
        ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
        ->implode('');

    if ($initials === '' && $fullName !== '') {
        $initials = collect(preg_split('/\s+/u', $fullName))
            ->filter(fn ($segment) => is_string($segment) && trim($segment) !== '')
            ->map(fn ($segment) => mb_strtoupper(mb_substr(trim($segment), 0, 1)))
            ->take(2)
            ->implode('');
    }

    $initials = $initials !== '' ? $initials : null;
    $headline = trim((string) ($data['headline'] ?? '')) ?: null;
    $summary = trim((string) ($data['summary'] ?? '')) ?: null;

    $email = trim((string) ($data['email'] ?? '')) ?: null;
    $phone = trim((string) ($data['phone'] ?? '')) ?: null;
    $city = trim((string) ($data['city'] ?? '')) ?: null;
    $country = trim((string) ($data['country'] ?? '')) ?: null;
    $website = trim((string) ($data['website'] ?? '')) ?: null;
    $linkedin = trim((string) ($data['linkedin'] ?? '')) ?: null;
    $github = trim((string) ($data['github'] ?? '')) ?: null;

    $location = trim(collect([$city, $country])->filter()->join(', '));

    $birthday = $data['birthday'] ?? null;
    $birthdayFormatted = null;
    if (!empty($birthday)) {
        try {
            $birthdayFormatted = \Illuminate\Support\Carbon::parse($birthday)->format('F j, Y');
        } catch (\Throwable $exception) {
            $birthdayFormatted = $birthday;
        }
    }

    $contactItems = collect([
        $headline,
        $email,
        $phone,
        $location ?: null,
        $birthdayFormatted,
        $website,
        $linkedin,
        $github,
    ])->filter()->values()->all();

    $formatMonth = function (?string $value) {
        $value = trim((string) ($value ?? ''));
        if ($value === '') {
            return null;
        }

        try {
            return \Illuminate\Support\Carbon::createFromFormat('Y-m', $value)->format('M Y');
        } catch (\Throwable $exception) {
            return $value;
        }
    };

    $experienceRaw = $data['experience'] ?? $data['work_experience'] ?? [];
    if ($experienceRaw && !is_array($experienceRaw)) {
        $experienceRaw = (array) $experienceRaw;
    }
    if (is_array($experienceRaw) && array_keys($experienceRaw) !== range(0, count($experienceRaw) - 1)) {
        $experienceRaw = [$experienceRaw];
    }

    $experienceItems = collect($experienceRaw)
        ->filter(fn ($item) => is_array($item))
        ->map(function (array $item) use ($formatMonth) {
            $position = trim((string) ($item['position'] ?? '')) ?: null;
            $company = trim((string) ($item['company'] ?? '')) ?: null;
            $city = trim((string) ($item['city'] ?? '')) ?: null;
            $country = trim((string) ($item['country'] ?? '')) ?: null;
            $location = trim(collect([$city, $country])->filter()->join(', '));
            $from = $formatMonth($item['from'] ?? null);
            $to = $formatMonth($item['to'] ?? null);
            $isCurrent = !empty($item['currently']);
            $achievements = trim((string) ($item['achievements'] ?? '')) ?: null;

            return [
                'position' => $position,
                'company' => $company,
                'location' => $location,
                'from' => $from,
                'to' => $isCurrent ? 'Present' : ($to ?: null),
                'is_current' => $isCurrent,
                'achievements' => $achievements,
            ];
        })
        ->filter(function (array $item) {
            return $item['position'] || $item['company'] || $item['achievements'];
        })
        ->values()
        ->all();

    $educationRaw = $data['education'] ?? [];
    if ($educationRaw && !is_array($educationRaw)) {
        $educationRaw = (array) $educationRaw;
    }
    if (is_array($educationRaw) && array_keys($educationRaw) !== range(0, count($educationRaw) - 1)) {
        $educationRaw = [$educationRaw];
    }

    $educationItems = collect($educationRaw)
        ->filter(fn ($item) => is_array($item))
        ->map(function (array $item) {
            $institution = trim((string) ($item['institution'] ?? $item['school'] ?? '')) ?: null;
            $degree = trim((string) ($item['degree'] ?? '')) ?: null;
            $field = trim((string) ($item['field'] ?? '')) ?: null;
            $city = trim((string) ($item['city'] ?? '')) ?: null;
            $country = trim((string) ($item['country'] ?? '')) ?: null;
            $location = trim(collect([$city, $country])->filter()->join(', '));
            $start = trim((string) ($item['start_year'] ?? '')) ?: null;
            $end = trim((string) ($item['end_year'] ?? '')) ?: null;

            return [
                'institution' => $institution,
                'degree' => $degree,
                'field' => $field,
                'location' => $location,
                'start' => $start,
                'end' => $end,
            ];
        })
        ->filter(function (array $item) {
            return $item['institution'] || $item['degree'] || $item['field'];
        })
        ->values()
        ->all();

    $skills = collect($data['skills'] ?? [])
        ->filter(fn ($skill) => is_string($skill) && trim($skill) !== '')
        ->map(fn ($skill) => trim($skill))
        ->values()
        ->all();

    $languages = collect($data['languages'] ?? [])
        ->filter(fn ($language) => is_array($language) && !empty($language['name']))
        ->map(function (array $language) {
            return [
                'name' => trim((string) $language['name']),
                'level' => trim((string) ($language['level'] ?? '')) ?: null,
            ];
        })
        ->values()
        ->all();

    $hobbies = collect($data['hobbies'] ?? [])
        ->filter(fn ($hobby) => is_string($hobby) && trim($hobby) !== '')
        ->map(fn ($hobby) => trim($hobby))
        ->values()
        ->all();

    $profileImage = null;
    $profileImageFilesystemPath = null;
    if (!empty($data['profile_image']) && is_string($data['profile_image'])) {
        $candidate = trim((string) $data['profile_image']);
        if ($candidate !== '') {
            $profileImage = $candidate;

            $isDataUri = str_starts_with($candidate, 'data:');
            $isAbsolute = filter_var($candidate, FILTER_VALIDATE_URL) !== false;

            $storageCandidate = $candidate;
            if ($isAbsolute) {
                $urlPath = parse_url($candidate, PHP_URL_PATH);
                if (is_string($urlPath) && $urlPath !== '') {
                    $storageCandidate = $urlPath;
                }
            }

            $storageCandidate = preg_replace('#^/?storage/#', '', (string) $storageCandidate);
            $storagePath = ltrim((string) $storageCandidate, '/');

            if (! $isDataUri) {
                try {
                    if ($storagePath !== '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                        $profileImageFilesystemPath = \Illuminate\Support\Facades\Storage::disk('public')->path($storagePath);
                        $profileImage = \Illuminate\Support\Facades\Storage::disk('public')->url($storagePath);
                    } elseif (! $isAbsolute && \Illuminate\Support\Facades\Storage::disk('public')->exists(ltrim($candidate, '/'))) {
                        $relativePath = ltrim($candidate, '/');
                        $profileImageFilesystemPath = \Illuminate\Support\Facades\Storage::disk('public')->path($relativePath);
                        $profileImage = \Illuminate\Support\Facades\Storage::disk('public')->url($relativePath);
                    }
                } catch (\Throwable $exception) {
                    $profileImageFilesystemPath = null;
                }
            }

            if (! $isDataUri && $profileImage && $profileImageFilesystemPath && is_readable($profileImageFilesystemPath)) {
                try {
                    $contents = @file_get_contents($profileImageFilesystemPath);
                    if ($contents !== false) {
                        $mimeType = @mime_content_type($profileImageFilesystemPath) ?: 'image/png';
                        $profileImage = 'data:' . $mimeType . ';base64,' . base64_encode($contents);
                    }
                } catch (\Throwable $exception) {
                    // keep the resolved URL fallback
                }
            }
        }
    }

    $summaryParagraphs = collect(preg_split('/\r\n|\r|\n/', (string) ($summary ?? '')))
        ->map(fn ($line) => trim((string) $line))
        ->filter()
        ->values();

    $achievementLines = function ($text) {
        return collect(preg_split('/\r\n|\r|\n|•|‣|▪|\x{2022}|\x{25CF}|\x{25CB}|\x{25AA}|\x{25AB}|\x{25A0}|\x{25A1}|\x{2023}|\x{2043}|\-/u', (string) ($text ?? '')))
            ->map(function ($line) {
                $line = trim((string) $line);
                if ($line === '') {
                    return null;
                }

                $line = preg_replace('/^[\p{Pd}\s•‣▪\x{2022}\x{25CF}\x{25CB}\x{25AA}\x{25AB}\x{25A0}\x{25A1}\x{2023}\x{2043}]+/u', '', $line);

                return trim((string) $line);
            })
            ->filter()
            ->values();
    };

    $experienceBlocks = collect($experienceItems ?? [])
        ->map(function ($item) use ($achievementLines) {
            if (!is_array($item)) {
                $item = (array) $item;
            }

            $item['bullets'] = $achievementLines($item['achievements'] ?? null);

            return $item;
        })
        ->filter(function ($item) {
            return !empty($item['position']) || !empty($item['company']) || !empty($item['achievements']);
        })
        ->values();

    $educationBlocks = collect($educationItems ?? [])
        ->map(function ($item) {
            if (!is_array($item)) {
                $item = (array) $item;
            }

            return $item;
        })
        ->filter(function ($item) {
            return !empty($item['institution']) || !empty($item['degree']) || !empty($item['field']);
        })
        ->values();

    $skillTags = collect($skills ?? [])
        ->map(fn ($item) => trim((string) $item))
        ->filter()
        ->values();

    $languageItems = collect($languages ?? [])
        ->map(function ($item) {
            if (!is_array($item)) {
                $item = (array) $item;
            }

            $name = trim((string) ($item['name'] ?? ($item[0] ?? '')));
            $level = trim((string) ($item['level'] ?? ($item[1] ?? '')));

            return [
                'name' => $name,
                'level' => $level,
            ];
        })
        ->filter(fn ($item) => $item['name'] !== '')
        ->values();

    $hobbyItems = collect($hobbies ?? [])
        ->map(fn ($item) => trim((string) $item))
        ->filter()
        ->values();
@endphp

@include('cv.pdf.templates.' . $templateKey, [
    'fullName' => $fullName,
    'headline' => $headline,
    'contactItems' => $contactItems,
    'summary' => $summary,
    'summaryParagraphs' => $summaryParagraphs,
    'experienceItems' => $experienceItems,
    'experienceBlocks' => $experienceBlocks,
    'educationItems' => $educationItems,
    'educationBlocks' => $educationBlocks,
    'skills' => $skills,
    'skillTags' => $skillTags,
    'languages' => $languages,
    'languageItems' => $languageItems,
    'hobbies' => $hobbies,
    'hobbyItems' => $hobbyItems,
    'profileImage' => $profileImage,
    'initials' => $initials,
    'accentColor' => $accentColor ?? '#1e293b',
    'templateKey' => $templateKey,
])

</body>
</html>
