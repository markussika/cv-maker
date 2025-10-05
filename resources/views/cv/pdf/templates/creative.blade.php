@include('cv.pdf.templates.partials.data-prep')

@php
    $accent = $accentColor ?? '#ec4899';
    $secondary = '#3b82f6';
    $hasCreativeAside = $skillTags->isNotEmpty() || $languageItems->isNotEmpty() || $hobbyItems->isNotEmpty();
@endphp

<style>
    body.template-creative {
        background-color: #fff6fb;
        padding: 18px;
        font-family: 'DejaVu Sans', 'Trebuchet MS', 'Arial', sans-serif;
        color: #1f1b2e;
    }

    body.template-creative .creative-page {
        background-color: #ffffff;
        border: 2px solid #fbd1e9;
        border-radius: 24px;
        padding: 0;
        overflow: hidden;
    }

    body.template-creative .creative-header {
        background-color: {{ $accent }};
        color: #ffffff;
        padding: 24px 30px;
    }

    body.template-creative .creative-header table {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-creative .creative-header td {
        vertical-align: top;
    }

    body.template-creative .creative-avatar {
        width: 94px;
        height: 94px;
        border-radius: 20px;
        border: 3px solid rgba(255, 255, 255, 0.6);
        background-color: rgba(15, 23, 42, 0.18);
        overflow: hidden;
    }

    body.template-creative .creative-avatar img {
        width: 94px;
        height: 94px;
        object-fit: cover;
    }

    body.template-creative .creative-avatar span {
        display: block;
        width: 94px;
        height: 94px;
        line-height: 94px;
        text-align: center;
        font-size: 26px;
        letter-spacing: 4px;
        color: #ffffff;
    }

    body.template-creative .creative-name {
        font-size: 30px;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin: 0;
    }

    body.template-creative .creative-headline {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 4px;
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.82);
    }

    body.template-creative .creative-tagline {
        display: inline-block;
        background-color: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 999px;
        padding: 4px 12px;
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-top: 10px;
    }

    body.template-creative .creative-contact {
        list-style: none;
        margin: 0;
        padding: 0;
        font-size: 11px;
    }

    body.template-creative .creative-contact li {
        margin-bottom: 4px;
    }

    body.template-creative .creative-body {
        padding: 26px 32px 32px;
    }

    body.template-creative .creative-summary {
        border: 2px dashed rgba(236, 72, 153, 0.35);
        background-color: #fff0f8;
        border-radius: 18px;
        padding: 16px 20px;
        margin-bottom: 24px;
        font-size: 12px;
        color: #312652;
    }

    body.template-creative .creative-summary p {
        margin: 0 0 10px 0;
    }

    body.template-creative .creative-summary p:last-child {
        margin-bottom: 0;
    }

    body.template-creative .creative-columns {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-creative .creative-columns td {
        vertical-align: top;
    }

    body.template-creative .creative-main {
        width: 64%;
        padding-right: 20px;
        border-right: 2px dotted #f0d0ff;
    }

    body.template-creative .creative-aside {
        width: 36%;
        padding-left: 20px;
    }

    body.template-creative .creative-section {
        margin-bottom: 26px;
    }

    body.template-creative .creative-section:last-child {
        margin-bottom: 0;
    }

    body.template-creative .creative-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: {{ $secondary }};
        margin-bottom: 10px;
    }

    body.template-creative .creative-entry {
        background-color: #fbf6ff;
        border: 1px solid #e6d9ff;
        border-radius: 16px;
        padding: 14px 16px;
        margin-bottom: 16px;
    }

    body.template-creative .creative-entry:last-child {
        margin-bottom: 0;
    }

    body.template-creative .creative-entry-title {
        font-size: 13px;
        font-weight: bold;
        color: #1f1b2e;
    }

    body.template-creative .creative-meta {
        font-size: 11px;
        color: #5c4f7f;
        margin-top: 4px;
    }

    body.template-creative .creative-bullets {
        margin: 10px 0 0 16px;
        padding: 0;
    }

    body.template-creative .creative-bullets li {
        font-size: 12px;
        color: #312652;
        margin-bottom: 6px;
    }

    body.template-creative .creative-bullets li:last-child {
        margin-bottom: 0;
    }

    body.template-creative .creative-chip-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-creative .creative-chip-list li {
        display: inline-block;
        background-color: rgba(59, 130, 246, 0.12);
        border: 1px solid rgba(59, 130, 246, 0.35);
        color: #2563eb;
        border-radius: 14px;
        padding: 5px 12px;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin: 0 6px 6px 0;
    }

    body.template-creative .creative-simple-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-creative .creative-simple-list li {
        font-size: 11px;
        color: #312652;
        margin-bottom: 6px;
    }

    body.template-creative .creative-simple-list li span {
        color: #6d5bb5;
    }
