<?php

namespace App\View;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class TemplateDataBuilder
{
    /**
     * Build the template-friendly data representation from a CV payload.
     */
    public static function fromCv($cv): array
    {
        $value = static function (string $key, $default = null) use ($cv) {
            return data_get($cv, $key, $default);
        };

        $firstName = $value('first_name');
        $lastName = $value('last_name');
        $fullName = collect([$firstName, $lastName])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => trim($item))
            ->implode(' ');
        $fullName = $fullName !== '' ? $fullName : null;

        $headline = $value('headline') ?? $value('title');
        $summary = $value('summary') ?? $value('about');

        $email = $value('email');
        $phone = $value('phone');
        $website = $value('website');

        $city = $value('city');
        $country = $value('country');
        $location = collect([$city, $country])
            ->filter(fn ($item) => is_string($item) && trim($item) !== '')
            ->map(fn ($item) => trim($item))
            ->implode(', ');
        $location = $location !== '' ? $location : null;

        $birthdayRaw = $value('birthday');
        $birthdayFormatted = null;
        if ($birthdayRaw instanceof Carbon) {
            $birthdayFormatted = $birthdayRaw->translatedFormat('F j, Y');
        } elseif (is_string($birthdayRaw) && trim($birthdayRaw) !== '') {
            try {
                $birthdayFormatted = Carbon::parse($birthdayRaw)->translatedFormat('F j, Y');
            } catch (\Throwable $exception) {
                $birthdayFormatted = $birthdayRaw;
            }
        }

        $formatMonthYear = static function ($val) {
            if (!is_string($val) || trim($val) === '') {
                return null;
            }
            $val = trim($val);
            try {
                if (preg_match('/^\d{4}-\d{2}$/', $val)) {
                    return Carbon::createFromFormat('Y-m', $val)->translatedFormat('M Y');
                }

                return Carbon::parse($val)->translatedFormat('M Y');
            } catch (\Throwable $e) {
                return $val;
            }
        };

        $formatYear = static function ($val) use ($formatMonthYear) {
            if (!is_string($val) || trim($val) === '') {
                return null;
            }
            $val = trim($val);
            try {
                if (preg_match('/^\d{4}$/', $val)) {
                    return Carbon::createFromFormat('Y', $val)->translatedFormat('Y');
                }

                return $formatMonthYear($val);
            } catch (\Throwable $e) {
                return $val;
            }
        };

        $normaliseCollection = static function ($items) {
            if ($items instanceof Collection) {
                $items = $items->all();
            }
            if (is_string($items)) {
                $decoded = json_decode($items, true);
                $items = is_array($decoded) ? $decoded : [];
            }
            if (!is_array($items)) {
                return collect();
            }
            $collection = collect($items);
            if ($collection->isEmpty()) {
                return collect();
            }
            if (Arr::isAssoc($collection->all())) {
                $collection = collect([$collection->all()]);
            }

            return $collection
                ->map(function ($item) {
                    if ($item instanceof Collection) {
                        return $item->toArray();
                    }
                    if (is_object($item)) {
                        return collect(get_object_vars($item))->toArray();
                    }

                    return is_array($item) ? $item : [];
                })
                ->filter(function ($item) {
                    if (!is_array($item)) {
                        return false;
                    }

                    foreach ($item as $value) {
                        if (is_array($value)) {
                            if (!empty($value)) {
                                return true;
                            }

                            continue;
                        }

                        if (trim((string) $value) !== '') {
                            return true;
                        }
                    }

                    return false;
                })
                ->values();
        };

        $experienceItems = $normaliseCollection($value('work_experience', $value('experience', [])))->map(function ($exp) use ($formatMonthYear) {
            $role = $exp['position'] ?? $exp['role'] ?? null;
            $company = $exp['company'] ?? null;
            $loc = collect([$exp['city'] ?? null, $exp['country'] ?? null])
                ->filter(fn ($i) => is_string($i) && trim($i) !== '')
                ->map(fn ($i) => trim($i))
                ->implode(', ');
            $loc = $loc !== '' ? $loc : null;

            $fromRaw = $exp['from'] ?? null;
            $toRaw = $exp['to'] ?? null;
            $from = $formatMonthYear($fromRaw);
            $isCurrent = !empty($exp['currently']);
            $to = $isCurrent ? __('Present') : $formatMonthYear($toRaw);
            $period = collect([$from, $to])->filter()->implode(' – ');

            $summaryValue = $exp['achievements'] ?? $exp['description'] ?? null;

            return [
                'role' => $role,
                'company' => $company,
                'location' => $loc,
                'from' => $from,
                'to' => $to,
                'from_raw' => $fromRaw,
                'to_raw' => $toRaw,
                'is_current' => $isCurrent,
                'period' => $period !== '' ? $period : null,
                'summary' => is_string($summaryValue) && trim($summaryValue) !== '' ? trim($summaryValue) : null,
            ];
        })->filter(fn ($i) => ($i['role'] ?? null) || ($i['company'] ?? null) || ($i['summary'] ?? null))
            ->values();

