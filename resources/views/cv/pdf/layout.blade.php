<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data['fullName'] ?? 'CV' }}</title>
    <style>
        @page { margin: 36px; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #111827;
        }
        h1, h2, h3, h4 { margin: 0; }
        p { margin: 0; }
        ul { margin: 0; padding: 0; list-style: none; }
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
    </style>
</head>
<body class="template-{{ $template ?? 'classic' }}">
    @include('cv.pdf.templates.' . ($template ?? 'classic'), [
        'fullName' => $data['fullName'] ?? null,
        'headline' => $data['headline'] ?? null,
        'summary' => $data['summary'] ?? null,
        'contactItems' => $data['contactItems'] ?? [],
        'experienceItems' => $data['experienceItems'] ?? [],
        'educationItems' => $data['educationItems'] ?? [],
        'skills' => $data['skills'] ?? [],
        'languages' => $data['languages'] ?? [],
        'hobbies' => $data['hobbies'] ?? [],
        'profileImage' => $data['profileImage'] ?? null,
        'accentColor' => $accentColor ?? '#1e293b',
        'templateKey' => $template ?? 'classic',
    ])
</body>
</html>
