<style>
    .template-gradient {
        background: linear-gradient(160deg, rgba(14, 165, 233, 0.18), rgba(16, 185, 129, 0.18));
        color: #0f172a;
    }
    .template-gradient .gradient-wrapper {
        width: 100%;
        background: #ffffff;
        border-radius: 28px;
        padding: 32px;
        border: 1px solid rgba(14, 165, 233, 0.2);
    }
    .template-gradient .gradient-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 26px;
    }
    .template-gradient .gradient-name {
        font-size: 27px;
        font-weight: 600;
    }
    .template-gradient .gradient-headline {
        margin-top: 8px;
        font-size: 12px;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        color: #0284c7;
    }
    .template-gradient .gradient-badge {
        font-size: 10px;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        color: #0ea5e9;
    }
    .template-gradient .gradient-contact {
        display: grid;
        gap: 6px;
        font-size: 11px;
        text-align: right;
        color: #0369a1;
    }
    .template-gradient .gradient-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 28px;
    }
    .template-gradient .gradient-section-title {
        font-size: 12px;
        letter-spacing: 0.32em;
        text-transform: uppercase;
        color: #0e7490;
        margin-bottom: 12px;
    }
    .template-gradient .gradient-card {
        border-left: 4px solid rgba(6, 182, 212, 0.4);
        border-radius: 16px;
        background: rgba(240, 249, 255, 0.8);
        padding: 18px 20px;
        margin-bottom: 16px;
    }
    .template-gradient .gradient-card:last-child {
        margin-bottom: 0;
    }
    .template-gradient .gradient-card h3 {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
    }
    .template-gradient .gradient-meta {
        font-size: 11px;
        color: #0e7490;
        margin-top: 4px;
    }
    .template-gradient .gradient-summary {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.15), rgba(16, 185, 129, 0.15));
        border: 1px solid rgba(14, 165, 233, 0.25);
        border-radius: 16px;
        padding: 18px;
        font-size: 12px;
        margin-bottom: 24px;
    }
    .template-gradient .gradient-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    .template-gradient .gradient-tag {
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 10px;
        letter-spacing: 0.25em;
        text-transform: uppercase;
        background: rgba(16, 185, 129, 0.15);
        color: #0f766e;
    }
</style>
<div class="gradient-wrapper">
    <header class="gradient-header">
        <div>
            <div class="gradient-badge">Profile</div>
            <h1 class="gradient-name">{{ $fullName ?: 'Curriculum Vitae' }}</h1>
            @if ($headline)
                <p class="gradient-headline">{{ strtoupper($headline) }}</p>
            @endif
        </div>
        @if (!empty($contactItems))
            <div class="gradient-contact">
                @foreach ($contactItems as $contact)
                    <span>{{ $contact }}</span>
                @endforeach
            </div>
        @endif
    </header>
    <div class="gradient-grid">
        <main>
            @if ($summary)
                <section class="gradient-summary">{{ $summary }}</section>
            @endif

            @if (!empty($experienceItems))
                <section style="margin-bottom: 24px;">
                    <h2 class="gradient-section-title">Experience</h2>
                    @foreach ($experienceItems as $experience)
                        <article class="gradient-card">
                            @if ($experience['position'])
                                <h3>{{ $experience['position'] }}</h3>
                            @endif
                            <p class="gradient-meta">{{ collect([$experience['company'], $experience['location']])->filter()->implode(' · ') }}</p>
                            <p class="gradient-meta">{{ collect([$experience['from'], $experience['to']])->filter()->implode(' – ') }}</p>
                            @if ($experience['achievements'])
                                <p style="margin-top: 10px; color: #134e4a;">{{ $experience['achievements'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </section>
            @endif

            @if (!empty($educationItems))
                <section>
                    <h2 class="gradient-section-title">Education</h2>
                    @foreach ($educationItems as $education)
                        <article class="gradient-card">
                            @if ($education['institution'])
                                <h3>{{ $education['institution'] }}</h3>
                            @endif
                            <p class="gradient-meta">{{ collect([$education['degree'], $education['field']])->filter()->implode(' · ') }}</p>
                            <p class="gradient-meta">{{ collect([$education['location'], collect([$education['start'], $education['end'] ?: __('Ongoing')])->filter()->implode(' – ')])->filter()->implode(' · ') }}</p>
                        </article>
                    @endforeach
                </section>
            @endif
        </main>
        <aside>
            @if (!empty($skills))
                <section style="margin-bottom: 18px;">
                    <h2 class="gradient-section-title">Skills</h2>
                    <div class="gradient-tags">
                        @foreach ($skills as $skill)
                            <span class="gradient-tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($languages))
                <section style="margin-bottom: 18px;">
                    <h2 class="gradient-section-title">Languages</h2>
                    <ul style="display: grid; gap: 6px; font-size: 11px; color: #0f172a;">
                        @foreach ($languages as $language)
                            <li>
                                {{ $language['name'] }}
                                @if ($language['level'])
                                    <span style="color: #0ea5e9;"> &middot; {{ $language['level'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (!empty($hobbies))
                <section>
                    <h2 class="gradient-section-title">Interests</h2>
                    <ul style="display: grid; gap: 6px; font-size: 11px; color: #0f172a;">
                        @foreach ($hobbies as $hobby)
                            <li>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </aside>
    </div>
</div>
