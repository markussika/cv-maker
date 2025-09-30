<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Corporate · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/corporate.css') }}">
</head>
<body class="corporate-template">
    <div class="corporate-wrapper">
        <header class="corporate-topbar">
            <div class="corporate-brand">
                <div class="corporate-avatar">
                    @if (!empty($templateData['profile_image']))
                        <img src="{{ $templateData['profile_image'] }}" alt="{{ $templateData['name'] ?? __('Profile photo') }}">
                    @elseif (!empty($templateData['initials']))
                        <span>{{ $templateData['initials'] }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <p class="corporate-badge">{{ __('Corporate Resume') }}</p>
                    <h1>{{ $templateData['name'] ?? __('Your Name') }}</h1>
                    @if (!empty($templateData['headline']))
                        <p>{{ $templateData['headline'] }}</p>
                    @endif
                </div>
            </div>
            @if (!empty($templateData['contacts']))
                <ul class="corporate-contact">
                    @foreach ($templateData['contacts'] as $contact)
                        <li>{{ $contact }}</li>
                    @endforeach
                </ul>
            @endif
        </header>

        <div class="corporate-body">
            <main class="corporate-main">
                @if (!empty($templateData['summary']))
                    <section class="corporate-section corporate-section--summary">
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $templateData['summary'] }}</p>
                    </section>
                @endif

                @if (!empty($templateData['experiences']))
                    <section class="corporate-section">
                        <header>
                            <h2>{{ __('Experience') }}</h2>
                            <p>{{ __('Leadership, strategy, and measurable outcomes.') }}</p>
                        </header>
                        <div class="corporate-timeline">
                            @foreach ($templateData['experiences'] as $experience)
                                <article>
                                    <div class="corporate-timeline__marker"></div>
                                    <div class="corporate-timeline__body">
                                        <div class="corporate-timeline__head">
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
                                        </div>
                                        @if ($experience['summary'])
                                            <p class="corporate-timeline__summary">{{ $experience['summary'] }}</p>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!empty($templateData['education']))
                    <section class="corporate-section">
                        <header>
                            <h2>{{ __('Education') }}</h2>
                            <p>{{ __('Degrees, certifications, and executive programs.') }}</p>
                        </header>
                        <div class="corporate-education">
                            @foreach ($templateData['education'] as $education)
                                <article>
                                    <div class="corporate-education__head">
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
                                        <p class="corporate-education__location">{{ $education['location'] }}</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>

            <aside class="corporate-aside">
                @if (!empty($templateData['skills']))
                    <section>
                        <h2>{{ __('Core Skills') }}</h2>
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
        </div>
    </div>
</body>
</html>
