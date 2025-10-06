@php
    $accent = $accentColor ?? '#1f2937';
    $highlight = '#22d3ee';
    $hasDarkAside = $skillTags->isNotEmpty() || $languageItems->isNotEmpty() || $hobbyItems->isNotEmpty();
@endphp

<style>
    body.template-darkmode {
        background-color: #0f172a;
        padding: 18px;
        font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
        color: #e2e8f0;
    }

    body.template-darkmode .dark-page {
        background-color: #1f2937;
        border-radius: 20px;
        overflow: hidden;
    }

    body.template-darkmode .dark-header {
        background-color: #111827;
        padding: 24px 30px;
        border-bottom: 3px solid {{ $highlight }};
    }

    body.template-darkmode .dark-header table {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-darkmode .dark-header td {
        vertical-align: top;
    }

    body.template-darkmode .dark-avatar {
        width: 92px;
        height: 92px;
        border-radius: 46px;
        border: 2px solid {{ $highlight }};
        overflow: hidden;
        background-color: #0f172a;
    }

    body.template-darkmode .dark-avatar img {
        width: 92px;
        height: 92px;
        object-fit: cover;
    }

    body.template-darkmode .dark-avatar span {
        display: block;
        width: 92px;
        height: 92px;
        line-height: 92px;
        text-align: center;
        font-size: 24px;
        letter-spacing: 4px;
        color: {{ $highlight }};
    }

    body.template-darkmode .dark-name {
        font-size: 28px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin: 0;
        color: #f9fafb;
    }

    body.template-darkmode .dark-headline {
        font-size: 12px;
        letter-spacing: 4px;
        text-transform: uppercase;
        margin-top: 6px;
        color: #94a3b8;
    }

    body.template-darkmode .dark-contact {
        list-style: none;
        margin: 0;
        padding: 0;
        font-size: 11px;
        color: #cbd5f5;
    }

    body.template-darkmode .dark-contact li {
        margin-bottom: 4px;
    }

    body.template-darkmode .dark-body {
        padding: 26px 30px 30px;
    }

    body.template-darkmode .dark-summary {
        border: 1px solid #374151;
        background-color: #0f172a;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        font-size: 12px;
        color: #cbd5f5;
    }

    body.template-darkmode .dark-summary p {
        margin: 0 0 10px 0;
    }

    body.template-darkmode .dark-summary p:last-child {
        margin-bottom: 0;
    }

    body.template-darkmode .dark-columns {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-darkmode .dark-columns td {
        vertical-align: top;
    }

    body.template-darkmode .dark-main {
        width: 65%;
        padding-right: 20px;
        border-right: 1px solid #374151;
    }

    body.template-darkmode .dark-aside {
        width: 35%;
        padding-left: 20px;
    }

    body.template-darkmode .dark-section {
        margin-bottom: 26px;
    }

    body.template-darkmode .dark-section:last-child {
        margin-bottom: 0;
    }

    body.template-darkmode .dark-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: {{ $highlight }};
        margin-bottom: 10px;
    }

    body.template-darkmode .dark-entry {
        margin-bottom: 18px;
        padding-left: 12px;
        border-left: 3px solid rgba(34, 211, 238, 0.35);
    }

    body.template-darkmode .dark-entry:last-child {
        margin-bottom: 0;
    }

    body.template-darkmode .dark-entry-title {
        font-size: 13px;
        font-weight: bold;
        color: #e2e8f0;
    }

    body.template-darkmode .dark-meta {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }

    body.template-darkmode .dark-bullets {
        margin: 10px 0 0 16px;
        padding: 0;
    }

    body.template-darkmode .dark-bullets li {
        font-size: 12px;
        color: #cbd5f5;
        margin-bottom: 6px;
    }

    body.template-darkmode .dark-bullets li:last-child {
        margin-bottom: 0;
    }

    body.template-darkmode .dark-chip-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-darkmode .dark-chip-list li {
        display: inline-block;
        background-color: rgba(34, 211, 238, 0.12);
        border: 1px solid rgba(34, 211, 238, 0.35);
        border-radius: 999px;
        padding: 4px 11px;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #67e8f9;
        margin: 0 6px 6px 0;
    }

    body.template-darkmode .dark-simple-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-darkmode .dark-simple-list li {
        font-size: 11px;
        color: #cbd5f5;
        margin-bottom: 6px;
    }

    body.template-darkmode .dark-simple-list li span {
        color: #67e8f9;
    }
</style>

<div class="dark-page">
    <header class="dark-header">
        <table>
            <tr>
                @if ($profileImage)
                    <td style="width: 120px;">
                        <div class="dark-avatar">
                            <img src="{{ $profileImage }}" alt="{{ $fullName ?: __('Profile photo') }}">
                        </div>
                    </td>
                @endif
                <td>
                    <div class="dark-name">{{ $fullName ?: 'Curriculum Vitae' }}</div>
                    @if ($headline)
                        <div class="dark-headline">{{ strtoupper($headline) }}</div>
                    @endif
                </td>
                @if (!empty($contactItems))
                    <td style="width: 220px;">
                        <ul class="dark-contact">
                            @foreach ($contactItems as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </td>
                @endif
            </tr>
        </table>
    </header>

    <div class="dark-body">
        @if ($summaryParagraphs->isNotEmpty())
            <div class="dark-summary">
                @foreach ($summaryParagraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
        @endif

        <table class="dark-columns">
            <tr>
                <td class="dark-main" @if (! $hasDarkAside) style="width: 100%; padding-right: 0; border-right: none;" @endif>
                    @if ($experienceBlocks->isNotEmpty())
                        <div class="dark-section">
                            <div class="dark-title">{{ __('Experience') }}</div>
                            @foreach ($experienceBlocks as $experience)
                                <div class="dark-entry">
                                    @if (!empty($experience['position']))
                                        <div class="dark-entry-title">{{ $experience['position'] }}</div>
                                    @endif
                                    @php
                                        $metaPieces = collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter();
                                        $timePieces = collect([$experience['from'] ?? null, $experience['to'] ?? null])->filter();
                                    @endphp
                                    @if ($metaPieces->isNotEmpty())
                                        <div class="dark-meta">{{ $metaPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($timePieces->isNotEmpty())
                                        <div class="dark-meta">{{ $timePieces->implode(' – ') }}</div>
                                    @endif
                                    @if ($experience['bullets']->isNotEmpty())
                                        <ul class="dark-bullets">
                                            @foreach ($experience['bullets'] as $bullet)
                                                <li>{{ $bullet }}</li>
                                            @endforeach
                                        </ul>
                                    @elseif (!empty($experience['achievements']))
                                        <p class="dark-meta" style="color: #cbd5f5; margin-top: 8px;">{{ $experience['achievements'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($educationBlocks->isNotEmpty())
                        <div class="dark-section">
                            <div class="dark-title">{{ __('Education') }}</div>
                            @foreach ($educationBlocks as $education)
                                <div class="dark-entry">
                                    @if (!empty($education['institution']))
                                        <div class="dark-entry-title">{{ $education['institution'] }}</div>
                                    @endif
                                    @php
                                        $studyPieces = collect([$education['degree'] ?? null, $education['field'] ?? null])->filter();
                                        $durationPieces = collect([$education['start'] ?? null, $education['end'] ?? __('Ongoing')])->filter();
                                        $locationPieces = collect([$education['location'] ?? null])->filter();
                                    @endphp
                                    @if ($studyPieces->isNotEmpty())
                                        <div class="dark-meta">{{ $studyPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($locationPieces->isNotEmpty() || $durationPieces->isNotEmpty())
                                        <div class="dark-meta">
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
                @if ($hasDarkAside)
                    <td class="dark-aside">
                        @if ($skillTags->isNotEmpty())
                            <div class="dark-section">
                                <div class="dark-title">{{ __('Skills') }}</div>
                                <ul class="dark-chip-list">
                                    @foreach ($skillTags as $skill)
                                        <li>{{ $skill }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($languageItems->isNotEmpty())
                            <div class="dark-section">
                                <div class="dark-title">{{ __('Languages') }}</div>
                                <ul class="dark-simple-list">
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
                            <div class="dark-section">
                                <div class="dark-title">{{ __('Interests') }}</div>
                                <ul class="dark-simple-list">
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
