<?php

namespace App\View\Data;

use App\Support\TemplateLibrary;
use App\View\TemplateDataBuilder;
use Illuminate\Support\Collection;

class CvPreviewViewData
{
    public static function build(?array $cvData, array $templates): array
    {
        $hasData = !empty($cvData);
        $previewMeta = TemplateLibrary::previewMeta();

        if (!$hasData) {
            return [
                'hasData' => false,
                'templateInfo' => null,
                'templateKey' => $templates[0] ?? 'classic',
            ];
        }

        $templateKey = $cvData['template'] ?? 'classic';
        if (!in_array($templateKey, $templates, true)) {
            $templateKey = $templates[0] ?? 'classic';
        }

        $templateInfo = $previewMeta[$templateKey] ?? [
            'title' => ucfirst($templateKey),
            'description' => 'Ready-to-print layout for your story.',
            'preview' => 'from-slate-200 via-white to-slate-100',
        ];

        $normalized = TemplateDataBuilder::fromCv($cvData);

        $fullName = trim(($cvData['first_name'] ?? '') . ' ' . ($cvData['last_name'] ?? '')) ?: ($normalized['name'] ?? '');
        $location = $normalized['location'] ?? null;
        $headline = $normalized['headline'] ?? null;
        $summary = $normalized['summary'] ?? null;
        $initials = $normalized['initials'] ?? 'CV';
        $profileImage = $normalized['profile_image'] ?? null;

        $socialLinks = Collection::make([
            ['label' => 'Website', 'url' => $normalized['website'] ?? null],
            ['label' => 'LinkedIn', 'url' => $normalized['linkedin'] ?? null],
            ['label' => 'GitHub', 'url' => $normalized['github'] ?? null],
        ])->filter(fn ($item) => is_string($item['url']) && trim($item['url']) !== '')->values()->all();

        $contactChips = Collection::make([
            $normalized['email'] ?? null,
            $normalized['phone'] ?? null,
            $location,
            $normalized['birthday'] ?? null,
        ])->filter(fn ($value) => is_string($value) && trim($value) !== '')->values()->all();

        return [
            'hasData' => true,
            'templateKey' => $templateKey,
            'templateInfo' => $templateInfo,
            'profile' => [
                'name' => $fullName !== '' ? $fullName : __('Untitled CV'),
                'email' => $normalized['email'] ?? null,
                'phone' => $normalized['phone'] ?? null,
                'location' => $location,
                'birthday' => $normalized['birthday'] ?? null,
                'headline' => $headline,
                'summary' => $summary,
                'initials' => $initials,
                'profile_image' => $profileImage,
                'contacts' => $normalized['contacts'] ?? [],
            ],
            'experiences' => $normalized['experiences'] ?? [],
            'education' => $normalized['education'] ?? [],
            'skills' => $normalized['skills'] ?? [],
            'languages' => $normalized['languages'] ?? [],
            'hobbies' => $normalized['hobbies'] ?? [],
            'socialLinks' => $socialLinks,
            'contactChips' => $contactChips,
        ];
    }
}