        $educationItems = $normaliseCollection($value('education', []))->map(function ($edu) use ($formatYear) {
            $institution = $edu['institution'] ?? $edu['school'] ?? null;
            $degree = $edu['degree'] ?? null;
            $field = $edu['field'] ?? null;

            $loc = collect([$edu['city'] ?? null, $edu['country'] ?? null])
                ->filter(fn ($i) => is_string($i) && trim($i) !== '')
                ->map(fn ($i) => trim($i))
                ->implode(', ');
            $loc = $loc !== '' ? $loc : null;

            $start = $formatYear($edu['start_year'] ?? $edu['from'] ?? null);
            $end = $formatYear($edu['end_year'] ?? $edu['to'] ?? null);
            $period = collect([$start, $end])->filter()->implode(' – ');

            return [
                'institution' => $institution,
                'degree' => $degree,
                'field' => $field,
                'location' => $loc,
                'start' => $start,
                'end' => $end,
                'period' => $period !== '' ? $period : null,
            ];
        })->filter(fn ($i) => ($i['institution'] ?? null) || ($i['degree'] ?? null) || ($i['field'] ?? null))
            ->values();

        $skillsItems = collect($value('skills', []))
            ->map(function ($item) {
                if (is_string($item)) {
                    return trim($item);
                }
                if (is_array($item)) {
                    $label = $item['name'] ?? $item['title'] ?? null;

                    return is_string($label) ? trim($label) : null;
                }

                return null;
            })
            ->filter(fn ($s) => is_string($s) && $s !== '')
            ->values();

        $languageItems = collect($value('languages', []))
            ->map(function ($item) {
                if (is_string($item)) {
                    return ['name' => trim($item), 'level' => null];
                }
                if (is_array($item)) {
                    $name = isset($item['name']) ? trim((string) $item['name']) : null;
                    $level = isset($item['level']) ? trim((string) $item['level']) : null;
                    if ($name === '') {
                        $name = null;
                    }
                    if ($level === '') {
                        $level = null;
                    }

                    return $name ? ['name' => $name, 'level' => $level] : null;
                }

                return null;
            })
            ->filter()
            ->values();

        $hobbyItems = collect($value('hobbies', []))
            ->map(function ($item) {
                if (is_string($item)) {
                    return trim($item);
                }
                if (is_array($item)) {
                    $label = $item['name'] ?? $item['title'] ?? null;

                    return is_string($label) ? trim($label) : null;
                }

                return null;
            })
            ->filter(fn ($h) => is_string($h) && $h !== '')
            ->values();

        $profileImage = $value('profile_image');
        if (is_string($profileImage) && trim($profileImage) !== '') {
            $profileImage = trim($profileImage);
            $isAbsoluteUrl = filter_var($profileImage, FILTER_VALIDATE_URL) !== false;
            $storagePath = preg_replace('#^/?storage/#', '', $profileImage);
            $storagePath = ltrim((string) $storagePath, '/');

            if (!$isAbsoluteUrl) {
                try {
                    if ($storagePath !== '' && Storage::disk('public')->exists($storagePath)) {
                        $profileImage = Storage::disk('public')->url($storagePath);
                    } elseif (Storage::disk('public')->exists(ltrim($profileImage, '/'))) {
                        $profileImage = Storage::disk('public')->url(ltrim($profileImage, '/'));
                    } else {
                        $profileImage = null;
                    }
                } catch (\Throwable $e) {
                    $profileImage = null;
                }
            }
        } else {
            $profileImage = null;
        }

        $templateData = [
            'name' => $fullName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'headline' => is_string($headline) && trim($headline) !== '' ? trim($headline) : null,
            'summary' => is_string($summary) && trim($summary) !== '' ? trim($summary) : null,
            'email' => $email,
            'phone' => $phone,
            'website' => $website,
            'location' => $location,
            'birthday' => $birthdayFormatted,
            'contacts' => array_values(array_filter([
                $email,
                $phone,
                $location,
                $birthdayFormatted,
                $website,
            ], fn ($i) => is_string($i) && trim($i) !== '')),
            'profile_image' => $profileImage,
            'experiences' => $experienceItems->all(),
            'education' => $educationItems->all(),
            'skills' => $skillsItems->all(),
            'languages' => $languageItems->all(),
            'hobbies' => $hobbyItems->all(),
            'template' => $value('template'),
        ];

        return $templateData;
    }
}
