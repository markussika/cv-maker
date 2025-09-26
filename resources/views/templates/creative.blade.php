<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Creative · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/creative.css') }}">
</head>
<body class="creative-template">
    @php
        $templateData = \App\View\TemplateDataBuilder::fromCv($cv ?? null);
        $data = $templateData;
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
        $profileImage = $data['profile_image'] ?? null;
    @endphp

    <div class="creative-canvas">
        <header class="creative-banner">
            <div class="creative-nameplate">
                <div class="creative-avatar">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $data['name'] ?? __('Profile photo') }}">
                    @elseif ($initials !== '')
                        <span>{{ $initials }}</span>
                    @else
                        <span>{{ __('CV') }}</span>
                    @endif
                </div>
                <div>
                    <p class="creative-badge">{{ __('Creative Resume') }}</p>
                    <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                    @if ($data['headline'])
                        <p class="creative-headline">{{ $data['headline'] }}</p>
                    @endif
                </div>
            </div>
            @if (!empty($data['contacts']))
                <ul class="creative-contact-list">
                    @foreach ($data['contacts'] as $contact)
                        <li>{{ $contact }}</li>
                    @endforeach
                </ul>
            @endif
        </header>

        <main class="creative-body">
            <section class="creative-intro">
                @if ($data['summary'])
                    <article class="creative-panel creative-panel--summary">
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </article>
                @endif

                @if (!empty($data['skills']))
                    <article class="creative-panel creative-panel--skills">
                        <h2>{{ __('Skills') }}</h2>
                        <ul>
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endif

                @if (!empty($data['languages']) || !empty($data['hobbies']))
                    <article class="creative-panel creative-panel--extra">
                        @if (!empty($data['languages']))
                            <div>
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
                            <div>
                                <h2>{{ __('Interests') }}</h2>
                                <ul>
                                    @foreach ($data['hobbies'] as $hobby)
                                        <li>{{ $hobby }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </article>
                @endif
            </section>

            @if (!empty($data['experiences']))
                <section class="creative-section creative-section--experience">
                    <header>
                        <h2>{{ __('Experience Highlights') }}</h2>
                        <p>{{ __('Projects and achievements that define your craft.') }}</p>
                    </header>
                    <div class="creative-experience">
                        @foreach ($data['experiences'] as $experience)
                            <article>
                                <div class="creative-experience__meta">
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
                                    <p class="creative-experience__summary">{{ $experience['summary'] }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($data['education']))
                <section class="creative-section creative-section--education">
                    <header>
                        <h2>{{ __('Education') }}</h2>
                        <p>{{ __('Courses, certifications, and workshops.') }}</p>
                    </header>
                    <div class="creative-education">
                        @foreach ($data['education'] as $education)
                            <article>
                                <div class="creative-education__head">
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
                                    <p class="creative-education__location">{{ $education['location'] }}</p>
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
