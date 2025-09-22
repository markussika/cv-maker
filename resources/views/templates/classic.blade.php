<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $cv->name ?? 'My CV' }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; color: #333; }
        h1, h2 { margin-bottom: 0; }
        .section { margin-bottom: 20px; }
        .header { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .job { margin-bottom: 10px; }
        .small { font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $cv->name }}</h1>
        <p class="small">{{ $cv->email }} | {{ $cv->phone }} | {{ $cv->birthday }}</p>
    </div>

    <div class="section">
        <h2>Experience</h2>
        @foreach($cv->experiences as $exp)
            <div class="job">
                <strong>{{ $exp->position }}</strong> – {{ $exp->company }}
                <div class="small">{{ $exp->city }}, {{ $exp->country }}</div>
                <div class="small">
                    {{ $exp->start_date }} – {{ $exp->currently ? 'Present' : $exp->end_date }}
                </div>
                <p>{{ $exp->description }}</p>
            </div>
        @endforeach
    </div>

    @if(!empty($cv->achievements))
        <div class="section">
            <h2>Achievements</h2>
            <ul>
                @foreach($cv->achievements as $a)
                    <li>{{ $a }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!empty($cv->about))
        <div class="section">
            <h2>About Me</h2>
            <p>{{ $cv->about }}</p>
        </div>
    @endif
</body>
</html>
