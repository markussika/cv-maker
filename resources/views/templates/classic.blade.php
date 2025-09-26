<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classic · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/classic.css') }}">
</head>
<body class="classic-template">
    @php
        $templateData = \App\View\TemplateDataBuilder::fromCv($cv ?? null);
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
    @endphp

    <div class="page">
        <header>
            <div class="identity">
                <div class="portrait">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    @elseif ($initials !== '')
                        <span>{{ $initials }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <span class="badge">{{ __('Classic Resume') }}</span>
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p>{{ $data['headline'] }}</p>
                    @endif
                </div>
            </div>
            <div class="contact">
                @foreach ($data['contacts'] as $contact)
                    <div>{{ $contact }}</div>
                @endforeach
            </div>
        </header>

        <div class="layout">
            <aside class="sidebar">
                @if ($data['summary'])
                    <div class="section">
                        <h2>{{ __('Profile') }}</h2>
                        <div class="summary">{{ $data['summary'] }}</div>
                    </div>
                @endif

                @if (!empty($data['skills']))
                    <div class="section">
                        <h2>{{ __('Skills') }}</h2>
                        <ul>
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!empty($data['languages']))
                    <div class="section">
                        <h2>{{ __('Languages') }}</h2>
                        <ul>
                            @foreach ($data['languages'] as $language)
                                <li>
                                    {{ $language['name'] }}
                                    @if (!empty($language['level']))
                                        <span class="meta">&mdash; {{ ucfirst($language['level']) }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!empty($data['hobbies']))
                    <div class="section">
                        <h2>{{ __('Interests') }}</h2>
                        <ul>
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>

            <main>
                @if (!empty($data['experiences']))
                    <div class="section">
                        <h2>{{ __('Experience') }}</h2>
                        @foreach ($data['experiences'] as $experience)
                            <div class="item">
                                @if ($experience['role'])
                                    <h3>{{ $experience['role'] }}</h3>
                                @endif
                                <div class="meta">
                                    {{ $experience['company'] }}
                                    @if ($experience['company'] && $experience['location'])
                                        &middot;
                                    @endif
                                    {{ $experience['location'] }}
                                </div>
                                @if ($experience['period'])
                                    <div class="meta">{{ $experience['period'] }}</div>
                                @endif
                                @if ($experience['summary'])
                                    <p class="meta experience-summary">{{ $experience['summary'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (!empty($data['education']))
                    <div class="divider"></div>
                    <div class="section">
                        <h2>{{ __('Education') }}</h2>
                        @foreach ($data['education'] as $education)
                            <div class="item">
                                @if ($education['degree'])
                                    <h3>{{ $education['degree'] }}</h3>
                                @endif
                                <div class="meta">
                                    {{ $education['institution'] }}
                                    @if ($education['institution'] && $education['location'])
                                        &middot;
                                    @endif
                                    {{ $education['location'] }}
                                </div>
                                @if ($education['period'])
                                    <div class="meta">{{ $education['period'] }}</div>
                                @endif
                                @if ($education['field'])
                                    <div class="meta education-field">{{ $education['field'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>
