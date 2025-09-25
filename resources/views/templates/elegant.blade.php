<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elegant · {{ config('app.name', 'CreateIt') }}</title>
    <style>
        :root {
            --charcoal: #1f2933;
            --taupe: #6b7280;
            --blush: #f5e1e5;
            --gold: #d97706;
            --paper: #fff9f2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Cormorant Garamond", "Georgia", serif;
            background: linear-gradient(140deg, rgba(245, 225, 229, 0.7), rgba(255, 249, 242, 0.9));
            color: var(--charcoal);
            font-size: 15px;
            line-height: 1.6;
            padding: 40px;
        }

        .sheet {
            background: var(--paper);
            border-radius: 32px;
            padding: 52px 64px;
            max-width: 780px;
            margin: 0 auto;
            box-shadow: 0 25px 60px rgba(31, 41, 51, 0.12);
            border: 1px solid rgba(217, 119, 6, 0.12);
        }

        header {
            text-align: center;
            margin-bottom: 48px;
        }

        header h1 {
            margin: 0;
            font-size: 44px;
            letter-spacing: 0.08em;
        }

        header p {
            margin: 12px 0 0;
            font-size: 18px;
            color: var(--taupe);
        }

        .contact {
            margin-top: 24px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 16px;
            font-size: 13px;
            color: var(--taupe);
        }

        .rule {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(217, 119, 6, 0.6), transparent);
            margin: 40px 0;
        }

        h2 {
            margin: 0 0 20px;
            text-transform: uppercase;
            letter-spacing: 0.4em;
            font-size: 13px;
            color: rgba(31, 41, 51, 0.6);
        }

        .item {
            margin-bottom: 28px;
        }

        .item:last-child {
            margin-bottom: 0;
        }

        .item h3 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 0.06em;
        }

        .meta {
            margin-top: 6px;
            font-size: 14px;
            color: var(--taupe);
            font-style: italic;
        }

        .item p {
            margin-top: 12px;
            color: var(--taupe);
            font-size: 15px;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }

        li {
            margin-bottom: 10px;
        }

        .list-columns {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 999px;
            border: 1px solid rgba(217, 119, 6, 0.3);
            font-size: 13px;
        }
    </style>
</head>
<body>
    @include('templates.partials.base-data', ['cv' => $cv])

    @php
        $data = $templateData;
    @endphp

    <div class="sheet">
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
            <section>
                <h2>{{ __('Profile') }}</h2>
                <p>{{ $data['summary'] }}</p>
                <div class="rule"></div>
            </section>
        @endif

        @if (!empty($data['experiences']))
            <section>
                <h2>{{ __('Experience') }}</h2>
                @foreach ($data['experiences'] as $experience)
                    <article class="item">
                        @if ($experience['role'])
                            <h3>{{ $experience['role'] }}</h3>
                        @endif
                        <div class="meta">
                            {{ $experience['company'] }}
                            @if ($experience['company'] && $experience['location'])
                                &bull;
                            @endif
                            {{ $experience['location'] }}
                            @if ($experience['period'])
                                &bull;
                                {{ $experience['period'] }}
                            @endif
                        </div>
                        @if ($experience['summary'])
                            <p>{{ $experience['summary'] }}</p>
                        @endif
                    </article>
                @endforeach
                <div class="rule"></div>
            </section>
        @endif

        @if (!empty($data['education']))
            <section>
                <h2>{{ __('Education') }}</h2>
                @foreach ($data['education'] as $education)
                    <article class="item">
                        @if ($education['degree'])
                            <h3>{{ $education['degree'] }}</h3>
                        @endif
                        <div class="meta">
                            {{ $education['institution'] }}
                            @if ($education['institution'] && $education['location'])
                                &bull;
                            @endif
                            {{ $education['location'] }}
                            @if ($education['period'])
                                &bull;
                                {{ $education['period'] }}
                            @endif
                        </div>
                        @if ($education['field'])
                            <p>{{ $education['field'] }}</p>
                        @endif
                    </article>
                @endforeach
                <div class="rule"></div>
            </section>
        @endif

        @if (!empty($data['skills']))
            <section>
                <h2>{{ __('Expertise') }}</h2>
                <div class="list-columns">
                    @foreach ($data['skills'] as $skill)
                        <span class="tag">{{ $skill }}</span>
                    @endforeach
                </div>
                <div class="rule"></div>
            </section>
        @endif

        @if (!empty($data['languages']) || !empty($data['hobbies']))
            <section>
                <h2>{{ __('Refinements') }}</h2>
                <div class="list-columns">
                    <div>
                        @if (!empty($data['languages']))
                            <strong>{{ __('Languages') }}</strong>
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
                        @endif
                    </div>
                    <div>
                        @if (!empty($data['hobbies']))
                            <strong>{{ __('Interests') }}</strong>
                            <ul>
                                @foreach ($data['hobbies'] as $hobby)
                                    <li>{{ $hobby }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </section>
        @endif
    </div>
</body>
</html>
