<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - Gradient</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(to right, #6366F1, #EC4899); color: white; padding: 20px; }
        h1 { font-size: 32px; margin-bottom: 0; }
        .section { background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; margin: 15px 0; }
    </style>
</head>
<body>
    <h1>{{ $data['name'] ?? '' }}</h1>
    <p>{{ $data['email'] ?? '' }} • {{ $data['phone'] ?? '' }} • {{ $data['birthday'] ?? '' }}</p>

    <h2>Experience</h2>
    @foreach($data['experience'] ?? [] as $exp)
        <div class="section">
            {{ $exp['title'] ?? '' }} - {{ $exp['company'] ?? '' }}<br>
            {{ $exp['start'] ?? '' }} - {{ $exp['current'] ? 'Present' : ($exp['end'] ?? '') }}
        </div>
    @endforeach
</body>
</html>
