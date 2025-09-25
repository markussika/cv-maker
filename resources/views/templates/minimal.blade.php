<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minimal · {{ config('app.name', 'CreateIt') }}</title>
    <style>
        :root {
            --ink: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --soft: #f8fafc;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "IBM Plex Sans", Arial, sans-serif;
            color: var(--ink);
            background: var(--soft);
            padding: 48px;
            font-size: 13px;
            line-height: 1.7;
        }

        .page {
            max-width: 760px;
            margin: 0 auto;
            background: #fff;
            border-radius: 28px;
            border: 1px solid var(--border);
            padding: 48px 60px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.08);
        }

        header {
            text-align: center;
            margin-bottom: 48px;
        }

        header h1 {
            margin: 0;
            font-size: 30px;
            letter-spacing: 0.04em;
        }

        header p {
            margin: 10px 0 0;
            color: var(--muted);
            font-size: 14px;
        }

        .contact {
            margin-top: 24px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            color: var(--muted);
            font-size: 12px;
        }

        .section {
            margin-bottom: 36px;
        }

        .section:last-child {
            margin-bottom: 0;
        }

        .section h2 {
            margin: 0 0 16px;
            font-size: 12px;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .item {
            margin-bottom: 24px;
        }

        .item:last-child {
            margin-bottom: 0;
        }

        .item h3 {
            margin: 0;
            font-size: 16px;
            letter-spacing: 0.01em;
        }

        .meta {
            margin-top: 6px;
            font-size: 12px;
            color: var(--muted);
        }

        .item p {
            margin-top: 12px;
            color: var(--muted);
            font-size: 13px;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        li {
            margin-bottom: 8px;
        }

        .pill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pill {
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 6px 14px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    @include('templates.partials.base-data', ['cv' => $cv])

    @php
        $data = $templateData;
    @endphp

    <div class="page">
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

        @if ($data['summary'])
            <section class="section">
                <h2>{{ __('Profile') }}</h2>
                <p>{{ $data['summary'] }}</p>
            </section>
        @endif

        @if (!empty($data['experiences']))
            <section class="section">
                <h2>{{ __('Experience') }}</h2>
                @foreach ($data['experiences'] as $experience)
                    <article class="item">
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
            <section class="section">
                <h2>{{ __('Education') }}</h2>
                @foreach ($data['education'] as $education)
                    <article class="item">
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

        @if (!empty($data['skills']))
            <section class="section">
                <h2>{{ __('Skills') }}</h2>
                <div class="pill-list">
                    @foreach ($data['skills'] as $skill)
                        <span class="pill">{{ $skill }}</span>
                    @endforeach
                </div>
            </section>
        @endif

        @if (!empty($data['languages']))
            <section class="section">
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
            </section>
        @endif

        @if (!empty($data['hobbies']))
            <section class="section">
                <h2>{{ __('Interests') }}</h2>
                <ul>
                    @foreach ($data['hobbies'] as $hobby)
                        <li>{{ $hobby }}</li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
</body>
</html>
