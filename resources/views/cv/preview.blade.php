<x-app-layout>
    <div class="bg-slate-50 py-10 sm:py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Preview</p>
                    <h1 class="mt-2 text-4xl font-semibold text-slate-900">Your CV snapshot</h1>
                    <p class="mt-3 text-sm text-slate-500 max-w-2xl">Review the saved details before exporting. You can always jump back to the builder to refine anything.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('cv.create') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:-translate-y-0.5 hover:shadow-lg transition">
                        <span aria-hidden="true">&larr;</span>
                        Edit details
                    </a>
                    @if($cv)
                        <a href="{{ route('cv.download', $cv->template ?? 'classic') }}" class="inline-flex items-center gap-2 rounded-full border border-transparent bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-black">
                            Download PDF
                            <span aria-hidden="true">&darr;</span>
                        </a>
                    @endif
                </div>
            </div>

            @if (session('status'))
                <div class="rounded-3xl border border-emerald-100 bg-emerald-50/80 p-4 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if($cv)
                @php
                    $experienceItems = collect($cv->work_experience ?? [])
                        ->map(function ($item) {
                            return is_array($item) ? array_filter($item, fn ($value) => $value !== null && $value !== '') : [];
                        })
                        ->filter(fn ($item) => !empty($item))
                        ->values();

                    $educationItems = collect($cv->education ?? [])
                        ->map(function ($item) {
                            return is_array($item) ? array_filter($item, fn ($value) => $value !== null && $value !== '') : [];
                        })
                        ->filter(fn ($item) => !empty($item))
                        ->values();

                    $skills = collect($cv->skills ?? [])->filter();
                    $languages = collect($cv->languages ?? [])->filter();
                    $hobbies = collect($cv->hobbies ?? [])->filter();
                    $activities = collect($cv->extra_curriculum_activities ?? [])->filter();
                @endphp

                <div class="rounded-[32px] border border-white bg-white/90 shadow-2xl shadow-slate-200/60 backdrop-blur p-6 sm:p-10 space-y-10">
                    <div class="flex flex-col gap-6 md:flex-row md:justify-between">
                        <div class="space-y-2">
                            <h2 class="text-3xl font-semibold text-slate-900">{{ $cv->full_name ?: 'Unnamed professional' }}</h2>
                            <div class="space-y-1 text-sm text-slate-500">
                                @if($cv->email)<p>{{ $cv->email }}</p>@endif
                                @if($cv->phone)<p>{{ $cv->phone }}</p>@endif
                                @if($cv->country || $cv->city)<p>{{ trim(($cv->city ? $cv->city . ', ' : '') . ($cv->country ?? '')) }}</p>@endif
                            </div>
                        </div>
                        <div class="flex flex-col items-start gap-2 text-xs text-slate-500">
                            @if($cv->birth_date)<p><span class="font-semibold text-slate-700">Birthday:</span> {{ $cv->birth_date->format('d F Y') }}</p>@endif
                            @if($cv->linkedin)<a href="{{ $cv->linkedin }}" class="inline-flex items-center gap-1 text-blue-600 hover:underline" target="_blank" rel="noopener">LinkedIn<span aria-hidden="true">&rarr;</span></a>@endif
                            @if($cv->github)<a href="{{ $cv->github }}" class="inline-flex items-center gap-1 text-blue-600 hover:underline" target="_blank" rel="noopener">GitHub<span aria-hidden="true">&rarr;</span></a>@endif
                            @if($cv->website)<a href="{{ $cv->website }}" class="inline-flex items-center gap-1 text-blue-600 hover:underline" target="_blank" rel="noopener">Website<span aria-hidden="true">&rarr;</span></a>@endif
                        </div>
                    </div>

                    @if($cv->summary)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50/80 p-6 text-slate-700 leading-relaxed">
                            {{ $cv->summary }}
                        </div>
                    @endif

                    <div class="grid gap-8 md:grid-cols-2">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Experience</h3>
                                <div class="mt-4 space-y-4">
                                    @forelse($experienceItems as $experience)
                                        <div class="rounded-2xl border border-slate-200 p-4">
                                            @if(!empty($experience['position']))
                                                <p class="font-semibold text-slate-800">{{ $experience['position'] }}</p>
                                            @endif
                                            <p class="text-sm text-slate-500">
                                                {{ $experience['company'] ?? '' }}
                                                @if(!empty($experience['company']) && (!empty($experience['city']) || !empty($experience['country'])))
                                                    &mdash;
                                                @endif
                                                {{ trim(($experience['city'] ?? '') . ' ' . ($experience['country'] ?? '')) }}
                                            </p>
                                            @if(!empty($experience['from']) || !empty($experience['to']) || !empty($experience['currently']))
                                                <p class="mt-2 text-xs uppercase tracking-[0.25em] text-slate-400">
                                                    {{ $experience['from'] ?? 'Start' }}
                                                    &ndash;
                                                    {{ !empty($experience['currently']) ? 'Present' : ($experience['to'] ?? 'End') }}
                                                </p>
                                            @endif
                                            @if(!empty($experience['achievements']))
                                                <p class="mt-3 text-sm text-slate-600">{{ $experience['achievements'] }}</p>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-sm text-slate-400">Add experience in the previous step to show it here.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Education</h3>
                                <div class="mt-4 space-y-4">
                                    @forelse($educationItems as $education)
                                        <div class="rounded-2xl border border-slate-200 p-4">
                                            @if(!empty($education['institution']))
                                                <p class="font-semibold text-slate-800">{{ $education['institution'] }}</p>
                                            @endif
                                            @if(!empty($education['degree']) || !empty($education['field']))
                                                <p class="text-sm text-slate-500">{{ trim(($education['degree'] ?? '') . ' ' . ($education['field'] ?? '')) }}</p>
                                            @endif
                                            @if(!empty($education['start_year']) || !empty($education['end_year']))
                                                <p class="mt-2 text-xs uppercase tracking-[0.25em] text-slate-400">
                                                    {{ $education['start_year'] ?? 'Start' }} &ndash; {{ $education['end_year'] ?? 'End' }}
                                                </p>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-sm text-slate-400">Education entries will appear once added.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Skills &amp; languages</h3>
                                <div class="mt-4 rounded-2xl border border-slate-200 p-4">
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Skills</p>
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                @forelse($skills as $skill)
                                                    <span class="rounded-full bg-slate-900 px-3 py-1 text-xs font-medium text-white">{{ $skill }}</span>
                                                @empty
                                                    <span class="text-sm text-slate-400">Add skills to highlight your strengths.</span>
                                                @endforelse
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Languages</p>
                                            <div class="mt-2 space-y-2 text-sm text-slate-600">
                                                @forelse($languages as $language)
                                                    <p>{{ $language }}</p>
                                                @empty
                                                    <p class="text-slate-400">List the languages you speak.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Life outside work</h3>
                                <div class="mt-4 rounded-2xl border border-slate-200 p-4 space-y-4 text-sm text-slate-600">
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Hobbies</p>
                                        <div class="mt-2 space-y-1">
                                            @forelse($hobbies as $hobby)
                                                <p>{{ $hobby }}</p>
                                            @empty
                                                <p class="text-slate-400">Share a human side &mdash; photography, cycling, cooking.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Activities</p>
                                        <div class="mt-2 space-y-1">
                                            @forelse($activities as $activity)
                                                <p>{{ $activity }}</p>
                                            @empty
                                                <p class="text-slate-400">Add volunteer work or awards to stand out.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-3xl border border-slate-200 bg-slate-100/80 p-6 text-sm text-slate-500">
                                <p class="font-semibold text-slate-700">Selected template</p>
                                <p class="mt-2">{{ ucfirst($cv->template ?? 'classic') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white/80 p-10 text-center text-slate-500">
                    <p class="text-lg font-semibold text-slate-700">No saved CV yet</p>
                    <p class="mt-2 text-sm">Start in the builder to see a live preview of your information.</p>
                    <a href="{{ route('cv.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-full border border-transparent bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow hover:-translate-y-0.5 hover:bg-black transition">
                        Begin building
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
