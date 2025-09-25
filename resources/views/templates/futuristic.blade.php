<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Futuristic · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/futuristic.css') }}">
</head>
<body class="futuristic-template">
    @php
        $templateData = \App\View\TemplateDataBuilder::fromCv($cv ?? null);
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
    @endphp

    <div class="futuristic-shell">
        <header class="futuristic-header">
            <div class="futuristic-identity">
                <div class="futuristic-avatar">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    @elseif ($initials !== '')
                        <span>{{ $initials }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <p class="futuristic-badge">{{ __('Futuristic Resume') }}</p>
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p class="futuristic-headline">{{ $data['headline'] }}</p>
                    @endif
                </div>
            </div>
            @if ($data['location'])
                <span class="futuristic-location">{{ $data['location'] }}</span>
            @endif
        </header>

        <div class="futuristic-grid">
            <aside class="futuristic-sidebar">
                @if ($data['summary'])
                    <section class="futuristic-panel">
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($data['contacts']))
                    <section class="futuristic-panel">
                        <h2>{{ __('Contact') }}</h2>
                        <ul>
                            @foreach ($data['contacts'] as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['skills']))
                    <section class="futuristic-panel">
                        <h2>{{ __('Skills') }}</h2>
                        <ul class="futuristic-tag-list">
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section class="futuristic-panel">
                        <h2>{{ __('Languages') }}</h2>
                        <ul class="futuristic-language">
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
                    <section class="futuristic-panel">
                        <h2>{{ __('Interests') }}</h2>
                        <ul class="futuristic-list">
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>

            <main class="futuristic-main">
                @if (!empty($data['experiences']))
                    <section class="futuristic-section">
                        <h2>{{ __('Experience') }}</h2>
                        <div class="futuristic-cards">
                            @foreach ($data['experiences'] as $experience)
                                <article class="futuristic-card">
                                    <header>
                                        <div>
                                            <h3>{{ $experience['role'] }}</h3>
                                            <p>{{ $experience['company'] }}</p>
                                        </div>
                                        @if ($experience['period'])
                                            <span>{{ $experience['period'] }}</span>
                                        @endif
                                    </header>
                                    @if ($experience['location'])
                                        <p class="futuristic-meta">{{ $experience['location'] }}</p>
                                    @endif
                                    @if ($experience['summary'])
                                        <p class="futuristic-summary">{{ $experience['summary'] }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!empty($data['education']))
                    <section class="futuristic-section">
                        <h2>{{ __('Education') }}</h2>
                        <div class="futuristic-table">
                            @foreach ($data['education'] as $education)
                                <article class="futuristic-row">
                                    <div>
                                        <h3>{{ $education['institution'] }}</h3>
                                        @if ($education['degree'])
                                            <p>{{ $education['degree'] }}</p>
                                        @endif
                                        @if ($education['field'])
                                            <p>{{ $education['field'] }}</p>
                                        @endif
                                    </div>
                                    <div class="futuristic-row__meta">
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
