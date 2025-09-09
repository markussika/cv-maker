<div class="bg-white shadow rounded p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $data['first_name'] ?? '' }} {{ $data['last_name'] ?? '' }}</h1>

    <p>Email: {{ $data['email'] ?? '' }}</p>
    <p>Phone: {{ $data['phone'] ?? '-' }}</p>
    <p>Location: {{ $data['location'] ?? '-' }}</p>
    <p>Website: {{ $data['website'] ?? '-' }}</p>
    <p>{{ $data['summary'] ?? '' }}</p>

    @if(!empty($data['experiences']))
        <h3 class="font-semibold mt-4 mb-2">Work Experience</h3>
        @foreach($data['experiences'] as $exp)
            <div class="border p-2 mb-2 rounded">
                <strong>{{ $exp['role'] ?? '' }}</strong> at {{ $exp['company'] ?? '' }}<br>
                {{ $exp['start_date'] ?? '-' }} - {{ isset($exp['current']) && $exp['current'] ? 'Present' : ($exp['end_date'] ?? '-') }}
                <p>{{ $exp['description'] ?? '' }}</p>
            </div>
        @endforeach
    @endif

    @if(!empty($data['achievements']))
        <h3 class="font-semibold mt-4 mb-2">Achievements</h3>
        <ul>
            @foreach($data['achievements'] as $ach)
                <li>{{ $ach['title'] ?? '' }} - {{ $ach['description'] ?? '' }}</li>
            @endforeach
        </ul>
    @endif

    @if(!empty($data['hobbies']))
        <h3 class="font-semibold mt-4 mb-2">Hobbies</h3>
        <ul>
            @foreach($data['hobbies'] as $hobby)
                <li>{{ $hobby['title'] ?? '' }}</li>
            @endforeach
        </ul>
    @endif

    @if(!empty($data['languages']))
        <h3 class="font-semibold mt-4 mb-2">Languages</h3>
        <ul>
            @foreach($data['languages'] as $lang)
                <li>{{ $lang['name'] ?? '' }} - {{ ucfirst($lang['level'] ?? '') }}</li>
            @endforeach
        </ul>
    @endif
</div>
