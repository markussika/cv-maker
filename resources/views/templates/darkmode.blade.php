<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - Dark Mode</title>
    <style>
        body { font-family: Arial, sans-serif; background: #111827; color: #F9FAFB; }
        h1 { color: #60A5FA; }
        h2 { color: #93C5FD; }
        .section { border-bottom: 1px solid #374151; margin: 15px 0; padding-bottom: 10px; }
    </style>
</head>
<body>
    <h1>{{ $data['name'] ?? '' }}</h1>
    <p>{{ $data['email'] ?? '' }} | {{ $data['phone'] ?? '' }} | {{ $data['birthday'] ?? '' }}</p>

    <h2>Experience</h2>
    @foreach($data['experience'] ?? [] as $exp)
        <div class="section">
            {{ $exp['title'] ?? '' }} at {{ $exp['company'] ?? '' }} ({{ $exp['start'] ?? '' }} - {{ $exp['current'] ? 'Present' : ($exp['end'] ?? '') }})
        </div>
    @endforeach
</body>
</html>
