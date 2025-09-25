<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modern · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/modern.css') }}">
</head>
<body class="modern-template">
    @include('templates.partials.base-data', ['cv' => $cv])

    @php
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
    @endphp

    <div class="modern-page">
        <aside class="modern-sidebar">
            <div class="modern-profile-card">
                <div class="modern-avatar">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    @elseif ($initials !== '')
                        <span>{{ $initials }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div class="modern-profile-text">
                    <h1 class="modern-name">{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p class="modern-headline">{{ $data['headline'] }}</p>
                    @endif
                </div>
            </div>

            @if (!empty($data['contacts']))
                <div class="modern-section">
                    <h2 class="modern-section__title">{{ __('Contact') }}</h2>
                    <ul class="modern-contact-list">
                        @foreach ($data['contacts'] as $contact)
                            <li>{{ $contact }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($data['summary'])
                <div class="modern-section">
                    <h2 class="modern-section__title">{{ __('Profile') }}</h2>
                    <p class="modern-summary">{{ $data['summary'] }}</p>
                </div>
            @endif

            @if (!empty($data['skills']))
                <div class="modern-section">
                    <h2 class="modern-section__title">{{ __('Skills') }}</h2>
                    <ul class="modern-pill-list">
                        @foreach ($data['skills'] as $skill)
                            <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!empty($data['languages']))
                <div class="modern-section">
                    <h2 class="modern-section__title">{{ __('Languages') }}</h2>
                    <ul class="modern-language-list">
                        @foreach ($data['languages'] as $language)
                            <li>
                                <span class="modern-language-name">{{ $language['name'] }}</span>
                                @if (!empty($language['level']))
                                    <span class="modern-language-level">{{ ucfirst($language['level']) }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!empty($data['hobbies']))
                <div class="modern-section">
                    <h2 class="modern-section__title">{{ __('Interests') }}</h2>
                    <ul class="modern-pill-list modern-pill-list--light">
                        @foreach ($data['hobbies'] as $hobby)
                            <li>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </aside>

        <main class="modern-main">
            <header class="modern-main__header">
                <div>
                    <p class="modern-badge">{{ __('Modern Resume') }}</p>
                    <h2>{{ $data['headline'] ?: __('Career Timeline') }}</h2>
                </div>
                @if ($data['location'])
                    <p class="modern-location">{{ $data['location'] }}</p>
                @endif
            </header>

            @if (!empty($data['experiences']))
                <section class="modern-timeline">
                    <h3 class="modern-timeline__title">{{ __('Experience') }}</h3>
                    <div class="modern-timeline__items">
                        @foreach ($data['experiences'] as $experience)
                            <article class="modern-timeline__item">
                                <div class="modern-timeline__marker"></div>
                                <div class="modern-timeline__content">
                                    @if ($experience['role'])
                                        <h4>{{ $experience['role'] }}</h4>
                                    @endif
                                    <p class="modern-meta">
                                        {{ $experience['company'] }}
                                        @if ($experience['company'] && $experience['location'])
                                            ·
                                        @endif
                                        {{ $experience['location'] }}
                                    </p>
                                    @if ($experience['period'])
                                        <p class="modern-meta">{{ $experience['period'] }}</p>
                                    @endif
                                    @if ($experience['summary'])
                                        <p class="modern-description">{{ $experience['summary'] }}</p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($data['education']))
                <section class="modern-grid">
                    <div class="modern-grid__header">
                        <h3>{{ __('Education') }}</h3>
                        <p>{{ __('Academic achievements and credentials.') }}</p>
                    </div>
                    <div class="modern-grid__items">
                        @foreach ($data['education'] as $education)
                            <article class="modern-card">
                                @if ($education['degree'])
                                    <h4>{{ $education['degree'] }}</h4>
                                @endif
                                <p class="modern-meta">{{ $education['institution'] }}</p>
                                @if ($education['location'])
                                    <p class="modern-meta">{{ $education['location'] }}</p>
                                @endif
                                @if ($education['period'])
                                    <p class="modern-meta">{{ $education['period'] }}</p>
                                @endif
                                @if ($education['field'])
                                    <p class="modern-description">{{ $education['field'] }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>
</body>
</html>
