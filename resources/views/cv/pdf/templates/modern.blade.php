<style>
    .template-modern {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.12), rgba(14, 165, 233, 0.12));
    }
    .template-modern .modern-wrapper {
        width: 100%;
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(37, 99, 235, 0.2);
    }
    .template-modern .modern-header {
        background: {{ $accentColor }};
        color: #ffffff;
        padding: 28px 32px;
    }
    .template-modern .modern-name {
        font-size: 28px;
        font-weight: 600;
        letter-spacing: 0.01em;
    }
    .template-modern .modern-headline {
        font-size: 13px;
        margin-top: 6px;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.72);
    }
    .template-modern .modern-contact {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 18px;
        font-size: 11px;
    }
    .template-modern .modern-body {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 28px;
        padding: 28px 32px;
    }
    .template-modern .modern-section-title {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.26em;
        color: #0f172a;
        margin-bottom: 12px;
    }
    .template-modern .modern-summary {
        background: rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.18);
        padding: 18px;
        border-radius: 18px;
        font-size: 12px;
        color: #1f2937;
        margin-bottom: 24px;
    }
    .template-modern .modern-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px 18px;
        margin-bottom: 16px;
    }
    .template-modern .modern-card:last-child {
        margin-bottom: 0;
    }
    .template-modern .modern-card h3 {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
    }
    .template-modern .modern-meta {
        font-size: 11px;
        color: #475569;
    }
    .template-modern .modern-aside-card {
        border: 1px solid rgba(15, 23, 42, 0.12);
        border-radius: 18px;
        padding: 18px;
        margin-bottom: 18px;
        background: rgba(15, 23, 42, 0.02);
    }
    .template-modern .modern-chiplist {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .template-modern .modern-chip {
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        background: rgba(37, 99, 235, 0.12);
        color: #1d4ed8;
    }
</style>
<div class="modern-wrapper">
    <header class="modern-header">
        <h1 class="modern-name">{{ $fullName ?: 'Curriculum Vitae' }}</h1>
        @if ($headline)
            <p class="modern-headline">{{ strtoupper($headline) }}</p>
        @endif
        @if (!empty($contactItems))
            <div class="modern-contact">
                @foreach ($contactItems as $contact)
                    <span>{{ $contact }}</span>
                @endforeach
            </div>
        @endif
    </header>
    <div class="modern-body">
        <main>
            @if ($summary)
                <section class="modern-summary">{{ $summary }}</section>
            @endif

            @if (!empty($experienceItems))
                <section style="margin-bottom: 24px;">
                    <h2 class="modern-section-title">Experience</h2>
                    @foreach ($experienceItems as $experience)
                        <article class="modern-card">
                            @if ($experience['position'])
                                <h3>{{ $experience['position'] }}</h3>
                            @endif
                            <p class="modern-meta">
                                {{ collect([$experience['company'], $experience['location']])->filter()->implode(' · ') }}
                            </p>
                            <p class="modern-meta">{{ collect([$experience['from'], $experience['to']])->filter()->implode(' – ') }}</p>
                            @if ($experience['achievements'])
                                <p style="margin-top: 10px; color: #1f2937;">{{ $experience['achievements'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </section>
            @endif

            @if (!empty($educationItems))
                <section>
                    <h2 class="modern-section-title">Education</h2>
                    @foreach ($educationItems as $education)
                        <article class="modern-card">
                            @if ($education['institution'])
                                <h3>{{ $education['institution'] }}</h3>
                            @endif
                            <p class="modern-meta">
                                {{ collect([$education['degree'], $education['field']])->filter()->implode(' · ') }}
                            </p>
                            <p class="modern-meta">
                                {{ collect([$education['location'], collect([$education['start'], $education['end'] ?: __('Ongoing')])->filter()->implode(' – ')])->filter()->implode(' · ') }}
                            </p>
                        </article>
                    @endforeach
                </section>
            @endif
        </main>
        <aside>
            @if (!empty($skills))
                <section class="modern-aside-card">
                    <h2 class="modern-section-title" style="margin-bottom: 16px;">Skills</h2>
                    <div class="modern-chiplist">
                        @foreach ($skills as $skill)
                            <span class="modern-chip">{{ $skill }}</span>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($languages))
                <section class="modern-aside-card">
                    <h2 class="modern-section-title" style="margin-bottom: 12px;">Languages</h2>
                    <ul style="display: grid; gap: 6px; font-size: 11px; color: #1f2937;">
                        @foreach ($languages as $language)
                            <li>
                                {{ $language['name'] }}
                                @if ($language['level'])
                                    <span style="color: #64748b;"> &middot; {{ $language['level'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (!empty($hobbies))
                <section class="modern-aside-card">
                    <h2 class="modern-section-title" style="margin-bottom: 12px;">Interests</h2>
                    <ul style="display: grid; gap: 6px; font-size: 11px; color: #1f2937;">
                        @foreach ($hobbies as $hobby)
                            <li>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </aside>
    </div>
</div>
