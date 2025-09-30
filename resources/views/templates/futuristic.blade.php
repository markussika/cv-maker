<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Futuristic · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/futuristic.css') }}">
</head>
<body class="futuristic-template">
    <div class="futuristic-grid">
        <aside class="futuristic-panel">
            <div class="futuristic-profile">
                <div class="futuristic-avatar">
                    @if (!empty($templateData['profile_image']))
                        <img src="{{ $templateData['profile_image'] }}" alt="{{ $templateData['name'] ?? __('Profile photo') }}">
                    @elseif (!empty($templateData['initials']))
                        <span>{{ $templateData['initials'] }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <p class="futuristic-badge">{{ __('Futuristic Resume') }}</p>
                    <h1>{{ $templateData['name'] ?? __('Your Name') }}</h1>
                    @if (!empty($templateData['headline']))
                        <p>{{ $templateData['headline'] }}</p>
                    @endif
                </div>
            </div>

            @if (!empty($templateData['contacts']))
                <section class="futuristic-section">
                    <h2>{{ __('Contact') }}</h2>
                    <ul>
                        @foreach ($templateData['contacts'] as $contact)
                            <li>{{ $contact }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (!empty($templateData['summary']))
                <section class="futuristic-section">
                    <h2>{{ __('Profile') }}</h2>
                    <p>{{ $templateData['summary'] }}</p>
                </section>
            @endif

            @if (!empty($templateData['skills']))
                <section class="futuristic-section">
                    <h2>{{ __('Skills') }}</h2>
                    <ul>
                        @foreach ($templateData['skills'] as $skill)
                            <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (!empty($templateData['languages']))
                <section class="futuristic-section">
                    <h2>{{ __('Languages') }}</h2>
                    <ul>
                        @foreach ($templateData['languages'] as $language)
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

            @if (!empty($templateData['hobbies']))
                <section class="futuristic-section">
                    <h2>{{ __('Interests') }}</h2>
                    <ul>
                        @foreach ($templateData['hobbies'] as $hobby)
                            <li>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </aside>

        <main class="futuristic-main">
            @if (!empty($templateData['experiences']))
                <section class="futuristic-card">
                    <header>
                        <h2>{{ __('Experience') }}</h2>
                        <p>{{ __('Projects, leadership, and high-impact work.') }}</p>
                    </header>
                    <div class="futuristic-entries">
                        @foreach ($templateData['experiences'] as $experience)
                            <article>
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
                                @if ($experience['summary'])
                                    <p>{{ $experience['summary'] }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($templateData['education']))
                <section class="futuristic-card">
                    <header>
                        <h2>{{ __('Education') }}</h2>
                        <p>{{ __('Certifications and learning pathways.') }}</p>
                    </header>
                    <div class="futuristic-entries">
                        @foreach ($templateData['education'] as $education)
                            <article>
                                <div>
                                    <h3>{{ $education['institution'] }}</h3>
                                    @if ($education['location'])
                                        <p>{{ $education['location'] }}</p>
                                    @endif
                                </div>
                                @if ($education['period'])
                                    <span>{{ $education['period'] }}</span>
                                @endif
                                <div class="futuristic-meta">
                                    @if ($education['degree'])
                                        <p>{{ $education['degree'] }}</p>
                                    @endif
                                    @if ($education['field'])
                                        <p>{{ $education['field'] }}</p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>
</body>
</html>
