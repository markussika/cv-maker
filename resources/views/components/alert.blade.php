@props([
    'type' => 'info',
    'title' => null,
])

@php
    $variant = in_array($type, ['success', 'error', 'warning', 'info'], true)
        ? $type
        : 'info';

    $icons = [
        'success' => 'M4.5 12.75 9 17.25 19.5 6.75',
        'error' => 'M15 9l-6 6m0-6 6 6',
        'warning' => 'M12 9v3.75m0 3.75h.008v.008H12V16.5Z',
        'info' => 'M11.25 11.25h1.5v5.25h-1.5m0-7.5h1.5',
    ];

    $viewBoxes = [
        'success' => '0 0 24 24',
        'error' => '0 0 24 24',
        'warning' => '0 0 24 24',
        'info' => '0 0 24 24',
    ];

    $titles = [
        'success' => __('Success'),
        'error' => __('Error'),
        'warning' => __('Heads up'),
        'info' => __('Notice'),
    ];

    $iconPath = $icons[$variant];
    $iconViewBox = $viewBoxes[$variant];
    $fallbackTitle = $titles[$variant];
    $showTitle = $title !== false;
    $resolvedTitle = $showTitle ? ($title ?? $fallbackTitle) : null;
@endphp

<div {{ $attributes->merge(['class' => 'createit-alert createit-alert--' . $variant, 'role' => 'alert']) }}>
    <div class="createit-alert__icon" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="{{ $iconViewBox }}" fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}" />
        </svg>
    </div>

    <div class="createit-alert__content">
        @if ($showTitle)
            <p class="createit-alert__title">
                {{ $resolvedTitle }}
            </p>
        @endif

        <div class="createit-alert__message">
            {{ $slot }}
        </div>
    </div>
</div>
