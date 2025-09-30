<?php

namespace App\View\Templates;

class TemplateViewFactory
{
    public static function make(string $templateKey, array $templateData): array
    {
        return match ($templateKey) {
            'classic' => ClassicTemplateViewData::make($templateData),
            default => ['templateData' => $templateData],
        };
    }
}
