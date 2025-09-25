<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Creative · {{ config('app.name', 'CreateIt') }}</title>
    <style>
        :root {
            --pink: #ec4899;
            --purple: #8b5cf6;
            --sky: #38bdf8;
            --ink: #0f172a;
            --slate-600: #475569;
            --slate-400: #94a3b8;
            --paper: #fdf4ff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Poppins", "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(120deg, rgba(236, 72, 153, 0.1), rgba(59, 130, 246, 0.08));
            color: var(--ink);
            font-size: 14px;
            line-height: 1.6;
            padding: 36px;
        }

        .canvas {
            background: #fff;
            border-radius: 36px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.14);
            border: 1px solid rgba(148, 163, 184, 0.4);
        }

        header {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.92), rgba(59, 130, 246, 0.92));
            color: #fff;
            padding: 48px 56px 56px;
            position: relative;
        }

        header::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(56, 189, 248, 0.35), transparent 45%);
            pointer-events: none;
        }

        .heading {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .eyebrow {
            font-size: 12px;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }

        .name {
            margin: 0;
            font-size: 34px;
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        .headline {
            margin: 0;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
        }

        .contact {
            margin-top: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
        }

        .body {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 40px;
            padding: 48px 56px 56px;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .card {
            background: var(--paper);
            border-radius: 24px;
            padding: 24px;
            border: 1px solid rgba(236, 72, 153, 0.15);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.4);
        }

        .card h2,
        .section h2 {
            margin: 0 0 16px;
            font-size: 13px;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: var(--slate-400);
        }

        .card p {
            margin: 0;
            font-size: 13px;
            color: var(--slate-600);
        }

        .badge-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .badge {
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
            background: rgba(236, 72, 153, 0.12);
            color: var(--ink);
            border: 1px solid rgba(236, 72, 153, 0.3);
        }

        .section {
            margin-bottom: 32px;
        }

        .section:last-child {
            margin-bottom: 0;
        }

        .item {
            margin-bottom: 24px;
            padding-left: 18px;
            border-left: 3px solid rgba(236, 72, 153, 0.35);
        }

        .item:last-child {
            margin-bottom: 0;
        }

        .item h3 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 0.01em;
        }

        .meta {
            margin-top: 8px;
            font-size: 12px;
            color: var(--slate-600);
        }

        .item p {
            margin-top: 12px;
            font-size: 13px;
            color: var(--slate-600);
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

    <div class="canvas">
        <header>
            <div class="heading">
                <p class="eyebrow">{{ __('Creative Spirit') }}</p>
                <h1 class="name">{{ $data['name'] ?? __('Your Name') }}</h1>
                @if ($data['headline'])
                    <p class="headline">{{ $data['headline'] }}</p>
                @endif
                @if (!empty($data['contacts']))
                    <div class="contact">
                        @foreach ($data['contacts'] as $contact)
                            <span>{{ $contact }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </header>

        <div class="body">
            <aside class="sidebar">
                @if ($data['summary'])
                    <div class="card">
                        <h2>{{ __('Artist Statement') }}</h2>
                        <p>{{ $data['summary'] }}</p>
                    </div>
                @endif

                @if (!empty($data['skills']))
                    <div class="card">
                        <h2>{{ __('Skill Palette') }}</h2>
                        <div class="badge-list">
                            @foreach ($data['skills'] as $skill)
                                <span class="badge">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (!empty($data['hobbies']))
                    <div class="card">
                        <h2>{{ __('Playful Interests') }}</h2>
                        <ul>
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
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
                                        <span class="meta">&mdash; {{ ucfirst($language['level']) }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>

            <main>
                @if (!empty($data['experiences']))
                    <section class="section">
                        <h2>{{ __('Featured Work') }}</h2>
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
                        <h2>{{ __('Learning Journey') }}</h2>
                        @foreach ($data['education'] as $education)
                            <article class="item">
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
                    </section>
                @endif
            </main>
        </div>
    </div>
</body>
</html>
