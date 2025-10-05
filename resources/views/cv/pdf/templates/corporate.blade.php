@php
    $accent = $accentColor ?? '#0f172a';
    $hasCorporateAside = $skillTags->isNotEmpty() || $languageItems->isNotEmpty() || $hobbyItems->isNotEmpty();
@endphp

<style>
    body.template-corporate {
        background-color: #eef1f6;
        padding: 18px;
        font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
        color: #0f172a;
    }

    body.template-corporate .corporate-page {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        overflow: hidden;
    }

    body.template-corporate .corporate-header {
        background-color: {{ $accent }};
        color: #ffffff;
        padding: 24px 30px;
    }

    body.template-corporate .corporate-header table {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-corporate .corporate-header td {
        vertical-align: top;
    }

    body.template-corporate .corporate-avatar {
        width: 92px;
        height: 92px;
        border-radius: 46px;
        border: 3px solid rgba(255, 255, 255, 0.45);
        overflow: hidden;
        background-color: rgba(15, 23, 42, 0.35);
    }

    body.template-corporate .corporate-avatar img {
        width: 92px;
        height: 92px;
        object-fit: cover;
    }

    body.template-corporate .corporate-avatar span {
        display: block;
        width: 92px;
        height: 92px;
        line-height: 92px;
        text-align: center;
        font-size: 24px;
        letter-spacing: 5px;
        color: #ffffff;
    }

    body.template-corporate .corporate-name {
        font-size: 28px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin: 0;
    }

    body.template-corporate .corporate-headline {
        font-size: 12px;
        letter-spacing: 4px;
        text-transform: uppercase;
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.75);
    }

    body.template-corporate .corporate-contact {
        list-style: none;
        margin: 0;
        padding: 0;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.85);
    }

    body.template-corporate .corporate-contact li {
        margin-bottom: 4px;
    }

    body.template-corporate .corporate-body {
        padding: 28px 32px 32px;
    }

    body.template-corporate .corporate-summary {
        border-left: 4px solid {{ $accent }};
        background-color: #f8fafc;
        padding: 16px 20px;
        margin-bottom: 24px;
        font-size: 12px;
        color: #1f2937;
    }

    body.template-corporate .corporate-summary p {
        margin: 0 0 10px 0;
    }

    body.template-corporate .corporate-summary p:last-child {
        margin-bottom: 0;
    }

    body.template-corporate .corporate-columns {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-corporate .corporate-columns td {
        vertical-align: top;
    }

    body.template-corporate .corporate-main {
        width: 65%;
        padding-right: 20px;
        border-right: 1px solid #e2e8f0;
    }

    body.template-corporate .corporate-aside {
        width: 35%;
        padding-left: 20px;
    }

    body.template-corporate .corporate-section {
        margin-bottom: 26px;
    }

    body.template-corporate .corporate-section:last-child {
        margin-bottom: 0;
    }

    body.template-corporate .corporate-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: {{ $accent }};
        margin-bottom: 10px;
    }

    body.template-corporate .corporate-entry {
        margin-bottom: 18px;
        padding-left: 12px;
        border-left: 3px solid rgba(15, 23, 42, 0.2);
    }

    body.template-corporate .corporate-entry:last-child {
        margin-bottom: 0;
    }

    body.template-corporate .corporate-entry-title {
        font-size: 13px;
        font-weight: bold;
        color: #0f172a;
    }

    body.template-corporate .corporate-meta {
        font-size: 11px;
        color: #475569;
        margin-top: 4px;
    }

    body.template-corporate .corporate-bullets {
        margin: 10px 0 0 16px;
        padding: 0;
    }

    body.template-corporate .corporate-bullets li {
        font-size: 12px;
        color: #1f2937;
        margin-bottom: 6px;
    }

    body.template-corporate .corporate-bullets li:last-child {
        margin-bottom: 0;
    }

    body.template-corporate .corporate-chip-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-corporate .corporate-chip-list li {
        display: inline-block;
        background-color: #f1f5f9;
        border: 1px solid #d1d9e6;
        border-radius: 999px;
        padding: 4px 11px;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #0f172a;
        margin: 0 6px 6px 0;
    }

    body.template-corporate .corporate-simple-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-corporate .corporate-simple-list li {
        font-size: 11px;
        color: #1f2937;
        margin-bottom: 6px;
    }

    body.template-corporate .corporate-simple-list li span {
        color: #64748b;
    }
</style>

