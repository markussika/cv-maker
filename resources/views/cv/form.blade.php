<x-app-layout>
    @php
        $stepItems = [
            ['title' => 'Contact', 'description' => 'How can employers reach you?'],
            ['title' => 'Experience', 'description' => 'Showcase your background'],
            ['title' => 'Highlights', 'description' => 'Skills, languages and extras'],
            ['title' => 'Template', 'description' => 'Pick the finishing look'],
        ];

        $templateMeta = [
            'classic' => ['title' => 'Classic', 'description' => 'Timeless balance of headings and content.', 'preview' => 'from-slate-200 via-white to-slate-100'],
            'modern' => ['title' => 'Modern', 'description' => 'Bold typography for confident profiles.', 'preview' => 'from-blue-200 via-blue-100 to-slate-50'],
            'creative' => ['title' => 'Creative', 'description' => 'Playful gradients for inventive roles.', 'preview' => 'from-pink-200 via-purple-200 to-sky-100'],
            'minimal' => ['title' => 'Minimal', 'description' => 'Whitespace-first layout with sharp lines.', 'preview' => 'from-white via-slate-50 to-slate-200'],
            'elegant' => ['title' => 'Elegant', 'description' => 'Serif elegance with gentle colour.', 'preview' => 'from-amber-100 via-rose-50 to-white'],
            'corporate' => ['title' => 'Corporate', 'description' => 'Structured sections that mean business.', 'preview' => 'from-slate-300 via-slate-200 to-white'],
            'gradient' => ['title' => 'Gradient', 'description' => 'Vibrant blends for tech-forward roles.', 'preview' => 'from-emerald-200 via-teal-200 to-cyan-100'],
            'darkmode' => ['title' => 'Dark Mode', 'description' => 'High contrast for late-night readers.', 'preview' => 'from-slate-900 via-slate-800 to-black'],
            'futuristic' => ['title' => 'Futuristic', 'description' => 'Neon inspired layout for innovators.', 'preview' => 'from-indigo-300 via-purple-300 to-slate-100'],
        ];

        $initialTemplate = $initialTemplate ?? ($templates[0] ?? 'classic');
        $inputClasses = 'mt-1 block w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200/60 focus:outline-none transition';

        $educationValues = old('education');
        if (! is_array($educationValues)) {
            $educationValues = is_array($cv?->education) ? (is_array($cv->education[0] ?? null) ? $cv->education[0] : $cv->education) : [];
        }
        if (! is_array($educationValues)) {
            $educationValues = [];
        }

        $experienceValues = old('experience');
        if (! is_array($experienceValues)) {
            $experienceValues = is_array($cv?->work_experience) ? (is_array($cv->work_experience[0] ?? null) ? $cv->work_experience[0] : $cv->work_experience) : [];
        }
        if (! is_array($experienceValues)) {
            $experienceValues = [];
        }

        $skillsValues = collect(old('skills', $cv?->skills ?? []))->filter()->values()->all();
        $languageValues = collect(old('languages', $cv?->languages ?? []))->filter()->values()->all();
        $hobbyValues = collect(old('hobbies', $cv?->hobbies ?? []))->filter()->values()->all();
        $activityValues = collect(old('activities', $cv?->extra_curriculum_activities ?? []))->filter()->values()->all();

        $selectedCountry = old('country', $cv?->country);
        $selectedCity = old('city', $cv?->city);
        $cityMap = config('location.city_map', []);
        $fallbackCities = $selectedCountry
            ? ($cityMap[$selectedCountry] ?? collect($cityMap)->first(fn ($list, $name) => strcasecmp($name, $selectedCountry) === 0, []))
            : [];

        $hasErrors = $errors->any();
    @endphp

    <div class="bg-gradient-to-br from-slate-100 via-slate-50 to-white py-10 sm:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="space-y-3">
                    <p class="inline-flex items-center gap-2 rounded-full bg-slate-900 text-white px-4 py-1 text-xs tracking-[0.3em] uppercase">CV Studio</p>
                    <h1 class="text-4xl sm:text-5xl font-semibold text-slate-900">Design your next opportunity</h1>
                    <p class="text-slate-500 text-base sm:text-lg max-w-2xl">Answer a few focused questions, enrich your CV with highlights, and finish with a template inspired by Apple&rsquo;s calm precision.</p>
                </div>
                <div class="rounded-3xl bg-white/80 shadow-inner border border-white p-6 text-sm text-slate-500 sm:max-w-xs">
                    <p class="font-semibold text-slate-700">Pro tip</p>
                    <p class="mt-2 leading-relaxed">You can tap any step above to revisit it instantly. Your answers stay in place until you save.</p>
                </div>
            </div>

            <div class="bg-white/90 backdrop-blur border border-white shadow-xl shadow-slate-200/70 rounded-[32px] p-6 sm:p-10 lg:p-12">
                <div class="relative mb-10">
                    <div class="hidden md:block absolute inset-x-10 top-7 h-px bg-slate-200" aria-hidden="true"></div>
                    <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                        @foreach ($stepItems as $index => $step)
                            <button type="button" data-step-trigger="{{ $loop->iteration }}" class="group relative flex items-center gap-3 text-left">
                                <span data-step-circle class="relative flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-semibold text-slate-500 shadow-sm transition-all duration-300"></span>
                                <span class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-800">{{ $step['title'] }}</span>
                                    <span class="text-xs text-slate-400 leading-snug">{{ $step['description'] }}</span>
                                </span>
                            </button>
                        @endforeach
                    </div>
                    <div class="mt-8">
                        <div class="flex items-center justify-between text-xs font-medium text-slate-400">
                            <span data-step-progress-label>Step 1 of {{ count($stepItems) }}</span>
                            <span data-step-progress-title class="uppercase tracking-[0.3em]"></span>
                        </div>
                        <div class="mt-2 h-1.5 rounded-full bg-slate-200 overflow-hidden">
                            <div data-step-progress-bar class="h-full w-1/4 rounded-full bg-gradient-to-r from-slate-900 via-slate-700 to-black transition-all duration-300"></div>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div data-validation-alert class="mb-8 rounded-3xl border border-red-100 bg-red-50/80 p-4 text-sm text-red-600">
                        <p class="font-semibold text-red-700">Let&rsquo;s fix a few details</p>
                        <ul class="mt-2 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('cv.store') }}" id="cvForm" class="space-y-12">
                    @csrf
                    <input type="hidden" name="cv_id" value="{{ $cv->id ?? '' }}">

                    <div data-step-panel="1" class="grid gap-8">
                        <div class="space-y-3">
                            <h2 class="text-2xl font-semibold text-slate-900">Contact details</h2>
                            <p class="text-sm text-slate-500">Share the essentials that headline your CV.</p>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-600" for="first_name">First name</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $cv?->first_name) }}" class="{{ $inputClasses }}" autocomplete="given-name" required>
                                @error('first_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600" for="last_name">Last name</label>
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $cv?->last_name) }}" class="{{ $inputClasses }}" autocomplete="family-name" required>
                                @error('last_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600" for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $cv?->email) }}" class="{{ $inputClasses }}" autocomplete="email">
                                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600" for="phone">Phone</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $cv?->phone) }}" class="{{ $inputClasses }}" autocomplete="tel">
                                @error('phone')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600" for="birthday">Birthday</label>
                                <input type="date" id="birthday" name="birthday" value="{{ old('birthday', optional($cv?->birth_date)->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}" class="{{ $inputClasses }}">
                                @error('birthday')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600" for="address">Address</label>
                                <input type="text" id="address" name="address" value="{{ old('address', $cv?->address) }}" class="{{ $inputClasses }}" placeholder="Street, building, flat">
                                @error('address')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600" for="country">Country</label>
                                <select id="country" name="country" class="{{ $inputClasses }} appearance-none pr-10">
                                    <option value="">Select country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}" @selected($selectedCountry === $country)>{{ $country }}</option>
                                    @endforeach
                                </select>
                                @error('country')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600" for="city">City</label>
                                <select id="city" name="city" class="{{ $inputClasses }} appearance-none pr-10" data-selected-city="{{ $selectedCity }}">
                                    <option value="">Select city</option>
                                    @foreach ($fallbackCities as $city)
                                        <option value="{{ $city }}" @selected($selectedCity === $city)>{{ $city }}</option>
                                    @endforeach
                                </select>
                                @error('city')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-600" for="linkedin">LinkedIn</label>
                                <input type="url" id="linkedin" name="linkedin" value="{{ old('linkedin', $cv?->linkedin) }}" class="{{ $inputClasses }}" placeholder="https://linkedin.com/in/&hellip;">
                                @error('linkedin')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid gap-6 sm:grid-cols-2 sm:col-span-1">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="github">GitHub</label>
                                    <input type="url" id="github" name="github" value="{{ old('github', $cv?->github) }}" class="{{ $inputClasses }}" placeholder="https://github.com/&hellip;">
                                    @error('github')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="website">Website</label>
                                    <input type="url" id="website" name="website" value="{{ old('website', $cv?->website) }}" class="{{ $inputClasses }}" placeholder="https://portfolio.com">
                                    @error('website')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600" for="summary">Profile summary</label>
                            <textarea id="summary" name="summary" rows="4" class="{{ $inputClasses }}" placeholder="Summarise what drives you and the value you bring.">{{ old('summary', $cv?->summary) }}</textarea>
                            @error('summary')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    @php $experienceCurrently = (bool) old('experience.currently', $experienceValues['currently'] ?? false); @endphp

                    <div data-step-panel="2" class="grid gap-8 hidden">
                        <div class="space-y-3">
                            <h2 class="text-2xl font-semibold text-slate-900">Experience &amp; education</h2>
                            <p class="text-sm text-slate-500">Capture one great highlight for each section. You can expand later.</p>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-white/80 p-6 space-y-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800">Most recent role</h3>
                                    <p class="text-xs text-slate-400 mt-1">We&rsquo;ll place this at the top of your experience list.</p>
                                </div>
                            </div>

                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="position">Position</label>
                                    <input type="text" id="position" name="experience[position]" value="{{ old('experience.position', $experienceValues['position'] ?? '') }}" class="{{ $inputClasses }}" placeholder="Product Designer">
                                    @error('experience.position')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="company">Company</label>
                                    <input type="text" id="company" name="experience[company]" value="{{ old('experience.company', $experienceValues['company'] ?? '') }}" class="{{ $inputClasses }}" placeholder="Apple">
                                    @error('experience.company')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="experience_country">Country</label>
                                    <input type="text" id="experience_country" name="experience[country]" value="{{ old('experience.country', $experienceValues['country'] ?? '') }}" class="{{ $inputClasses }}" placeholder="Latvia">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="experience_city">City</label>
                                    <input type="text" id="experience_city" name="experience[city]" value="{{ old('experience.city', $experienceValues['city'] ?? '') }}" class="{{ $inputClasses }}" placeholder="Rīga">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="experience_from">Start date</label>
                                    <input type="month" id="experience_from" name="experience[from]" value="{{ old('experience.from', $experienceValues['from'] ?? '') }}" class="{{ $inputClasses }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="experience_to">End date</label>
                                    <input type="month" id="experience_to" name="experience[to]" value="{{ old('experience.to', $experienceValues['to'] ?? '') }}" class="{{ $inputClasses }}" @disabled($experienceCurrently)>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="experience_currently" name="experience[currently]" value="1" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" @checked($experienceCurrently)>
                                <label for="experience_currently" class="text-sm text-slate-600">I currently work here</label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600" for="experience_achievements">Key achievements</label>
                                <textarea id="experience_achievements" name="experience[achievements]" rows="4" class="{{ $inputClasses }}" placeholder="Lead the redesign that improved conversion by 18%.">{{ old('experience.achievements', $experienceValues['achievements'] ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-white/80 p-6 space-y-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800">Education</h3>
                                    <p class="text-xs text-slate-400 mt-1">Share the most relevant programme or qualification.</p>
                                </div>
                            </div>

                            <div class="grid gap-6 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-600" for="education_institution">Institution</label>
                                    <input type="text" id="education_institution" name="education[institution]" value="{{ old('education.institution', $educationValues['institution'] ?? ($educationValues['school'] ?? '')) }}" class="{{ $inputClasses }}" placeholder="Riga Technical University">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="education_degree">Degree</label>
                                    <input type="text" id="education_degree" name="education[degree]" value="{{ old('education.degree', $educationValues['degree'] ?? '') }}" class="{{ $inputClasses }}" placeholder="BSc">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="education_field">Field of study</label>
                                    <input type="text" id="education_field" name="education[field]" value="{{ old('education.field', $educationValues['field'] ?? '') }}" class="{{ $inputClasses }}" placeholder="Information Technology">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="education_start_year">Start year</label>
                                    <input type="text" id="education_start_year" name="education[start_year]" value="{{ old('education.start_year', $educationValues['start_year'] ?? '') }}" class="{{ $inputClasses }}" placeholder="2019">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600" for="education_end_year">Graduation year</label>
                                    <input type="text" id="education_end_year" name="education[end_year]" value="{{ old('education.end_year', $educationValues['end_year'] ?? '') }}" class="{{ $inputClasses }}" placeholder="2023">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div data-step-panel="3" class="grid gap-8 hidden">
                        <div class="space-y-3">
                            <h2 class="text-2xl font-semibold text-slate-900">Highlights</h2>
                            <p class="text-sm text-slate-500">Build quick bullet sections with short phrases.</p>
                        </div>

                        <div class="grid gap-8 lg:grid-cols-2">
                            <div data-collection="skills" data-collection-values='@json($skillsValues)'>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-800">Skills</h3>
                                        <p class="text-xs text-slate-400">One skill per line keeps the layout tidy.</p>
                                    </div>
                                    <button type="button" data-collection-add class="rounded-full border border-slate-200 px-3 py-1 text-xs font-medium text-slate-600 hover:border-slate-300">+ Add</button>
                                </div>
                                <div class="mt-4 space-y-3" data-collection-items></div>
                                <template data-collection-template>
                                    <div data-collection-item class="group flex items-center gap-3">
                                        <input type="text" class="{{ $inputClasses }} flex-1" placeholder="Team leadership">
                                        <button type="button" data-collection-remove class="h-10 w-10 flex items-center justify-center rounded-full border border-slate-200 text-slate-400 hover:text-slate-600">&times;</button>
                                    </div>
                                </template>
                                @if ($errors->has('skills.*'))
                                    <p class="mt-2 text-xs text-red-500">{{ $errors->first('skills.*') }}</p>
                                @endif
                            </div>

                            <div data-collection="languages" data-collection-values='@json($languageValues)'>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-800">Languages</h3>
                                        <p class="text-xs text-slate-400">Example: English &mdash; Native.</p>
                                    </div>
                                    <button type="button" data-collection-add class="rounded-full border border-slate-200 px-3 py-1 text-xs font-medium text-slate-600 hover:border-slate-300">+ Add</button>
                                </div>
                                <div class="mt-4 space-y-3" data-collection-items></div>
                                <template data-collection-template>
                                    <div data-collection-item class="group flex items-center gap-3">
                                        <input type="text" class="{{ $inputClasses }} flex-1" placeholder="Latvian &mdash; Native">
                                        <button type="button" data-collection-remove class="h-10 w-10 flex items-center justify-center rounded-full border border-slate-200 text-slate-400 hover:text-slate-600">&times;</button>
                                    </div>
                                </template>
                                @if ($errors->has('languages.*'))
                                    <p class="mt-2 text-xs text-red-500">{{ $errors->first('languages.*') }}</p>
                                @endif
                            </div>

                            <div data-collection="hobbies" data-collection-values='@json($hobbyValues)'>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-800">Hobbies</h3>
                                        <p class="text-xs text-slate-400">Optional but human.</p>
                                    </div>
                                    <button type="button" data-collection-add class="rounded-full border border-slate-200 px-3 py-1 text-xs font-medium text-slate-600 hover:border-slate-300">+ Add</button>
                                </div>
                                <div class="mt-4 space-y-3" data-collection-items></div>
                                <template data-collection-template>
                                    <div data-collection-item class="group flex items-center gap-3">
                                        <input type="text" class="{{ $inputClasses }} flex-1" placeholder="Cycling">
                                        <button type="button" data-collection-remove class="h-10 w-10 flex items-center justify-center rounded-full border border-slate-200 text-slate-400 hover:text-slate-600">&times;</button>
                                    </div>
                                </template>
                                @if ($errors->has('hobbies.*'))
                                    <p class="mt-2 text-xs text-red-500">{{ $errors->first('hobbies.*') }}</p>
                                @endif
                            </div>

                            <div data-collection="activities" data-collection-values='@json($activityValues)'>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-800">Activities</h3>
                                        <p class="text-xs text-slate-400">Volunteer work, awards or side projects.</p>
                                    </div>
                                    <button type="button" data-collection-add class="rounded-full border border-slate-200 px-3 py-1 text-xs font-medium text-slate-600 hover:border-slate-300">+ Add</button>
                                </div>
                                <div class="mt-4 space-y-3" data-collection-items></div>
                                <template data-collection-template>
                                    <div data-collection-item class="group flex items-center gap-3">
                                        <input type="text" class="{{ $inputClasses }} flex-1" placeholder="TEDx Riga &mdash; Speaker">
                                        <button type="button" data-collection-remove class="h-10 w-10 flex items-center justify-center rounded-full border border-slate-200 text-slate-400 hover:text-slate-600">&times;</button>
                                    </div>
                                </template>
                                @if ($errors->has('activities.*'))
                                    <p class="mt-2 text-xs text-red-500">{{ $errors->first('activities.*') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div data-step-panel="4" class="space-y-8 hidden">
                        <div class="space-y-3">
                            <h2 class="text-2xl font-semibold text-slate-900">Choose your template</h2>
                            <p class="text-sm text-slate-500">Each card shows the personality of the template. Pick one and continue to preview.</p>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($templates as $template)
                                @php
                                    $meta = $templateMeta[$template] ?? ['title' => ucfirst($template), 'description' => 'Beautiful layout ready for your story.', 'preview' => 'from-slate-200 via-white to-slate-100'];
                                    $inputId = 'template-' . $template;
                                @endphp
                                <label for="{{ $inputId }}" data-template-card class="group cursor-pointer">
                                    <input type="radio" id="{{ $inputId }}" name="template" value="{{ $template }}" class="peer sr-only" @checked(old('template', $initialTemplate) === $template)>
                                    <div class="relative flex h-full flex-col gap-4 rounded-3xl border border-slate-200 bg-white/80 p-6 shadow-sm transition-all duration-300 group-hover:border-slate-300 peer-checked:border-slate-900 peer-checked:shadow-2xl">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-lg font-semibold text-slate-900">{{ $meta['title'] }}</h3>
                                                <p class="text-sm text-slate-500 mt-1">{{ $meta['description'] }}</p>
                                            </div>
                                            <div class="relative h-20 w-24 overflow-hidden rounded-2xl bg-gradient-to-br {{ $meta['preview'] }} shadow-inner">
                                                <span class="absolute top-3 left-4 right-4 h-2 rounded-full bg-white/80"></span>
                                                <span class="absolute top-6 left-4 right-12 h-2 rounded-full bg-white/70"></span>
                                                <span class="absolute top-9 left-4 right-8 h-2 rounded-full bg-white/50"></span>
                                                <span class="absolute bottom-4 left-4 right-6 h-8 rounded-xl border border-white/40 bg-white/30"></span>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs text-slate-400">
                                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                                Instant preview
                                            </span>
                                            <span class="tracking-[0.3em] uppercase">{{ strtoupper($template) }}</span>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('template')<p class="text-sm text-red-500">{{ $message }}</p>@enderror

                        <div class="rounded-3xl border border-slate-200 bg-slate-50/80 p-6 text-sm text-slate-500">
                            <p class="font-semibold text-slate-700">What happens after saving?</p>
                            <ul class="mt-3 space-y-2 list-disc list-inside">
                                <li>We store your answers securely in your account.</li>
                                <li>You will see an instant preview and can download a PDF.</li>
                                <li>Come back anytime to create new versions &mdash; a history section is on the way.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 pt-6 border-t border-slate-200 sm:flex-row sm:items-center sm:justify-between">
                        <button type="button" id="prevStep" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-600 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg hidden">
                            <span aria-hidden="true">&larr;</span>
                            <span>Previous step</span>
                        </button>

                        <div class="flex flex-1 justify-end gap-3">
                            <button type="button" id="nextStep" class="inline-flex items-center gap-2 rounded-full border border-transparent bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-black">
                                <span>Next step</span>
                                <span aria-hidden="true">&rarr;</span>
                            </button>
                            <button type="submit" id="submitStep" class="hidden inline-flex items-center gap-2 rounded-full border border-transparent bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-700">
                                <span>Save &amp; preview</span>
                                <span aria-hidden="true">&rarr;</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stepButtons = Array.from(document.querySelectorAll('[data-step-trigger]'));
            const stepPanels = Array.from(document.querySelectorAll('[data-step-panel]'));
            const nextButton = document.getElementById('nextStep');
            const prevButton = document.getElementById('prevStep');
            const submitButton = document.getElementById('submitStep');
            const progressBar = document.querySelector('[data-step-progress-bar]');
            const progressLabel = document.querySelector('[data-step-progress-label]');
            const progressTitle = document.querySelector('[data-step-progress-title]');
            const totalSteps = stepPanels.length;
            const hasErrors = document.querySelector('[data-validation-alert]');
            let currentStep = 1;
            let maxStepVisited = hasErrors ? totalSteps : 1;

            function updateStepVisuals() {
                stepButtons.forEach((button) => {
                    const step = Number(button.dataset.stepTrigger);
                    const circle = button.querySelector('[data-step-circle]');
                    const isActive = step === currentStep;
                    const isVisited = step <= maxStepVisited;

                    button.classList.toggle('text-slate-900', isActive);
                    button.classList.toggle('text-slate-400', !isActive);
                    button.classList.toggle('cursor-pointer', isVisited);
                    button.classList.toggle('cursor-not-allowed', !isVisited);
                    button.disabled = !isVisited;

                    if (circle) {
                        circle.textContent = step;
                        circle.className = 'relative flex h-12 w-12 items-center justify-center rounded-full border text-base font-semibold shadow-sm transition-all duration-300';
                        if (step < currentStep) {
                            circle.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-blue-200');
                        } else if (isActive) {
                            circle.classList.add('bg-slate-900', 'text-white', 'border-slate-900', 'ring-4', 'ring-blue-100/60');
                        } else {
                            circle.classList.add('bg-white', 'text-slate-400', 'border-slate-200');
                        }
                    }
                });

                stepPanels.forEach((panel) => {
                    const step = Number(panel.dataset.stepPanel);
                    panel.classList.toggle('hidden', step !== currentStep);
                });

                prevButton.classList.toggle('hidden', currentStep === 1);
                nextButton.classList.toggle('hidden', currentStep === totalSteps);
                submitButton.classList.toggle('hidden', currentStep !== totalSteps);

                const progress = currentStep / totalSteps;
                if (progressBar) {
                    progressBar.style.width = `${Math.max(progress * 100, 10)}%`;
                }
                if (progressLabel) {
                    progressLabel.textContent = `Step ${currentStep} of ${totalSteps}`;
                }
                if (progressTitle) {
                    const activeButton = stepButtons.find((button) => Number(button.dataset.stepTrigger) === currentStep);
                    const title = activeButton?.querySelector('.text-sm.font-semibold')?.textContent ?? '';
                    progressTitle.textContent = title.toUpperCase();
                }
            }

            stepButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const targetStep = Number(button.dataset.stepTrigger);
                    if (targetStep <= maxStepVisited) {
                        currentStep = targetStep;
                        updateStepVisuals();
                    }
                });
            });

            nextButton?.addEventListener('click', () => {
                if (currentStep < totalSteps) {
                    currentStep += 1;
                    maxStepVisited = Math.max(maxStepVisited, currentStep);
                    updateStepVisuals();
                }
            });

            prevButton?.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep -= 1;
                    updateStepVisuals();
                }
            });

            updateStepVisuals();

            const countrySelect = document.getElementById('country');
            const citySelect = document.getElementById('city');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            async function fetchCities(country, selectedCity = '') {
                if (!country || !citySelect) {
                    return;
                }

                citySelect.innerHTML = '<option value="">Loading...</option>';

                try {
                    const response = await fetch("{{ route('cv.cities') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken ?? '',
                        },
                        body: JSON.stringify({ country }),
                    });

                    if (!response.ok) {
                        throw new Error('Failed to fetch cities');
                    }

                    const cities = await response.json();
                    citySelect.innerHTML = '<option value="">Select city</option>';
                    (cities || []).forEach((city) => {
                        const option = document.createElement('option');
                        option.value = city;
                        option.textContent = city;
                        if (selectedCity && selectedCity === city) {
                            option.selected = true;
                        }
                        citySelect.appendChild(option);
                    });
                } catch (error) {
                    citySelect.innerHTML = '<option value="">Unable to load cities</option>';
                }
            }

            if (countrySelect) {
                countrySelect.addEventListener('change', () => {
                    const selected = countrySelect.value;
                    if (citySelect) {
                        citySelect.dataset.selectedCity = '';
                    }
                    if (selected) {
                        fetchCities(selected);
                    } else if (citySelect) {
                        citySelect.innerHTML = '<option value="">Select city</option>';
                    }
                });

                const presetCountry = countrySelect.value;
                const presetCity = citySelect?.dataset.selectedCity ?? '';
                const hasPresetOption = presetCity && Array.from(citySelect?.options ?? []).some((option) => option.value === presetCity);
                if (presetCountry && (!hasPresetOption || (citySelect && citySelect.options.length <= 1))) {
                    fetchCities(presetCountry, presetCity);
                }
            }

            if (citySelect) {
                citySelect.addEventListener('change', () => {
                    citySelect.dataset.selectedCity = citySelect.value || '';
                });
            }

            const currentlyCheckbox = document.getElementById('experience_currently');
            const experienceToInput = document.getElementById('experience_to');
            const toggleEndDate = () => {
                if (!currentlyCheckbox || !experienceToInput) {
                    return;
                }
                const isChecked = currentlyCheckbox.checked;
                experienceToInput.disabled = isChecked;
                experienceToInput.classList.toggle('opacity-60', isChecked);
                if (isChecked) {
                    experienceToInput.value = '';
                }
            };
            currentlyCheckbox?.addEventListener('change', toggleEndDate);
            toggleEndDate();

            function setupCollection(name) {
                const wrapper = document.querySelector(`[data-collection="${name}"]`);
                if (!wrapper) {
                    return;
                }

                const values = (() => {
                    try {
                        return JSON.parse(wrapper.dataset.collectionValues || '[]');
                    } catch (error) {
                        return [];
                    }
                })();

                const list = wrapper.querySelector('[data-collection-items]');
                const template = wrapper.querySelector('[data-collection-template]');
                const addButton = wrapper.querySelector('[data-collection-add]');

                if (!list || !template) {
                    return;
                }

                const addItem = (value = '') => {
                    const fragment = template.content.cloneNode(true);
                    const input = fragment.querySelector('input');
                    if (input) {
                        input.name = `${name}[]`;
                        input.value = value;
                    }
                    list.appendChild(fragment);
                };

                addButton?.addEventListener('click', () => addItem());

                list.addEventListener('click', (event) => {
                    if (event.target.matches('[data-collection-remove]')) {
                        event.target.closest('[data-collection-item]')?.remove();
                    }
                });

                if (values.length) {
                    values.forEach((value) => addItem(value));
                } else {
                    addItem('');
                }
            }

            ['skills', 'languages', 'hobbies', 'activities'].forEach(setupCollection);
        });
    </script>
</x-app-layout>
