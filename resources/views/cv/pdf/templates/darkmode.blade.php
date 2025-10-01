<style>
    .template-darkmode {
        background: #0b1120;
        color: #e2e8f0;
    }
    .template-darkmode .dark-wrapper {
        width: 100%;
        background: #111827;
        border-radius: 24px;
        border: 1px solid rgba(148, 163, 184, 0.25);
        padding: 32px;
        color: #e2e8f0;
    }
    .template-darkmode .dark-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 28px;
    }
    .template-darkmode .dark-header-main {
        display: flex;
        align-items: center;
        gap: 24px;
    }
    .template-darkmode .dark-avatar {
        width: 86px;
        height: 86px;
        border-radius: 999px;
        border: 3px solid rgba(56, 189, 248, 0.6);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(15, 118, 110, 0.35);
        color: #e2e8f0;
    }
    .template-darkmode .dark-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .template-darkmode .dark-avatar-initials {
        font-size: 22px;
        font-weight: 600;
        letter-spacing: 0.3em;
    }
    .template-darkmode .dark-name {
        font-size: 28px;
        font-weight: 600;
        color: #f8fafc;
    }
    .template-darkmode .dark-headline {
        margin-top: 6px;
        font-size: 11px;
        letter-spacing: 0.34em;
        text-transform: uppercase;
        color: #38bdf8;
    }
    .template-darkmode .dark-contact {
        text-align: right;
        display: grid;
        gap: 6px;
        font-size: 11px;
        color: #94a3b8;
    }
    .template-darkmode .dark-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 32px;
    }
    .template-darkmode .dark-section-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.4em;
        color: #38bdf8;
        margin-bottom: 14px;
    }
    .template-darkmode .dark-card {
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.2);
        background: rgba(15, 23, 42, 0.8);
        padding: 18px 20px;
        margin-bottom: 16px;
    }
    .template-darkmode .dark-card:last-child {
        margin-bottom: 0;
    }
    .template-darkmode .dark-card h3 {
        font-size: 13px;
        color: #f1f5f9;
    }
    .template-darkmode .dark-meta {
        font-size: 11px;
        color: #cbd5f5;
        margin-top: 4px;
    }
    .template-darkmode .dark-summary {
        background: rgba(8, 145, 178, 0.12);
        border: 1px solid rgba(56, 189, 248, 0.25);
        padding: 18px;
        border-radius: 18px;
        font-size: 12px;
        color: #e0f2fe;
        margin-bottom: 24px;
    }
    .template-darkmode .dark-chiplist {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .template-darkmode .dark-chip {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 10px;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        background: rgba(56, 189, 248, 0.1);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }
</style>
<div class="dark-wrapper">
    <header class="dark-header">
        <div class="dark-header-main">
            @if ($profileImage || $initials)
                <div class="dark-avatar">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $fullName ?: __('Profile photo') }}">
                    @else
                        <span class="dark-avatar-initials">{{ $initials }}</span>
                    @endif
                </div>
            @endif
            <div>
                <h1 class="dark-name">{{ $fullName ?: 'Curriculum Vitae' }}</h1>
                @if ($headline)
                    <p class="dark-headline">{{ strtoupper($headline) }}</p>
                @endif
            </div>
        </div>
        @if (!empty($contactItems))
            <div class="dark-contact">
                @foreach ($contactItems as $contact)
                    <span>{{ $contact }}</span>
                @endforeach
            </div>
        @endif
    </header>
    <div class="dark-grid">
        <main>
            @if ($summary)
                <section class="dark-summary">{{ $summary }}</section>
            @endif

            @if (!empty($experienceItems))
                <section style="margin-bottom: 24px;">
                    <h2 class="dark-section-title">Experience</h2>
                    @foreach ($experienceItems as $experience)
                        <article class="dark-card">
                            @if ($experience['position'])
                                <h3>{{ $experience['position'] }}</h3>
                            @endif
                            <p class="dark-meta">{{ collect([$experience['company'], $experience['location']])->filter()->implode(' · ') }}</p>
                            <p class="dark-meta">{{ collect([$experience['from'], $experience['to']])->filter()->implode(' – ') }}</p>
                            @if ($experience['achievements'])
                                <p style="margin-top: 10px; color: #bae6fd;">{{ $experience['achievements'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </section>
            @endif

            @if (!empty($educationItems))
                <section>
                    <h2 class="dark-section-title">Education</h2>
                    @foreach ($educationItems as $education)
                        <article class="dark-card">
                            @if ($education['institution'])
                                <h3>{{ $education['institution'] }}</h3>
                            @endif
                            <p class="dark-meta">{{ collect([$education['degree'], $education['field']])->filter()->implode(' · ') }}</p>
                            <p class="dark-meta">{{ collect([$education['location'], collect([$education['start'], $education['end'] ?: __('Ongoing')])->filter()->implode(' – ')])->filter()->implode(' · ') }}</p>
                        </article>
                    @endforeach
                </section>
            @endif
        </main>
        <aside>
            @if (!empty($skills))
                <section style="margin-bottom: 20px;">
                    <h2 class="dark-section-title">Skills</h2>
                    <div class="dark-chiplist">
                        @foreach ($skills as $skill)
                            <span class="dark-chip">{{ $skill }}</span>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($languages))
                <section style="margin-bottom: 20px;">
                    <h2 class="dark-section-title">Languages</h2>
                    <ul style="display: grid; gap: 6px; font-size: 11px; color: #e2e8f0;">
                        @foreach ($languages as $language)
                            <li>
                                {{ $language['name'] }}
                                @if ($language['level'])
                                    <span style="color: #38bdf8;"> &middot; {{ $language['level'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (!empty($hobbies))
                <section>
                    <h2 class="dark-section-title">Interests</h2>
                    <ul style="display: grid; gap: 6px; font-size: 11px; color: #e2e8f0;">
                        @foreach ($hobbies as $hobby)
                            <li>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </aside>
    </div>
</div>
