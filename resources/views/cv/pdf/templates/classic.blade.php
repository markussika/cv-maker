<style>
    .template-classic {
        background: #f8fafc;
    }
    .template-classic .classic-wrapper {
        width: 100%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 28px;
    }
    .template-classic .classic-header {
        border-bottom: 2px solid {{ $accentColor }};
        padding-bottom: 18px;
        margin-bottom: 22px;
    }
    .template-classic .classic-name {
        font-size: 26px;
        font-weight: 600;
        letter-spacing: 0.02em;
        color: #0f172a;
    }
    .template-classic .classic-headline {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.32em;
        color: {{ $accentColor }};
        margin-top: 6px;
    }
    .template-classic .classic-layout {
        display: grid;
        grid-template-columns: 2.2fr 1fr;
        gap: 28px;
    }
    .template-classic .classic-contact {
        display: grid;
        gap: 8px;
        font-size: 11px;
        color: #475569;
    }
    .template-classic .classic-section-title {
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.28em;
        color: {{ $accentColor }};
        margin-bottom: 10px;
    }
    .template-classic .classic-item {
        margin-bottom: 18px;
    }
    .template-classic .classic-item:last-child {
        margin-bottom: 0;
    }
    .template-classic .classic-item h3 {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }
    .template-classic .classic-meta {
        font-size: 11px;
        color: #64748b;
        margin-bottom: 4px;
    }
    .template-classic .classic-summary {
        font-size: 12px;
        color: #334155;
        margin-bottom: 20px;
    }
    .template-classic .classic-taglist {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    .template-classic .classic-tag {
        background: rgba(148, 163, 184, 0.2);
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        color: #475569;
    }
</style>
<div class="classic-wrapper">
    <header class="classic-header">
        <h1 class="classic-name">{{ $fullName ?: 'Curriculum Vitae' }}</h1>
        @if ($headline)
            <p class="classic-headline">{{ strtoupper($headline) }}</p>
        @endif
    </header>
    <div class="classic-layout">
        <main>
            @if ($summary)
                <section class="classic-summary">{{ $summary }}</section>
            @endif

            @if (!empty($experienceItems))
                <section class="classic-section">
                    <h2 class="classic-section-title">Experience</h2>
                    @foreach ($experienceItems as $experience)
                        <article class="classic-item">
                            @if ($experience['position'])
                                <h3>{{ $experience['position'] }}</h3>
                            @endif
                            <p class="classic-meta">
                                {{ $experience['company'] }}
                                @if ($experience['company'] && $experience['location'])
                                    &middot;
                                @endif
                                {{ $experience['location'] }}
                            </p>
                            <p class="classic-meta">
                                {{ $experience['from'] ?: 'Unknown' }}
                                &ndash;
                                {{ $experience['to'] ?: 'Unknown' }}
                            </p>
                            @if ($experience['achievements'])
                                <p>{{ $experience['achievements'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </section>
            @endif

            @if (!empty($educationItems))
                <section class="classic-section" style="margin-top: 24px;">
                    <h2 class="classic-section-title">Education</h2>
                    @foreach ($educationItems as $education)
                        <article class="classic-item">
                            @if ($education['institution'])
                                <h3>{{ $education['institution'] }}</h3>
                            @endif
                            <p class="classic-meta">
                                {{ collect([$education['degree'], $education['field']])->filter()->implode(' · ') }}
                            </p>
                            <p class="classic-meta">
                                {{ $education['location'] }}
                                @if ($education['location'] && ($education['start'] || $education['end']))
                                    &middot;
                                @endif
                                {{ collect([$education['start'], $education['end'] ?: __('Ongoing')])->filter()->implode(' – ') }}
                            </p>
                        </article>
                    @endforeach
                </section>
            @endif
        </main>
        <aside>
            @if (!empty($contactItems))
                <section style="margin-bottom: 20px;">
                    <h2 class="classic-section-title">Contact</h2>
                    <div class="classic-contact">
                        @foreach ($contactItems as $contact)
                            <span>{{ $contact }}</span>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($skills))
                <section style="margin-bottom: 20px;">
                    <h2 class="classic-section-title">Skills</h2>
                    <div class="classic-taglist">
                        @foreach ($skills as $skill)
                            <span class="classic-tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($languages))
                <section style="margin-bottom: 20px;">
                    <h2 class="classic-section-title">Languages</h2>
                    <ul class="classic-contact">
                        @foreach ($languages as $language)
                            <li>
                                {{ $language['name'] }}
                                @if ($language['level'])
                                    <span> &middot; {{ $language['level'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (!empty($hobbies))
                <section>
                    <h2 class="classic-section-title">Interests</h2>
                    <ul class="classic-contact">
                        @foreach ($hobbies as $hobby)
                            <li>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </aside>
    </div>
</div>
