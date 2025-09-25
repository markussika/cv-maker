<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gradient · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/gradient.css') }}">
</head>
<body class="gradient-template">
    @include('templates.partials.base-data', ['cv' => $cv])

    @php
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
    @endphp

    <div class="gradient-page">
        <header class="gradient-header">
            <div class="gradient-hero">
                <div class="gradient-avatar">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    @elseif ($initials !== '')
                        <span>{{ $initials }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <p class="gradient-badge">{{ __('Gradient Resume') }}</p>
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p class="gradient-headline">{{ $data['headline'] }}</p>
                    @endif
                </div>
            </div>
            @if ($data['location'])
                <div class="gradient-location">{{ $data['location'] }}</div>
            @endif
        </header>

        <div class="gradient-content">
            <aside class="gradient-sidebar">
                @if ($data['summary'])
                    <section class="gradient-card gradient-card--highlight">
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($data['contacts']))
                    <section class="gradient-card">
                        <h2>{{ __('Contact') }}</h2>
                        <ul>
                            @foreach ($data['contacts'] as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['skills']))
                    <section class="gradient-card">
                        <h2>{{ __('Skills') }}</h2>
                        <ul class="gradient-tag-list">
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section class="gradient-card">
                        <h2>{{ __('Languages') }}</h2>
                        <ul class="gradient-language">
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
                    <section class="gradient-card">
                        <h2>{{ __('Interests') }}</h2>
                        <ul class="gradient-list">
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>

            <main class="gradient-main">
                @if (!empty($data['experiences']))
                    <section class="gradient-section">
                        <h2>{{ __('Experience') }}</h2>
                        <div class="gradient-experience">
                            @foreach ($data['experiences'] as $experience)
                                <article class="gradient-experience__item">
                                    <div class="gradient-experience__header">
                                        <div>
                                            <h3>{{ $experience['role'] }}</h3>
                                            <p>{{ $experience['company'] }}</p>
                                        </div>
                                        @if ($experience['period'])
                                            <span class="gradient-chip">{{ $experience['period'] }}</span>
                                        @endif
                                    </div>
                                    @if ($experience['location'])
                                        <p class="gradient-meta">{{ $experience['location'] }}</p>
                                    @endif
                                    @if ($experience['summary'])
                                        <p class="gradient-summary">{{ $experience['summary'] }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!empty($data['education']))
                    <section class="gradient-section">
                        <h2>{{ __('Education') }}</h2>
                        <div class="gradient-education">
                            @foreach ($data['education'] as $education)
                                <article class="gradient-education__item">
                                    <div>
                                        <h3>{{ $education['institution'] }}</h3>
                                        @if ($education['degree'])
                                            <p>{{ $education['degree'] }}</p>
                                        @endif
                                        @if ($education['field'])
                                            <p>{{ $education['field'] }}</p>
                                        @endif
                                    </div>
                                    <div class="gradient-education__meta">
                                        @if ($education['location'])
                                            <span>{{ $education['location'] }}</span>
                                        @endif
                                        @if ($education['period'])
                                            <span>{{ $education['period'] }}</span>
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
