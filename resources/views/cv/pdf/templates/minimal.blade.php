<style>
    .template-minimal {
        background: #ffffff;
    }
    .template-minimal .minimal-wrapper {
        width: 100%;
        padding: 24px 28px;
    }
    .template-minimal .minimal-header {
        margin-bottom: 26px;
    }
    .template-minimal .minimal-header-main {
        display: flex;
        align-items: center;
        gap: 24px;
    }
    .template-minimal .minimal-avatar {
        width: 74px;
        height: 74px;
        border-radius: 999px;
        border: 2px solid rgba(100, 116, 139, 0.3);
        background: rgba(15, 23, 42, 0.05);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0f172a;
    }
    .template-minimal .minimal-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .template-minimal .minimal-avatar-initials {
        font-size: 20px;
        font-weight: 500;
        letter-spacing: 0.22em;
    }
    .template-minimal .minimal-name {
        font-size: 28px;
        font-weight: 500;
        letter-spacing: 0.02em;
        color: #0f172a;
    }
    .template-minimal .minimal-headline {
        margin-top: 8px;
        font-size: 12px;
        letter-spacing: 0.38em;
        text-transform: uppercase;
        color: #475569;
    }
    .template-minimal .minimal-contact {
        margin-top: 16px;
        display: grid;
        gap: 4px;
        font-size: 11px;
        color: #475569;
    }
    .template-minimal .minimal-grid {
        display: grid;
        grid-template-columns: 1.7fr 1fr;
        gap: 32px;
    }
    .template-minimal .minimal-section-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.4em;
        color: #64748b;
        margin-bottom: 10px;
    }
    .template-minimal .minimal-divider {
        height: 1px;
        background: rgba(148, 163, 184, 0.5);
        margin: 18px 0;
    }
    .template-minimal .minimal-item {
        margin-bottom: 18px;
    }
    .template-minimal .minimal-item:last-child {
        margin-bottom: 0;
    }
    .template-minimal .minimal-item h3 {
        font-size: 13px;
        font-weight: 500;
        color: #0f172a;
        margin-bottom: 4px;
    }
    .template-minimal .minimal-meta {
        font-size: 11px;
        color: #94a3b8;
    }
    .template-minimal .minimal-summary {
        font-size: 12px;
        color: #1f2937;
        margin-bottom: 24px;
    }
    .template-minimal .minimal-bullet {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        color: #334155;
    }
    .template-minimal .minimal-dot {
        width: 4px;
        height: 4px;
        border-radius: 999px;
        background: #475569;
    }
</style>
<div class="minimal-wrapper">
    <header class="minimal-header">
        <div class="minimal-header-main">
            @if ($profileImage || $initials)
                <div class="minimal-avatar">
                    @if ($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $fullName ?: __('Profile photo') }}">
                    @else
                        <span class="minimal-avatar-initials">{{ $initials }}</span>
                    @endif
                </div>
            @endif
            <div>
                <h1 class="minimal-name">{{ $fullName ?: 'Curriculum Vitae' }}</h1>
                @if ($headline)
                    <p class="minimal-headline">{{ strtoupper($headline) }}</p>
                @endif
            </div>
        </div>
        @if (!empty($contactItems))
            <div class="minimal-contact">
                @foreach ($contactItems as $contact)
                    <span>{{ $contact }}</span>
                @endforeach
            </div>
        @endif
    </header>
    <div class="minimal-grid">
        <main>
            @if ($summary)
                <section class="minimal-summary">{{ $summary }}</section>
            @endif

            @if (!empty($experienceItems))
                <section>
                    <h2 class="minimal-section-title">Experience</h2>
                    <div class="minimal-divider"></div>
                    @foreach ($experienceItems as $experience)
                        <article class="minimal-item">
                            @if ($experience['position'])
                                <h3>{{ $experience['position'] }}</h3>
                            @endif
                            <p class="minimal-meta">{{ collect([$experience['company'], $experience['location']])->filter()->implode(' · ') }}</p>
                            <p class="minimal-meta">{{ collect([$experience['from'], $experience['to']])->filter()->implode(' – ') }}</p>
                            @if ($experience['achievements'])
                                <p style="margin-top: 10px; color: #1f2937;">{{ $experience['achievements'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </section>
            @endif

            @if (!empty($educationItems))
                <section style="margin-top: 28px;">
                    <h2 class="minimal-section-title">Education</h2>
                    <div class="minimal-divider"></div>
                    @foreach ($educationItems as $education)
                        <article class="minimal-item">
                            @if ($education['institution'])
                                <h3>{{ $education['institution'] }}</h3>
                            @endif
                            <p class="minimal-meta">{{ collect([$education['degree'], $education['field']])->filter()->implode(' · ') }}</p>
                            <p class="minimal-meta">{{ collect([$education['location'], collect([$education['start'], $education['end'] ?: __('Ongoing')])->filter()->implode(' – ')])->filter()->implode(' · ') }}</p>
                        </article>
                    @endforeach
                </section>
            @endif
        </main>
        <aside>
            @if (!empty($skills))
                <section>
                    <h2 class="minimal-section-title">Skills</h2>
                    <div class="minimal-divider"></div>
                    <ul style="display: grid; gap: 6px;">
                        @foreach ($skills as $skill)
                            <li class="minimal-bullet"><span class="minimal-dot"></span>{{ $skill }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (!empty($languages))
                <section style="margin-top: 28px;">
                    <h2 class="minimal-section-title">Languages</h2>
                    <div class="minimal-divider"></div>
                    <ul style="display: grid; gap: 6px;">
                        @foreach ($languages as $language)
                            <li class="minimal-bullet">
                                <span class="minimal-dot"></span>
                                {{ $language['name'] }}
                                @if ($language['level'])
                                    <span style="color: #94a3b8;">&nbsp;{{ $language['level'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (!empty($hobbies))
                <section style="margin-top: 28px;">
                    <h2 class="minimal-section-title">Interests</h2>
                    <div class="minimal-divider"></div>
                    <ul style="display: grid; gap: 6px;">
                        @foreach ($hobbies as $hobby)
                            <li class="minimal-bullet"><span class="minimal-dot"></span>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </aside>
    </div>
</div>
