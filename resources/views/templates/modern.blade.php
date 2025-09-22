<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - Modern</title>
    <style>
        body { font-family: Arial, sans-serif; background: #F9FAFB; color: #111827; }
        h1 { background: #2563EB; color: white; padding: 10px; border-radius: 6px; }
        .section { margin: 20px 0; padding: 10px; border-left: 4px solid #2563EB; }
    </style>
</head>
<body>
    <h1>{{ $data['name'] ?? '' }}</h1>
    <p><strong>Email:</strong> {{ $data['email'] ?? '' }} | <strong>Phone:</strong> {{ $data['phone'] ?? '' }} | <strong>Birthday:</strong> {{ $data['birthday'] ?? '' }}</p>

    <h2>Experience</h2>
    @foreach($data['experience'] ?? [] as $exp)
        <div class="section">
            <h3>{{ $exp['title'] ?? '' }}</h3>
            <p>{{ $exp['company'] ?? '' }} ({{ $exp['start'] ?? '' }} - {{ $exp['current'] ? 'Present' : ($exp['end'] ?? '') }})</p>
            <p>{{ $exp['city'] ?? '' }}, {{ $exp['country'] ?? '' }}</p>
            <p><em>{{ $exp['achievements'] ?? '' }}</em></p>
            <p>{{ $exp['about'] ?? '' }}</p>
        </div>
    @endforeach
</body>
</html>
