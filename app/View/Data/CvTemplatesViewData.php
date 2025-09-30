<?php

namespace App\View\Data;

use App\Support\TemplateLibrary;
use App\View\TemplateDataBuilder;
use App\View\Templates\TemplateViewFactory;

class CvTemplatesViewData
{
    public static function build(array $templates): array
    {
        $metadata = TemplateLibrary::galleryMeta();
        $sampleCv = TemplateLibrary::sampleCv();

        $cards = [];
        foreach ($templates as $template) {
            $meta = $metadata[$template] ?? [
                'title' => ucfirst($template),
                'description' => 'Beautiful layout ready for your story.',
                'preview' => 'from-slate-200 via-white to-slate-100',
            ];

            $previewId = 'template-preview-' . $template;
            $templateData = TemplateDataBuilder::fromCv(array_merge($sampleCv, ['template' => $template]));
            $viewData = TemplateViewFactory::make($template, $templateData);
            $previewHtml = view('templates.' . $template, $viewData)->render();

            $cards[] = [
                'key' => $template,
                'meta' => $meta,
                'preview_id' => $previewId,
                'preview_html' => $previewHtml,
                'partial' => $meta['partial'] ?? null,
            ];
        }

        return [
            'templateCards' => $cards,
        ];
    }
}
