@include('cv.pdf.templates.partials.data-prep')

@php
    $accent = $accentColor ?? '#c026d3';
    $hasElegantAside = $skillTags->isNotEmpty() || $languageItems->isNotEmpty() || $hobbyItems->isNotEmpty();
@endphp

<style>
    body.template-elegant {
        background-color: #f7f5ff;
        padding: 18px;
        font-family: 'DejaVu Sans', 'Georgia', 'Times New Roman', serif;
        color: #2c1b33;
    }

    body.template-elegant .elegant-page {
        background-color: #ffffff;
        border: 1px solid #dccdf2;
        border-radius: 24px;
        padding: 30px 34px;
    }

    body.template-elegant .elegant-header {
        border-bottom: 2px solid {{ $accent }};
        padding-bottom: 20px;
        margin-bottom: 24px;
    }

    body.template-elegant .elegant-header table {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-elegant .elegant-header td {
        vertical-align: top;
    }

    body.template-elegant .elegant-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50px;
        border: 4px double {{ $accent }};
        overflow: hidden;
        background-color: #f4ecff;
    }

    body.template-elegant .elegant-avatar img {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    body.template-elegant .elegant-avatar span {
        display: block;
        width: 100px;
        height: 100px;
        line-height: 100px;
        text-align: center;
        font-size: 26px;
        letter-spacing: 5px;
        color: {{ $accent }};
    }

    body.template-elegant .elegant-name {
        font-size: 30px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin: 0;
    }

    body.template-elegant .elegant-headline {
        font-size: 12px;
        letter-spacing: 5px;
        text-transform: uppercase;
        margin-top: 6px;
        color: #7c4ba0;
    }

    body.template-elegant .elegant-contact {
        list-style: none;
        margin: 0;
        padding: 0;
        font-size: 11px;
        color: #5a3e6b;
        text-align: right;
    }

    body.template-elegant .elegant-contact li {
        margin-bottom: 4px;
    }

    body.template-elegant .elegant-summary {
        background-color: #f9f3ff;
        border: 1px solid #e8d9fb;
        border-radius: 18px;
        padding: 16px 20px;
        margin-bottom: 24px;
        font-size: 12px;
        color: #3c2a47;
    }

    body.template-elegant .elegant-summary p {
        margin: 0 0 10px 0;
    }

    body.template-elegant .elegant-summary p:last-child {
        margin-bottom: 0;
    }

    body.template-elegant .elegant-columns {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-elegant .elegant-columns td {
        vertical-align: top;
    }

    body.template-elegant .elegant-main {
        width: 64%;
        padding-right: 22px;
        border-right: 1px solid #e3d8f6;
    }

    body.template-elegant .elegant-aside {
        width: 36%;
        padding-left: 22px;
    }

    body.template-elegant .elegant-section {
        margin-bottom: 26px;
    }

    body.template-elegant .elegant-section:last-child {
        margin-bottom: 0;
    }

    body.template-elegant .elegant-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 4px;
        color: {{ $accent }};
        margin-bottom: 10px;
    }

    body.template-elegant .elegant-entry {
        margin-bottom: 18px;
    }

    body.template-elegant .elegant-entry:last-child {
        margin-bottom: 0;
    }

    body.template-elegant .elegant-entry-title {
        font-size: 13px;
        font-weight: bold;
        color: #2c1b33;
    }

    body.template-elegant .elegant-meta {
        font-size: 11px;
        color: #6a4a7d;
        margin-top: 4px;
    }

    body.template-elegant .elegant-bullets {
        margin: 10px 0 0 16px;
        padding: 0;
    }

    body.template-elegant .elegant-bullets li {
        font-size: 12px;
        color: #3c2a47;
        margin-bottom: 6px;
    }

    body.template-elegant .elegant-bullets li:last-child {
        margin-bottom: 0;
    }

    body.template-elegant .elegant-chip-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-elegant .elegant-chip-list li {
        display: inline-block;
        background-color: #f3e9ff;
        border: 1px solid #e2d0fb;
        border-radius: 18px;
        padding: 5px 12px;
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #7c4ba0;
        margin: 0 6px 6px 0;
    }

    body.template-elegant .elegant-simple-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-elegant .elegant-simple-list li {
        font-size: 11px;
        color: #3c2a47;
        margin-bottom: 6px;
    }

    body.template-elegant .elegant-simple-list li span {
        color: #7c4ba0;
    }
</style>

<div class="elegant-page">
    <header class="elegant-header">
        <table>
            <tr>
                <td style="width: 120px;">
                    <div class="elegant-avatar">
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
                    <div class="elegant-name">{{ $fullName ?: 'Curriculum Vitae' }}</div>
                    @if ($headline)
                        <div class="elegant-headline">{{ strtoupper($headline) }}</div>
                    @endif
                </td>
                @if (!empty($contactItems))
                    <td style="width: 220px;">
                        <ul class="elegant-contact">
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
        <div class="elegant-summary">
            @foreach ($summaryParagraphs as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    @endif

    <table class="elegant-columns">
        <tr>
            <td class="elegant-main" @if (! $hasElegantAside) style="width: 100%; padding-right: 0; border-right: none;" @endif>
                @if ($experienceBlocks->isNotEmpty())
                    <div class="elegant-section">
                        <div class="elegant-title">{{ __('Experience') }}</div>
                        @foreach ($experienceBlocks as $experience)
                            <div class="elegant-entry">
                                @if (!empty($experience['position']))
                                    <div class="elegant-entry-title">{{ $experience['position'] }}</div>
                                @endif
                                @php
                                    $metaPieces = collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter();
                                    $timePieces = collect([$experience['from'] ?? null, $experience['to'] ?? null])->filter();
                                @endphp
                                @if ($metaPieces->isNotEmpty())
                                    <div class="elegant-meta">{{ $metaPieces->implode(' · ') }}</div>
                                @endif
                                @if ($timePieces->isNotEmpty())
                                    <div class="elegant-meta">{{ $timePieces->implode(' – ') }}</div>
                                @endif
                                @if ($experience['bullets']->isNotEmpty())
                                    <ul class="elegant-bullets">
                                        @foreach ($experience['bullets'] as $bullet)
                                            <li>{{ $bullet }}</li>
                                        @endforeach
                                    </ul>
                                @elseif (!empty($experience['achievements']))
                                    <p class="elegant-meta" style="color: #3c2a47; margin-top: 8px;">{{ $experience['achievements'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($educationBlocks->isNotEmpty())
                    <div class="elegant-section">
                        <div class="elegant-title">{{ __('Education') }}</div>
                        @foreach ($educationBlocks as $education)
                            <div class="elegant-entry">
                                @if (!empty($education['institution']))
                                    <div class="elegant-entry-title">{{ $education['institution'] }}</div>
                                @endif
                                @php
                                    $studyPieces = collect([$education['degree'] ?? null, $education['field'] ?? null])->filter();
                                    $durationPieces = collect([$education['start'] ?? null, $education['end'] ?? __('Ongoing')])->filter();
                                    $locationPieces = collect([$education['location'] ?? null])->filter();
                                @endphp
                                @if ($studyPieces->isNotEmpty())
                                    <div class="elegant-meta">{{ $studyPieces->implode(' · ') }}</div>
                                @endif
                                @if ($locationPieces->isNotEmpty() || $durationPieces->isNotEmpty())
                                    <div class="elegant-meta">
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
            @if ($hasElegantAside)
                <td class="elegant-aside">
                    @if ($skillTags->isNotEmpty())
                        <div class="elegant-section">
                            <div class="elegant-title">{{ __('Skills') }}</div>
                            <ul class="elegant-chip-list">
                                @foreach ($skillTags as $skill)
                                    <li>{{ $skill }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($languageItems->isNotEmpty())
                        <div class="elegant-section">
                            <div class="elegant-title">{{ __('Languages') }}</div>
                            <ul class="elegant-simple-list">
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
                        <div class="elegant-section">
                            <div class="elegant-title">{{ __('Interests') }}</div>
                            <ul class="elegant-simple-list">
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
