<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?: 'CV' }}</title>
    <style>
        @page { margin: 36px; }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', 'DejaVu Sans', sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
        }
        h1, h2, h3 { margin: 0; }
        h1 {
            font-size: 24px;
            letter-spacing: 0.03em;
            margin-bottom: 4px;
        }
        h2 {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: {{ $accentColor ?? '#1e293b' }};
            margin-bottom: 10px;
        }
        h3 {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }
        p { margin: 0; }
        .wrapper { width: 100%; }
        .header {
            border-bottom: 2px solid {{ $accentColor ?? '#1e293b' }};
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .contact {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 11px;
            color: #4b5563;
        }
        .badge {
            font-size: 10px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: #6b7280;
        }
        .section { margin-bottom: 24px; }
        .item { margin-bottom: 16px; }
        .item:last-child { margin-bottom: 0; }
        .item-meta { font-size: 11px; color: #4b5563; margin-top: 2px; }
        .item-description { font-size: 11px; color: #334155; margin-top: 6px; }
        .template-card {
            border: 1px solid rgba(148, 163, 184, 0.4);
            border-radius: 12px;
            padding: 12px;
            margin-top: 12px;
            background: linear-gradient(135deg, rgba(148, 163, 184, 0.1), rgba(226, 232, 240, 0.4));
        }
        .template-card-title {
            font-size: 11px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
@php
    $fullName = trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''));
    $email = $data['email'] ?? null;
    $phone = $data['phone'] ?? null;
    $city = $data['city'] ?? null;
    $country = $data['country'] ?? null;
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

    $experienceData = $data['experience'] ?? $data['work_experience'] ?? [];
    if ($experienceData && !is_array($experienceData)) {
        $experienceData = (array) $experienceData;
    }
    if (is_array($experienceData) && array_keys($experienceData) !== range(0, count($experienceData) - 1)) {
        $experienceData = [$experienceData];
    }
    $experienceData = array_values(array_filter($experienceData, fn ($item) => is_array($item)));

    $educationData = $data['education'] ?? [];
    if ($educationData && !is_array($educationData)) {
        $educationData = (array) $educationData;
    }
    if (is_array($educationData) && array_keys($educationData) !== range(0, count($educationData) - 1)) {
        $educationData = [$educationData];
    }
    $educationData = array_values(array_filter($educationData, fn ($item) => is_array($item)));

    $hobbiesData = $data['hobbies'] ?? [];
    if ($hobbiesData && !is_array($hobbiesData)) {
        $hobbiesData = (array) $hobbiesData;
    }
    $hobbiesData = array_values(array_filter($hobbiesData, fn ($item) => is_string($item) && trim($item) !== ''));

    $templateKey = $template ?? ($data['template'] ?? 'classic');
    $templateLabel = ucfirst($templateKey);
@endphp
<div class="wrapper">
    <header class="header">
        <span class="badge">{{ strtoupper($templateLabel) }}</span>
        <h1>{{ $fullName ?: 'Curriculum Vitae' }}</h1>
        <div class="contact">
            @if ($email)
                <span>{{ $email }}</span>
            @endif
            @if ($phone)
                <span>{{ $phone }}</span>
            @endif
            @if ($location)
                <span>{{ $location }}</span>
            @endif
            @if ($birthdayFormatted)
                <span>{{ $birthdayFormatted }}</span>
            @endif
        </div>
    </header>

    @if (!empty($experienceData))
        <section class="section">
            <h2>Experience</h2>
            @foreach ($experienceData as $experience)
                @php
                    $position = $experience['position'] ?? null;
                    $company = $experience['company'] ?? null;
                    $experienceLocation = trim(collect([$experience['city'] ?? null, $experience['country'] ?? null])->filter()->join(', '));
                    $from = $experience['from'] ?? null;
                    $to = $experience['to'] ?? null;
                    $fromLabel = $from;
                    $toLabel = $to;

                    try {
                        if ($from) {
                            $fromLabel = \Illuminate\Support\Carbon::createFromFormat('Y-m', $from)->format('M Y');
                        }
                    } catch (\Throwable $exception) {
                        $fromLabel = $from;
                    }

                    try {
                        if ($to) {
                            $toLabel = \Illuminate\Support\Carbon::createFromFormat('Y-m', $to)->format('M Y');
                        }
                    } catch (\Throwable $exception) {
                        $toLabel = $to;
                    }

                    $isCurrent = !empty($experience['currently']);
                    $achievements = $experience['achievements'] ?? null;
                @endphp
                <div class="item">
                    @if ($position)
                        <h3>{{ $position }}</h3>
                    @endif
                    <p class="item-meta">
                        {{ $company ?: '' }}
                        @if ($company && $experienceLocation)
                            &middot;
                        @endif
                        {{ $experienceLocation }}
                    </p>
                    @if ($fromLabel || $toLabel || $isCurrent)
                        <p class="item-meta">
                            {{ $fromLabel ?: 'Unknown' }} &ndash; {{ $isCurrent ? 'Present' : ($toLabel ?: 'Unknown') }}
                        </p>
                    @endif
                    @if ($achievements)
                        <p class="item-description">{{ $achievements }}</p>
                    @endif
                </div>
            @endforeach
        </section>
    @endif

    @if (!empty($educationData))
        <section class="section">
            <h2>Education</h2>
            @foreach ($educationData as $education)
                @php
                    $institution = $education['institution'] ?? $education['school'] ?? null;
                    $degree = $education['degree'] ?? null;
                    $field = $education['field'] ?? null;
                    $start = $education['start_year'] ?? null;
                    $end = $education['end_year'] ?? null;
                @endphp
                <div class="item">
                    @if ($institution)
                        <h3>{{ $institution }}</h3>
                    @endif
                    <p class="item-meta">{{ collect([$degree, $field])->filter()->join(' · ') }}</p>
                    @if ($start || $end)
                        <p class="item-meta">{{ $start }} &ndash; {{ $end ?: 'Ongoing' }}</p>
                    @endif
                </div>
            @endforeach
        </section>
    @endif

    @if (!empty($hobbiesData))
        <section class="section">
            <h2>Hobbies &amp; Interests</h2>
            <ul style="margin: 0; padding-left: 18px; list-style: disc; color: #475569;">
                @foreach ($hobbiesData as $hobby)
                    <li style="margin-bottom:6px;">{{ $hobby }}</li>
                @endforeach
            </ul>
        </section>
    @endif

    <section class="section">
        <h2>Summary</h2>
        <div class="template-card">
            <div class="template-card-title">{{ $templateLabel }} Template</div>
            <p style="font-size:11px; color:#475569;">This PDF was generated using the {{ strtolower($templateLabel) }} layout. Return to the builder to switch styles or refresh your details before exporting again.</p>
        </div>
    </section>
</div>
</body>
</html>
