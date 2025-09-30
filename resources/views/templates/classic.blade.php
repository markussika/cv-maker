<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classic · {{ config('app.name', 'CreateIt') }}</title>
    <link rel="stylesheet" href="{{ asset('templates/css/classic.css') }}">
</head>
<body class="classic-template">
    <div class="page">
        <header class="page-header">
            <div class="header-main">
                @if (!empty($templateData['profile_image']) || !empty($templateData['initials']))
                    <div class="portrait">
                        @if (!empty($templateData['profile_image']))
                            <img src="{{ $templateData['profile_image'] }}" alt="{{ $templateData['name'] ?? __('Profile photo') }}">
                        @elseif (!empty($templateData['initials']))
                            <span>{{ $templateData['initials'] }}</span>
                        @else
                            <span>{{ __('CV') }}</span>
                        @endif
                    </div>
                @endif
                <div class="hero-text">
                    <h1>{{ $templateData['name'] ?? __('Your Name') }}</h1>
                    @if (!empty($classic['tagline']))
                        <p class="headline">{{ $classic['tagline'] }}</p>
                    @endif
                </div>
            </div>
            @if (!empty($templateData['contacts']))
                <div class="contact">
                    @foreach ($templateData['contacts'] as $contact)
                        <span>{{ $contact }}</span>
                    @endforeach
                </div>
            @endif
        </header>

        <div class="page-body">
            @if (!empty($classic['achievementLines']) || !empty($classic['summaryParagraphs']))
                <div class="intro-block">
                    @if (!empty($classic['achievementLines']))
                        <section class="section achievements">
                            <h2>{{ __('Key Achievements') }}</h2>
                            <ul class="achievements-list">
                                @foreach ($classic['achievementLines'] as $line)
                                    <li>{{ $line }}</li>
                                @endforeach
                            </ul>
                        </section>
                    @endif

                    @if (!empty($classic['summaryParagraphs']))
                        <section class="section summary-block">
                            <h2>{{ __('Taking On Challenges') }}</h2>
                            <div class="summary-text">
                                @foreach ($classic['summaryParagraphs'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>
            @endif

            <div class="content-grid {{ !empty($classic['hasSecondaryColumn']) ? 'two-columns' : 'single-column' }}">
                <div class="primary-column">
                    @if (!empty($templateData['education']))
                        <section class="section education">
                            <h2>{{ __('Education') }}</h2>
                            <div class="entries">
                                @foreach ($templateData['education'] as $education)
                                    <article class="entry">
                                        <div class="entry-heading">
                                            <div>
                                                @if ($education['degree'])
                                                    <h3>{{ $education['degree'] }}</h3>
                                                @endif
                                                @if ($education['institution'])
                                                    <div class="entry-subtitle">{{ $education['institution'] }}</div>
                                                @endif
                                                @if ($education['location'])
                                                    <div class="entry-location">{{ $education['location'] }}</div>
                                                @endif
                                            </div>
                                            @if ($education['period'])
                                                <div class="entry-period">{{ $education['period'] }}</div>
                                            @endif
                                        </div>
                                        @if ($education['field'])
                                            <div class="entry-meta-line">{{ $education['field'] }}</div>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if (!empty($classic['experiences']))
                        <section class="section experience">
                            <h2>{{ __('Experience') }}</h2>
                            <div class="entries">
                                @foreach ($classic['experiences'] as $experience)
                                    <article class="entry">
                                        <div class="entry-heading">
                                            <div>
                                                @if ($experience['role'])
                                                    <h3>{{ $experience['role'] }}</h3>
                                                @endif
                                                @if (!empty($experience['company']) || !empty($experience['location']))
                                                    <div class="entry-subtitle">
                                                        {{ $experience['company'] ?? '' }}
                                                        @if (!empty($experience['company']) && !empty($experience['location']))
                                                            ·
                                                        @endif
                                                        {{ $experience['location'] ?? '' }}
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($experience['period'])
                                                <div class="entry-period">{{ $experience['period'] }}</div>
                                            @endif
                                        </div>

                                        @if (!empty($experience['has_summary_list']) && $experience['has_summary_list'])
                                            <ul class="entry-points">
                                                @foreach ($experience['summary_points'] as $point)
                                                    <li>{{ $point }}</li>
                                                @endforeach
                                            </ul>
                                        @elseif (!empty($experience['summary_first_point']))
                                            <p class="entry-description">{{ $experience['summary_first_point'] }}</p>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                @if (!empty($classic['hasSecondaryColumn']))
                    <aside class="secondary-column">
                        @if (!empty($templateData['skills']))
                            <section class="section skills">
                                <h2>{{ __('Technical Skills') }}</h2>
                                <ul class="skills-list">
                                    @foreach ($templateData['skills'] as $skill)
                                        <li>{{ $skill }}</li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif

                        @if (!empty($templateData['languages']))
                            <section class="section languages">
                                <h2>{{ __('Languages') }}</h2>
                                <ul class="languages-list">
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
                            <section class="section hobbies">
                                <h2>{{ __('Interests') }}</h2>
                                <ul class="hobbies-list">
                                    @foreach ($templateData['hobbies'] as $hobby)
                                        <li>{{ $hobby }}</li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    </aside>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
