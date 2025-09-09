<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $data['first_name'] ?? '' }} {{ $data['last_name'] ?? '' }} - CV</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.4; margin: 20px; }
        h1 { font-size: 24px; margin-bottom: 10px; }
        h2 { font-size: 18px; margin-top: 20px; margin-bottom: 5px; }
        p, li { font-size: 14px; margin-bottom: 5px; }
        ul { padding-left: 20px; margin-bottom: 10px; }
        .section { margin-bottom: 15px; }
        .border { border: 1px solid #ccc; padding: 10px; border-radius: 4px; margin-bottom: 10px; }
    </style>
</head>
<body>

<h1>{{ trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) }}</h1>

{{-- Personal Information --}}
@if(!empty($data['first_name']) || !empty($data['last_name']) || !empty($data['email']))
<div class="section">
    <h2>Personal Information</h2>
    @if(!empty($data['email']))<p>Email: {{ $data['email'] }}</p>@endif
    @if(!empty($data['phone']))<p>Phone: {{ $data['phone'] }}</p>@endif
    @if(!empty($data['location']))<p>Location: {{ $data['location'] }}</p>@endif
    @if(!empty($data['website']))<p>Website: {{ $data['website'] }}</p>@endif
    @if(!empty($data['summary']))<p>Summary: {{ $data['summary'] }}</p>@endif
</div>
@endif

{{-- Work Experience --}}
@if(!empty($data['experiences']))
<div class="section">
    <h2>Work Experience</h2>
    @foreach($data['experiences'] as $exp)
        @php
            $hasExp = !empty($exp['company']) || !empty($exp['role']);
        @endphp
        @if($hasExp)
        <div class="border">
            @if(!empty($exp['company']))<p><strong>{{ $exp['company'] }}</strong></p>@endif
            @if(!empty($exp['role']))<p>Role: {{ $exp['role'] }}</p>@endif
            @if(!empty($exp['city']) || !empty($exp['country']))<p>Location: {{ $exp['city'] ?? '' }}{{ !empty($exp['city']) && !empty($exp['country']) ? ', ' : '' }}{{ $exp['country'] ?? '' }}</p>@endif
            @if(!empty($exp['start_date']) || !empty($exp['end_date']) || !empty($exp['currently_working']))
                <p>Period: {{ $exp['start_date'] ?? '' }} - {{ !empty($exp['currently_working']) ? 'Present' : ($exp['end_date'] ?? '') }}</p>
            @endif
            @if(!empty($exp['description']))<p>{{ $exp['description'] }}</p>@endif
        </div>
        @endif
    @endforeach
</div>
@endif

{{-- Activities --}}
@if(!empty($data['activities']))
<div class="section">
    <h2>Activities</h2>
    @foreach($data['activities'] as $act)
        @if(!empty($act['title']) || !empty($act['description']))
        <div class="border">
            @if(!empty($act['title']))<p><strong>{{ $act['title'] }}</strong></p>@endif
            @if(!empty($act['description']))<p>{{ $act['description'] }}</p>@endif
        </div>
        @endif
    @endforeach
</div>
@endif

{{-- Hobbies --}}
@if(!empty($data['hobbies']))
<div class="section">
    <h2>Hobbies</h2>
    <ul>
        @foreach($data['hobbies'] as $hobby)
            @if(!empty($hobby))<li>{{ $hobby }}</li>@endif
        @endforeach
    </ul>
</div>
@endif

{{-- Languages --}}
@if(!empty($data['languages']))
<div class="section">
    <h2>Languages</h2>
    <ul>
        @foreach($data['languages'] as $lang)
            @if(!empty($lang['name']))
                <li>{{ $lang['name'] }}{{ !empty($lang['level']) ? ' - '.ucfirst($lang['level']) : '' }}</li>
            @endif
        @endforeach
    </ul>
</div>
@endif

</body>
</html>
