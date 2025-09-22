<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - Minimal</title>
    <style>
        body { font-family: Helvetica, sans-serif; color: #111; }
        h1 { font-size: 28px; margin-bottom: 0; }
        h2 { font-size: 20px; margin-top: 30px; }
        .section { margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>{{ $data['name'] ?? '' }}</h1>
    <p>{{ $data['email'] ?? '' }} • {{ $data['phone'] ?? '' }} • {{ $data['birthday'] ?? '' }}</p>

    <h2>Experience</h2>
    @foreach($data['experience'] ?? [] as $exp)
        <div class="section">
            <strong>{{ $exp['title'] ?? '' }}</strong>, {{ $exp['company'] ?? '' }} ({{ $exp['start'] ?? '' }} - {{ $exp['current'] ? 'Present' : ($exp['end'] ?? '') }})
        </div>
    @endforeach
</body>
</html>
