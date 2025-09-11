<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV PDF</title>
    <style>
        body{font-family: DejaVu Sans, sans-serif; margin:20px;}
        h2{margin-bottom:5px;}
        h3{margin-top:15px; margin-bottom:5px;}
        ul{list-style: square; padding-left:20px;}
        img{max-width:100px; max-height:100px;}
    </style>
</head>
<body>

    @php
        $hobbies = is_string($data['hobbies'] ?? null) ? json_decode($data['hobbies'], true) : ($data['hobbies'] ?? []);
        $languages = is_string($data['languages'] ?? null) ? json_decode($data['languages'], true) : ($data['languages'] ?? []);
        $skills = is_string($data['skills'] ?? null) ? json_decode($data['skills'], true) : ($data['skills'] ?? []);
        $education = is_string($data['education'] ?? null) ? json_decode($data['education'], true) : ($data['education'] ?? []);
        $extra_activities = is_string($data['extra_curriculum_activities'] ?? null) ? json_decode($data['extra_curriculum_activities'], true) : ($data['extra_curriculum_activities'] ?? []);
        $work_experience = is_string($data['work_experience'] ?? null) ? json_decode($data['work_experience'], true) : ($data['work_experience'] ?? []);
    @endphp

    <h2>{{ $data['first_name'] ?? '' }} {{ $data['last_name'] ?? '' }}</h2>
    <p>Email: {{ $data['email'] ?? '' }} | Phone: {{ $data['phone'] ?? '' }}</p>

    @if(isset($data['profile_image']))
        <img src="{{ public_path('storage/'.$data['profile_image']) }}">
    @endif

    @if(!empty($work_experience))
        <h3>Work Experience</h3>
        <ul>
            @foreach($work_experience as $we)
                @if(!empty($we['position']))
                    <li>{{ $we['position'] }} at {{ $we['company'] ?? '' }}, {{ $we['city'] ?? '' }}, {{ $we['country'] ?? '' }}
                    @if(isset($we['still_working']) && $we['still_working']) (Currently Working) @endif
                    </li>
                @endif
            @endforeach
        </ul>
    @endif

    @if(!empty($hobbies))
        <h3>Hobbies</h3>
        <ul>@foreach($hobbies as $h)<li>{{ $h }}</li>@endforeach</ul>
    @endif

    @if(!empty($languages))
        <h3>Languages</h3>
        <ul>@foreach($languages as $l)<li>{{ $l }}</li>@endforeach</ul>
    @endif

    @if(!empty($skills))
        <h3>Skills</h3>
        <ul>@foreach($skills as $s)<li>{{ $s }}</li>@endforeach</ul>
    @endif

    @if(!empty($education))
        <h3>Education</h3>
        <ul>@foreach($education as $e)<li>{{ $e }}</li>@endforeach</ul>
    @endif

    @if(!empty($extra_activities))
        <h3>Extra Curricular Activities</h3>
        <ul>@foreach($extra_activities as $ea)<li>{{ $ea }}</li>@endforeach</ul>
    @endif

</body>
</html>
