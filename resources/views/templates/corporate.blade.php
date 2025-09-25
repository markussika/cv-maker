<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Corporate · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/corporate.css') }}">
</head>
<body class="corporate-template">
    @include('templates.partials.base-data-helper', ['cv' => $cv])

    @php
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
    @endphp

    <div class="corporate-page">
        <header class="corporate-header">
            <div class="corporate-header__identity">
                <div class="corporate-avatar">
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
            <div class="corporate-header__details">
                <span class="corporate-badge">{{ __('Corporate Resume') }}</span>
                @if ($data['location'])
                    <span>{{ $data['location'] }}</span>
                @endif
            </div>
        </header>

        <div class="corporate-grid">
            <aside class="corporate-sidebar">
                @if ($data['summary'])
                    <section class="corporate-card">
                        <h2>{{ __('Summary') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($data['contacts']))
                    <section class="corporate-card">
                        <h2>{{ __('Contact') }}</h2>
                        <ul>
                            @foreach ($data['contacts'] as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['skills']))
                    <section class="corporate-card">
                        <h2>{{ __('Skills') }}</h2>
                        <ul class="corporate-pill-list">
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section class="corporate-card">
                        <h2>{{ __('Languages') }}</h2>
                        <ul class="corporate-language">
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
                    <section class="corporate-card">
                        <h2>{{ __('Interests') }}</h2>
                        <ul class="corporate-list">
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>

            <main class="corporate-main">
                @if (!empty($data['experiences']))
                    <section class="corporate-section">
                        <div class="corporate-section__head">
                            <h2>{{ __('Experience') }}</h2>
                            <p>{{ __('Career progression and leadership roles.') }}</p>
                        </div>
                        <div class="corporate-experience">
                            @foreach ($data['experiences'] as $experience)
                                <article class="corporate-experience__item">
                                    <div class="corporate-experience__meta">
                                        <h3>{{ $experience['role'] }}</h3>
                                        @if ($experience['period'])
                                            <span>{{ $experience['period'] }}</span>
                                        @endif
                                    </div>
                                    <p class="corporate-experience__company">
                                        {{ $experience['company'] }}
                                        @if ($experience['company'] && $experience['location'])
                                            ·
                                        @endif
                                        {{ $experience['location'] }}
                                    </p>
                                    @if ($experience['summary'])
                                        <p class="corporate-experience__summary">{{ $experience['summary'] }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!empty($data['education']))
                    <section class="corporate-section">
                        <div class="corporate-section__head">
                            <h2>{{ __('Education') }}</h2>
                            <p>{{ __('Degrees, certifications, and recognitions.') }}</p>
                        </div>
                        <div class="corporate-education">
                            @foreach ($data['education'] as $education)
                                <article>
                                    <div class="corporate-education__title">
                                        <h3>{{ $education['degree'] ?? $education['institution'] }}</h3>
                                        @if ($education['period'])
                                            <span>{{ $education['period'] }}</span>
                                        @endif
                                    </div>
                                    <p class="corporate-education__institution">{{ $education['institution'] }}</p>
                                    <div class="corporate-education__meta">
                                        @if ($education['field'])
                                            <span>{{ $education['field'] }}</span>
                                        @endif
                                        @if ($education['location'])
                                            <span>{{ $education['location'] }}</span>
                                        @endif
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
