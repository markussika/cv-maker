<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dark Mode · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/darkmode.css') }}">
</head>
<body class="darkmode-template">
    @php
        $templateData = \App\View\TemplateDataBuilder::fromCv($cv ?? null);
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
    @endphp

    <div class="darkmode-shell">
        <header class="darkmode-header">
            <div class="darkmode-identity">
                <div class="darkmode-avatar">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    @elseif ($initials !== '')
                        <span>{{ $initials }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <p class="darkmode-badge">{{ __('Dark Mode Resume') }}</p>
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p class="darkmode-headline">{{ $data['headline'] }}</p>
                    @endif
                </div>
            </div>
            @if (!empty($data['contacts']))
                <ul class="darkmode-contact">
                    @foreach ($data['contacts'] as $contact)
                        <li>{{ $contact }}</li>
                    @endforeach
                </ul>
            @endif
        </header>

        <div class="darkmode-body">
            <aside class="darkmode-aside">
                @if ($data['summary'])
                    <section>
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($data['skills']))
                    <section>
                        <h2>{{ __('Skills') }}</h2>
                        <ul>
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section>
                        <h2>{{ __('Languages') }}</h2>
                        <ul>
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
                        <ul>
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>

            <main class="darkmode-main">
                @if (!empty($data['experiences']))
                    <section class="darkmode-section">
                        <h2>{{ __('Experience') }}</h2>
                        <div class="darkmode-timeline">
                            @foreach ($data['experiences'] as $experience)
                                <article>
                                    <div class="darkmode-timeline__line"></div>
                                    <div class="darkmode-timeline__content">
                                        <header>
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
                                                <span>{{ $experience['period'] }}</span>
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
                    <section class="darkmode-section">
                        <h2>{{ __('Education') }}</h2>
                        <div class="darkmode-education">
                            @foreach ($data['education'] as $education)
                                <article>
                                    <header>
                                        <h3>{{ $education['institution'] }}</h3>
                                        @if ($education['period'])
                                            <span>{{ $education['period'] }}</span>
                                        @endif
                                    </header>
                                    @if ($education['degree'])
                                        <p>{{ $education['degree'] }}</p>
                                    @endif
                                    @if ($education['field'])
                                        <p>{{ $education['field'] }}</p>
                                    @endif
                                    @if ($education['location'])
                                        <p class="darkmode-meta">{{ $education['location'] }}</p>
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
