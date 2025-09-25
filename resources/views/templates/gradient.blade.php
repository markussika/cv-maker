<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gradient · {{ config('app.name', 'CreateIt') }}</title>
    <style>
        :root {
            --emerald: #34d399;
            --teal: #14b8a6;
            --cyan: #22d3ee;
            --slate-900: #0f172a;
            --slate-500: #64748b;
            --slate-200: #e2e8f0;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Manrope", "Helvetica Neue", Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: var(--slate-900);
            background: linear-gradient(135deg, rgba(52, 211, 153, 0.4), rgba(34, 211, 238, 0.45));
            padding: 40px;
        }

        .wrapper {
            max-width: 860px;
            margin: 0 auto;
            background: #fff;
            border-radius: 36px;
            overflow: hidden;
            box-shadow: 0 30px 90px rgba(15, 23, 42, 0.18);
        }

        header {
            background: linear-gradient(120deg, rgba(52, 211, 153, 0.92), rgba(20, 184, 166, 0.92));
            color: #fff;
            padding: 48px 60px 56px;
        }

        header h1 {
            margin: 0;
            font-size: 36px;
            letter-spacing: 0.03em;
        }

        header p {
            margin: 10px 0 0;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.85);
        }

        .contact {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
        }

        .content {
            padding: 48px 60px;
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 40px;
        }

        h2 {
            margin: 0 0 18px;
            font-size: 12px;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: var(--slate-500);
        }

        .entry {
            margin-bottom: 26px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        .entry:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .entry h3 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 0.01em;
        }

        .meta {
            margin-top: 6px;
            font-size: 12px;
            color: var(--slate-500);
        }

        .entry p {
            margin-top: 12px;
            font-size: 13px;
            color: var(--slate-500);
        }

        .card {
            background: linear-gradient(145deg, rgba(52, 211, 153, 0.12), rgba(34, 211, 238, 0.18));
            border-radius: 24px;
            padding: 24px;
            border: 1px solid rgba(20, 184, 166, 0.2);
            margin-bottom: 24px;
        }

        .card:last-child {
            margin-bottom: 0;
        }

        .pill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pill {
            background: rgba(15, 23, 42, 0.08);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
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

    <div class="wrapper">
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
                    <div class="entry" style="border-bottom: none; margin-bottom: 32px; padding-bottom: 0;">
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
                    <div class="card">
                        <h2>{{ __('Skills') }}</h2>
                        <div class="pill-list">
                            @foreach ($data['skills'] as $skill)
                                <span class="pill">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (!empty($data['languages']))
                    <div class="card">
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
                    <div class="card">
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
