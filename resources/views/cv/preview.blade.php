<x-app-layout>
    <x-slot name="header">CV Preview</x-slot>

    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Your CV Preview</h1>

        @if(!empty($cvData))
            <div class="bg-white shadow rounded-2xl p-6 space-y-6">
                {{-- Personal info --}}
                <div>
                    <h2 class="text-lg font-semibold mb-2">Personal Information</h2>
                    <p><strong>Name:</strong> {{ ($cvData['first_name'] ?? '') . ' ' . ($cvData['last_name'] ?? '') }}</p>
                    @if(!empty($cvData['email'])) <p><strong>Email:</strong> {{ $cvData['email'] }}</p> @endif
                    @if(!empty($cvData['phone'])) <p><strong>Phone:</strong> {{ $cvData['phone'] }}</p> @endif
                    @if(!empty($cvData['birthday'])) <p><strong>Birthday:</strong> {{ $cvData['birthday'] }}</p> @endif
                </div>

                {{-- Experience (handle both single and array cases) --}}
                @php
                    $experiences = $cvData['experience'] ?? null;
                    // If single object submitted as associative array keys like company/position, wrap into array
                    if ($experiences && !is_array($experiences)) $experiences = [$experiences];
                    // If experiences is associative (single experience) and keys are strings, detect and normalize
                    if (is_array($experiences) && array_keys($experiences) !== range(0, count($experiences)-1)) {
                        // treat as single experience
                        $experiences = [$experiences];
                    }
                @endphp

                @if(!empty($experiences))
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Experience</h2>
                        <div class="space-y-4">
                            @foreach($experiences as $exp)
                                @php if (!is_array($exp)) $exp = (array)$exp; @endphp
                                <div class="p-4 border rounded-lg bg-gray-50">
                                    @if(!empty($exp['position'])) <div class="font-semibold">{{ $exp['position'] }}</div> @endif
                                    @if(!empty($exp['company'])) <div class="text-sm text-gray-700">{{ $exp['company'] }}</div> @endif
                                    @if(!empty($exp['from']) || !empty($exp['to']) || !empty($exp['currently']))
                                        <div class="text-sm text-gray-600 mt-1">
                                            {{ $exp['from'] ?? '' }}
                                            -
                                            {{ (!empty($exp['currently']) && $exp['currently']) ? 'Present' : ($exp['to'] ?? '') }}
                                        </div>
                                    @endif
                                    @if(!empty($exp['city']) || !empty($exp['country']))
                                        <div class="text-sm text-gray-600 mt-1">{{ trim(($exp['city'] ?? '') . ' ' . ($exp['country'] ?? '')) }}</div>
                                    @endif
                                    @if(!empty($exp['achievements'])) <div class="mt-2 text-sm">{{ $exp['achievements'] }}</div> @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Education --}}
                @if(!empty($cvData['education']))
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Education</h2>
                        <p><strong>Institution:</strong> {{ $cvData['education']['institution'] ?? $cvData['education']['school'] ?? '' }}</p>
                        <p><strong>Degree:</strong> {{ $cvData['education']['degree'] ?? '' }}</p>
                    </div>
                @endif

                {{-- Template selection (if passed) --}}
                @if(!empty($cvData['template']))
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Selected Template</h2>
                        <p>{{ $cvData['template'] }}</p>
                    </div>
                @endif

                {{-- Download link --}}
                <div class="flex justify-end">
                    <a href="{{ route('cv.download', $cvData['template'] ?? 'classic') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Download PDF</a>
                </div>
            </div>

        @else
            <div class="bg-white p-6 rounded shadow">
                <p>No CV data found. Please fill the form first.</p>
                <a href="{{ route('cv.create') }}" class="inline-block mt-4 text-blue-600">Go back to form</a>
            </div>
        @endif
    </div>
</x-app-layout>
