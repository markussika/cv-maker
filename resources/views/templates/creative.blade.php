<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Creative · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/creative.css') }}">
</head>
<body class="creative-template">
    @php
        $templateData = \App\View\TemplateDataBuilder::fromCv($cv ?? null);
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
    @endphp

    <div class="creative-page">
        <header class="creative-hero">
            <div class="creative-hero__badge">{{ __('Creative Resume') }}</div>
            <div class="creative-hero__profile">
                <div class="creative-hero__avatar">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    @elseif ($initials !== '')
                        <span>{{ $initials }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p>{{ $data['headline'] }}</p>
                    @endif
                </div>
            </div>
            @if ($data['location'])
                <div class="creative-hero__location">{{ $data['location'] }}</div>
            @endif
        </header>

        <div class="creative-content">
            <aside class="creative-aside">
                @if ($data['summary'])
                    <section class="creative-card creative-card--accent">
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($data['contacts']))
                    <section class="creative-card">
                        <h2>{{ __('Contact') }}</h2>
                        <ul class="creative-list">
                            @foreach ($data['contacts'] as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['skills']))
                    <section class="creative-card">
                        <h2>{{ __('Skills') }}</h2>
                        <ul class="creative-tag-list">
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section class="creative-card creative-card--split">
                        <h2>{{ __('Languages') }}</h2>
                        <ul class="creative-list creative-list--condensed">
                            @foreach ($data['languages'] as $language)
                                <li>
                                    <span class="creative-list__primary">{{ $language['name'] }}</span>
                                    @if (!empty($language['level']))
                                        <span class="creative-list__secondary">{{ ucfirst($language['level']) }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['hobbies']))
                    <section class="creative-card">
                        <h2>{{ __('Interests') }}</h2>
                        <ul class="creative-tag-list creative-tag-list--soft">
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>

            <main class="creative-main">
                @if (!empty($data['experiences']))
                    <section>
                        <div class="creative-section-head">
                            <h2>{{ __('Experience highlights') }}</h2>
                            <p>{{ __('Selected projects and accomplishments.') }}</p>
                        </div>
                        <div class="creative-experience-grid">
                            @foreach ($data['experiences'] as $experience)
                                <article class="creative-experience-card">
                                    <div class="creative-experience-card__header">
                                        <span class="creative-dot"></span>
                                        <div>
                                            @if ($experience['role'])
                                                <h3>{{ $experience['role'] }}</h3>
                                            @endif
                                            <p>
                                                {{ $experience['company'] }}
                                                @if ($experience['company'] && $experience['location'])
                                                    ·
                                                @endif
                                                {{ $experience['location'] }}
                                            </p>
                                        </div>
                                        @if ($experience['period'])
                                            <span class="creative-chip">{{ $experience['period'] }}</span>
                                        @endif
                                    </div>
                                    @if ($experience['summary'])
                                        <p class="creative-experience-card__body">{{ $experience['summary'] }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!empty($data['education']))
                    <section>
                        <div class="creative-section-head">
                            <h2>{{ __('Education') }}</h2>
                            <p>{{ __('Studies, certifications, and workshops.') }}</p>
                        </div>
                        <div class="creative-education">
                            @foreach ($data['education'] as $education)
                                <article class="creative-education__item">
                                    <div class="creative-education__timeline"></div>
                                    <div class="creative-education__content">
                                        <h3>{{ $education['institution'] }}</h3>
                                        @if ($education['degree'])
                                            <p class="creative-education__meta">{{ $education['degree'] }}</p>
                                        @endif
                                        @if ($education['field'])
                                            <p class="creative-education__meta">{{ $education['field'] }}</p>
                                        @endif
                                        <div class="creative-education__footer">
                                            @if ($education['location'])
                                                <span>{{ $education['location'] }}</span>
                                            @endif
                                            @if ($education['period'])
                                                <span>{{ $education['period'] }}</span>
                                            @endif
                                        </div>
                                    </div>
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
