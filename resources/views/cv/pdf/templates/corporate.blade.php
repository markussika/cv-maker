<style>
    .template-corporate {
        background: #f1f5f9;
        color: #0f172a;
    }
    .template-corporate .corporate-wrapper {
        width: 100%;
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(15, 23, 42, 0.1);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 2fr;
    }
    .template-corporate .corporate-sidebar {
        background: #0f172a;
        color: #e2e8f0;
        padding: 32px 24px;
        display: grid;
        gap: 24px;
    }
    .template-corporate .corporate-avatar {
        width: 86px;
        height: 86px;
        border-radius: 999px;
        border: 3px solid rgba(148, 163, 184, 0.4);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(15, 23, 42, 0.6);
        color: #f8fafc;
        margin-bottom: 18px;
    }
    .template-corporate .corporate-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .template-corporate .corporate-avatar-initials {
        font-size: 20px;
        font-weight: 600;
        letter-spacing: 0.2em;
    }
    .template-corporate .corporate-name {
        font-size: 24px;
        font-weight: 600;
        letter-spacing: 0.05em;
    }
    .template-corporate .corporate-headline {
        font-size: 11px;
        letter-spacing: 0.28em;
        text-transform: uppercase;
        color: rgba(148, 163, 184, 0.9);
        margin-top: 8px;
    }
    .template-corporate .corporate-contact,
    .template-corporate .corporate-list {
        display: grid;
        gap: 6px;
        font-size: 11px;
    }
    .template-corporate .corporate-body {
        padding: 32px 34px;
    }
    .template-corporate .corporate-section-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.35em;
        color: #1f2937;
        margin-bottom: 14px;
    }
    .template-corporate .corporate-item {
        border-left: 3px solid rgba(15, 23, 42, 0.1);
        padding-left: 16px;
        margin-bottom: 20px;
    }
    .template-corporate .corporate-item:last-child {
        margin-bottom: 0;
    }
    .template-corporate .corporate-item h3 {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
    }
    .template-corporate .corporate-meta {
        font-size: 11px;
        color: #475569;
    }
    .template-corporate .corporate-summary {
        font-size: 12px;
        margin-bottom: 24px;
        color: #1f2937;
    }
</style>
<div class="corporate-wrapper">
    <aside class="corporate-sidebar">
        <div>
            @if ($profileImage)
                <div class="corporate-avatar">
                    <img src="{{ $profileImage }}" alt="{{ $fullName ?: __('Profile photo') }}">
                </div>
            @endif
            <h1 class="corporate-name">{{ $fullName ?: 'Curriculum Vitae' }}</h1>
            @if ($headline)
                <p class="corporate-headline">{{ strtoupper($headline) }}</p>
            @endif
        </div>
        @if ($summary)
            <div>
                <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.3em; color: rgba(148, 163, 184, 0.9);">Summary</div>
                <p style="font-size: 11px; line-height: 1.6;">{{ $summary }}</p>
            </div>
        @endif
        @if (!empty($contactItems))
            <div>
                <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.3em; color: rgba(148, 163, 184, 0.9);">Contact</div>
                <div class="corporate-contact">
                    @foreach ($contactItems as $contact)
                        <span>{{ $contact }}</span>
                    @endforeach
                </div>
            </div>
        @endif
        @if (!empty($skills))
            <div>
                <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.3em; color: rgba(148, 163, 184, 0.9);">Skills</div>
                <div class="corporate-list">
                    @foreach ($skills as $skill)
                        <span>{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
        @endif
        @if (!empty($languages))
            <div>
                <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.3em; color: rgba(148, 163, 184, 0.9);">Languages</div>
                <div class="corporate-list">
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
                <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.3em; color: rgba(148, 163, 184, 0.9);">Interests</div>
                <div class="corporate-list">
                    @foreach ($hobbies as $hobby)
                        <span>{{ $hobby }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </aside>
    <main class="corporate-body">
        @if (!empty($experienceItems))
            <section style="margin-bottom: 32px;">
                <h2 class="corporate-section-title">Experience</h2>
                @foreach ($experienceItems as $experience)
                    <article class="corporate-item">
                        @if ($experience['position'])
                            <h3>{{ $experience['position'] }}</h3>
                        @endif
                        <p class="corporate-meta">{{ collect([$experience['company'], $experience['location']])->filter()->implode(' · ') }}</p>
                        <p class="corporate-meta">{{ collect([$experience['from'], $experience['to']])->filter()->implode(' – ') }}</p>
                        @if ($experience['achievements'])
                            <p style="margin-top: 8px; font-size: 11px;">{{ $experience['achievements'] }}</p>
                        @endif
                    </article>
                @endforeach
            </section>
        @endif

        @if (!empty($educationItems))
            <section>
                <h2 class="corporate-section-title">Education</h2>
                @foreach ($educationItems as $education)
                    <article class="corporate-item">
                        @if ($education['institution'])
                            <h3>{{ $education['institution'] }}</h3>
                        @endif
                        <p class="corporate-meta">{{ collect([$education['degree'], $education['field']])->filter()->implode(' · ') }}</p>
                        <p class="corporate-meta">{{ collect([$education['location'], collect([$education['start'], $education['end'] ?: __('Ongoing')])->filter()->implode(' – ')])->filter()->implode(' · ') }}</p>
                    </article>
                @endforeach
            </section>
        @endif
    </main>
</div>
