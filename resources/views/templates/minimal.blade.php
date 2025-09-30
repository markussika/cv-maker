<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minimal · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/minimal.css') }}">
</head>
<body class="minimal-template">
    <div class="minimal-page">
        <header class="minimal-header">
            <div class="minimal-identity">
                <div class="minimal-avatar">
                    @if (!empty($templateData['profile_image']))
                        <img src="{{ $templateData['profile_image'] }}" alt="{{ $templateData['name'] ?? __('Profile photo') }}">
                    @elseif (!empty($templateData['initials']))
                        <span>{{ $templateData['initials'] }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <h1>{{ $templateData['name'] ?? __('Your Name') }}</h1>
                    @if (!empty($templateData['headline']))
                        <p>{{ $templateData['headline'] }}</p>
                    @endif
                </div>
            </div>
            @if (!empty($templateData['contacts']))
                <div class="minimal-contact">
                    <h2>{{ __('Contact') }}</h2>
                    <ul>
                        @foreach ($templateData['contacts'] as $contact)
                            <li>{{ $contact }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </header>

        <main class="minimal-body">
            @if (!empty($templateData['summary']))
                <section class="minimal-section minimal-section--summary">
                    <h2>{{ __('Summary') }}</h2>
                    <p>{{ $templateData['summary'] }}</p>
                </section>
            @endif

            @if (!empty($templateData['experiences']))
                <section class="minimal-section">
                    <h2>{{ __('Experience') }}</h2>
                    <div class="minimal-timeline">
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
                                    <p class="minimal-note">{{ $experience['summary'] }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($templateData['education']))
                <section class="minimal-section">
                    <h2>{{ __('Education') }}</h2>
                    <div class="minimal-education">
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
                                    <p class="minimal-muted">{{ $education['location'] }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($templateData['skills']) || !empty($templateData['languages']) || !empty($templateData['hobbies']))
                <section class="minimal-section minimal-section--grid">
                    @if (!empty($templateData['skills']))
                        <div class="minimal-card">
                            <h2>{{ __('Skills') }}</h2>
                            <ul>
                                @foreach ($templateData['skills'] as $skill)
                                    <li>{{ $skill }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (!empty($templateData['languages']))
                        <div class="minimal-card">
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
                        </div>
                    @endif
                    @if (!empty($templateData['hobbies']))
                        <div class="minimal-card">
                            <h2>{{ __('Interests') }}</h2>
                            <ul>
                                @foreach ($templateData['hobbies'] as $hobby)
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
