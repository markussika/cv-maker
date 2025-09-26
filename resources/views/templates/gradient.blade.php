<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gradient · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/gradient.css') }}">
</head>
<body class="gradient-template">
    @php
        $templateData = \App\View\TemplateDataBuilder::fromCv($cv ?? null);
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
    @endphp

    <div class="gradient-wrapper">
        <header class="gradient-hero">
            <div class="gradient-profile">
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
                    <span class="gradient-badge">{{ __('Gradient Resume') }}</span>
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p>{{ $data['headline'] }}</p>
                    @endif
                    @if ($data['location'])
                        <p class="gradient-location">{{ $data['location'] }}</p>
                    @endif
                </div>
            </div>
            @if (!empty($data['contacts']))
                <ul class="gradient-contact">
                    @foreach ($data['contacts'] as $contact)
                        <li>{{ $contact }}</li>
                    @endforeach
                </ul>
            @endif
        </header>

        <div class="gradient-columns">
            <main class="gradient-main">
                @if (!empty($data['experiences']))
                    <section class="gradient-section">
                        <h2>{{ __('Experience') }}</h2>
                        <div class="gradient-grid">
                            @foreach ($data['experiences'] as $experience)
                                <article>
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
                                        <p class="gradient-meta">{{ $education['location'] }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>

            <aside class="gradient-aside">
                @if ($data['summary'])
                    <section class="gradient-card">
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($data['skills']))
                    <section class="gradient-card">
                        <h2>{{ __('Skills') }}</h2>
                        <ul>
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section class="gradient-card">
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
                    <section class="gradient-card">
                        <h2>{{ __('Interests') }}</h2>
                        <ul>
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
