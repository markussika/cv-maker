<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Corporate · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/corporate.css') }}">
</head>
<body class="corporate-template">
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

    <div class="corporate-report">
        <header class="corporate-header">
            <div class="corporate-header__inner">
                @if ($profileImage)
                    <div class="corporate-avatar">
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    </div>
                @elseif ($initials)
                    <div class="corporate-avatar corporate-avatar--initials">{{ $initials }}</div>
                @endif
                <div class="corporate-header__identity">
                    <p class="corporate-label">{{ __('Executive Profile') }}</p>
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p class="corporate-headline">{{ $data['headline'] }}</p>
                    @endif
                    @if (($data['location'] ?? null) || ($data['phone'] ?? null))
                        <div class="corporate-header__meta">
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

        <div class="corporate-layout">
            <aside class="corporate-side">
                @if (!empty($data['skills']))
                    <section class="corporate-panel">
                        <h2>{{ __('Core Competencies') }}</h2>
                        <ul class="corporate-list corporate-list--chips">
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section class="corporate-panel">
                        <h2>{{ __('Languages') }}</h2>
                        <ul class="corporate-list">
                            @foreach ($data['languages'] as $language)
                                <li>
                                    <span>{{ $language['name'] }}</span>
                                    @if (!empty($language['level']))
                                        <span>{{ ucfirst($language['level']) }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['hobbies']))
                    <section class="corporate-panel">
                        <h2>{{ __('Interests') }}</h2>
                        <ul class="corporate-list corporate-list--divider">
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>

            <main class="corporate-main">
                @if ($summaryParagraphs->isNotEmpty())
                    <section class="corporate-panel corporate-panel--summary">
                        <h2>{{ __('Leadership Narrative') }}</h2>
                        <div class="corporate-panel__body">
                            @foreach ($summaryParagraphs as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!empty($data['experiences']))
                    <section class="corporate-panel">
                        <header class="corporate-panel__header">
                            <h2>{{ __('Experience Highlights') }}</h2>
                            <p>{{ __('Guiding organisations through transformation and growth.') }}</p>
                        </header>
                        <div class="corporate-milestones">
                            @foreach ($data['experiences'] as $experience)
                                <article class="corporate-milestone">
                                    <div class="corporate-milestone__meta">
                                        @if ($experience['period'])
                                            <span class="corporate-milestone__period">{{ $experience['period'] }}</span>
                                        @endif
                                        <span class="corporate-milestone__company">{{ collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter()->implode(' · ') }}</span>
                                    </div>
                                    <div class="corporate-milestone__content">
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
                    <section class="corporate-panel">
                        <h2>{{ __('Education') }}</h2>
                        <div class="corporate-education">
                            @foreach ($data['education'] as $education)
                                <article>
                                    <h3>{{ $education['institution'] }}</h3>
                                    <div class="corporate-education__meta">
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
