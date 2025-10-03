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
    @endphp

    <div class="elegant-page">
        <header class="elegant-header">
            <div class="elegant-header__info">
                @if ($profileImage)
                    <div class="elegant-avatar">
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    </div>
                @endif
                <div>
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p>{{ $data['headline'] }}</p>
                    @endif
                </div>
            </div>
            <div class="elegant-header__details">
                <div class="elegant-badge">{{ __('Elegant Resume') }}</div>
                <div class="elegant-contact">
                    @foreach ($data['contacts'] as $contact)
                        <span>{{ $contact }}</span>
                    @endforeach
                </div>
            </div>
        </header>

        <div class="elegant-columns">
            <aside class="elegant-sidebar">
                @if ($data['summary'])
                    <section>
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($data['skills']))
                    <section>
                        <h2>{{ __('Core Competencies') }}</h2>
                        <ul class="elegant-list">
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section>
                        <h2>{{ __('Languages') }}</h2>
                        <ul class="elegant-language">
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
                    <section>
                        <h2>{{ __('Interests') }}</h2>
                        <ul class="elegant-tag-list">
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>

            <main class="elegant-main">
                @if (!empty($data['experiences']))
                    <section class="elegant-section">
                        <h2>{{ __('Experience') }}</h2>
                        <div class="elegant-timeline">
                            @foreach ($data['experiences'] as $experience)
                                <article class="elegant-timeline__item">
                                    <div class="elegant-timeline__point"></div>
                                    <div class="elegant-timeline__body">
                                        <header>
                                            @if ($experience['role'])
                                                <h3>{{ $experience['role'] }}</h3>
                                            @endif
                                            <div>
                                                <span>{{ $experience['company'] }}</span>
                                                @if ($experience['company'] && $experience['location'])
                                                    <span>·</span>
                                                @endif
                                                <span>{{ $experience['location'] }}</span>
                                            </div>
                                            @if ($experience['period'])
                                                <span class="elegant-period">{{ $experience['period'] }}</span>
                                            @endif
                                        </header>
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
                    <section class="elegant-section">
                        <h2>{{ __('Education') }}</h2>
                        <div class="elegant-education">
                            @foreach ($data['education'] as $education)
                                <article>
                                    <h3>{{ $education['institution'] }}</h3>
                                    <div class="elegant-education__meta">
                                        @if ($education['degree'])
                                            <span>{{ $education['degree'] }}</span>
                                        @endif
                                        @if ($education['field'])
                                            <span>{{ $education['field'] }}</span>
                                        @endif
                                    </div>
                                    <div class="elegant-education__footer">
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
