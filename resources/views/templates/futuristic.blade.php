<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Futuristic · {{ config('app.name', 'CreateIt') }}</title>
    <style>
        :root {
            --midnight: #0b1120;
            --violet: #7c3aed;
            --cyan: #22d3ee;
            --magenta: #f472b6;
            --text: #f8fafc;
            --muted: #a5b4fc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Archivo", "Inter", sans-serif;
            background: radial-gradient(circle at 20% 20%, rgba(124, 58, 237, 0.28), transparent 55%),
                radial-gradient(circle at 80% 0%, rgba(34, 211, 238, 0.24), transparent 50%),
                var(--midnight);
            color: var(--text);
            font-size: 13px;
            line-height: 1.6;
            padding: 40px;
        }

        .grid {
            max-width: 880px;
            margin: 0 auto;
            border-radius: 36px;
            border: 1px solid rgba(124, 58, 237, 0.2);
            overflow: hidden;
            background: linear-gradient(140deg, rgba(15, 23, 42, 0.92), rgba(12, 10, 43, 0.95));
            box-shadow: 0 40px 120px rgba(15, 23, 42, 0.35);
        }

        header {
            padding: 48px 60px;
            border-bottom: 1px solid rgba(124, 58, 237, 0.2);
        }

        header h1 {
            margin: 0;
            font-size: 32px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        header p {
            margin: 14px 0 0;
            font-size: 15px;
            color: var(--muted);
        }

        .contact {
            margin-top: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 11px;
            color: rgba(165, 180, 252, 0.85);
        }

        .body {
            display: grid;
            grid-template-columns: 1fr 260px;
            gap: 40px;
            padding: 48px 60px;
        }

        h2 {
            margin: 0 0 18px;
            font-size: 12px;
            letter-spacing: 0.5em;
            text-transform: uppercase;
            color: rgba(165, 180, 252, 0.7);
        }

        .entry {
            margin-bottom: 26px;
            border-left: 3px solid rgba(124, 58, 237, 0.35);
            padding-left: 18px;
        }

        .entry:last-child {
            margin-bottom: 0;
        }

        .entry h3 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .meta {
            margin-top: 6px;
            font-size: 11px;
            color: rgba(165, 180, 252, 0.85);
        }

        .entry p {
            margin-top: 12px;
            font-size: 13px;
            color: rgba(226, 232, 240, 0.85);
        }

        .panel {
            background: linear-gradient(145deg, rgba(124, 58, 237, 0.18), rgba(34, 211, 238, 0.18));
            border-radius: 24px;
            padding: 24px;
            border: 1px solid rgba(124, 58, 237, 0.2);
            margin-bottom: 24px;
        }

        .panel:last-child {
            margin-bottom: 0;
        }

        .chip-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .chip {
            background: rgba(124, 58, 237, 0.2);
            color: var(--text);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
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

    <div class="grid">
        <header>
            <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
            @if ($data['headline'])
                <p>{{ $data['headline'] }}</p>
            @endif
            @if (!empty($data['contacts']))
                <div class="contact">
                    @foreach ($data['contacts'] as $contact)
                        <span>{{ $contact }}</span>
                    @endforeach
                </div>
            @endif
        </header>

        <div class="body">
            <section>
                @if ($data['summary'])
                    <div class="entry" style="border-left-color: rgba(244, 114, 182, 0.45);">
                        <h2>{{ __('Profile') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </div>
                @endif

                @if (!empty($data['experiences']))
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
                @endif

                @if (!empty($data['education']))
                    <h2>{{ __('Education') }}</h2>
                    @foreach ($data['education'] as $education)
                        <article class="entry">
                            @if ($education['degree'])
                                <h3>{{ $education['degree'] }}</h3>
                            @endif
                            <div class="meta">
                                {{ $education['institution'] }}
                                @if ($education['institution'] && $education['location'])
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
                @endif
            </section>

            <aside>
                @if (!empty($data['skills']))
                    <div class="panel">
                        <h2>{{ __('Skills') }}</h2>
                        <div class="chip-list">
                            @foreach ($data['skills'] as $skill)
                                <span class="chip">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (!empty($data['languages']))
                    <div class="panel">
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

                @if (!empty($data['hobbies']))
                    <div class="panel">
                        <h2>{{ __('Interests') }}</h2>
                        <ul>
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</body>
</html>
