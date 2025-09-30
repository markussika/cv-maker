<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elegant · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/elegant.css') }}">
</head>
<body class="elegant-template">
    <div class="elegant-wrapper">
        <header class="elegant-hero">
            <div class="elegant-identity">
                <div class="elegant-avatar">
                    @if (!empty($templateData['profile_image']))
                        <img src="{{ $templateData['profile_image'] }}" alt="{{ $templateData['name'] ?? __('Profile photo') }}">
                    @elseif (!empty($templateData['initials']))
                        <span>{{ $templateData['initials'] }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <p class="elegant-badge">{{ __('Elegant Resume') }}</p>
                    <h1>{{ $templateData['name'] ?? __('Your Name') }}</h1>
                    @if (!empty($templateData['headline']))
                        <p class="elegant-headline">{{ $templateData['headline'] }}</p>
                    @endif
                </div>
            </div>
            @if (!empty($templateData['contacts']))
                <ul class="elegant-contact">
                    @foreach ($templateData['contacts'] as $contact)
                        <li>{{ $contact }}</li>
                    @endforeach
                </ul>
            @endif
        </header>

        <div class="elegant-layout">
            <aside class="elegant-aside">
                @if (!empty($templateData['summary']))
                    <section>
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $templateData['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($templateData['skills']))
                    <section>
                        <h2>{{ __('Skills') }}</h2>
                        <ul>
                            @foreach ($templateData['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if (!empty($templateData['languages']))
                    <section>
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
                    <section>
                        <h2>{{ __('Interests') }}</h2>
                        <ul>
                            @foreach ($templateData['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>

            <main class="elegant-main">
                @if (!empty($templateData['experiences']))
                    <section class="elegant-section">
                        <h2>{{ __('Experience') }}</h2>
                        <div class="elegant-entries">
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
                    <section class="elegant-section">
                        <h2>{{ __('Education') }}</h2>
                        <div class="elegant-entries">
                            @foreach ($templateData['education'] as $education)
                                <article>
                                    <div>
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
                                        <p class="elegant-meta">{{ $education['location'] }}</p>
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
