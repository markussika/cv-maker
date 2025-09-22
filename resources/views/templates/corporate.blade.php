<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - Corporate</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; background: #F3F4F6; }
        h1 { background: #111827; color: white; padding: 8px; }
        h2 { color: #374151; }
        .section { border: 1px solid #D1D5DB; padding: 10px; margin: 15px 0; }
    </style>
</head>
<body>
    <h1>{{ $data['name'] ?? '' }}</h1>
    <p>Email: {{ $data['email'] ?? '' }} | Phone: {{ $data['phone'] ?? '' }} | Birthday: {{ $data['birthday'] ?? '' }}</p>

    <h2>Experience</h2>
    @foreach($data['experience'] ?? [] as $exp)
        <div class="section">
            <b>{{ $exp['title'] ?? '' }}</b> - {{ $exp['company'] ?? '' }}<br>
            {{ $exp['start'] ?? '' }} → {{ $exp['current'] ? 'Present' : ($exp['end'] ?? '') }}
        </div>
    @endforeach
</body>
</html>
