@php
    $skillTags = ($skillTags ?? collect())->filter();
    $languageItems = ($languageItems ?? collect())->filter();
    $hobbyItems = ($hobbyItems ?? collect())->filter();

    $hasClassicAside = $skillTags->isNotEmpty() || $languageItems->isNotEmpty() || $hobbyItems->isNotEmpty();
@endphp

<style>
    body.template-classic {
        background-color: #f5f1eb;
        padding: 18px;
        font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
        color: #2f2a1e;
    }

    body.template-classic .classic-page {
        background-color: #ffffff;
        border: 2px solid #d9c7a3;
        border-radius: 18px;
        padding: 26px 30px 30px;
        box-shadow: none;
    }

    body.template-classic .classic-header {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 24px;
    }

    body.template-classic .classic-header td {
        vertical-align: top;
    }

    body.template-classic .classic-avatar {
        width: 96px;
        height: 96px;
        border-radius: 54px;
        border: 3px solid #c59d5f;
        background-color: #f6ede1;
        overflow: hidden;
    }

    body.template-classic .classic-avatar img {
        width: 96px;
        height: 96px;
        object-fit: cover;
    }

    body.template-classic .classic-avatar span {
        display: block;
        width: 96px;
        height: 96px;
        line-height: 96px;
        text-align: center;
        font-size: 24px;
        letter-spacing: 6px;
        color: #b07233;
    }

    body.template-classic .classic-name {
        font-size: 28px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: #2f2a1e;
    }

    body.template-classic .classic-headline {
        margin-top: 6px;
        font-size: 12px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: #b07233;
    }

    body.template-classic .classic-contact {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-classic .classic-contact li {
        font-size: 11px;
        color: #5b5043;
        margin-bottom: 4px;
    }

    body.template-classic .classic-summary {
        background-color: #faf4ea;
        border: 1px solid #e9dcc7;
        border-radius: 14px;
        padding: 16px 18px;
        margin-bottom: 24px;
        font-size: 12px;
        color: #42392f;
    }

    body.template-classic .classic-summary p {
        margin: 0 0 10px 0;
    }

    body.template-classic .classic-summary p:last-child {
        margin-bottom: 0;
    }

    body.template-classic .classic-columns {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-classic .classic-columns td {
        vertical-align: top;
    }

    body.template-classic .classic-main {
        width: 65%;
        padding-right: 18px;
        border-right: 1px solid #e6ddcf;
    }

    body.template-classic .classic-aside {
        width: 35%;
        padding-left: 18px;
    }

    body.template-classic .classic-section {
        margin-bottom: 26px;
    }

    body.template-classic .classic-section:last-child {
        margin-bottom: 0;
    }

    body.template-classic .classic-section-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #b07233;
        margin-bottom: 10px;
    }

    body.template-classic .classic-entry {
        margin-bottom: 18px;
    }

    body.template-classic .classic-entry:last-child {
        margin-bottom: 0;
    }

    body.template-classic .classic-entry-title {
        font-size: 13px;
        font-weight: bold;
        color: #2f2a1e;
    }

    body.template-classic .classic-entry-meta {
        font-size: 11px;
        color: #5b5043;
        margin-top: 4px;
    }

    body.template-classic .classic-bullets {
        margin: 10px 0 0 16px;
        padding: 0;
    }

    body.template-classic .classic-bullets li {
        font-size: 12px;
        color: #42392f;
        margin-bottom: 6px;
    }

    body.template-classic .classic-bullets li:last-child {
        margin-bottom: 0;
    }

    body.template-classic .classic-chip-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-classic .classic-chip-list li {
        display: inline-block;
        background-color: #f0e4d3;
        border: 1px solid #e3d2b8;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #6c5840;
        margin: 0 6px 6px 0;
    }

    body.template-classic .classic-simple-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-classic .classic-simple-list li {
        font-size: 11px;
        color: #3f372d;
        margin-bottom: 6px;
    }

    body.template-classic .classic-simple-list li span {
        color: #8c7b66;
    }
</style>

<div class="classic-page">
    <table class="classic-header">
        <tr>
            <td style="width: 110px;">
                <div class="classic-avatar">
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
                <div class="classic-name">{{ $fullName ?: 'Curriculum Vitae' }}</div>
                @if ($headline)
                    <div class="classic-headline">{{ strtoupper($headline) }}</div>
                @endif
            </td>
            @if (!empty($contactItems))
                <td style="width: 220px;">
                    <ul class="classic-contact">
                        @foreach ($contactItems as $contact)
                            <li>{{ $contact }}</li>
                        @endforeach
                    </ul>
                </td>
            @endif
        </tr>
    </table>

    @if ($summaryParagraphs->isNotEmpty())
        <div class="classic-summary">
            @foreach ($summaryParagraphs as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    @endif

    <table class="classic-columns">
        <tr>
            <td class="classic-main" @if (! $hasClassicAside) style="width: 100%; padding-right: 0; border-right: none;" @endif>
                @if ($experienceBlocks->isNotEmpty())
                    <div class="classic-section">
                        <div class="classic-section-title">{{ __('Experience') }}</div>
                        @foreach ($experienceBlocks as $experience)
                            <div class="classic-entry">
                                @if (!empty($experience['position']))
                                    <div class="classic-entry-title">{{ $experience['position'] }}</div>
                                @endif
                                @php
                                    $metaPieces = collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter();
                                    $timePieces = collect([$experience['from'] ?? null, $experience['to'] ?? null])->filter();
                                @endphp
                                @if ($metaPieces->isNotEmpty())
                                    <div class="classic-entry-meta">{{ $metaPieces->implode(' · ') }}</div>
                                @endif
                                @if ($timePieces->isNotEmpty())
                                    <div class="classic-entry-meta">{{ $timePieces->implode(' – ') }}</div>
                                @endif
                                @if ($experience['bullets']->isNotEmpty())
                                    <ul class="classic-bullets">
                                        @foreach ($experience['bullets'] as $bullet)
                                            <li>{{ $bullet }}</li>
                                        @endforeach
                                    </ul>
                                @elseif (!empty($experience['achievements']))
                                    <p class="classic-entry-meta" style="color: #42392f; margin-top: 8px;">{{ $experience['achievements'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($educationBlocks->isNotEmpty())
                    <div class="classic-section">
                        <div class="classic-section-title">{{ __('Education') }}</div>
                        @foreach ($educationBlocks as $education)
                            <div class="classic-entry">
                                @if (!empty($education['institution']))
                                    <div class="classic-entry-title">{{ $education['institution'] }}</div>
                                @endif
                                @php
                                    $studyPieces = collect([$education['degree'] ?? null, $education['field'] ?? null])->filter();
                                    $durationPieces = collect([$education['start'] ?? null, $education['end'] ?? __('Ongoing')])->filter();
                                    $locationPieces = collect([$education['location'] ?? null])->filter();
                                @endphp
                                @if ($studyPieces->isNotEmpty())
                                    <div class="classic-entry-meta">{{ $studyPieces->implode(' · ') }}</div>
                                @endif
                                @if ($locationPieces->isNotEmpty() || $durationPieces->isNotEmpty())
                                    <div class="classic-entry-meta">
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
            @if ($hasClassicAside)
                <td class="classic-aside">
                    @if ($skillTags->isNotEmpty())
                        <div class="classic-section">
                            <div class="classic-section-title">{{ __('Skills') }}</div>
                            <ul class="classic-chip-list">
                                @foreach ($skillTags as $skill)
                                    <li>{{ $skill }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($languageItems->isNotEmpty())
                        <div class="classic-section">
                            <div class="classic-section-title">{{ __('Languages') }}</div>
                            <ul class="classic-simple-list">
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
                        <div class="classic-section">
                            <div class="classic-section-title">{{ __('Interests') }}</div>
                            <ul class="classic-simple-list">
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