</style>

<div class="creative-page">
    <header class="creative-header">
        <table>
            <tr>
                <td style="width: 110px;">
                    <div class="creative-avatar">
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
                    <div class="creative-name">{{ $fullName ?: 'Curriculum Vitae' }}</div>
                    @if ($headline)
                        <div class="creative-headline">{{ strtoupper($headline) }}</div>
                    @endif
                    <div class="creative-tagline">{{ strtoupper($templateKey ?? 'Creative') }}</div>
                </td>
                @if (!empty($contactItems))
                    <td style="width: 220px;">
                        <ul class="creative-contact">
                            @foreach ($contactItems as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </td>
                @endif
            </tr>
        </table>
    </header>

    <div class="creative-body">
        @if ($summaryParagraphs->isNotEmpty())
            <div class="creative-summary">
                @foreach ($summaryParagraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
        @endif

        <table class="creative-columns">
            <tr>
                <td class="creative-main" @if (! $hasCreativeAside) style="width: 100%; padding-right: 0; border-right: none;" @endif>
                    @if ($experienceBlocks->isNotEmpty())
                        <div class="creative-section">
                            <div class="creative-title">{{ __('Experience') }}</div>
                            @foreach ($experienceBlocks as $experience)
                                <div class="creative-entry">
                                    @if (!empty($experience['position']))
                                        <div class="creative-entry-title">{{ $experience['position'] }}</div>
                                    @endif
                                    @php
                                        $metaPieces = collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter();
                                        $timePieces = collect([$experience['from'] ?? null, $experience['to'] ?? null])->filter();
                                    @endphp
                                    @if ($metaPieces->isNotEmpty())
                                        <div class="creative-meta">{{ $metaPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($timePieces->isNotEmpty())
                                        <div class="creative-meta">{{ $timePieces->implode(' – ') }}</div>
                                    @endif
                                    @if ($experience['bullets']->isNotEmpty())
                                        <ul class="creative-bullets">
                                            @foreach ($experience['bullets'] as $bullet)
                                                <li>{{ $bullet }}</li>
                                            @endforeach
                                        </ul>
                                    @elseif (!empty($experience['achievements']))
                                        <p class="creative-meta" style="color: #312652; margin-top: 8px;">{{ $experience['achievements'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($educationBlocks->isNotEmpty())
                        <div class="creative-section">
                            <div class="creative-title">{{ __('Education') }}</div>
                            @foreach ($educationBlocks as $education)
                                <div class="creative-entry">
                                    @if (!empty($education['institution']))
                                        <div class="creative-entry-title">{{ $education['institution'] }}</div>
                                    @endif
                                    @php
                                        $studyPieces = collect([$education['degree'] ?? null, $education['field'] ?? null])->filter();
                                        $durationPieces = collect([$education['start'] ?? null, $education['end'] ?? __('Ongoing')])->filter();
                                        $locationPieces = collect([$education['location'] ?? null])->filter();
                                    @endphp
                                    @if ($studyPieces->isNotEmpty())
                                        <div class="creative-meta">{{ $studyPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($locationPieces->isNotEmpty() || $durationPieces->isNotEmpty())
                                        <div class="creative-meta">
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
                @if ($hasCreativeAside)
                    <td class="creative-aside">
                        @if ($skillTags->isNotEmpty())
                            <div class="creative-section">
                                <div class="creative-title">{{ __('Skills') }}</div>
                                <ul class="creative-chip-list">
                                    @foreach ($skillTags as $skill)
                                        <li>{{ $skill }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($languageItems->isNotEmpty())
                            <div class="creative-section">
                                <div class="creative-title">{{ __('Languages') }}</div>
                                <ul class="creative-simple-list">
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
                            <div class="creative-section">
                                <div class="creative-title">{{ __('Interests') }}</div>
                                <ul class="creative-simple-list">
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
