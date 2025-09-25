<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classic · {{ config('app.name', 'CreateIt') }}</title>
    <style>
        :root {
            --slate-900: #0f172a;
            --slate-700: #334155;
            --slate-500: #64748b;
            --slate-200: #e2e8f0;
            --slate-100: #f1f5f9;
            --accent: #1f2937;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Georgia", "Times New Roman", serif;
            color: var(--slate-900);
            background: var(--slate-100);
            padding: 40px;
            line-height: 1.6;
            font-size: 14px;
        }

        .page {
            background: #fff;
            border: 1px solid var(--slate-200);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
        }

        header {
            padding: 40px;
            border-bottom: 1px solid var(--slate-200);
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 24px;
            align-items: center;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.04), rgba(148, 163, 184, 0.12));
        }

        header h1 {
            margin: 0;
            font-size: 32px;
            letter-spacing: 0.02em;
        }

        header p {
            margin: 6px 0 0;
            font-size: 15px;
            color: var(--slate-500);
        }

        .contact {
            text-align: right;
            font-size: 12px;
            color: var(--slate-500);
        }

        .layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 32px;
            padding: 40px;
        }

        .sidebar {
            border-right: 1px solid var(--slate-200);
            padding-right: 32px;
        }

        h2 {
            text-transform: uppercase;
            letter-spacing: 0.3em;
            font-size: 12px;
            color: var(--slate-500);
            margin: 0 0 16px;
        }

        h3 {
            margin: 0;
            font-size: 16px;
            color: var(--accent);
        }

        .section {
            margin-bottom: 32px;
        }

        .section:last-child {
            margin-bottom: 0;
        }

        .item {
            margin-bottom: 20px;
        }

        .item:last-child {
            margin-bottom: 0;
        }

        .meta {
            color: var(--slate-500);
            font-size: 12px;
            margin-top: 6px;
        }

        ul {
            padding-left: 18px;
            margin: 0;
        }

        li {
            margin-bottom: 8px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.32em;
            color: var(--slate-500);
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(148, 163, 184, 0.6), transparent);
            margin: 24px 0;
        }

        .summary {
            background: rgba(15, 23, 42, 0.04);
            padding: 18px;
            border-radius: 12px;
            font-size: 13px;
            color: var(--slate-700);
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
            <div>
                <span class="badge">{{ __('Classic Resume') }}</span>
                <h1>{{ $data['name'] ?? __('Your Name') }}</h1>
                @if ($data['headline'])
                    <p>{{ $data['headline'] }}</p>
                @endif
            </div>
            <div class="contact">
                @foreach ($data['contacts'] as $contact)
                    <div>{{ $contact }}</div>
                @endforeach
            </div>
        </header>

        <div class="layout">
            <aside class="sidebar">
                @if ($data['summary'])
                    <div class="section">
                        <h2>{{ __('Profile') }}</h2>
                        <div class="summary">{{ $data['summary'] }}</div>
                    </div>
                @endif

                @if (!empty($data['skills']))
                    <div class="section">
                        <h2>{{ __('Skills') }}</h2>
                        <ul>
                            @foreach ($data['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!empty($data['languages']))
                    <div class="section">
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

                @if (!empty($data['hobbies']))
                    <div class="section">
                        <h2>{{ __('Interests') }}</h2>
                        <ul>
                            @foreach ($data['hobbies'] as $hobby)
                                <li>{{ $hobby }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>

            <main>
                @if (!empty($data['experiences']))
                    <div class="section">
                        <h2>{{ __('Experience') }}</h2>
                        @foreach ($data['experiences'] as $experience)
                            <div class="item">
                                @if ($experience['role'])
                                    <h3>{{ $experience['role'] }}</h3>
                                @endif
                                <div class="meta">
                                    {{ $experience['company'] }}
                                    @if ($experience['company'] && $experience['location'])
                                        &middot;
                                    @endif
                                    {{ $experience['location'] }}
                                </div>
                                @if ($experience['period'])
                                    <div class="meta">{{ $experience['period'] }}</div>
                                @endif
                                @if ($experience['summary'])
                                    <p class="meta" style="margin-top: 12px; color: var(--slate-700); font-size: 13px;">{{ $experience['summary'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (!empty($data['education']))
                    <div class="divider"></div>
                    <div class="section">
                        <h2>{{ __('Education') }}</h2>
                        @foreach ($data['education'] as $education)
                            <div class="item">
                                @if ($education['degree'])
                                    <h3>{{ $education['degree'] }}</h3>
                                @endif
                                <div class="meta">
                                    {{ $education['institution'] }}
                                    @if ($education['institution'] && $education['location'])
                                        &middot;
                                    @endif
                                    {{ $education['location'] }}
                                </div>
                                @if ($education['period'])
                                    <div class="meta">{{ $education['period'] }}</div>
                                @endif
                                @if ($education['field'])
                                    <div class="meta" style="margin-top: 8px; color: var(--slate-700);">{{ $education['field'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>
