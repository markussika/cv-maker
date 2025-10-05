@php
    $accent = $accentColor ?? '#7c3aed';
    $secondary = '#22d3ee';
    $hasFuturisticAside = $skillTags->isNotEmpty() || $languageItems->isNotEmpty() || $hobbyItems->isNotEmpty();
@endphp

<style>
    body.template-futuristic {
        background-color: #06080f;
        padding: 18px;
        font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
        color: #e5edff;
    }

    body.template-futuristic .futuristic-page {
        background-color: #111827;
        border: 1px solid #1f2937;
        border-radius: 24px;
        overflow: hidden;
    }

    body.template-futuristic .futuristic-header {
        background-color: #0b1120;
        border-bottom: 3px solid {{ $accent }};
        padding: 24px 32px;
    }

    body.template-futuristic .futuristic-header table {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-futuristic .futuristic-header td {
        vertical-align: top;
    }

    body.template-futuristic .futuristic-avatar {
        width: 94px;
        height: 94px;
        border-radius: 20px;
        border: 2px solid {{ $accent }};
        overflow: hidden;
        background-color: #06080f;
        box-shadow: 0 0 12px rgba(124, 58, 237, 0.45);
    }

    body.template-futuristic .futuristic-avatar img {
        width: 94px;
        height: 94px;
        object-fit: cover;
    }

    body.template-futuristic .futuristic-avatar span {
        display: block;
        width: 94px;
        height: 94px;
        line-height: 94px;
        text-align: center;
        font-size: 24px;
        letter-spacing: 4px;
        color: {{ $accent }};
    }

    body.template-futuristic .futuristic-name {
        font-size: 28px;
        letter-spacing: 4px;
        text-transform: uppercase;
        margin: 0;
        color: #f8fafc;
    }

    body.template-futuristic .futuristic-headline {
        font-size: 12px;
        letter-spacing: 5px;
        text-transform: uppercase;
        margin-top: 6px;
        color: #a5b4fc;
    }

    body.template-futuristic .futuristic-contact {
        list-style: none;
        margin: 0;
        padding: 0;
        font-size: 11px;
        color: #cbd5f5;
    }

    body.template-futuristic .futuristic-contact li {
        margin-bottom: 4px;
    }

    body.template-futuristic .futuristic-body {
        padding: 26px 32px 34px;
        background: linear-gradient(90deg, rgba(124, 58, 237, 0.08), rgba(34, 211, 238, 0.08));
    }

    body.template-futuristic .futuristic-summary {
        border: 1px solid rgba(124, 58, 237, 0.4);
        background-color: rgba(15, 23, 42, 0.8);
        border-radius: 18px;
        padding: 16px 20px;
        margin-bottom: 24px;
        font-size: 12px;
        color: #d0dcff;
    }

    body.template-futuristic .futuristic-summary p {
        margin: 0 0 10px 0;
    }

    body.template-futuristic .futuristic-summary p:last-child {
        margin-bottom: 0;
    }

    body.template-futuristic .futuristic-columns {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-futuristic .futuristic-columns td {
        vertical-align: top;
    }

    body.template-futuristic .futuristic-main {
        width: 65%;
        padding-right: 22px;
        border-right: 1px solid rgba(99, 102, 241, 0.25);
    }

    body.template-futuristic .futuristic-aside {
        width: 35%;
        padding-left: 22px;
    }

    body.template-futuristic .futuristic-section {
        margin-bottom: 26px;
    }

    body.template-futuristic .futuristic-section:last-child {
        margin-bottom: 0;
    }

    body.template-futuristic .futuristic-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 4px;
        color: {{ $secondary }};
        margin-bottom: 10px;
    }

    body.template-futuristic .futuristic-entry {
        margin-bottom: 18px;
        padding-left: 14px;
        border-left: 3px solid rgba(124, 58, 237, 0.45);
        background-color: rgba(15, 23, 42, 0.6);
        border-radius: 6px;
        padding-bottom: 10px;
        padding-top: 10px;
    }

    body.template-futuristic .futuristic-entry:last-child {
        margin-bottom: 0;
    }

    body.template-futuristic .futuristic-entry-title {
        font-size: 13px;
        font-weight: bold;
        color: #f8fafc;
    }

    body.template-futuristic .futuristic-meta {
        font-size: 11px;
        color: #a5b4fc;
        margin-top: 4px;
    }

    body.template-futuristic .futuristic-bullets {
        margin: 10px 0 0 16px;
        padding: 0;
    }

    body.template-futuristic .futuristic-bullets li {
        font-size: 12px;
        color: #d0dcff;
        margin-bottom: 6px;
    }

    body.template-futuristic .futuristic-bullets li:last-child {
        margin-bottom: 0;
    }

    body.template-futuristic .futuristic-chip-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-futuristic .futuristic-chip-list li {
        display: inline-block;
        background-color: rgba(124, 58, 237, 0.15);
        border: 1px solid rgba(124, 58, 237, 0.35);
        border-radius: 999px;
        padding: 4px 11px;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #c4b5fd;
        margin: 0 6px 6px 0;
    }

    body.template-futuristic .futuristic-simple-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-futuristic .futuristic-simple-list li {
        font-size: 11px;
        color: #d0dcff;
        margin-bottom: 6px;
    }

    body.template-futuristic .futuristic-simple-list li span {
        color: #a5b4fc;
    }
</style>

<div class="futuristic-page">
    <header class="futuristic-header">
        <table>
            <tr>
                <td style="width: 120px;">
                    <div class="futuristic-avatar">
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
                    <div class="futuristic-name">{{ $fullName ?: 'Curriculum Vitae' }}</div>
                    @if ($headline)
                        <div class="futuristic-headline">{{ strtoupper($headline) }}</div>
                    @endif
                </td>
                @if (!empty($contactItems))
                    <td style="width: 220px;">
                        <ul class="futuristic-contact">
                            @foreach ($contactItems as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </td>
                @endif
            </tr>
        </table>
    </header>

    <div class="futuristic-body">
        @if ($summaryParagraphs->isNotEmpty())
            <div class="futuristic-summary">
                @foreach ($summaryParagraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
        @endif

        <table class="futuristic-columns">
            <tr>
                <td class="futuristic-main" @if (! $hasFuturisticAside) style="width: 100%; padding-right: 0; border-right: none;" @endif>
                    @if ($experienceBlocks->isNotEmpty())
                        <div class="futuristic-section">
                            <div class="futuristic-title">{{ __('Experience') }}</div>
                            @foreach ($experienceBlocks as $experience)
                                <div class="futuristic-entry">
                                    @if (!empty($experience['position']))
                                        <div class="futuristic-entry-title">{{ $experience['position'] }}</div>
                                    @endif
                                    @php
                                        $metaPieces = collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter();
                                        $timePieces = collect([$experience['from'] ?? null, $experience['to'] ?? null])->filter();
                                    @endphp
                                    @if ($metaPieces->isNotEmpty())
                                        <div class="futuristic-meta">{{ $metaPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($timePieces->isNotEmpty())
                                        <div class="futuristic-meta">{{ $timePieces->implode(' – ') }}</div>
                                    @endif
                                    @if ($experience['bullets']->isNotEmpty())
                                        <ul class="futuristic-bullets">
                                            @foreach ($experience['bullets'] as $bullet)
                                                <li>{{ $bullet }}</li>
                                            @endforeach
                                        </ul>
                                    @elseif (!empty($experience['achievements']))
                                        <p class="futuristic-meta" style="color: #d0dcff; margin-top: 8px;">{{ $experience['achievements'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($educationBlocks->isNotEmpty())
                        <div class="futuristic-section">
                            <div class="futuristic-title">{{ __('Education') }}</div>
                            @foreach ($educationBlocks as $education)
                                <div class="futuristic-entry">
                                    @if (!empty($education['institution']))
                                        <div class="futuristic-entry-title">{{ $education['institution'] }}</div>
                                    @endif
                                    @php
                                        $studyPieces = collect([$education['degree'] ?? null, $education['field'] ?? null])->filter();
                                        $durationPieces = collect([$education['start'] ?? null, $education['end'] ?? __('Ongoing')])->filter();
                                        $locationPieces = collect([$education['location'] ?? null])->filter();
                                    @endphp
                                    @if ($studyPieces->isNotEmpty())
                                        <div class="futuristic-meta">{{ $studyPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($locationPieces->isNotEmpty() || $durationPieces->isNotEmpty())
                                        <div class="futuristic-meta">
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
                @if ($hasFuturisticAside)
                    <td class="futuristic-aside">
                        @if ($skillTags->isNotEmpty())
                            <div class="futuristic-section">
                                <div class="futuristic-title">{{ __('Skills') }}</div>
                                <ul class="futuristic-chip-list">
                                    @foreach ($skillTags as $skill)
                                        <li>{{ $skill }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($languageItems->isNotEmpty())
                            <div class="futuristic-section">
                                <div class="futuristic-title">{{ __('Languages') }}</div>
                                <ul class="futuristic-simple-list">
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
                            <div class="futuristic-section">
                                <div class="futuristic-title">{{ __('Interests') }}</div>
                                <ul class="futuristic-simple-list">
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
