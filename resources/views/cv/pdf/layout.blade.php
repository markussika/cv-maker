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
    if (!empty($data['profile_image']) && is_string($data['profile_image'])) {
        $profileImage = $data['profile_image'];
    }
@endphp

@include('cv.pdf.templates.' . $templateKey, [
    'fullName' => $fullName,
    'headline' => $headline,
    'contactItems' => $contactItems,
    'summary' => $summary,
    'experienceItems' => $experienceItems,
    'educationItems' => $educationItems,
    'skills' => $skills,
    'languages' => $languages,
    'hobbies' => $hobbies,
    'profileImage' => $profileImage,
    'accentColor' => $accentColor ?? '#1e293b',
    'templateKey' => $templateKey,
])

</body>
</html>
