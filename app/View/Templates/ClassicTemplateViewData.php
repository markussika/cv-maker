<?php

namespace App\View\Templates;

use Illuminate\Support\Collection;

class ClassicTemplateViewData
{
    public static function make(array $templateData): array
    {
        $summaryText = self::trimString($templateData['summary'] ?? null);
        $headline = self::trimString($templateData['headline'] ?? null);

        $summaryParagraphs = self::splitParagraphs($summaryText);
        $tagline = $headline;

        if ($tagline === null && $summaryText !== null) {
            $sentences = self::splitSentences($summaryText);
            if (!empty($sentences)) {
                $tagline = $sentences[0];
            }
        }

        $experienceData = [];
        $achievementLines = [];

        foreach ($templateData['experiences'] ?? [] as $experience) {
            $summary = self::trimString($experience['summary'] ?? null);
            $points = self::splitBullets($summary);
            $pointsCount = count($points);
            $hasList = $pointsCount > 1;
            $singlePoint = $pointsCount === 1 ? ($points[0] ?? null) : null;
            if ($singlePoint === null) {
                $singlePoint = $summary;
            }

            if (!empty($points)) {
                foreach ($points as $point) {
                    if (!in_array($point, $achievementLines, true)) {
                        $achievementLines[] = $point;
                    }
                }
            }

            $experienceData[] = array_merge($experience, [
                'summary_points' => $points,
                'summary_text' => $summary,
                'summary_points_count' => $pointsCount,
                'summary_first_point' => $singlePoint,
                'has_summary_list' => $hasList,
            ]);
        }

        if (empty($achievementLines) && $summaryText !== null) {
            $sentences = self::splitSentences($summaryText);
            foreach ($sentences as $sentence) {
                if (!in_array($sentence, $achievementLines, true)) {
                    $achievementLines[] = $sentence;
                }
                if (count($achievementLines) >= 4) {
                    break;
                }
            }
        }

        $achievementLines = array_slice($achievementLines, 0, 6);

        $hasSecondaryColumn = !empty($templateData['skills'])
            || !empty($templateData['languages'])
            || !empty($templateData['hobbies']);

        return [
            'templateData' => $templateData,
            'classic' => [
                'tagline' => $tagline,
                'summaryParagraphs' => $summaryParagraphs,
                'achievementLines' => $achievementLines,
                'experiences' => $experienceData,
                'hasSecondaryColumn' => $hasSecondaryColumn,
            ],
        ];
    }

    protected static function splitParagraphs(?string $text): array
    {
        if ($text === null || $text === '') {
            return [];
        }

        return Collection::make(preg_split('/\r\n|\r|\n/', $text) ?: [$text])
            ->map(fn ($line) => self::trimString($line))
            ->filter()
            ->values()
            ->all();
    }

    protected static function splitBullets(?string $text): array
    {
        if ($text === null || $text === '') {
            return [];
        }

        $segments = preg_split('/\r\n|\r|\n|•/', $text) ?: [$text];

        return Collection::make($segments)
            ->map(function ($line) {
                $line = self::trimString($line);
                if ($line === null) {
                    return null;
                }

                $line = ltrim($line, "-•\t ");

                return self::trimString($line);
            })
            ->filter()
            ->values()
            ->all();
    }

    protected static function splitSentences(string $text): array
    {
        return Collection::make(preg_split('/(?<=[.!?])\s+/', $text) ?: [$text])
            ->map(fn ($line) => self::trimString($line))
            ->filter()
            ->values()
            ->all();
    }

    protected static function trimString($value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
