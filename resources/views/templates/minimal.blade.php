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
    @endphp

    <div class="minimal-page">
        <header class="minimal-header">
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
                    <h2>{{ __('Contact') }}</h2>
                    <ul>
                        @foreach ($data['contacts'] as $contact)
                            <li>{{ $contact }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </header>

        <main class="minimal-body">
            @if ($data['summary'])
                <section class="minimal-section minimal-section--summary">
                    <h2>{{ __('Summary') }}</h2>
                    <p>{{ $data['summary'] }}</p>
                </section>
            @endif

            @if (!empty($data['experiences']))
                <section class="minimal-section">
                    <h2>{{ __('Experience') }}</h2>
                    <div class="minimal-timeline">
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
                                    <p class="minimal-note">{{ $experience['summary'] }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($data['education']))
                <section class="minimal-section">
                    <h2>{{ __('Education') }}</h2>
                    <div class="minimal-education">
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
                                    <p class="minimal-muted">{{ $education['location'] }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($data['skills']) || !empty($data['languages']) || !empty($data['hobbies']))
                <section class="minimal-section minimal-section--grid">
                    @if (!empty($data['skills']))
                        <div class="minimal-card">
                            <h2>{{ __('Skills') }}</h2>
                            <ul>
                                @foreach ($data['skills'] as $skill)
                                    <li>{{ $skill }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (!empty($data['languages']))
                        <div class="minimal-card">
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
                        </div>
                    @endif
                    @if (!empty($data['hobbies']))
                        <div class="minimal-card">
                            <h2>{{ __('Interests') }}</h2>
                            <ul>
                                @foreach ($data['hobbies'] as $hobby)
                                    <li>{{ $hobby }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </section>
            @endif
        </main>
    </div>
</body>
</html>
