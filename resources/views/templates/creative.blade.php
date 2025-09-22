<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - Creative</title>
    <style>
        body { font-family: "Comic Sans MS", cursive, sans-serif; background: #FFFBEB; color: #78350F; }
        h1 { color: #D97706; text-align: center; }
        .section { background: #FEF3C7; padding: 15px; border-radius: 10px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>{{ $data['name'] ?? '' }}</h1>
    <p style="text-align:center;">Email: {{ $data['email'] ?? '' }} | Phone: {{ $data['phone'] ?? '' }} | Birthday: {{ $data['birthday'] ?? '' }}</p>

    <h2>Experience</h2>
    @foreach($data['experience'] ?? [] as $exp)
        <div class="section">
            <strong>{{ $exp['title'] ?? '' }}</strong> – {{ $exp['company'] ?? '' }}<br>
            {{ $exp['start'] ?? '' }} - {{ $exp['current'] ? 'Present' : ($exp['end'] ?? '') }}<br>
            <i>{{ $exp['achievements'] ?? '' }}</i><br>
            {{ $exp['about'] ?? '' }}
        </div>
    @endforeach
</body>
</html>
