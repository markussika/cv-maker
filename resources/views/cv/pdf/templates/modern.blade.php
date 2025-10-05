@include('cv.pdf.templates.partials.data-prep')

@php
    $accent = $accentColor ?? '#2563eb';
    $hasModernAside = $skillTags->isNotEmpty() || $languageItems->isNotEmpty() || $hobbyItems->isNotEmpty();
@endphp

<style>
    body.template-modern {
        background-color: #eef3ff;
        padding: 18px;
        font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
        color: #0f172a;
    }

    body.template-modern .modern-page {
        background-color: #ffffff;
        border: 1px solid #cbd5f5;
        border-radius: 20px;
        padding: 0;
        overflow: hidden;
    }

    body.template-modern .modern-header {
        background-color: {{ $accent }};
        color: #ffffff;
        padding: 22px 28px;
    }

    body.template-modern .modern-header table {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-modern .modern-header td {
        vertical-align: top;
    }

    body.template-modern .modern-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50px;
        border: 3px solid rgba(255, 255, 255, 0.5);
        overflow: hidden;
        background-color: rgba(15, 23, 42, 0.25);
    }

    body.template-modern .modern-avatar img {
        width: 90px;
        height: 90px;
        object-fit: cover;
    }

    body.template-modern .modern-avatar span {
        display: block;
        width: 90px;
        height: 90px;
        line-height: 90px;
        text-align: center;
        font-size: 24px;
        letter-spacing: 5px;
        color: #ffffff;
    }

    body.template-modern .modern-name {
        font-size: 27px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin: 0;
    }

    body.template-modern .modern-headline {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.78);
    }

    body.template-modern .modern-contact {
        list-style: none;
        margin: 0;
        padding: 0;
        font-size: 11px;
    }

    body.template-modern .modern-contact li {
        margin-bottom: 4px;
    }

    body.template-modern .modern-body {
        padding: 26px 30px 28px;
    }

    body.template-modern .modern-summary {
        background-color: rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.2);
        border-radius: 14px;
        padding: 16px 18px;
        margin-bottom: 24px;
        font-size: 12px;
        color: #1f2937;
    }

    body.template-modern .modern-summary p {
        margin: 0 0 10px 0;
    }

    body.template-modern .modern-summary p:last-child {
        margin-bottom: 0;
    }

    body.template-modern .modern-columns {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-modern .modern-columns td {
        vertical-align: top;
    }

    body.template-modern .modern-main {
        width: 66%;
        padding-right: 18px;
        border-right: 1px solid #d9e2ff;
    }

    body.template-modern .modern-aside {
        width: 34%;
        padding-left: 18px;
    }

    body.template-modern .modern-section {
        margin-bottom: 26px;
    }

    body.template-modern .modern-section:last-child {
        margin-bottom: 0;
    }

    body.template-modern .modern-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: {{ $accent }};
        margin-bottom: 10px;
    }

    body.template-modern .modern-entry {
        border-left: 3px solid rgba(37, 99, 235, 0.35);
        padding-left: 12px;
        margin-bottom: 18px;
    }

    body.template-modern .modern-entry:last-child {
        margin-bottom: 0;
    }

    body.template-modern .modern-entry-title {
        font-size: 13px;
        font-weight: bold;
        color: #0f172a;
    }

    body.template-modern .modern-meta {
        font-size: 11px;
        color: #475569;
        margin-top: 4px;
    }

    body.template-modern .modern-bullets {
        margin: 10px 0 0 16px;
        padding: 0;
    }

    body.template-modern .modern-bullets li {
        font-size: 12px;
        color: #1f2937;
        margin-bottom: 6px;
    }

    body.template-modern .modern-bullets li:last-child {
        margin-bottom: 0;
    }

    body.template-modern .modern-chip-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-modern .modern-chip-list li {
        display: inline-block;
        background-color: rgba(37, 99, 235, 0.12);
        border: 1px solid rgba(37, 99, 235, 0.3);
        color: #1d4ed8;
        border-radius: 999px;
        padding: 4px 11px;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin: 0 6px 6px 0;
    }

    body.template-modern .modern-simple-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-modern .modern-simple-list li {
        font-size: 11px;
        color: #1f2937;
        margin-bottom: 6px;
    }

    body.template-modern .modern-simple-list li span {
        color: #64748b;
    }
