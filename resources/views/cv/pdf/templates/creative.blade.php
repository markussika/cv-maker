<style>
    .template-creative {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.08), rgba(59, 130, 246, 0.08));
    }
    .template-creative .creative-wrapper {
        width: 100%;
        background: #ffffff;
        border-radius: 28px;
        border: 1px solid rgba(236, 72, 153, 0.15);
        overflow: hidden;
    }
    .template-creative .creative-top {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 24px;
        padding: 32px;
        background: linear-gradient(120deg, rgba(236, 72, 153, 0.85), rgba(14, 165, 233, 0.75));
        color: #ffffff;
    }
    .template-creative .creative-avatar {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
    }
    .template-creative .creative-avatar-block {
        display: flex;
        align-items: center;
        gap: 22px;
    }
    .template-creative .creative-avatar-figure {
        width: 88px;
        height: 88px;
        border-radius: 28px;
        background: rgba(15, 23, 42, 0.18);
        border: 3px solid rgba(255, 255, 255, 0.55);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
    }
    .template-creative .creative-avatar-figure img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .template-creative .creative-avatar-initials {
        font-size: 22px;
        font-weight: 600;
        letter-spacing: 0.3em;
    }
    .template-creative .creative-name {
        font-size: 30px;
        font-weight: 700;
        letter-spacing: 0.01em;
    }
    .template-creative .creative-headline {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.24em;
        color: rgba(255, 255, 255, 0.78);
    }
    .template-creative .creative-contact {
        display: grid;
        gap: 6px;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.9);
    }
    .template-creative .creative-body {
        padding: 28px 32px 32px;
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 28px;
    }
    .template-creative .creative-section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3em;
        color: #0f172a;
        margin-bottom: 12px;
    }
    .template-creative .creative-card {
        border-radius: 20px;
        padding: 18px 20px;
        margin-bottom: 18px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 1), rgba(148, 163, 184, 0.15));
        border: 1px solid rgba(148, 163, 184, 0.3);
    }
    .template-creative .creative-card:last-child {
        margin-bottom: 0;
    }
    .template-creative .creative-card h3 {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
    }
    .template-creative .creative-meta {
        font-size: 11px;
        color: #475569;
        margin-top: 4px;
    }
    .template-creative .creative-pill {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 10px;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: #ffffff;
    }
    .template-creative .creative-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        color: #6366f1;
        margin-bottom: 12px;
    }
    .template-creative .creative-aside-card {
        border-radius: 22px;
        padding: 18px 20px;
        background: rgba(248, 250, 252, 0.75);
        border: 1px dashed rgba(59, 130, 246, 0.35);
        margin-bottom: 18px;
    }
    .template-creative .creative-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .template-creative .creative-tag {
        padding: 6px 12px;
        border-radius: 14px;
        font-size: 11px;
        background: rgba(99, 102, 241, 0.12);
        color: #4338ca;
        border: 1px solid rgba(99, 102, 241, 0.2);
    }
</style>
<div class="creative-wrapper">
    <div class="creative-top">
        <div class="creative-avatar">
            <span class="creative-pill">{{ strtoupper($templateKey ?? 'Creative') }}</span>
            <div class="creative-avatar-block">
                @if ($profileImage)
                    <div class="creative-avatar-figure">
                        <img src="{{ $profileImage }}" alt="{{ $fullName ?: __('Profile photo') }}">
                    </div>
                @endif
                <div>
                    <h1 class="creative-name">{{ $fullName ?: 'Curriculum Vitae' }}</h1>
                    @if ($headline)
                        <p class="creative-headline">{{ strtoupper($headline) }}</p>
                    @endif
                </div>
            </div>
        </div>
        @if (!empty($contactItems))
            <div class="creative-contact">
                @foreach ($contactItems as $contact)
                    <span>{{ $contact }}</span>
                @endforeach
            </div>
        @endif
    </div>
    <div class="creative-body">
        <main>
            @if ($summary)
                <section class="creative-card" style="margin-bottom: 24px;">
                    <div class="creative-badge">Spotlight</div>
                    <p style="color: #1f2937; font-size: 12px;">{{ $summary }}</p>
                </section>
            @endif

            @if (!empty($experienceItems))
                <section style="margin-bottom: 26px;">
                    <h2 class="creative-section-title">Experience</h2>
                    @foreach ($experienceItems as $experience)
                        <article class="creative-card">
                            @if ($experience['position'])
                                <h3>{{ $experience['position'] }}</h3>
                            @endif
                            <p class="creative-meta">{{ collect([$experience['company'], $experience['location']])->filter()->implode(' · ') }}</p>
                            <p class="creative-meta">{{ collect([$experience['from'], $experience['to']])->filter()->implode(' – ') }}</p>
                            @if ($experience['achievements'])
                                <p style="margin-top: 12px; color: #1e293b;">{{ $experience['achievements'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </section>
            @endif

            @if (!empty($educationItems))
                <section>
                    <h2 class="creative-section-title">Education</h2>
                    @foreach ($educationItems as $education)
                        <article class="creative-card">
                            @if ($education['institution'])
                                <h3>{{ $education['institution'] }}</h3>
                            @endif
                            <p class="creative-meta">{{ collect([$education['degree'], $education['field']])->filter()->implode(' · ') }}</p>
                            <p class="creative-meta">{{ collect([$education['location'], collect([$education['start'], $education['end'] ?: __('Ongoing')])->filter()->implode(' – ')])->filter()->implode(' · ') }}</p>
                        </article>
                    @endforeach
                </section>
            @endif
        </main>
        <aside>
            @if (!empty($skills))
                <section class="creative-aside-card">
                    <h2 class="creative-section-title" style="margin-bottom: 14px;">Skills</h2>
                    <div class="creative-tags">
                        @foreach ($skills as $skill)
                            <span class="creative-tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!empty($languages))
                <section class="creative-aside-card">
                    <h2 class="creative-section-title" style="margin-bottom: 12px;">Languages</h2>
                    <ul style="display: grid; gap: 6px; font-size: 11px; color: #1f2937;">
                        @foreach ($languages as $language)
                            <li>
                                {{ $language['name'] }}
                                @if ($language['level'])
                                    <span style="color: #6366f1;"> &middot; {{ $language['level'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (!empty($hobbies))
                <section class="creative-aside-card">
                    <h2 class="creative-section-title" style="margin-bottom: 12px;">Interests</h2>
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
