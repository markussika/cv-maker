@php
    $accent = $accentColor ?? '#0ea5e9';
    $secondary = '#f97316';
    $hasGradientAside = $skillTags->isNotEmpty() || $languageItems->isNotEmpty() || $hobbyItems->isNotEmpty();
@endphp

<style>
    body.template-gradient {
        background-color: #f1f9ff;
        padding: 18px;
        font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
        color: #13223a;
    }

    body.template-gradient .gradient-page {
        background-color: #ffffff;
        border: 2px solid #cdeafe;
        border-radius: 22px;
        overflow: hidden;
    }

    body.template-gradient .gradient-header {
        background-color: {{ $accent }};
        color: #ffffff;
        padding: 26px 32px;
        border-bottom: 4px solid {{ $secondary }};
    }

    body.template-gradient .gradient-header table {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-gradient .gradient-header td {
        vertical-align: top;
    }

    body.template-gradient .gradient-avatar {
        width: 96px;
        height: 96px;
        border-radius: 24px;
        border: 3px solid rgba(255, 255, 255, 0.6);
        overflow: hidden;
        background-color: rgba(15, 23, 42, 0.25);
    }

    body.template-gradient .gradient-avatar img {
        width: 96px;
        height: 96px;
        object-fit: cover;
    }

    body.template-gradient .gradient-avatar span {
        display: block;
        width: 96px;
        height: 96px;
        line-height: 96px;
        text-align: center;
        font-size: 24px;
        letter-spacing: 4px;
        color: #ffffff;
    }

    body.template-gradient .gradient-name {
        font-size: 30px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin: 0;
    }

    body.template-gradient .gradient-headline {
        font-size: 12px;
        letter-spacing: 4px;
        text-transform: uppercase;
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.8);
    }

    body.template-gradient .gradient-contact {
        list-style: none;
        margin: 0;
        padding: 0;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.85);
    }

    body.template-gradient .gradient-contact li {
        margin-bottom: 4px;
    }

    body.template-gradient .gradient-body {
        padding: 28px 32px 34px;
    }

    body.template-gradient .gradient-summary {
        border: 1px solid #cdeafe;
        background-color: #ebf8ff;
        border-radius: 18px;
        padding: 16px 20px;
        margin-bottom: 24px;
        font-size: 12px;
        color: #1b2e44;
    }

    body.template-gradient .gradient-summary p {
        margin: 0 0 10px 0;
    }

    body.template-gradient .gradient-summary p:last-child {
        margin-bottom: 0;
    }

    body.template-gradient .gradient-columns {
        width: 100%;
        border-collapse: collapse;
    }

    body.template-gradient .gradient-columns td {
        vertical-align: top;
    }

    body.template-gradient .gradient-main {
        width: 65%;
        padding-right: 22px;
        border-right: 1px solid #d7ecff;
    }

    body.template-gradient .gradient-aside {
        width: 35%;
        padding-left: 22px;
    }

    body.template-gradient .gradient-section {
        margin-bottom: 26px;
    }

    body.template-gradient .gradient-section:last-child {
        margin-bottom: 0;
    }

    body.template-gradient .gradient-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: {{ $secondary }};
        margin-bottom: 10px;
    }

    body.template-gradient .gradient-entry {
        margin-bottom: 18px;
        padding-left: 12px;
        border-left: 3px solid rgba(14, 165, 233, 0.35);
    }

    body.template-gradient .gradient-entry:last-child {
        margin-bottom: 0;
    }

    body.template-gradient .gradient-entry-title {
        font-size: 13px;
        font-weight: bold;
        color: #13223a;
    }

    body.template-gradient .gradient-meta {
        font-size: 11px;
        color: #355072;
        margin-top: 4px;
    }

    body.template-gradient .gradient-bullets {
        margin: 10px 0 0 16px;
        padding: 0;
    }

    body.template-gradient .gradient-bullets li {
        font-size: 12px;
        color: #1b2e44;
        margin-bottom: 6px;
    }

    body.template-gradient .gradient-bullets li:last-child {
        margin-bottom: 0;
    }

    body.template-gradient .gradient-chip-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-gradient .gradient-chip-list li {
        display: inline-block;
        background-color: rgba(14, 165, 233, 0.12);
        border: 1px solid rgba(14, 165, 233, 0.3);
        border-radius: 12px;
        padding: 4px 11px;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #0f4c75;
        margin: 0 6px 6px 0;
    }

    body.template-gradient .gradient-simple-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    body.template-gradient .gradient-simple-list li {
        font-size: 11px;
        color: #1b2e44;
        margin-bottom: 6px;
    }

    body.template-gradient .gradient-simple-list li span {
        color: #355072;
    }
