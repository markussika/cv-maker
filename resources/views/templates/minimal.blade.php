<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minimal · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/minimal.css') }}">
</head>
<body class="minimal-template">
    @include('templates.partials.base-data-helper', ['cv' => $cv])

    @php
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
    @endphp

    <div class="minimal-page">
        <header class="minimal-header">
            <div class="minimal-header__identity">
                <div class="minimal-avatar">
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
            <div class="minimal-header__meta">
                <div class="minimal-badge">{{ __('Minimal Resume') }}</div>
                @if ($data['location'])
                    <span>{{ $data['location'] }}</span>
                @endif
            </div>
        </header>

        <div class="minimal-columns">
            <aside class="minimal-sidebar">
                @if (!empty($data['contacts']))
                    <section>
                        <h2>{{ __('Contact') }}</h2>
                        <ul>
                            @foreach ($data['contacts'] as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if ($data['summary'])
                    <section>
                        <h2>{{ __('Summary') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($data['skills']))
                    <section>
                        <h2>{{ __('Skills') }}</h2>
                        <ul class="minimal-pill-list">
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($data['languages']))
                    <section>
                        <h2>{{ __('Languages') }}</h2>
                        <ul class="minimal-language-list">
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
                        <ul class="minimal-list">
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>

            <main class="minimal-main">
                @if (!empty($data['experiences']))
                    <section class="minimal-section">
                        <h2>{{ __('Experience') }}</h2>
                        <div class="minimal-timeline">
                            @foreach ($data['experiences'] as $experience)
                                <article class="minimal-timeline__item">
                                    <div class="minimal-timeline__bar"></div>
                                    <div class="minimal-timeline__content">
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
                                        @if ($experience['period'])
                                            <span>{{ $experience['period'] }}</span>
                                        @endif
                                        @if ($experience['summary'])
                                            <p class="minimal-note">{{ $experience['summary'] }}</p>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!empty($data['education']))
                    <section class="minimal-section">
                        <h2>{{ __('Education') }}</h2>
                        <ul class="minimal-list minimal-list--spaced">
                            @foreach ($data['education'] as $education)
                                <li>
                                    <div>
                                        <h3>{{ $education['institution'] }}</h3>
                                        @if ($education['degree'])
                                            <span>{{ $education['degree'] }}</span>
                                        @endif
                                        @if ($education['field'])
                                            <span>{{ $education['field'] }}</span>
                                        @endif
                                    </div>
                                    <div class="minimal-list__meta">
                                        @if ($education['location'])
                                            <span>{{ $education['location'] }}</span>
                                        @endif
                                        @if ($education['period'])
                                            <span>{{ $education['period'] }}</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </main>
        </div>
    </div>
</body>
</html>
