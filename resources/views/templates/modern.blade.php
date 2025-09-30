<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modern · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/modern.css') }}">
</head>
<body class="modern-template">
    <div class="modern-page">
        <aside class="modern-sidebar">
            <div class="modern-profile-card">
                <div class="modern-avatar">
                    @if (!empty($templateData['profile_image']))
                        <img src="{{ $templateData['profile_image'] }}" alt="{{ $templateData['name'] ?? __('Profile photo') }}">
                    @elseif (!empty($templateData['initials']))
                        <span>{{ $templateData['initials'] }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div class="modern-profile-text">
                    <h1 class="modern-name">{{ $templateData['name'] ?? __('Your Name') }}</h1>
                    @if (!empty($templateData['headline']))
                        <p class="modern-headline">{{ $templateData['headline'] }}</p>
                    @endif
                </div>
            </div>

            @if (!empty($templateData['contacts']))
                <div class="modern-section">
                    <h2 class="modern-section__title">{{ __('Contact') }}</h2>
                    <ul class="modern-contact-list">
                        @foreach ($templateData['contacts'] as $contact)
                            <li>{{ $contact }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!empty($templateData['summary']))
                <div class="modern-section">
                    <h2 class="modern-section__title">{{ __('Profile') }}</h2>
                    <p class="modern-summary">{{ $templateData['summary'] }}</p>
                </div>
            @endif

            @if (!empty($templateData['skills']))
                <div class="modern-section">
                    <h2 class="modern-section__title">{{ __('Skills') }}</h2>
                    <ul class="modern-pill-list">
                        @foreach ($templateData['skills'] as $skill)
                            <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!empty($templateData['languages']))
                <div class="modern-section">
                    <h2 class="modern-section__title">{{ __('Languages') }}</h2>
                    <ul class="modern-language-list">
                        @foreach ($templateData['languages'] as $language)
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

            @if (!empty($templateData['hobbies']))
                <div class="modern-section">
                    <h2 class="modern-section__title">{{ __('Interests') }}</h2>
                    <ul class="modern-pill-list modern-pill-list--light">
                        @foreach ($templateData['hobbies'] as $hobby)
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
                    <h2>{{ $templateData['headline'] ?: __('Career Timeline') }}</h2>
                </div>
                @if (!empty($templateData['location']))
                    <p class="modern-location">{{ $templateData['location'] }}</p>
                @endif
            </header>

            @if (!empty($templateData['experiences']))
                <section class="modern-timeline">
                    <h3 class="modern-timeline__title">{{ __('Experience') }}</h3>
                    <div class="modern-timeline__items">
                        @foreach ($templateData['experiences'] as $experience)
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

            @if (!empty($templateData['education']))
                <section class="modern-grid">
                    <div class="modern-grid__header">
                        <h3>{{ __('Education') }}</h3>
                        <p>{{ __('Academic achievements and credentials.') }}</p>
                    </div>
                    <div class="modern-grid__items">
                        @foreach ($templateData['education'] as $education)
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
