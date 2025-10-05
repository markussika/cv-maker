<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elegant · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/elegant.css') }}">
</head>
<body class="elegant-template">
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

    <div class="elegant-document">
        <header class="elegant-hero">
            <div class="elegant-hero__identity">
                @if ($profileImage)
                    <figure class="elegant-avatar">
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    </figure>
                @elseif ($initials)
                    <figure class="elegant-avatar elegant-avatar--initials">{{ $initials }}</figure>
                @endif
                <div>
                    <p class="elegant-label">{{ __('Curriculum Vitae') }}</p>
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p class="elegant-headline">{{ $data['headline'] }}</p>
                    @endif
                </div>
            </div>

            @if (!empty($data['contacts']))
                <div class="elegant-hero__contact">
                    @foreach ($data['contacts'] as $contact)
                        <span>{{ $contact }}</span>
                    @endforeach
                </div>
            @endif
        </header>

        <div class="elegant-body">
            <main class="elegant-primary">
                @if ($summaryParagraphs->isNotEmpty())
                    <section class="elegant-card elegant-summary">
                        <h2>{{ __('Profile Summary') }}</h2>
                        <div class="elegant-summary__text">
                            @foreach ($summaryParagraphs as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!empty($data['experiences']))
                    <section class="elegant-card">
                        <header class="elegant-section-header">
                            <h2>{{ __('Professional Journey') }}</h2>
                            <p>{{ __('Selected roles and achievements delivered with poise.') }}</p>
                        </header>
                        <div class="elegant-journey">
                            @foreach ($data['experiences'] as $experience)
                                <article class="elegant-journey__item">
                                    <div class="elegant-journey__period">
                                        @if ($experience['period'])
                                            <span>{{ $experience['period'] }}</span>
                                        @endif
                                    </div>
                                    <div class="elegant-journey__details">
                                        <h3>{{ $experience['role'] }}</h3>
                                        <div class="elegant-journey__meta">
                                            {{ collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter()->implode(' · ') }}
                                        </div>
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
                    <section class="elegant-card">
                        <header class="elegant-section-header">
                            <h2>{{ __('Education & Training') }}</h2>
                            <p>{{ __('Academic and professional development milestones.') }}</p>
                        </header>
                        <div class="elegant-education">
                            @foreach ($data['education'] as $education)
                                <article>
                                    <div class="elegant-education__header">
                                        <h3>{{ $education['institution'] }}</h3>
                                        @if ($education['period'])
                                            <span>{{ $education['period'] }}</span>
                                        @endif
                                    </div>
                                    <p class="elegant-education__role">{{ collect([$education['degree'] ?? null, $education['field'] ?? null])->filter()->implode(' · ') }}</p>
                                    @if ($education['location'])
                                        <p class="elegant-education__location">{{ $education['location'] }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>

            <aside class="elegant-secondary">
                @if (!empty($data['skills']))
                    <section class="elegant-aside-card">
                        <h2>{{ __('Competencies') }}</h2>
                        <ul class="elegant-tag-list">
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section class="elegant-aside-card">
                        <h2>{{ __('Languages') }}</h2>
                        <ul class="elegant-language-list">
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
                    <section class="elegant-aside-card">
                        <h2>{{ __('Interests') }}</h2>
                        <ul class="elegant-interest-list">
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>
        </div>
    </div>
</body>
</html>
