<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - Futuristic</title>
    <style>
        body { font-family: "Orbitron", sans-serif; background: black; color: #00F5FF; }
        h1 { font-size: 34px; border-bottom: 2px solid #00F5FF; }
        .section { background: rgba(0,245,255,0.1); padding: 15px; margin: 15px 0; border-radius: 8px; }
    </style>
</head>
<body>
    <h1>{{ $data['name'] ?? '' }}</h1>
    <p>{{ $data['email'] ?? '' }} • {{ $data['phone'] ?? '' }} • {{ $data['birthday'] ?? '' }}</p>

    <h2>Experience</h2>
    @foreach($data['experience'] ?? [] as $exp)
        <div class="section">
            {{ $exp['title'] ?? '' }} @ {{ $exp['company'] ?? '' }}<br>
            {{ $exp['start'] ?? '' }} - {{ $exp['current'] ? 'Present' : ($exp['end'] ?? '') }}
        </div>
    @endforeach
</body>
</html>
