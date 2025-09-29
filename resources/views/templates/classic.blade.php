<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classic · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/classic.css') }}">
</head>
<body class="classic-template">
    @php
        $templateData = \App\View\TemplateDataBuilder::fromCv($cv ?? null);
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
        $summaryText = is_string($data['summary'] ?? null) ? trim((string) $data['summary']) : null;
        $summaryParagraphs = $summaryText !== null
            ? collect(preg_split('/\r\n|\r|\n/', $summaryText))->map(fn ($line) => trim($line))->filter()
            : collect();
        $headline = $data['headline'] ?? null;
        $tagline = is_string($headline) && trim($headline) !== '' ? trim($headline) : null;
        if (!$tagline && $summaryText) {
            $sentenceSplit = preg_split('/(?<=[.!?])\s+/', $summaryText);
            if (is_array($sentenceSplit) && isset($sentenceSplit[0])) {
                $taglineCandidate = trim($sentenceSplit[0]);
                if ($taglineCandidate !== '') {
                    $tagline = $taglineCandidate;
                }
            }
        }
        $achievementLines = collect($data['experiences'] ?? [])
            ->pluck('summary')
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->flatMap(function ($summary) {
                $segments = preg_split('/\r\n|\r|\n|•/', $summary);
                if (!is_array($segments)) {
                    $segments = [$summary];
                }

                return collect($segments)
                    ->map(fn ($line) => trim(ltrim($line, "-•\t ")))
                    ->filter();
            })
            ->unique()
            ->values();
        if ($achievementLines->isEmpty() && $summaryText) {
            $achievementLines = collect(preg_split('/(?<=[.!?])\s+/', $summaryText))
                ->map(fn ($line) => trim($line))
                ->filter()
                ->take(4)
                ->values();
        } else {
            $achievementLines = $achievementLines->take(6);
        }
        $hasSecondaryColumn = !empty($data['skills']) || !empty($data['languages']) || !empty($data['hobbies']);
    @endphp

    <div class="page">
        <header class="page-header">
            <div class="header-main">
                @if ($profileImage || $initials !== '')
                    <div class="portrait">
                        @if ($profileImage)
                            <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                        @elseif ($initials !== '')
                            <span>{{ $initials }}</span>
                        @else
                            <span>{{ __('CV') }}</span>
                        @endif
                    </div>
                @endif
                <div class="hero-text">
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($tagline)
                        <p class="headline">{{ $tagline }}</p>
                    @endif
                </div>
            </div>
            @if (!empty($data['contacts']))
                <div class="contact">
                    @foreach ($data['contacts'] as $contact)
                        <span>{{ $contact }}</span>
                    @endforeach
                </div>
            @endif
        </header>

        <div class="page-body">
            @if ($achievementLines->isNotEmpty() || $summaryParagraphs->isNotEmpty())
                <div class="intro-block">
                    @if ($achievementLines->isNotEmpty())
                        <section class="section achievements">
                            <h2>{{ __('Key Achievements') }}</h2>
                            <ul class="achievements-list">
                                @foreach ($achievementLines as $line)
                                    <li>{{ $line }}</li>
                                @endforeach
                            </ul>
                        </section>
                    @endif

                    @if ($summaryParagraphs->isNotEmpty())
                        <section class="section summary-block">
                            <h2>{{ __('Taking On Challenges') }}</h2>
                            <div class="summary-text">
                                @foreach ($summaryParagraphs as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>
            @endif

            <div class="content-grid {{ $hasSecondaryColumn ? 'two-columns' : 'single-column' }}">
                <div class="primary-column">
                    @if (!empty($data['education']))
                        <section class="section education">
                            <h2>{{ __('Education') }}</h2>
                            <div class="entries">
                                @foreach ($data['education'] as $education)
                                    <article class="entry">
                                        <div class="entry-heading">
                                            <div>
                                                @if ($education['degree'])
                                                    <h3>{{ $education['degree'] }}</h3>
                                                @endif
                                                @if ($education['institution'])
                                                    <div class="entry-subtitle">{{ $education['institution'] }}</div>
                                                @endif
                                                @if ($education['location'])
                                                    <div class="entry-location">{{ $education['location'] }}</div>
                                                @endif
                                            </div>
                                            @if ($education['period'])
                                                <div class="entry-period">{{ $education['period'] }}</div>
                                            @endif
                                        </div>
                                        @if ($education['field'])
                                            <div class="entry-meta-line">{{ $education['field'] }}</div>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if (!empty($data['experiences']))
                        <section class="section experience">
                            <h2>{{ __('Experience') }}</h2>
                            <div class="entries">
                                @foreach ($data['experiences'] as $experience)
                                    <article class="entry">
                                        <div class="entry-heading">
                                            <div>
                                                @if ($experience['role'])
                                                    <h3>{{ $experience['role'] }}</h3>
                                                @endif
                                                <div class="entry-subtitle">
                                                    {{ collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter()->implode(' · ') }}
                                                </div>
                                            </div>
                                            @if ($experience['period'])
                                                <div class="entry-period">{{ $experience['period'] }}</div>
                                            @endif
                                        </div>

                                        @php
                                            $experienceSummary = $experience['summary'] ?? null;
                                            $summaryPoints = collect();
                                            if (is_string($experienceSummary) && trim($experienceSummary) !== '') {
                                                $summaryPoints = collect(preg_split('/\r\n|\r|\n|•/', $experienceSummary))
                                                    ->map(fn ($item) => trim(ltrim($item, "-•\t ")))
                                                    ->filter();
                                            }
                                        @endphp

                                        @if ($summaryPoints->count() > 1)
                                            <ul class="entry-points">
                                                @foreach ($summaryPoints as $point)
                                                    <li>{{ $point }}</li>
                                                @endforeach
                                            </ul>
                                        @elseif ($summaryPoints->count() === 1)
                                            <p class="entry-description">{{ $summaryPoints->first() }}</p>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                @if ($hasSecondaryColumn)
                    <aside class="secondary-column">
                        @if (!empty($data['skills']))
                            <section class="section skills">
                                <h2>{{ __('Technical Skills') }}</h2>
                                <ul class="skills-list">
                                    @foreach ($data['skills'] as $skill)
                                        <li>{{ $skill }}</li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif

                        @if (!empty($data['languages']))
                            <section class="section languages">
                                <h2>{{ __('Languages') }}</h2>
                                <ul class="languages-list">
                                    @foreach ($data['languages'] as $language)
                                        <li>
                                            <span>{{ $language['name'] }}</span>
                                            @if (!empty($language['level']))
                                                <span class="language-level">{{ ucfirst($language['level']) }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif

                        @if (!empty($data['hobbies']))
                            <section class="section interests">
                                <h2>{{ __('Interests') }}</h2>
                                <ul class="tag-list">
                                    @foreach ($data['hobbies'] as $hobby)
                                        <li>{{ $hobby }}</li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    </aside>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
