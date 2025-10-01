<style>
    .template-futuristic {
        background: radial-gradient(circle at top left, rgba(124, 58, 237, 0.25), transparent 45%), #0f172a;
        color: #e2e8f0;
    }
    .template-futuristic .futuristic-wrapper {
        width: 100%;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.95));
        border-radius: 28px;
        border: 1px solid rgba(124, 58, 237, 0.35);
        padding: 34px;
    }
    .template-futuristic .futuristic-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
    }
    .template-futuristic .futuristic-header-main {
        display: flex;
        align-items: center;
        gap: 24px;
    }
    .template-futuristic .futuristic-avatar {
        width: 88px;
        height: 88px;
        border-radius: 28px;
        border: 3px solid rgba(124, 58, 237, 0.6);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: radial-gradient(circle at center, rgba(168, 85, 247, 0.3), rgba(30, 64, 175, 0.35));
        color: #f5f3ff;
    }
    .template-futuristic .futuristic-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .template-futuristic .futuristic-avatar-initials {
        font-size: 22px;
        font-weight: 600;
        letter-spacing: 0.35em;
    }
    .template-futuristic .futuristic-name {
        font-size: 30px;
        font-weight: 600;
        color: #f5f3ff;
    }
    .template-futuristic .futuristic-headline {
        margin-top: 8px;
        font-size: 11px;
        letter-spacing: 0.45em;
        text-transform: uppercase;
        color: #a855f7;
    }
    .template-futuristic .futuristic-contact {
        text-align: right;
        display: grid;
        gap: 6px;
        font-size: 11px;
        color: #c4b5fd;
    }
    .template-futuristic .futuristic-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 28px;
    }
    .template-futuristic .futuristic-section-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.4em;
        color: #a855f7;
        margin-bottom: 14px;
    }
    .template-futuristic .futuristic-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        padding: 18px 20px;
        background: rgba(15, 118, 110, 0.1);
        border: 1px solid rgba(124, 58, 237, 0.3);
        margin-bottom: 18px;
    }
    .template-futuristic .futuristic-card:last-child {
        margin-bottom: 0;
    }
    .template-futuristic .futuristic-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, rgba(124, 58, 237, 0.25), transparent 55%);
        pointer-events: none;
    }
    .template-futuristic .futuristic-card h3 {
        position: relative;
        font-size: 13px;
        color: #f5f3ff;
        margin-bottom: 6px;
    }
    .template-futuristic .futuristic-meta {
        position: relative;
        font-size: 11px;
        color: #c4b5fd;
    }
    .template-futuristic .futuristic-summary {
        border-radius: 22px;
        padding: 20px;
        margin-bottom: 24px;
        background: linear-gradient(120deg, rgba(124, 58, 237, 0.25), rgba(14, 116, 144, 0.25));
        border: 1px solid rgba(124, 58, 237, 0.35);
        font-size: 12px;
        color: #ede9fe;
    }
    .template-futuristic .futuristic-chiplist {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .template-futuristic .futuristic-chip {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 10px;
        letter-spacing: 0.32em;
        text-transform: uppercase;
        background: rgba(124, 58, 237, 0.2);
        color: #c4b5fd;
        border: 1px solid rgba(99, 102, 241, 0.45);
    }
</style>
<div class="futuristic-wrapper">
    <header class="futuristic-header">
        <div class="futuristic-header-main">
            @if ($profileImage || $initials)
                <div class="futuristic-avatar">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $fullName ?: __('Profile photo') }}">
                    @else
                        <span class="futuristic-avatar-initials">{{ $initials }}</span>
                    @endif
                </div>
            @endif
            <div>
                <h1 class="futuristic-name">{{ $fullName ?: 'Curriculum Vitae' }}</h1>
                @if ($headline)
                    <p class="futuristic-headline">{{ strtoupper($headline) }}</p>
                @endif
            </div>
        </div>
        @if (!empty($contactItems))
            <div class="futuristic-contact">
                @foreach ($contactItems as $contact)
                    <span>{{ $contact }}</span>
                @endforeach
            </div>
        @endif
    </header>
    <div class="futuristic-grid">
        <main>
            @if ($summary)
                <section class="futuristic-summary">{{ $summary }}</section>
            @endif

            @if (!empty($experienceItems))
                <section style="margin-bottom: 24px;">
                    <h2 class="futuristic-section-title">Experience</h2>
                    @foreach ($experienceItems as $experience)
                        <article class="futuristic-card">
                            @if ($experience['position'])
                                <h3>{{ $experience['position'] }}</h3>
                            @endif
                            <p class="futuristic-meta">{{ collect([$experience['company'], $experience['location']])->filter()->implode(' · ') }}</p>
                            <p class="futuristic-meta">{{ collect([$experience['from'], $experience['to']])->filter()->implode(' – ') }}</p>
                            @if ($experience['achievements'])
                                <p style="position: relative; margin-top: 10px; color: #f1f5f9;">{{ $experience['achievements'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </section>
            @endif

            @if (!empty($educationItems))
                <section>
                    <h2 class="futuristic-section-title">Education</h2>
                    @foreach ($educationItems as $education)
                        <article class="futuristic-card">
                            @if ($education['institution'])
                                <h3>{{ $education['institution'] }}</h3>
                            @endif
                            <p class="futuristic-meta">{{ collect([$education['degree'], $education['field']])->filter()->implode(' · ') }}</p>
                            <p class="futuristic-meta">{{ collect([$education['location'], collect([$education['start'], $education['end'] ?: __('Ongoing')])->filter()->implode(' – ')])->filter()->implode(' · ') }}</p>
                        </article>
                    @endforeach
                </section>
            @endif
        </main>
        <aside>
            @if (!empty($skills))
                <section style="margin-bottom: 18px;">
                    <h2 class="futuristic-section-title">Skills</h2>
                    <div class="futuristic-chiplist">
                        @foreach ($skills as $skill)
                            <span class="futuristic-chip">{{ $skill }}</span>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($languages))
                <section style="margin-bottom: 18px;">
                    <h2 class="futuristic-section-title">Languages</h2>
                    <ul style="display: grid; gap: 6px; font-size: 11px; color: #e2e8f0;">
                        @foreach ($languages as $language)
                            <li>
                                {{ $language['name'] }}
                                @if ($language['level'])
                                    <span style="color: #a855f7;"> &middot; {{ $language['level'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (!empty($hobbies))
                <section>
                    <h2 class="futuristic-section-title">Interests</h2>
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