</style>

<div class="modern-page">
    <header class="modern-header">
        <table>
            <tr>
                <td style="width: 110px;">
                    <div class="modern-avatar">
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
                    <div class="modern-name">{{ $fullName ?: 'Curriculum Vitae' }}</div>
                    @if ($headline)
                        <div class="modern-headline">{{ strtoupper($headline) }}</div>
                    @endif
                </td>
                @if (!empty($contactItems))
                    <td style="width: 220px;">
                        <ul class="modern-contact">
                            @foreach ($contactItems as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </td>
                @endif
            </tr>
        </table>
    </header>

    <div class="modern-body">
        @if ($summaryParagraphs->isNotEmpty())
            <div class="modern-summary">
                @foreach ($summaryParagraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
        @endif

        <table class="modern-columns">
            <tr>
                <td class="modern-main" @if (! $hasModernAside) style="width: 100%; padding-right: 0; border-right: none;" @endif>
                    @if ($experienceBlocks->isNotEmpty())
                        <div class="modern-section">
                            <div class="modern-title">{{ __('Experience') }}</div>
                            @foreach ($experienceBlocks as $experience)
                                <div class="modern-entry">
                                    @if (!empty($experience['position']))
                                        <div class="modern-entry-title">{{ $experience['position'] }}</div>
                                    @endif
                                    @php
                                        $metaPieces = collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter();
                                        $timePieces = collect([$experience['from'] ?? null, $experience['to'] ?? null])->filter();
                                    @endphp
                                    @if ($metaPieces->isNotEmpty())
                                        <div class="modern-meta">{{ $metaPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($timePieces->isNotEmpty())
                                        <div class="modern-meta">{{ $timePieces->implode(' – ') }}</div>
                                    @endif
                                    @if ($experience['bullets']->isNotEmpty())
                                        <ul class="modern-bullets">
                                            @foreach ($experience['bullets'] as $bullet)
                                                <li>{{ $bullet }}</li>
                                            @endforeach
                                        </ul>
                                    @elseif (!empty($experience['achievements']))
                                        <p class="modern-meta" style="color: #1f2937; margin-top: 8px;">{{ $experience['achievements'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($educationBlocks->isNotEmpty())
                        <div class="modern-section">
                            <div class="modern-title">{{ __('Education') }}</div>
                            @foreach ($educationBlocks as $education)
                                <div class="modern-entry">
                                    @if (!empty($education['institution']))
                                        <div class="modern-entry-title">{{ $education['institution'] }}</div>
                                    @endif
                                    @php
                                        $studyPieces = collect([$education['degree'] ?? null, $education['field'] ?? null])->filter();
                                        $durationPieces = collect([$education['start'] ?? null, $education['end'] ?? __('Ongoing')])->filter();
                                        $locationPieces = collect([$education['location'] ?? null])->filter();
                                    @endphp
                                    @if ($studyPieces->isNotEmpty())
                                        <div class="modern-meta">{{ $studyPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($locationPieces->isNotEmpty() || $durationPieces->isNotEmpty())
                                        <div class="modern-meta">
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
                @if ($hasModernAside)
                    <td class="modern-aside">
                        @if ($skillTags->isNotEmpty())
                            <div class="modern-section">
                                <div class="modern-title">{{ __('Skills') }}</div>
                                <ul class="modern-chip-list">
                                    @foreach ($skillTags as $skill)
                                        <li>{{ $skill }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($languageItems->isNotEmpty())
                            <div class="modern-section">
                                <div class="modern-title">{{ __('Languages') }}</div>
                                <ul class="modern-simple-list">
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
                            <div class="modern-section">
                                <div class="modern-title">{{ __('Interests') }}</div>
                                <ul class="modern-simple-list">
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
