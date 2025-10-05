@php
    $accent = $accentColor ?? '#0f172a';
    $hasMinimalAside = $skillTags->isNotEmpty() || $languageItems->isNotEmpty() || $hobbyItems->isNotEmpty();
@endphp

<style>
    body.template-minimal {
        background-color: #f4f7fb;
        padding: 18px;
        font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
        color: #0f172a;
    }

    body.template-minimal .minimal-page {
        background-color: #ffffff;
        border: 1px solid #d6deeb;
        border-radius: 18px;
        padding: 28px 32px;
    }

    body.template-minimal .minimal-header {
        border-bottom: 1px solid #d6deeb;
        padding-bottom: 18px;
        margin-bottom: 22px;
    }

    body.template-minimal .minimal-header table {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-minimal .minimal-header td {
        vertical-align: top;
    }

    body.template-minimal .minimal-avatar {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        border: 2px solid #d6deeb;
        overflow: hidden;
        background-color: #f1f5f9;
    }

    body.template-minimal .minimal-avatar img {
        width: 90px;
        height: 90px;
        object-fit: cover;
    }

    body.template-minimal .minimal-avatar span {
        display: block;
        width: 90px;
        height: 90px;
        line-height: 90px;
        text-align: center;
        font-size: 22px;
        letter-spacing: 4px;
        color: #475569;
    }

    body.template-minimal .minimal-name {
        font-size: 26px;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin: 0;
    }

    body.template-minimal .minimal-headline {
        font-size: 12px;
        letter-spacing: 4px;
        text-transform: uppercase;
        margin-top: 6px;
        color: #64748b;
    }

    body.template-minimal .minimal-contact {
        list-style: none;
        margin: 0;
        padding: 0;
        font-size: 11px;
        color: #475569;
    }

    body.template-minimal .minimal-contact li {
        margin-bottom: 4px;
    }

    body.template-minimal .minimal-summary {
        border-left: 4px solid {{ $accent }};
        background-color: #f8fafc;
        padding: 14px 18px;
        margin-bottom: 24px;
        font-size: 12px;
        color: #1f2937;
    }

    body.template-minimal .minimal-summary p {
        margin: 0 0 10px 0;
    }

    body.template-minimal .minimal-summary p:last-child {
        margin-bottom: 0;
    }

    body.template-minimal .minimal-columns {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-minimal .minimal-columns td {
        vertical-align: top;
    }

    body.template-minimal .minimal-main {
        width: 67%;
        padding-right: 20px;
        border-right: 1px solid #e2e8f0;
    }

    body.template-minimal .minimal-aside {
        width: 33%;
        padding-left: 20px;
    }

    body.template-minimal .minimal-section {
        margin-bottom: 24px;
    }

    body.template-minimal .minimal-section:last-child {
        margin-bottom: 0;
    }

    body.template-minimal .minimal-title {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #475569;
        margin-bottom: 8px;
    }

    body.template-minimal .minimal-entry {
        margin-bottom: 16px;
    }

    body.template-minimal .minimal-entry:last-child {
        margin-bottom: 0;
    }

    body.template-minimal .minimal-entry-title {
        font-size: 13px;
        font-weight: bold;
        color: #0f172a;
    }

    body.template-minimal .minimal-meta {
        font-size: 11px;
        color: #64748b;
        margin-top: 4px;
    }

    body.template-minimal .minimal-bullets {
        margin: 10px 0 0 16px;
        padding: 0;
    }

    body.template-minimal .minimal-bullets li {
        font-size: 12px;
        color: #1f2937;
        margin-bottom: 6px;
    }

    body.template-minimal .minimal-bullets li:last-child {
        margin-bottom: 0;
    }

    body.template-minimal .minimal-chip-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-minimal .minimal-chip-list li {
        display: inline-block;
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #475569;
        margin: 0 6px 6px 0;
    }

    body.template-minimal .minimal-simple-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-minimal .minimal-simple-list li {
        font-size: 11px;
        color: #1f2937;
        margin-bottom: 6px;
    }

    body.template-minimal .minimal-simple-list li span {
        color: #64748b;
    }
</style>

<div class="minimal-page">
    <header class="minimal-header">
        <table>
            <tr>
                @if ($profileImage)
                    <td style="width: 110px;">
                        <div class="minimal-avatar">
                            <img src="{{ $profileImage }}" alt="{{ $fullName ?: __('Profile photo') }}">
                        </div>
                    </td>
                @endif
                <td>
                    <div class="minimal-name">{{ $fullName ?: 'Curriculum Vitae' }}</div>
                    @if ($headline)
                        <div class="minimal-headline">{{ strtoupper($headline) }}</div>
                    @endif
                </td>
                @if (!empty($contactItems))
                    <td style="width: 220px;">
                        <ul class="minimal-contact">
                            @foreach ($contactItems as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </td>
                @endif
            </tr>
        </table>
    </header>

    @if ($summaryParagraphs->isNotEmpty())
        <div class="minimal-summary">
            @foreach ($summaryParagraphs as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    @endif

    <table class="minimal-columns">
        <tr>
            <td class="minimal-main" @if (! $hasMinimalAside) style="width: 100%; padding-right: 0; border-right: none;" @endif>
                @if ($experienceBlocks->isNotEmpty())
                    <div class="minimal-section">
                        <div class="minimal-title">{{ __('Experience') }}</div>
                        @foreach ($experienceBlocks as $experience)
                            <div class="minimal-entry">
                                @if (!empty($experience['position']))
                                    <div class="minimal-entry-title">{{ $experience['position'] }}</div>
                                @endif
                                @php
                                    $metaPieces = collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter();
                                    $timePieces = collect([$experience['from'] ?? null, $experience['to'] ?? null])->filter();
                                @endphp
                                @if ($metaPieces->isNotEmpty())
                                    <div class="minimal-meta">{{ $metaPieces->implode(' · ') }}</div>
                                @endif
                                @if ($timePieces->isNotEmpty())
                                    <div class="minimal-meta">{{ $timePieces->implode(' – ') }}</div>
                                @endif
                                @if ($experience['bullets']->isNotEmpty())
                                    <ul class="minimal-bullets">
                                        @foreach ($experience['bullets'] as $bullet)
                                            <li>{{ $bullet }}</li>
                                        @endforeach
                                    </ul>
                                @elseif (!empty($experience['achievements']))
                                    <p class="minimal-meta" style="color: #1f2937; margin-top: 8px;">{{ $experience['achievements'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($educationBlocks->isNotEmpty())
                    <div class="minimal-section">
                        <div class="minimal-title">{{ __('Education') }}</div>
                        @foreach ($educationBlocks as $education)
                            <div class="minimal-entry">
                                @if (!empty($education['institution']))
                                    <div class="minimal-entry-title">{{ $education['institution'] }}</div>
                                @endif
                                @php
                                    $studyPieces = collect([$education['degree'] ?? null, $education['field'] ?? null])->filter();
                                    $durationPieces = collect([$education['start'] ?? null, $education['end'] ?? __('Ongoing')])->filter();
                                    $locationPieces = collect([$education['location'] ?? null])->filter();
                                @endphp
                                @if ($studyPieces->isNotEmpty())
                                    <div class="minimal-meta">{{ $studyPieces->implode(' · ') }}</div>
                                @endif
                                @if ($locationPieces->isNotEmpty() || $durationPieces->isNotEmpty())
                                    <div class="minimal-meta">
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
            @if ($hasMinimalAside)
                <td class="minimal-aside">
                    @if ($skillTags->isNotEmpty())
                        <div class="minimal-section">
                            <div class="minimal-title">{{ __('Skills') }}</div>
                            <ul class="minimal-chip-list">
                                @foreach ($skillTags as $skill)
                                    <li>{{ $skill }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($languageItems->isNotEmpty())
                        <div class="minimal-section">
                            <div class="minimal-title">{{ __('Languages') }}</div>
                            <ul class="minimal-simple-list">
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
                        <div class="minimal-section">
                            <div class="minimal-title">{{ __('Interests') }}</div>
                            <ul class="minimal-simple-list">
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
