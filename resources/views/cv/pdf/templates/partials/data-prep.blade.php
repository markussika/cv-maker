@php
    $summaryParagraphs = collect(preg_split('/\r\n|\r|\n/', (string) ($summary ?? '')))
        ->map(fn ($line) => trim((string) $line))
        ->filter()
        ->values();

    $achievementLines = function ($text) {
        return collect(preg_split('/\r\n|\r|\n|•|‣|▪|\x{2022}|\x{25CF}|\x{25CB}|\x{25AA}|\x{25AB}|\x{25A0}|\x{25A1}|\x{2023}|\x{2043}|\-/u', (string) ($text ?? '')))
            ->map(function ($line) {
                $line = trim((string) $line);
                if ($line === '') {
                    return null;
                }

                $line = preg_replace('/^[\p{Pd}\s•‣▪\x{2022}\x{25CF}\x{25CB}\x{25AA}\x{25AB}\x{25A0}\x{25A1}\x{2023}\x{2043}]+/u', '', $line);

                return trim((string) $line);
            })
            ->filter()
            ->values();
    };

    $experienceBlocks = collect($experienceItems ?? [])
        ->map(function ($item) use ($achievementLines) {
            if (!is_array($item)) {
                $item = (array) $item;
            }

            $item['bullets'] = $achievementLines($item['achievements'] ?? null);

            return $item;
        })
        ->filter(function ($item) {
            return !empty($item['position']) || !empty($item['company']) || !empty($item['achievements']);
        })
        ->values();

    $educationBlocks = collect($educationItems ?? [])
        ->map(function ($item) {
            if (!is_array($item)) {
                $item = (array) $item;
            }

            return $item;
        })
        ->filter(function ($item) {
            return !empty($item['institution']) || !empty($item['degree']) || !empty($item['field']);
        })
        ->values();

    $skillTags = collect($skills ?? [])
        ->map(fn ($item) => trim((string) $item))
        ->filter()
        ->values();

    $languageItems = collect($languages ?? [])
        ->map(function ($item) {
            if (!is_array($item)) {
                $item = (array) $item;
            }

            $name = trim((string) ($item['name'] ?? ($item[0] ?? '')));
            $level = trim((string) ($item['level'] ?? ($item[1] ?? '')));

            return [
                'name' => $name,
                'level' => $level,
            ];
        })
        ->filter(fn ($item) => $item['name'] !== '')
        ->values();

    $hobbyItems = collect($hobbies ?? [])
        ->map(fn ($item) => trim((string) $item))
        ->filter()
        ->values();
@endphp
