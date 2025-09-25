{{-- Shared template data helper. Prefer using the TemplateDataBuilder directly. --}}
@php
    $templateData = \App\View\TemplateDataBuilder::fromCv($cv ?? null);
    $data = $templateData;
@endphp