</style>

<div class="gradient-page">
    <header class="gradient-header">
        <table>
            <tr>
                @if ($profileImage)
                    <td style="width: 120px;">
                        <div class="gradient-avatar">
                            <img src="{{ $profileImage }}" alt="{{ $fullName ?: __('Profile photo') }}">
                        </div>
                    </td>
                @endif
                <td>
                    <div class="gradient-name">{{ $fullName ?: 'Curriculum Vitae' }}</div>
                    @if ($headline)
                        <div class="gradient-headline">{{ strtoupper($headline) }}</div>
                    @endif
                </td>
                @if (!empty($contactItems))
                    <td style="width: 220px;">
                        <ul class="gradient-contact">
                            @foreach ($contactItems as $contact)
                                <li>{{ $contact }}</li>
                            @endforeach
                        </ul>
                    </td>
                @endif
            </tr>
        </table>
    </header>

    <div class="gradient-body">
        @if ($summaryParagraphs->isNotEmpty())
            <div class="gradient-summary">
                @foreach ($summaryParagraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
        @endif

        <table class="gradient-columns">
            <tr>
                <td class="gradient-main" @if (! $hasGradientAside) style="width: 100%; padding-right: 0; border-right: none;" @endif>
                    @if ($experienceBlocks->isNotEmpty())
                        <div class="gradient-section">
                            <div class="gradient-title">{{ __('Experience') }}</div>
                            @foreach ($experienceBlocks as $experience)
                                <div class="gradient-entry">
                                    @if (!empty($experience['position']))
                                        <div class="gradient-entry-title">{{ $experience['position'] }}</div>
                                    @endif
                                    @php
                                        $metaPieces = collect([$experience['company'] ?? null, $experience['location'] ?? null])->filter();
                                        $timePieces = collect([$experience['from'] ?? null, $experience['to'] ?? null])->filter();
                                    @endphp
                                    @if ($metaPieces->isNotEmpty())
                                        <div class="gradient-meta">{{ $metaPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($timePieces->isNotEmpty())
                                        <div class="gradient-meta">{{ $timePieces->implode(' – ') }}</div>
                                    @endif
                                    @if ($experience['bullets']->isNotEmpty())
                                        <ul class="gradient-bullets">
                                            @foreach ($experience['bullets'] as $bullet)
                                                <li>{{ $bullet }}</li>
                                            @endforeach
                                        </ul>
                                    @elseif (!empty($experience['achievements']))
                                        <p class="gradient-meta" style="color: #1b2e44; margin-top: 8px;">{{ $experience['achievements'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($educationBlocks->isNotEmpty())
                        <div class="gradient-section">
                            <div class="gradient-title">{{ __('Education') }}</div>
                            @foreach ($educationBlocks as $education)
                                <div class="gradient-entry">
                                    @if (!empty($education['institution']))
                                        <div class="gradient-entry-title">{{ $education['institution'] }}</div>
                                    @endif
                                    @php
                                        $studyPieces = collect([$education['degree'] ?? null, $education['field'] ?? null])->filter();
                                        $durationPieces = collect([$education['start'] ?? null, $education['end'] ?? __('Ongoing')])->filter();
                                        $locationPieces = collect([$education['location'] ?? null])->filter();
                                    @endphp
                                    @if ($studyPieces->isNotEmpty())
                                        <div class="gradient-meta">{{ $studyPieces->implode(' · ') }}</div>
                                    @endif
                                    @if ($locationPieces->isNotEmpty() || $durationPieces->isNotEmpty())
                                        <div class="gradient-meta">
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
                @if ($hasGradientAside)
                    <td class="gradient-aside">
                        @if ($skillTags->isNotEmpty())
                            <div class="gradient-section">
                                <div class="gradient-title">{{ __('Skills') }}</div>
                                <ul class="gradient-chip-list">
                                    @foreach ($skillTags as $skill)
                                        <li>{{ $skill }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($languageItems->isNotEmpty())
                            <div class="gradient-section">
                                <div class="gradient-title">{{ __('Languages') }}</div>
                                <ul class="gradient-simple-list">
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
                            <div class="gradient-section">
                                <div class="gradient-title">{{ __('Interests') }}</div>
                                <ul class="gradient-simple-list">
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
