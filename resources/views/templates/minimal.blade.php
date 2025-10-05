<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minimal · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/minimal.css') }}">
</head>
<body class="minimal-template">
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
    @endphp

    <div class="minimal-wrapper">
        <header class="minimal-header">
            <div class="minimal-header__inner">
                @if ($profileImage)
                    <div class="minimal-header__avatar">
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    </div>
                @elseif ($initials)
                    <div class="minimal-header__avatar minimal-header__avatar--initials">{{ $initials }}</div>
                @endif
                <div class="minimal-header__identity">
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p class="minimal-header__headline">{{ $data['headline'] }}</p>
                    @endif
                    @if (($data['location'] ?? null) || ($data['phone'] ?? null))
                        <div class="minimal-header__meta">
                            @if ($data['location'] ?? null)
                                <span>{{ $data['location'] }}</span>
                            @endif
                            @if ($data['phone'] ?? null)
                                <span>{{ $data['phone'] }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <div class="minimal-layout">
            <aside class="minimal-column minimal-column--left">
                @if (!empty($data['skills']))
                    <section class="minimal-sidebar-section">
                        <h2>{{ __('Strengths') }}</h2>
                        <ul>
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section class="minimal-sidebar-section">
                        <h2>{{ __('Languages') }}</h2>
                        <ul>
                            @foreach ($data['languages'] as $language)
                                <li>
                                    <span>{{ $language['name'] }}</span>
                                    @if (!empty($language['level']))
                                        <span class="minimal-badge">{{ ucfirst($language['level']) }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['hobbies']))
                    <section class="minimal-sidebar-section">
                        <h2>{{ __('Interests & Hobbies') }}</h2>
                        <ul class="minimal-pill-list">
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>

            <main class="minimal-column minimal-column--right">
                @if ($summaryParagraphs->isNotEmpty())
                    <section class="minimal-section minimal-section--summary">
                        <h2>{{ __('Overview') }}</h2>
                        <div class="minimal-section__body">
                            @foreach ($summaryParagraphs as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!empty($data['experiences']))
                    <section class="minimal-section">
                        <header class="minimal-section__header">
                            <h2>{{ __('Experience') }}</h2>
                            <p>{{ __('Roles, results and responsibilities in reverse chronology.') }}</p>
                        </header>
                        <div class="minimal-timeline">
                            @foreach ($data['experiences'] as $experience)
                                <article class="minimal-timeline__item">
                                    <div class="minimal-timeline__meta">
                                        @if ($experience['period'])
                                            <span class="minimal-timeline__period">{{ $experience['period'] }}</span>
                                        @endif
                                        <span class="minimal-timeline__company">{{ collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter()->implode(' · ') }}</span>
                                    </div>
                                    <div class="minimal-timeline__content">
                                        @if ($experience['role'])
                                            <h3>{{ $experience['role'] }}</h3>
                                        @endif
                                        @if ($experience['summary'])
                                            <p>{{ $experience['summary'] }}</p>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!empty($data['education']))
                    <section class="minimal-section">
                        <header class="minimal-section__header">
                            <h2>{{ __('Education') }}</h2>
                            <p>{{ __('Programmes and academic achievements.') }}</p>
                        </header>
                        <div class="minimal-education">
                            @foreach ($data['education'] as $education)
                                <article>
                                    <h3>{{ $education['institution'] }}</h3>
                                    <div class="minimal-education__details">
                                        <span>{{ collect([$education['degree'] ?? null, $education['field'] ?? null])->filter()->implode(' · ') }}</span>
                                        @if ($education['period'])
                                            <span>{{ $education['period'] }}</span>
                                        @endif
                                    </div>
                                    @if ($education['location'])
                                        <p>{{ $education['location'] }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>
        </div>
    </div>
</body>
</html>
