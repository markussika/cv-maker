<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Corporate · {{ config('app.name', 'CreateIt') }}</title>
    <style>
        :root {
            --navy: #0f172a;
            --steel: #1e293b;
            --ash: #64748b;
            --cloud: #e2e8f0;
            --snow: #f8fafc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Source Sans Pro", Arial, sans-serif;
            background: var(--snow);
            color: var(--navy);
            font-size: 13px;
            line-height: 1.65;
            padding: 32px;
        }

        .layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.15);
            border: 1px solid rgba(100, 116, 139, 0.18);
        }

        aside {
            background: linear-gradient(180deg, var(--steel), var(--navy));
            color: #fff;
            padding: 40px 32px;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        aside h2 {
            margin: 0 0 14px;
            font-size: 12px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.7);
        }

        .identity h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 0.04em;
        }

        .identity p {
            margin: 8px 0 0;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.75);
        }

        .contact {
            display: grid;
            gap: 8px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.75);
        }

        .badge-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .badge {
            background: rgba(15, 23, 42, 0.35);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
        }

        main {
            background: #fff;
            padding: 48px;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        main h2 {
            margin: 0 0 18px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.35em;
            color: var(--ash);
        }

        .entry {
            margin-bottom: 24px;
            border-bottom: 1px solid var(--cloud);
            padding-bottom: 18px;
        }

        .entry:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .entry h3 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 0.02em;
        }

        .meta {
            margin-top: 6px;
            font-size: 12px;
            color: var(--ash);
        }

        .entry p {
            margin-top: 12px;
            color: var(--ash);
            font-size: 13px;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    @include('templates.partials.base-data', ['cv' => $cv])

    @php
        $data = $templateData;
    @endphp

    <div class="layout">
        <aside>
            <div class="identity">
                <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                @if ($data['headline'])
                    <p>{{ $data['headline'] }}</p>
                @endif
            </div>

            @if (!empty($data['contacts']))
                <div>
                    <h2>{{ __('Contact') }}</h2>
                    <div class="contact">
                        @foreach ($data['contacts'] as $contact)
                            <span>{{ $contact }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($data['summary'])
                <div>
                    <h2>{{ __('Summary') }}</h2>
                    <p style="font-size: 13px; line-height: 1.7; color: rgba(255, 255, 255, 0.8);">{{ $data['summary'] }}</p>
                </div>
            @endif

            @if (!empty($data['skills']))
                <div>
                    <h2>{{ __('Core Skills') }}</h2>
                    <div class="badge-list">
                        @foreach ($data['skills'] as $skill)
                            <span class="badge">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (!empty($data['languages']))
                <div>
                    <h2>{{ __('Languages') }}</h2>
                    <ul>
                        @foreach ($data['languages'] as $language)
                            <li>
                                {{ $language['name'] }}
                                @if (!empty($language['level']))
                                    &mdash; {{ ucfirst($language['level']) }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </aside>

        <main>
            @if (!empty($data['experiences']))
                <section>
                    <h2>{{ __('Experience') }}</h2>
                    @foreach ($data['experiences'] as $experience)
                        <article class="entry">
                            @if ($experience['role'])
                                <h3>{{ $experience['role'] }}</h3>
                            @endif
                            <div class="meta">
                                {{ $experience['company'] }}
                                @if ($experience['company'] && $experience['location'])
                                    &middot;
                                @endif
                                {{ $experience['location'] }}
                                @if ($experience['period'])
                                    &middot;
                                    {{ $experience['period'] }}
                                @endif
                            </div>
                            @if ($experience['summary'])
                                <p>{{ $experience['summary'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </section>
            @endif

            @if (!empty($data['education']))
                <section>
                    <h2>{{ __('Education') }}</h2>
                    @foreach ($data['education'] as $education)
                        <article class="entry">
                            @if ($education['institution'])
                                <h3>{{ $education['institution'] }}</h3>
                            @endif
                            <div class="meta">
                                {{ $education['degree'] }}
                                @if ($education['degree'] && $education['location'])
                                    &middot;
                                @endif
                                {{ $education['location'] }}
                                @if ($education['period'])
                                    &middot;
                                    {{ $education['period'] }}
                                @endif
                            </div>
                            @if ($education['field'])
                                <p>{{ $education['field'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </section>
            @endif

            @if (!empty($data['hobbies']))
                <section>
                    <h2>{{ __('Interests') }}</h2>
                    <ul>
                        @foreach ($data['hobbies'] as $hobby)
                            <li>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </main>
    </div>
</body>
</html>
