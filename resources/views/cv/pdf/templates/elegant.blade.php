<style>
    .template-elegant {
        background: #fcf7ff;
        font-family: 'Georgia', 'Times New Roman', serif;
        color: #2d1b4e;
    }
    .template-elegant .elegant-wrapper {
        width: 100%;
        background: #ffffff;
        border-radius: 26px;
        border: 1px solid rgba(192, 38, 211, 0.2);
        overflow: hidden;
        display: grid;
        grid-template-columns: 0.8fr 2fr;
    }
    .template-elegant .elegant-sidebar {
        background: linear-gradient(180deg, rgba(192, 38, 211, 0.85), rgba(79, 70, 229, 0.85));
        color: #fdf4ff;
        padding: 34px 24px;
        display: grid;
        gap: 24px;
    }
    .template-elegant .elegant-name {
        font-size: 26px;
        letter-spacing: 0.08em;
    }
    .template-elegant .elegant-headline {
        margin-top: 6px;
        font-size: 12px;
        letter-spacing: 0.4em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.78);
    }
    .template-elegant .elegant-contact {
        display: grid;
        gap: 6px;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.9);
    }
    .template-elegant .elegant-badge {
        font-size: 10px;
        letter-spacing: 0.4em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.7);
    }
    .template-elegant .elegant-body {
        padding: 34px 36px;
    }
    .template-elegant .elegant-section-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.32em;
        color: #7c3aed;
        margin-bottom: 14px;
    }
    .template-elegant .elegant-divider {
        height: 1px;
        background: rgba(124, 58, 237, 0.25);
        margin-bottom: 16px;
    }
    .template-elegant .elegant-item {
        margin-bottom: 20px;
    }
    .template-elegant .elegant-item h3 {
        font-size: 14px;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }
    .template-elegant .elegant-meta {
        font-size: 11px;
        color: #5b21b6;
    }
    .template-elegant .elegant-summary {
        font-size: 12px;
        line-height: 1.6;
        margin-bottom: 26px;
    }
    .template-elegant .elegant-list {
        display: grid;
        gap: 6px;
        font-size: 11px;
    }
</style>
<div class="elegant-wrapper">
    <aside class="elegant-sidebar">
        <div>
            <div class="elegant-badge">Profile</div>
            <h1 class="elegant-name">{{ $fullName ?: 'Curriculum Vitae' }}</h1>
            @if ($headline)
                <p class="elegant-headline">{{ strtoupper($headline) }}</p>
            @endif
        </div>
        @if ($summary)
            <div>
                <div class="elegant-badge">About</div>
                <p style="font-size: 11px; line-height: 1.6;">{{ $summary }}</p>
            </div>
        @endif
        @if (!empty($contactItems))
            <div>
                <div class="elegant-badge">Contact</div>
                <div class="elegant-contact">
                    @foreach ($contactItems as $contact)
                        <span>{{ $contact }}</span>
                    @endforeach
                </div>
            </div>
        @endif
        @if (!empty($skills))
            <div>
                <div class="elegant-badge">Skills</div>
                <div class="elegant-contact">
                    @foreach ($skills as $skill)
                        <span>{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
        @endif
        @if (!empty($languages))
            <div>
                <div class="elegant-badge">Languages</div>
                <div class="elegant-contact">
                    @foreach ($languages as $language)
                        <span>
                            {{ $language['name'] }}
                            @if ($language['level'])
                                <span>&middot; {{ $language['level'] }}</span>
                            @endif
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
        @if (!empty($hobbies))
            <div>
                <div class="elegant-badge">Interests</div>
                <div class="elegant-contact">
                    @foreach ($hobbies as $hobby)
                        <span>{{ $hobby }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </aside>
    <main class="elegant-body">
        @if (!empty($experienceItems))
            <section style="margin-bottom: 32px;">
                <h2 class="elegant-section-title">Experience</h2>
                <div class="elegant-divider"></div>
                @foreach ($experienceItems as $experience)
                    <article class="elegant-item">
                        @if ($experience['position'])
                            <h3>{{ $experience['position'] }}</h3>
                        @endif
                        <p class="elegant-meta">{{ collect([$experience['company'], $experience['location']])->filter()->implode(' · ') }}</p>
                        <p class="elegant-meta">{{ collect([$experience['from'], $experience['to']])->filter()->implode(' – ') }}</p>
                        @if ($experience['achievements'])
                            <p style="margin-top: 10px; font-size: 12px;">{{ $experience['achievements'] }}</p>
                        @endif
                    </article>
                @endforeach
            </section>
        @endif

        @if (!empty($educationItems))
            <section>
                <h2 class="elegant-section-title">Education</h2>
                <div class="elegant-divider"></div>
                @foreach ($educationItems as $education)
                    <article class="elegant-item">
                        @if ($education['institution'])
                            <h3>{{ $education['institution'] }}</h3>
                        @endif
                        <p class="elegant-meta">{{ collect([$education['degree'], $education['field']])->filter()->implode(' · ') }}</p>
                        <p class="elegant-meta">{{ collect([$education['location'], collect([$education['start'], $education['end'] ?: __('Ongoing')])->filter()->implode(' – ')])->filter()->implode(' · ') }}</p>
                    </article>
                @endforeach
            </section>
        @endif
    </main>
</div>
