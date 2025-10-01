<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minimal · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/minimal.css') }}">
</head>
<body class="minimal-template">
    @php
        $templateData = \App\View\TemplateDataBuilder::fromCv($cv ?? null);
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
        $hasSidebar = !empty($data['skills']) || !empty($data['languages']) || !empty($data['hobbies']);
    @endphp

    <div class="minimal-page">
        <div class="minimal-sheet">
            <header class="minimal-header">
                <div class="minimal-header-bar">
                    <div class="minimal-identity">
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

                    @if (!empty($data['contacts']))
                        <div class="minimal-contact">
                            @foreach ($data['contacts'] as $contact)
                                <span>{{ $contact }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </header>

            <main class="minimal-main">
                @if ($data['summary'])
                    <section class="minimal-card minimal-summary">
                        <h2>{{ __('Summary') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </section>
                @endif

                <div class="minimal-layout">
                    <div class="minimal-column">
                        @if (!empty($data['experiences']))
                            <section class="minimal-card minimal-experience">
                                <div class="minimal-card-header">
                                    <h2>{{ __('Experience') }}</h2>
                                </div>
                                <div class="minimal-experience-list">
                                    @foreach ($data['experiences'] as $experience)
                                        <article class="minimal-experience-item">
                                            <header>
                                                <div>
                                                    @if ($experience['role'])
                                                        <h3>{{ $experience['role'] }}</h3>
                                                    @endif
                                                    @if ($experience['company'] || $experience['location'])
                                                        <p>
                                                            {{ $experience['company'] }}
                                                            @if ($experience['company'] && $experience['location'])
                                                                ·
                                                            @endif
                                                            {{ $experience['location'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                                @if ($experience['period'])
                                                    <span>{{ $experience['period'] }}</span>
                                                @endif
                                            </header>
                                            @if ($experience['summary'])
                                                <p class="minimal-note">{{ $experience['summary'] }}</p>
                                            @endif
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        @if (!empty($data['education']))
                            <section class="minimal-card minimal-education">
                                <div class="minimal-card-header">
                                    <h2>{{ __('Education') }}</h2>
                                </div>
                                <div class="minimal-education-list">
                                    @foreach ($data['education'] as $education)
                                        <article class="minimal-education-item">
                                            <header>
                                                <div>
                                                    <h3>{{ $education['institution'] }}</h3>
                                                    @if ($education['degree'] || $education['field'])
                                                        <p>
                                                            {{ $education['degree'] }}
                                                            @if ($education['degree'] && $education['field'])
                                                                ·
                                                            @endif
                                                            {{ $education['field'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                                @if ($education['period'])
                                                    <span>{{ $education['period'] }}</span>
                                                @endif
                                            </header>
                                            @if ($education['location'])
                                                <p class="minimal-muted">{{ $education['location'] }}</p>
                                            @endif
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    </div>

                    @if ($hasSidebar)
                        <div class="minimal-column minimal-column--aside">
                            @if (!empty($data['skills']))
                                <section class="minimal-card minimal-aside-card">
                                    <h2>{{ __('Skills') }}</h2>
                                    <ul>
                                        @foreach ($data['skills'] as $skill)
                                            <li>{{ $skill }}</li>
                                        @endforeach
                                    </ul>
                                </section>
                            @endif

                            @if (!empty($data['languages']))
                                <section class="minimal-card minimal-aside-card">
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
                                <section class="minimal-card minimal-aside-card">
                                    <h2>{{ __('Interests') }}</h2>
                                    <ul>
                                        @foreach ($data['hobbies'] as $hobby)
                                            <li>{{ $hobby }}</li>
                                        @endforeach
                                    </ul>
                                </section>
                            @endif
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>
</html>
