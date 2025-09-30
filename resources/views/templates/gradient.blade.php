<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gradient · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/gradient.css') }}">
</head>
<body class="gradient-template">
    <div class="gradient-wrapper">
        <header class="gradient-hero">
            <div class="gradient-profile">
                <div class="gradient-avatar">
                    @if (!empty($templateData['profile_image']))
                        <img src="{{ $templateData['profile_image'] }}" alt="{{ $templateData['name'] ?? __('Profile photo') }}">
                    @elseif (!empty($templateData['initials']))
                        <span>{{ $templateData['initials'] }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <span class="gradient-badge">{{ __('Gradient Resume') }}</span>
                    <h1>{{ $templateData['name'] ?? __('Your Name') }}</h1>
                    @if (!empty($templateData['headline']))
                        <p>{{ $templateData['headline'] }}</p>
                    @endif
                    @if (!empty($templateData['location']))
                        <p class="gradient-location">{{ $templateData['location'] }}</p>
                    @endif
                </div>
            </div>
            @if (!empty($templateData['contacts']))
                <ul class="gradient-contact">
                    @foreach ($templateData['contacts'] as $contact)
                        <li>{{ $contact }}</li>
                    @endforeach
                </ul>
            @endif
        </header>

        <div class="gradient-columns">
            <main class="gradient-main">
                @if (!empty($templateData['experiences']))
                    <section class="gradient-section">
                        <h2>{{ __('Experience') }}</h2>
                        <div class="gradient-grid">
                            @foreach ($templateData['experiences'] as $experience)
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

                @if (!empty($templateData['education']))
                    <section class="gradient-section">
                        <h2>{{ __('Education') }}</h2>
                        <div class="gradient-education">
                            @foreach ($templateData['education'] as $education)
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
                @if (!empty($templateData['summary']))
                    <section class="gradient-card">
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $templateData['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($templateData['skills']))
                    <section class="gradient-card">
                        <h2>{{ __('Skills') }}</h2>
                        <ul>
                            @foreach ($templateData['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($templateData['languages']))
                    <section class="gradient-card">
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
                    <section class="gradient-card">
                        <h2>{{ __('Interests') }}</h2>
                        <ul>
                            @foreach ($templateData['hobbies'] as $hobby)
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
