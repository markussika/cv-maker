<x-app-layout>
    <x-slot name="header">CV Preview</x-slot>
    <div class="p-6 bg-white rounded shadow">

        @php
            // Pārvērš JSON string vai null par array
            $hobbies = is_string($data['hobbies'] ?? null) ? json_decode($data['hobbies'], true) : ($data['hobbies'] ?? []);
            $languages = is_string($data['languages'] ?? null) ? json_decode($data['languages'], true) : ($data['languages'] ?? []);
            $skills = is_string($data['skills'] ?? null) ? json_decode($data['skills'], true) : ($data['skills'] ?? []);
            $education = is_string($data['education'] ?? null) ? json_decode($data['education'], true) : ($data['education'] ?? []);
            $extra_activities = is_string($data['extra_curriculum_activities'] ?? null) ? json_decode($data['extra_curriculum_activities'], true) : ($data['extra_curriculum_activities'] ?? []);
            $work_experience = is_string($data['work_experience'] ?? null) ? json_decode($data['work_experience'], true) : ($data['work_experience'] ?? []);
        @endphp

        <h2 class="text-2xl font-bold">{{ $data['first_name'] ?? '' }} {{ $data['last_name'] ?? '' }}</h2>
        <p>Email: {{ $data['email'] ?? '' }}</p>
        <p>Phone: {{ $data['phone'] ?? '' }}</p>

        @if(isset($data['profile_image']))
            <img src="{{ asset('storage/'.$data['profile_image']) }}" class="w-32 h-32 rounded mt-2 mb-4">
        @endif

        @if(!empty($work_experience))
            <h3 class="text-xl mt-4">Work Experience</h3>
            <ul class="list-disc pl-6">
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
            <h3 class="text-xl mt-4">Hobbies</h3>
            <ul class="list-disc pl-6">
                @foreach($hobbies as $h)<li>{{ $h }}</li>@endforeach
            </ul>
        @endif

        @if(!empty($languages))
            <h3 class="text-xl mt-4">Languages</h3>
            <ul class="list-disc pl-6">
                @foreach($languages as $l)<li>{{ $l }}</li>@endforeach
            </ul>
        @endif

        @if(!empty($skills))
            <h3 class="text-xl mt-4">Skills</h3>
            <ul class="list-disc pl-6">
                @foreach($skills as $s)<li>{{ $s }}</li>@endforeach
            </ul>
        @endif

        @if(!empty($education))
            <h3 class="text-xl mt-4">Education</h3>
            <ul class="list-disc pl-6">
                @foreach($education as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        @endif

        @if(!empty($extra_activities))
            <h3 class="text-xl mt-4">Extra Curricular Activities</h3>
            <ul class="list-disc pl-6">
                @foreach($extra_activities as $ea)<li>{{ $ea }}</li>@endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('cv.pdf') }}" class="mt-4">
            @csrf
            @foreach($data as $key=>$val)
                @if(is_array($val) || is_string($val))
                    <input type="hidden" name="{{ $key }}" value="{{ is_array($val)?json_encode($val):$val }}">
                @endif
            @endforeach
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Download PDF</button>
        </form>
    </div>
</x-app-layout>
