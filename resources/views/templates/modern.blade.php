<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modern · {{ config('app.name', 'CreateIt') }}</title>
    <style>
        :root {
            --blue-700: #1d4ed8;
            --blue-500: #2563eb;
            --slate-900: #0f172a;
            --slate-600: #475569;
            --slate-200: #e2e8f0;
            --slate-100: #f1f5f9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Inter", "Helvetica Neue", Arial, sans-serif;
            background: var(--slate-100);
            color: var(--slate-900);
            font-size: 14px;
            line-height: 1.6;
            padding: 36px;
        }

        .grid {
            display: grid;
            grid-template-columns: 260px 1fr;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid var(--slate-200);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
        }

        aside {
            background: linear-gradient(160deg, var(--blue-700), var(--blue-500));
            color: #fff;
            padding: 40px 32px;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        aside h2 {
            font-size: 12px;
            letter-spacing: 0.32em;
            text-transform: uppercase;
            margin: 0 0 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .avatar {
            width: 88px;
            height: 88px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .name {
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.02em;
            margin: 0;
        }

        .headline {
            color: rgba(255, 255, 255, 0.75);
            font-size: 14px;
            margin-top: 6px;
        }

        .contact {
            display: grid;
            gap: 8px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.75);
        }

        .summary {
            background: rgba(15, 23, 42, 0.12);
            border-radius: 16px;
            padding: 18px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
        }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tag {
            background: rgba(15, 23, 42, 0.18);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            color: #fff;
        }

        main {
            background: #fff;
            padding: 48px;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        main h2 {
            font-size: 12px;
            letter-spacing: 0.32em;
            text-transform: uppercase;
            margin: 0 0 20px;
            color: var(--slate-600);
        }

        .entry {
            margin-bottom: 24px;
        }

        .entry:last-child {
            margin-bottom: 0;
        }

        .entry h3 {
            margin: 0;
            font-size: 17px;
            color: var(--slate-900);
            letter-spacing: 0.01em;
        }

        .entry .meta {
            margin-top: 6px;
            font-size: 12px;
            color: var(--slate-600);
        }

        .entry p {
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
        $initials = collect([$data['first_name'] ?? null, $data['last_name'] ?? null])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => mb_strtoupper(mb_substr(trim($item), 0, 1)))
            ->implode('');
    @endphp

    <div class="grid">
        <aside>
            <div>
                <div class="avatar">{{ $initials !== '' ? $initials : 'CV' }}</div>
                <p class="name">{{ $data['name'] ?? __('Your Name') }}</p>
                @if ($data['headline'])
                    <p class="headline">{{ $data['headline'] }}</p>
                @endif
            </div>

            @if (!empty($data['contacts']))
                <div>
                    <h2>{{ __('Contact') }}</h2>
                    <div class="contact">
                        @foreach ($data['contacts'] as $contact)
                            <div>{{ $contact }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($data['summary'])
                <div>
                    <h2>{{ __('About') }}</h2>
                    <div class="summary">{{ $data['summary'] }}</div>
                </div>
            @endif

            @if (!empty($data['skills']))
                <div>
                    <h2>{{ __('Skills') }}</h2>
                    <div class="tag-list">
                        @foreach ($data['skills'] as $skill)
                            <span class="tag">{{ $skill }}</span>
                        @endforeach
                    </div>
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

            @if (!empty($data['languages']))
                <section>
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
        </main>
    </div>
</body>
</html>
