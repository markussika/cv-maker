<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - Elegant</title>
    <style>
        body { font-family: Georgia, serif; background: #FDF2F8; color: #831843; }
        h1 { border-bottom: 2px solid #BE185D; padding-bottom: 5px; }
        .section { margin: 20px 0; }
    </style>
</head>
<body>
    <h1>{{ $data['name'] ?? '' }}</h1>
    <p>Email: {{ $data['email'] ?? '' }} | Phone: {{ $data['phone'] ?? '' }} | Birthday: {{ $data['birthday'] ?? '' }}</p>

    <h2>Experience</h2>
    @foreach($data['experience'] ?? [] as $exp)
        <div class="section">
            <strong>{{ $exp['title'] ?? '' }}</strong> at {{ $exp['company'] ?? '' }}<br>
            <i>{{ $exp['start'] ?? '' }} - {{ $exp['current'] ? 'Present' : ($exp['end'] ?? '') }}</i><br>
            {{ $exp['about'] ?? '' }}
        </div>
    @endforeach
</body>
</html>
