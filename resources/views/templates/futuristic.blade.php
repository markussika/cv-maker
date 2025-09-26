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

    <div class="futuristic-frame">
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
                        <p>{{ $data['headline'] }}</p>
                    @endif
                    @if ($data['location'])
                        <p class="futuristic-location">{{ $data['location'] }}</p>
                    @endif
                </div>
            </div>
            @if (!empty($data['contacts']))
                <ul class="futuristic-contact">
                    @foreach ($data['contacts'] as $contact)
                        <li>{{ $contact }}</li>
                    @endforeach
                </ul>
            @endif
        </header>

        <main class="futuristic-body">
            <section class="futuristic-grid">
                @if ($data['summary'])
                    <article class="futuristic-panel">
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </article>
                @endif
                @if (!empty($data['skills']))
                    <article class="futuristic-panel">
                        <h2>{{ __('Skills') }}</h2>
                        <ul>
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endif
                @if (!empty($data['languages']))
                    <article class="futuristic-panel">
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
                    </article>
                @endif
                @if (!empty($data['hobbies']))
                    <article class="futuristic-panel">
                        <h2>{{ __('Interests') }}</h2>
                        <ul>
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endif
            </section>

            @if (!empty($data['experiences']))
                <section class="futuristic-section">
                    <h2>{{ __('Experience Timeline') }}</h2>
                    <div class="futuristic-timeline">
                        @foreach ($data['experiences'] as $experience)
                            <article>
                                <div class="futuristic-timeline__marker"></div>
                                <div class="futuristic-timeline__card">
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
                <section class="futuristic-section">
                    <h2>{{ __('Education & Certifications') }}</h2>
                    <div class="futuristic-education">
                        @foreach ($data['education'] as $education)
                            <article>
                                <div class="futuristic-education__head">
                                    <h3>{{ $education['institution'] }}</h3>
                                    @if ($education['period'])
                                        <span>{{ $education['period'] }}</span>
                                    @endif
                                </div>
                                @if ($education['degree'])
                                    <p>{{ $education['degree'] }}</p>
                                @endif
                                @if ($education['field'])
                                    <p>{{ $education['field'] }}</p>
                                @endif
                                @if ($education['location'])
                                    <p class="futuristic-education__meta">{{ $education['location'] }}</p>
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
