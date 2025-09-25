<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dark Mode · {{ config('app.name', 'CreateIt') }}</title>
    <style>
        :root {
            --bg: #0f172a;
            --panel: #111827;
            --muted: #94a3b8;
            --accent: #38bdf8;
            --soft: #1e293b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Space Grotesk", "Inter", sans-serif;
            background: radial-gradient(circle at top left, rgba(56, 189, 248, 0.18), transparent 55%), var(--bg);
            color: #f8fafc;
            font-size: 14px;
            line-height: 1.6;
            padding: 40px;
        }

        .shell {
            max-width: 820px;
            margin: 0 auto;
            background: linear-gradient(145deg, rgba(17, 24, 39, 0.95), rgba(15, 23, 42, 0.95));
            border-radius: 32px;
            border: 1px solid rgba(56, 189, 248, 0.18);
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(8, 47, 73, 0.25);
        }

        header {
            padding: 48px 56px;
            border-bottom: 1px solid rgba(56, 189, 248, 0.12);
        }

        header h1 {
            margin: 0;
            font-size: 34px;
            letter-spacing: 0.05em;
        }

        header p {
            margin: 12px 0 0;
            font-size: 16px;
            color: var(--muted);
        }

        .contact {
            margin-top: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12px;
            color: rgba(148, 163, 184, 0.85);
        }

        .content {
            display: grid;
            grid-template-columns: 1fr 260px;
            gap: 40px;
            padding: 48px 56px;
        }

        h2 {
            margin: 0 0 18px;
            font-size: 12px;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: rgba(148, 163, 184, 0.7);
        }

        .entry {
            margin-bottom: 26px;
        }

        .entry:last-child {
            margin-bottom: 0;
        }

        .entry h3 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 0.02em;
            color: #e2e8f0;
        }

        .meta {
            margin-top: 6px;
            font-size: 12px;
            color: rgba(148, 163, 184, 0.8);
        }

        .entry p {
            margin-top: 12px;
            font-size: 13px;
            color: rgba(226, 232, 240, 0.8);
        }

        .panel {
            background: var(--soft);
            border-radius: 24px;
            padding: 24px;
            border: 1px solid rgba(148, 163, 184, 0.12);
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
            background: rgba(56, 189, 248, 0.12);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            color: #e0f2fe;
            border: 1px solid rgba(56, 189, 248, 0.2);
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

    <div class="shell">
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

        <div class="content">
            <section>
                @if ($data['summary'])
                    <div class="entry">
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
