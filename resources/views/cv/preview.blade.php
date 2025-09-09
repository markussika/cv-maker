<x-app-layout>
<div class="container mx-auto py-8 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">CV Preview</h1>

    {{-- Personal Info --}}
    @if(!empty($data['first_name']) || !empty($data['last_name']) || !empty($data['email']))
    <div class="mb-6">
        <h2 class="font-bold text-xl mb-2">Personal Information</h2>
        @if(!empty($data['first_name']) || !empty($data['last_name']))
            <p>{{ $data['first_name'] ?? '' }} {{ $data['last_name'] ?? '' }}</p>
        @endif
        @if(!empty($data['email']))<p>Email: {{ $data['email'] }}</p>@endif
        @if(!empty($data['phone']))<p>Phone: {{ $data['phone'] }}</p>@endif
        @if(!empty($data['location']))<p>Location: {{ $data['location'] }}</p>@endif
        @if(!empty($data['website']))<p>Website: {{ $data['website'] }}</p>@endif
        @if(!empty($data['summary']))<p>Summary: {{ $data['summary'] }}</p>@endif
    </div>
    @endif

    {{-- Work Experience --}}
    @if(!empty($data['experiences']))
    <div class="mb-6">
        <h2 class="font-bold text-xl mb-2">Work Experience</h2>
        @foreach($data['experiences'] as $exp)
            @php
                $hasExp = !empty($exp['company']) || !empty($exp['role']);
            @endphp
            @if($hasExp)
            <div class="border p-2 rounded mb-2">
                @if(!empty($exp['company']))<p><strong>{{ $exp['company'] }}</strong></p>@endif
                @if(!empty($exp['role']))<p>Role: {{ $exp['role'] }}</p>@endif
                @if(!empty($exp['city']) || !empty($exp['country']))
                    <p>Location: {{ $exp['city'] ?? '' }}{{ !empty($exp['city']) && !empty($exp['country']) ? ', ' : '' }}{{ $exp['country'] ?? '' }}</p>
                @endif
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
    <div class="mb-6">
        <h2 class="font-bold text-xl mb-2">Activities</h2>
        @foreach($data['activities'] as $act)
            @if(!empty($act['title']) || !empty($act['description']))
            <div class="border p-2 rounded mb-2">
                @if(!empty($act['title']))<p><strong>{{ $act['title'] }}</strong></p>@endif
                @if(!empty($act['description']))<p>{{ $act['description'] }}</p>@endif
            </div>
            @endif
        @endforeach
    </div>
    @endif

    {{-- Hobbies --}}
    @if(!empty($data['hobbies']))
    <div class="mb-6">
        <h2 class="font-bold text-xl mb-2">Hobbies</h2>
        <ul class="list-disc ml-6">
            @foreach($data['hobbies'] as $hobby)
                @if(!empty($hobby))<li>{{ $hobby }}</li>@endif
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Languages --}}
    @if(!empty($data['languages']))
    <div class="mb-6">
        <h2 class="font-bold text-xl mb-2">Languages</h2>
        <ul class="list-disc ml-6">
            @foreach($data['languages'] as $lang)
                @if(!empty($lang['name']))
                    <li>{{ $lang['name'] }}{{ !empty($lang['level']) ? ' - '.ucfirst($lang['level']) : '' }}</li>
                @endif
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Download PDF --}}
    <form action="{{ route('cv.pdf') }}" method="POST">
        @csrf
        <input type="hidden" name="data" value="{{ htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8') }}">
        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 transition">Download PDF</button>
    </form>
</div>
</x-app-layout>