<div class="corporate-page">
    <header class="corporate-header">
        <table>
            <tr>
                <td style="width: 120px;">
                    <div class="corporate-avatar">
                        @if ($profileImage)
                            <img src="{{ $profileImage }}" alt="{{ $fullName ?: __('Profile photo') }}">
                        @elseif ($initials)
                            <span>{{ $initials }}</span>
                        @else
                            <span>{{ __('CV') }}</span>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="corporate-name">{{ $fullName ?: 'Curriculum Vitae' }}</div>
                    @if ($headline)
                        <div class="corporate-headline">{{ strtoupper($headline) }}</div>
                    @endif
                </td>
                @if (!empty($contactItems))
                    <td style="width: 220px;">
                        <ul class="corporate-contact">
                            @foreach ($contactItems as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </td>
                @endif
            </tr>
        </table>
    </header>

    <div class="corporate-body">
        @if ($summaryParagraphs->isNotEmpty())
            <div class="corporate-summary">
                @foreach ($summaryParagraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
        @endif

        <table class="corporate-columns">
            <tr>
                <td class="corporate-main" @if (! $hasCorporateAside) style="width: 100%; padding-right: 0; border-right: none;" @endif>
                    @if ($experienceBlocks->isNotEmpty())
                        <div class="corporate-section">
                            <div class="corporate-title">{{ __('Experience') }}</div>
                            @foreach ($experienceBlocks as $experience)
                                <div class="corporate-entry">
                                    @if (!empty($experience['position']))
                                        <div class="corporate-entry-title">{{ $experience['position'] }}</div>
                                    @endif
                                    @php
                                        $metaPieces = collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter();
                                        $timePieces = collect([$experience['from'] ?? null, $experience['to'] ?? null])->filter();
                                    @endphp
                                    @if ($metaPieces->isNotEmpty())
                                        <div class="corporate-meta">{{ $metaPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($timePieces->isNotEmpty())
                                        <div class="corporate-meta">{{ $timePieces->implode(' – ') }}</div>
                                    @endif
                                    @if ($experience['bullets']->isNotEmpty())
                                        <ul class="corporate-bullets">
                                            @foreach ($experience['bullets'] as $bullet)
                                                <li>{{ $bullet }}</li>
                                            @endforeach
                                        </ul>
                                    @elseif (!empty($experience['achievements']))
                                        <p class="corporate-meta" style="color: #1f2937; margin-top: 8px;">{{ $experience['achievements'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($educationBlocks->isNotEmpty())
                        <div class="corporate-section">
                            <div class="corporate-title">{{ __('Education') }}</div>
                            @foreach ($educationBlocks as $education)
                                <div class="corporate-entry">
                                    @if (!empty($education['institution']))
                                        <div class="corporate-entry-title">{{ $education['institution'] }}</div>
                                    @endif
                                    @php
                                        $studyPieces = collect([$education['degree'] ?? null, $education['field'] ?? null])->filter();
                                        $durationPieces = collect([$education['start'] ?? null, $education['end'] ?? __('Ongoing')])->filter();
                                        $locationPieces = collect([$education['location'] ?? null])->filter();
                                    @endphp
                                    @if ($studyPieces->isNotEmpty())
                                        <div class="corporate-meta">{{ $studyPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($locationPieces->isNotEmpty() || $durationPieces->isNotEmpty())
                                        <div class="corporate-meta">
                                            {{ $locationPieces->implode(' · ') }}
                                            @if ($locationPieces->isNotEmpty() && $durationPieces->isNotEmpty())
                                                ·
                                            @endif
                                            {{ $durationPieces->implode(' – ') }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </td>
                @if ($hasCorporateAside)
                    <td class="corporate-aside">
                        @if ($skillTags->isNotEmpty())
                            <div class="corporate-section">
                                <div class="corporate-title">{{ __('Skills') }}</div>
                                <ul class="corporate-chip-list">
                                    @foreach ($skillTags as $skill)
                                        <li>{{ $skill }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($languageItems->isNotEmpty())
                            <div class="corporate-section">
                                <div class="corporate-title">{{ __('Languages') }}</div>
                                <ul class="corporate-simple-list">
                                    @foreach ($languageItems as $language)
                                        <li>
                                            {{ $language['name'] }}
                                            @if ($language['level'])
                                                <span>· {{ $language['level'] }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($hobbyItems->isNotEmpty())
                            <div class="corporate-section">
                                <div class="corporate-title">{{ __('Interests') }}</div>
                                <ul class="corporate-simple-list">
                                    @foreach ($hobbyItems as $hobby)
                                        <li>{{ $hobby }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </td>
                @endif
            </tr>
        </table>
    </div>
</div>
