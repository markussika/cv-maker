<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

return new class extends Migration {
    public function up(): void
    {
        $templates = ['classic', 'modern', 'creative', 'minimal', 'elegant', 'corporate', 'gradient', 'darkmode', 'futuristic'];

        DB::table('cvs')
            ->select([
                'id',
                'headline',
                'summary',
                'website',
                'linkedin',
                'github',
                'birthday',
                'country',
                'city',
                'template',
                'profile_image',
                'hobbies',
                'languages',
                'work_experience',
                'education',
                'skills',
                'extra_curriculum_activities',
                'created_at',
                'updated_at',
            ])
            ->orderBy('id')
            ->chunkById(100, function ($rows) use ($templates) {
                foreach ($rows as $row) {
                    if (!$this->shouldFixRow($row, $templates)) {
                        continue;
                    }

                    $updates = $this->buildUpdates($row);

                    if (!empty($updates)) {
                        DB::table('cvs')->where('id', $row->id)->update($updates);
                    }
                }
            });
    }

    public function down(): void
    {
        // This migration is data corrective; it cannot be reliably reversed.
    }

    protected function shouldFixRow(object $row, array $templates): bool
    {
        $template = is_string($row->template) ? trim($row->template) : null;

        $templateInvalid = $template === null || $template === '' || !in_array($template, $templates, true);

        if (!$templateInvalid) {
            return false;
        }

        if ($this->looksLikeJson($row->summary)
            || $this->looksLikeJson($row->website)
            || $this->looksLikeJson($row->linkedin)
            || $this->looksLikeJson($row->github)
            || $this->looksLikeJson($row->birthday)
            || $this->looksLikeJson($row->country)) {
            return true;
        }

        if ($this->looksLikeTimestamp($row->city) || $this->looksLikeTimestamp($row->template)) {
            return true;
        }

        if ($this->looksLikeProfileImage($row->headline) && ($row->profile_image === null || trim((string) $row->profile_image) === '')) {
            return true;
        }

        return false;
    }

    protected function buildUpdates(object $row): array
    {
        $updates = [];

        $profileImage = $this->normaliseProfileImage($row->headline);
        if ($profileImage !== null && ($row->profile_image === null || trim((string) $row->profile_image) === '')) {
            $updates['profile_image'] = $profileImage;
            $updates['headline'] = null;
        }

        $hobbies = $this->normaliseJson($row->summary);
        if ($hobbies !== null) {
            $updates['hobbies'] = $hobbies;
            $updates['summary'] = null;
        }

        $languages = $this->normaliseJson($row->website);
        if ($languages !== null) {
            $updates['languages'] = $languages;
            $updates['website'] = null;
        }

        $experience = $this->normaliseJson($row->linkedin);
        if ($experience !== null) {
            $updates['work_experience'] = $experience;
            $updates['linkedin'] = null;
        }

        $education = $this->normaliseJson($row->github);
        if ($education !== null) {
            $updates['education'] = $education;
            $updates['github'] = null;
        }

        $skills = $this->normaliseJson($row->birthday);
        if ($skills !== null) {
            $updates['skills'] = $skills;
            $updates['birthday'] = null;
        }

        $activities = $this->normaliseJson($row->country);
        if ($activities !== null) {
            $updates['extra_curriculum_activities'] = $activities;
            $updates['country'] = null;
        }

        $createdAt = $this->parseTimestamp($row->city);
        if ($createdAt !== null) {
            $updates['created_at'] = $createdAt;
            $updates['city'] = null;
        }

        $updatedAt = $this->parseTimestamp($row->template);
        if ($updatedAt !== null) {
            $updates['updated_at'] = $updatedAt;
        }

        if (!empty($updates)) {
            $updates['template'] = 'classic';
        }

        return $updates;
    }

    protected function normaliseJson(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $trimmed = trim($value);
        if ($trimmed === '' || strtolower($trimmed) === 'null') {
            return null;
        }

        $decoded = json_decode($trimmed, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function parseTimestamp(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            return null;
        }

        try {
            return Carbon::parse($trimmed)->format('Y-m-d H:i:s');
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function looksLikeJson(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $trimmed = ltrim($value);
        if ($trimmed === '') {
            return false;
        }

        $first = $trimmed[0];
        return $first === '{' || $first === '[';
    }

    protected function looksLikeTimestamp(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            return false;
        }

        return preg_match('/^\d{4}-\d{2}-\d{2}(?:[ T]\d{2}:\d{2}:\d{2})?$/', $trimmed) === 1;
    }

    protected function looksLikeProfileImage(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $trimmed = trim($value);
        if ($trimmed === '' || $this->looksLikeJson($trimmed)) {
            return false;
        }

        return Str::contains($trimmed, ['/', '.']);
    }

    protected function normaliseProfileImage(mixed $value): ?string
    {
        if (!$this->looksLikeProfileImage($value)) {
            return null;
        }

        return trim($value);
    }
};
