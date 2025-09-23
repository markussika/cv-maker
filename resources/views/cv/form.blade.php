<x-app-layout>
    @php
        $stepItems = [
            ['title' => 'Personal', 'description' => 'Tell us about yourself'],
            ['title' => 'Education', 'description' => 'Share your studies'],
            ['title' => 'Experience', 'description' => 'Add recent roles'],
            ['title' => 'Template', 'description' => 'Pick a visual style'],
        ];

        $templateMeta = [
            'classic' => [
                'title' => 'Classic',
                'description' => 'Timeless layout with balanced typography.',
                'preview' => 'from-slate-200 via-white to-slate-100',
            ],
            'modern' => [
                'title' => 'Modern',
                'description' => 'Bold headings and confident accents.',
                'preview' => 'from-blue-200 via-blue-100 to-slate-50',
            ],
            'creative' => [
                'title' => 'Creative',
                'description' => 'Playful design that stands out.',
                'preview' => 'from-pink-200 via-purple-200 to-sky-100',
            ],
            'minimal' => [
                'title' => 'Minimal',
                'description' => 'Clean, airy composition for focus.',
                'preview' => 'from-white via-slate-50 to-slate-100',
            ],
            'elegant' => [
                'title' => 'Elegant',
                'description' => 'Subtle serif style with delicate lines.',
                'preview' => 'from-amber-100 via-rose-50 to-white',
            ],
            'corporate' => [
                'title' => 'Corporate',
                'description' => 'Structured sections for formal roles.',
                'preview' => 'from-slate-300 via-slate-200 to-white',
            ],
            'gradient' => [
                'title' => 'Gradient',
                'description' => 'Vibrant gradients for modern teams.',
                'preview' => 'from-emerald-200 via-teal-200 to-cyan-100',
            ],
            'darkmode' => [
                'title' => 'Dark Mode',
                'description' => 'Sleek look with high contrast.',
                'preview' => 'from-slate-800 via-slate-900 to-black',
            ],
            'futuristic' => [
                'title' => 'Futuristic',
                'description' => 'Tech-forward blocks and glow.',
                'preview' => 'from-indigo-300 via-purple-300 to-slate-100',
            ],
        ];

        $prefill = $prefill ?? null;

        $prefillEducation = [];
        if ($prefill) {
            $rawEducation = data_get($prefill, 'education');
            if (is_string($rawEducation)) {
                $decodedEducation = json_decode($rawEducation, true);
                $rawEducation = is_array($decodedEducation) ? $decodedEducation : [];
            }
            if (is_array($rawEducation)) {
                $prefillEducation = array_is_list($rawEducation) ? $rawEducation : [$rawEducation];
            }
        }

        $prefillExperience = [];
        if ($prefill) {
            $rawExperience = data_get($prefill, 'work_experience', data_get($prefill, 'experience', []));
            if (is_string($rawExperience)) {
                $decodedExperience = json_decode($rawExperience, true);
                $rawExperience = is_array($decodedExperience) ? $decodedExperience : [];
            }
            if (is_array($rawExperience)) {
                $prefillExperience = array_is_list($rawExperience) ? $rawExperience : [$rawExperience];
            }
        }

        $educationEntries = old('education', $prefillEducation);
        if (!is_array($educationEntries)) {
            $educationEntries = [];
        }
        $educationEntries = array_values(array_filter($educationEntries, fn($entry) => is_array($entry)));
        if (empty($educationEntries)) {
            $educationEntries = [[]];
        }
        $educationNextIndex = count($educationEntries);

        $experienceEntries = old('experience', $prefillExperience);
        if (!is_array($experienceEntries)) {
            $experienceEntries = [];
        }
        $experienceEntries = array_values(array_filter($experienceEntries, fn($entry) => is_array($entry)));
        if (empty($experienceEntries)) {
            $experienceEntries = [[]];
        }
        $experienceNextIndex = count($experienceEntries);

        $prefillHobbies = [];
        if ($prefill) {
            $rawHobbies = data_get($prefill, 'hobbies', []);
            if (is_string($rawHobbies)) {
                $decodedHobbies = json_decode($rawHobbies, true);
                $rawHobbies = is_array($decodedHobbies) ? $decodedHobbies : [];
            }
            if (is_array($rawHobbies)) {
                $prefillHobbies = $rawHobbies;
            }
        }

        $hobbyEntries = old('hobbies', $prefillHobbies);
        if (!is_array($hobbyEntries)) {
            $hobbyEntries = [];
        }
        $hobbyEntries = array_values(array_filter(array_map(fn($value) => is_string($value) ? $value : null, $hobbyEntries)));
        if (empty($hobbyEntries)) {
            $hobbyEntries = [''];
        }
        $hobbyNextIndex = count($hobbyEntries);

        $prefillBirthdayValue = data_get($prefill, 'birthday');
        if ($prefillBirthdayValue instanceof \Carbon\CarbonInterface) {
            $prefilledBirthday = $prefillBirthdayValue->format('Y-m-d');
        } else {
            $prefilledBirthday = $prefillBirthdayValue ?: null;
        }

        $initialCountry = old('country', data_get($prefill, 'country') ?? request('country'));
        $initialCity = old('city', data_get($prefill, 'city') ?? '');

        $requestedTemplate = $initialTemplate ?? ($templates[0] ?? 'classic');
        if (!in_array($requestedTemplate, $templates, true)) {
            $requestedTemplate = $templates[0] ?? 'classic';
        }

        $selectedTemplate = old('template', $requestedTemplate);
        if (!in_array($selectedTemplate, $templates, true)) {
            $selectedTemplate = $templates[0] ?? 'classic';
        }

        $inputClasses = 'mt-1 block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200/60 focus:outline-none transition';
        $errorClasses = 'border-red-500 ring-1 ring-red-200 focus:border-red-500 focus:ring-red-200';
    @endphp

    <div class="min-h-screen -mx-4 -mt-8 bg-gradient-to-br from-slate-100 via-white to-slate-200 px-4 py-10 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="text-center text-slate-900 mb-12">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/70 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-slate-500 shadow-sm">
                    <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                    {{ __('Guided builder') }}
                </div>
                <h1 class="mt-5 text-4xl md:text-5xl font-semibold tracking-tight">Craft your CV</h1>
                <p class="mt-3 text-base md:text-lg text-slate-500">Follow the guided steps to build a polished resume with live templates and smart defaults.</p>
            </div>

            @if ($errors->any())
                <div class="mb-10 rounded-3xl border border-red-200 bg-red-50/90 p-6 text-sm text-red-700 shadow-sm">
                    <p class="font-semibold">{{ __('We couldn’t save yet. Please fix the highlighted fields.') }}</p>
                    <ul class="mt-3 space-y-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white/95 backdrop-blur-xl shadow-xl rounded-[32px] p-6 sm:p-10 md:p-12">
                <div class="mb-12">
                    <div class="flex flex-col gap-6 md:flex-row md:items-center md:gap-4">
                        @foreach ($stepItems as $index => $step)
                            <div class="flex items-center gap-4 md:flex-1">
                                <button type="button" data-step-trigger="{{ $loop->iteration }}" class="flex flex-col md:flex-row md:items-center text-slate-500 gap-2 transition" aria-label="Step {{ $loop->iteration }}: {{ $step['title'] }}">
                                    <span data-step-circle class="flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-semibold shadow-sm transition-all duration-300">{{ $loop->iteration }}</span>
                                    <span class="flex flex-col text-left md:text-left">
                                        <span class="text-sm font-semibold">{{ $step['title'] }}</span>
                                        <span class="text-xs text-slate-400">{{ $step['description'] }}</span>
                                    </span>
                                </button>
                                @if (!$loop->last)
                                    <div data-step-connector="{{ $loop->iteration }}" class="hidden md:block flex-1 h-0.5 bg-slate-200 rounded-full transition-colors duration-300"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <form method="POST" action="{{ route('cv.store') }}" id="cvForm" class="space-y-10">
                    @csrf

                    <div data-step-panel="1" class="space-y-6">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900">Personal information</h2>
                            <p class="text-sm text-slate-500 mt-1">Let&rsquo;s start with the essentials so employers can reach you.</p>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-600">First name</label>
                                <input type="text" name="first_name" value="{{ old('first_name', data_get($prefill, 'first_name', '')) }}" class="{{ $inputClasses }} @error('first_name') {{ $errorClasses }} @enderror" autocomplete="given-name" placeholder="Tim" required>
                                @error('first_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Last name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', data_get($prefill, 'last_name', '')) }}" class="{{ $inputClasses }} @error('last_name') {{ $errorClasses }} @enderror" autocomplete="family-name" placeholder="Cook" required>
                                @error('last_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Email</label>
                                <input type="email" name="email" value="{{ old('email', data_get($prefill, 'email', '')) }}" class="{{ $inputClasses }} @error('email') {{ $errorClasses }} @enderror" autocomplete="email" placeholder="you@example.com" required>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Phone</label>
                                <input type="tel" name="phone" value="{{ old('phone', data_get($prefill, 'phone', '')) }}" class="{{ $inputClasses }}" autocomplete="tel" placeholder="(+371) 20000000">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Birthday</label>
                                <input type="date" name="birthday" max="{{ date('Y-m-d') }}" value="{{ old('birthday', $prefilledBirthday ?? '') }}" class="{{ $inputClasses }}">
                            </div>
                            <div class="grid gap-6 md:grid-cols-2 md:col-span-2" data-location-group>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600">Country</label>
                                    <select name="country" id="personal-country" class="{{ $inputClasses }} appearance-none pr-10" data-country-select>
                                        <option value="">Select country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}" @selected($initialCountry === $country)>{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600">City</label>
                                    <select name="city" id="personal-city" class="{{ $inputClasses }} appearance-none pr-10" data-city-select data-selected-city="{{ $initialCity }}">
                                        <option value="">Select city</option>
                                        @if ($initialCity)
                                            <option value="{{ $initialCity }}" selected>{{ $initialCity }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div data-step-panel="2" class="space-y-6 hidden">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900">Education</h2>
                            <p class="text-sm text-slate-500 mt-1">Highlight each school, qualification, and location to build your academic timeline.</p>
                        </div>

                        <div class="space-y-6" data-collection="education" data-next-index="{{ $educationNextIndex }}" data-min-items="1">
                            @foreach ($educationEntries as $index => $education)
                                @php
                                    $institution = $education['institution'] ?? $education['school'] ?? '';
                                    $degree = $education['degree'] ?? '';
                                    $field = $education['field'] ?? '';
                                    $educationCountry = $education['country'] ?? '';
                                    $educationCity = $education['city'] ?? '';
                                    $startYear = $education['start_year'] ?? '';
                                    $endYear = $education['end_year'] ?? '';
                                @endphp
                                <div class="rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-sm space-y-6" data-collection-item data-collection-index="{{ $index }}">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-slate-900">Education {{ $loop->iteration }}</h3>
                                        <button type="button" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-red-600 transition {{ count($educationEntries) === 1 ? 'hidden' : '' }}" data-action="remove">
                                            <svg viewBox="0 0 20 20" aria-hidden="true" class="h-4 w-4"><path fill="currentColor" d="M11.41 10l3.3-3.29a1 1 0 0 0-1.42-1.42L10 8.59l-3.29-3.3a1 1 0 0 0-1.42 1.42L8.59 10l-3.3 3.29a1 1 0 1 0 1.42 1.42L10 11.41l3.29 3.3a1 1 0 0 0 1.42-1.42Z"/></svg>
                                            <span>{{ __('Remove') }}</span>
                                        </button>
                                    </div>

                                    <div class="grid gap-6 md:grid-cols-2">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-slate-600">School / University</label>
                                            <input type="text" name="education[{{ $index }}][institution]" value="{{ $institution }}" class="{{ $inputClasses }} @error('education.' . $index . '.institution') {{ $errorClasses }} @enderror" placeholder="Stanford University">
                                            <x-input-error :messages="$errors->get('education.' . $index . '.institution')" class="mt-2" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600">Degree</label>
                                            <input type="text" name="education[{{ $index }}][degree]" value="{{ $degree }}" class="{{ $inputClasses }} @error('education.' . $index . '.degree') {{ $errorClasses }} @enderror" placeholder="MBA">
                                            <x-input-error :messages="$errors->get('education.' . $index . '.degree')" class="mt-2" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600">Field of study</label>
                                            <input type="text" name="education[{{ $index }}][field]" value="{{ $field }}" class="{{ $inputClasses }} @error('education.' . $index . '.field') {{ $errorClasses }} @enderror" placeholder="Business Administration">
                                            <x-input-error :messages="$errors->get('education.' . $index . '.field')" class="mt-2" />
                                        </div>
                                        <div class="md:col-span-2 grid gap-6 md:grid-cols-2" data-location-group>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-600">Country</label>
                                                <select name="education[{{ $index }}][country]" class="{{ $inputClasses }} appearance-none pr-10 @error('education.' . $index . '.country') {{ $errorClasses }} @enderror" data-country-select>
                                                    <option value="">Select country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country }}" @selected($educationCountry === $country)>{{ $country }}</option>
                                                    @endforeach
                                                </select>
                                                <x-input-error :messages="$errors->get('education.' . $index . '.country')" class="mt-2" />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-600">City</label>
                                                <select name="education[{{ $index }}][city]" class="{{ $inputClasses }} appearance-none pr-10 @error('education.' . $index . '.city') {{ $errorClasses }} @enderror" data-city-select data-selected-city="{{ $educationCity }}">
                                                    <option value="">Select city</option>
                                                    @if ($educationCity)
                                                        <option value="{{ $educationCity }}" selected>{{ $educationCity }}</option>
                                                    @endif
                                                </select>
                                                <x-input-error :messages="$errors->get('education.' . $index . '.city')" class="mt-2" />
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600">Start year</label>
                                            <input type="text" name="education[{{ $index }}][start_year]" value="{{ $startYear }}" class="{{ $inputClasses }} @error('education.' . $index . '.start_year') {{ $errorClasses }} @enderror" placeholder="2017">
                                            <x-input-error :messages="$errors->get('education.' . $index . '.start_year')" class="mt-2" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600">Graduation year</label>
                                            <input type="text" name="education[{{ $index }}][end_year]" value="{{ $endYear }}" class="{{ $inputClasses }} @error('education.' . $index . '.end_year') {{ $errorClasses }} @enderror" placeholder="2021">
                                            <x-input-error :messages="$errors->get('education.' . $index . '.end_year')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" data-add="education" class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-blue-500 hover:text-blue-600">
                            <span class="text-lg" aria-hidden="true">+</span>
                            {{ __('Add another education') }}
                        </button>
                    </div>

                    <div data-step-panel="3" class="space-y-6 hidden">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900">Experience</h2>
                            <p class="text-sm text-slate-500 mt-1">Share your recent roles, locations, and highlights. Add as many roles as you need.</p>
                        </div>

                        <div class="space-y-6" data-collection="experience" data-next-index="{{ $experienceNextIndex }}" data-min-items="1">
                            @foreach ($experienceEntries as $index => $experience)
                                @php
                                    $position = $experience['position'] ?? '';
                                    $company = $experience['company'] ?? '';
                                    $experienceCountry = $experience['country'] ?? '';
                                    $experienceCity = $experience['city'] ?? '';
                                    $from = $experience['from'] ?? '';
                                    $to = $experience['to'] ?? '';
                                    $currently = !empty($experience['currently']);
                                    $achievements = $experience['achievements'] ?? '';
                                    $currentlyId = 'experience-currently-' . $index;
                                @endphp
                                <div class="rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-sm space-y-6" data-collection-item data-collection-index="{{ $index }}">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-slate-900">Experience {{ $loop->iteration }}</h3>
                                        <button type="button" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-red-600 transition {{ count($experienceEntries) === 1 ? 'hidden' : '' }}" data-action="remove">
                                            <svg viewBox="0 0 20 20" aria-hidden="true" class="h-4 w-4"><path fill="currentColor" d="M11.41 10l3.3-3.29a1 1 0 0 0-1.42-1.42L10 8.59l-3.29-3.3a1 1 0 0 0-1.42 1.42L8.59 10l-3.3 3.29a1 1 0 1 0 1.42 1.42L10 11.41l3.29 3.3a1 1 0 0 0 1.42-1.42Z"/></svg>
                                            <span>{{ __('Remove') }}</span>
                                        </button>
                                    </div>

                                    <div class="grid gap-6 md:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600">Role / Position</label>
                                            <input type="text" name="experience[{{ $index }}][position]" value="{{ $position }}" class="{{ $inputClasses }} @error('experience.' . $index . '.position') {{ $errorClasses }} @enderror" placeholder="Product Manager">
                                            <x-input-error :messages="$errors->get('experience.' . $index . '.position')" class="mt-2" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600">Company</label>
                                            <input type="text" name="experience[{{ $index }}][company]" value="{{ $company }}" class="{{ $inputClasses }} @error('experience.' . $index . '.company') {{ $errorClasses }} @enderror" placeholder="Apple">
                                            <x-input-error :messages="$errors->get('experience.' . $index . '.company')" class="mt-2" />
                                        </div>
                                        <div class="md:col-span-2 grid gap-6 md:grid-cols-2" data-location-group>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-600">Country</label>
                                                <select name="experience[{{ $index }}][country]" class="{{ $inputClasses }} appearance-none pr-10 @error('experience.' . $index . '.country') {{ $errorClasses }} @enderror" data-country-select>
                                                    <option value="">Select country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country }}" @selected($experienceCountry === $country)>{{ $country }}</option>
                                                    @endforeach
                                                </select>
                                                <x-input-error :messages="$errors->get('experience.' . $index . '.country')" class="mt-2" />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-600">City</label>
                                                <select name="experience[{{ $index }}][city]" class="{{ $inputClasses }} appearance-none pr-10 @error('experience.' . $index . '.city') {{ $errorClasses }} @enderror" data-city-select data-selected-city="{{ $experienceCity }}">
                                                    <option value="">Select city</option>
                                                    @if ($experienceCity)
                                                        <option value="{{ $experienceCity }}" selected>{{ $experienceCity }}</option>
                                                    @endif
                                                </select>
                                                <x-input-error :messages="$errors->get('experience.' . $index . '.city')" class="mt-2" />
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600">Start date</label>
                                            <input type="month" name="experience[{{ $index }}][from]" value="{{ $from }}" class="{{ $inputClasses }} @error('experience.' . $index . '.from') {{ $errorClasses }} @enderror">
                                            <x-input-error :messages="$errors->get('experience.' . $index . '.from')" class="mt-2" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600">End date</label>
                                            <input type="month" name="experience[{{ $index }}][to]" value="{{ $to }}" class="{{ $inputClasses }} @error('experience.' . $index . '.to') {{ $errorClasses }} @enderror" data-end-input>
                                            <x-input-error :messages="$errors->get('experience.' . $index . '.to')" class="mt-2" />
                                        </div>
                                        <div class="md:col-span-2 flex items-center gap-3">
                                            <input type="checkbox" id="{{ $currentlyId }}" name="experience[{{ $index }}][currently]" value="1" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" data-currently-checkbox @checked($currently)>
                                            <label for="{{ $currentlyId }}" class="text-sm text-slate-600">I&rsquo;m currently working in this role</label>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-slate-600">Key achievements</label>
                                            <textarea name="experience[{{ $index }}][achievements]" rows="4" class="{{ $inputClasses }} @error('experience.' . $index . '.achievements') {{ $errorClasses }} @enderror" placeholder="Summarise measurable achievements">{{ $achievements }}</textarea>
                                            <x-input-error :messages="$errors->get('experience.' . $index . '.achievements')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" data-add="experience" class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-blue-500 hover:text-blue-600">
                            <span class="text-lg" aria-hidden="true">+</span>
                            {{ __('Add another role') }}
                        </button>

                        <div class="space-y-4 rounded-3xl border border-slate-200 bg-slate-50/80 p-6">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">{{ __('Hobbies & interests') }}</h3>
                                <p class="text-sm text-slate-500 mt-1">{{ __('Share a few personal passions that show personality or balance to your resume.') }}</p>
                            </div>

                            <div class="space-y-3" data-hobby-collection data-next-index="{{ $hobbyNextIndex }}">
                                @foreach ($hobbyEntries as $index => $hobby)
                                    <div class="flex items-center gap-3" data-hobby-item data-hobby-index="{{ $index }}">
                                        <div class="flex-1">
                                            <input type="text" name="hobbies[{{ $index }}]" value="{{ $hobby }}" class="{{ $inputClasses }} @error('hobbies.' . $index) {{ $errorClasses }} @enderror" placeholder="Photography, hiking, volunteering">
                                            <x-input-error :messages="$errors->get('hobbies.' . $index)" class="mt-2" />
                                        </div>
                                        <button type="button" class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-red-400 hover:text-red-600" data-action="remove-hobby">
                                            <svg viewBox="0 0 20 20" aria-hidden="true" class="h-3.5 w-3.5"><path fill="currentColor" d="M11.41 10l3.3-3.29a1 1 0 0 0-1.42-1.42L10 8.59l-3.29-3.3a1 1 0 0 0-1.42 1.42L8.59 10l-3.3 3.29a1 1 0 1 0 1.42 1.42L10 11.41l3.29 3.3a1 1 0 0 0 1.42-1.42Z"/></svg>
                                            <span>{{ __('Remove') }}</span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" data-add-hobby class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-blue-500 hover:text-blue-600">
                                <span class="text-lg" aria-hidden="true">+</span>
                                {{ __('Add hobby or interest') }}
                            </button>
                        </div>
                    </div>

                    <div data-step-panel="4" class="space-y-8 hidden">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900">Choose your template</h2>
                            <p class="text-sm text-slate-500 mt-1">Pick a design that matches your personality. You can always come back and change it.</p>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            @foreach ($templates as $template)
                                @php
                                    $meta = $templateMeta[$template] ?? [
                                        'title' => ucfirst($template),
                                        'description' => 'Beautiful layout ready for your story.',
                                        'preview' => 'from-slate-200 via-white to-slate-100',
                                    ];
                                    $inputId = 'template-' . $template;
                                @endphp
                                <label for="{{ $inputId }}" data-template-card class="group cursor-pointer">
                                    <input type="radio" id="{{ $inputId }}" name="template" value="{{ $template }}" class="peer sr-only" @checked($selectedTemplate === $template)>
                                    <div class="rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-sm transition-all duration-300 peer-checked:border-blue-500 peer-checked:shadow-xl peer-checked:shadow-blue-100">
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <h3 class="text-lg font-semibold text-slate-900">{{ $meta['title'] }}</h3>
                                                <p class="text-sm text-slate-500 mt-1">{{ $meta['description'] }}</p>
                                            </div>
                                            <div class="relative w-24 h-16 rounded-2xl overflow-hidden bg-gradient-to-br {{ $meta['preview'] }} shadow-inner">
                                                <span class="absolute top-3 left-4 right-4 h-2 rounded-full bg-white/80"></span>
                                                <span class="absolute top-6 left-4 right-10 h-2 rounded-full bg-white/60"></span>
                                                <span class="absolute top-9 left-4 right-8 h-2 rounded-full bg-white/40"></span>
                                                <span class="absolute bottom-4 left-4 right-6 h-8 rounded-xl border border-white/40 bg-white/30"></span>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        @error('template')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="rounded-3xl border border-slate-200 bg-white/60 p-6 text-sm text-slate-600">
                            <p class="font-semibold text-slate-800">What happens next?</p>
                            <ul class="mt-3 space-y-2 list-disc list-inside">
                                <li>Review your CV details on the next screen.</li>
                                <li>Download a polished PDF or return to adjust any step.</li>
                                <li>Click the circles above at any time to revisit an earlier step.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t border-slate-200">
                        <button type="button" id="prevStep" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-transparent bg-white px-5 py-3 text-sm font-medium text-slate-600 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg hidden">
                            <span>&larr;</span>
                            <span>Previous step</span>
                        </button>

                        <div class="flex flex-1 sm:flex-initial justify-end gap-3">
                            <button type="button" id="nextStep" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-transparent bg-slate-900 px-6 py-3 text-sm font-medium text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-black">
                                <span>Next step</span>
                                <span>&rarr;</span>
                            </button>
                            <button type="submit" id="submitStep" class="hidden inline-flex items-center justify-center gap-2 rounded-2xl border border-transparent bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-700">
                                <span>Save &amp; preview</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="education-template">
        <div class="rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-sm space-y-6" data-collection-item data-collection-index="__INDEX__">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Education</h3>
                <button type="button" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-red-600 transition" data-action="remove">
                    <svg viewBox="0 0 20 20" aria-hidden="true" class="h-4 w-4"><path fill="currentColor" d="M11.41 10l3.3-3.29a1 1 0 0 0-1.42-1.42L10 8.59l-3.29-3.3a1 1 0 0 0-1.42 1.42L8.59 10l-3.3 3.29a1 1 0 1 0 1.42 1.42L10 11.41l3.29 3.3a1 1 0 0 0 1.42-1.42Z"/></svg>
                    <span>{{ __('Remove') }}</span>
                </button>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-600">School / University</label>
                    <input type="text" name="education[__INDEX__][institution]" class="{{ $inputClasses }}" placeholder="Stanford University">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Degree</label>
                    <input type="text" name="education[__INDEX__][degree]" class="{{ $inputClasses }}" placeholder="MBA">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Field of study</label>
                    <input type="text" name="education[__INDEX__][field]" class="{{ $inputClasses }}" placeholder="Business Administration">
                </div>
                <div class="md:col-span-2 grid gap-6 md:grid-cols-2" data-location-group>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Country</label>
                        <select name="education[__INDEX__][country]" class="{{ $inputClasses }} appearance-none pr-10" data-country-select>
                            <option value="">Select country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">City</label>
                        <select name="education[__INDEX__][city]" class="{{ $inputClasses }} appearance-none pr-10" data-city-select data-selected-city="">
                            <option value="">Select city</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Start year</label>
                    <input type="text" name="education[__INDEX__][start_year]" class="{{ $inputClasses }}" placeholder="2017">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Graduation year</label>
                    <input type="text" name="education[__INDEX__][end_year]" class="{{ $inputClasses }}" placeholder="2021">
                </div>
            </div>
        </div>
    </template>

    <template id="experience-template">
        <div class="rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-sm space-y-6" data-collection-item data-collection-index="__INDEX__">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Experience</h3>
                <button type="button" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-red-600 transition" data-action="remove">
                    <svg viewBox="0 0 20 20" aria-hidden="true" class="h-4 w-4"><path fill="currentColor" d="M11.41 10l3.3-3.29a1 1 0 0 0-1.42-1.42L10 8.59l-3.29-3.3a1 1 0 0 0-1.42 1.42L8.59 10l-3.3 3.29a1 1 0 1 0 1.42 1.42L10 11.41l3.29 3.3a1 1 0 0 0 1.42-1.42Z"/></svg>
                    <span>{{ __('Remove') }}</span>
                </button>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-600">Role / Position</label>
                    <input type="text" name="experience[__INDEX__][position]" class="{{ $inputClasses }}" placeholder="Product Manager">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Company</label>
                    <input type="text" name="experience[__INDEX__][company]" class="{{ $inputClasses }}" placeholder="Apple">
                </div>
                <div class="md:col-span-2 grid gap-6 md:grid-cols-2" data-location-group>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Country</label>
                        <select name="experience[__INDEX__][country]" class="{{ $inputClasses }} appearance-none pr-10" data-country-select>
                            <option value="">Select country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600">City</label>
                        <select name="experience[__INDEX__][city]" class="{{ $inputClasses }} appearance-none pr-10" data-city-select data-selected-city="">
                            <option value="">Select city</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">Start date</label>
                    <input type="month" name="experience[__INDEX__][from]" class="{{ $inputClasses }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600">End date</label>
                    <input type="month" name="experience[__INDEX__][to]" class="{{ $inputClasses }}" data-end-input>
                </div>
                <div class="md:col-span-2 flex items-center gap-3">
                    <input type="checkbox" name="experience[__INDEX__][currently]" value="1" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" data-currently-checkbox>
                    <span class="text-sm text-slate-600">I&rsquo;m currently working in this role</span>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-600">Key achievements</label>
                    <textarea name="experience[__INDEX__][achievements]" rows="4" class="{{ $inputClasses }}" placeholder="Summarise measurable achievements"></textarea>
                </div>
            </div>
        </div>
    </template>

    <template id="hobby-template">
        <div class="flex items-center gap-3" data-hobby-item data-hobby-index="__INDEX__">
            <div class="flex-1">
                <input type="text" name="hobbies[__INDEX__]" class="{{ $inputClasses }}" placeholder="Photography, hiking, volunteering">
            </div>
            <button type="button" class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-red-400 hover:text-red-600" data-action="remove-hobby">
                <svg viewBox="0 0 20 20" aria-hidden="true" class="h-3.5 w-3.5"><path fill="currentColor" d="M11.41 10l3.3-3.29a1 1 0 0 0-1.42-1.42L10 8.59l-3.29-3.3a1 1 0 0 0-1.42 1.42L8.59 10l-3.3 3.29a1 1 0 1 0 1.42 1.42L10 11.41l3.29 3.3a1 1 0 0 0 1.42-1.42Z"/></svg>
                <span>{{ __('Remove') }}</span>
            </button>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stepButtons = Array.from(document.querySelectorAll('[data-step-trigger]'));
            const stepPanels = Array.from(document.querySelectorAll('[data-step-panel]'));
            const connectors = Array.from(document.querySelectorAll('[data-step-connector]'));
            const nextButton = document.getElementById('nextStep');
            const prevButton = document.getElementById('prevStep');
            const submitButton = document.getElementById('submitStep');
            const totalSteps = stepPanels.length;
            let currentStep = 1;
            let maxStepVisited = 1;

            function updateStepVisuals() {
                stepButtons.forEach(button => {
                    const step = Number(button.dataset.stepTrigger);
                    const circle = button.querySelector('[data-step-circle]');
                    button.classList.toggle('text-slate-900', step === currentStep);
                    button.classList.toggle('text-slate-400', step !== currentStep);
                    button.classList.toggle('cursor-pointer', step <= maxStepVisited);
                    button.classList.toggle('cursor-not-allowed', step > maxStepVisited);
                    button.disabled = step > maxStepVisited;

                    if (circle) {
                        circle.className = 'flex h-12 w-12 items-center justify-center rounded-full border text-base font-semibold shadow-sm transition-all duration-300';
                        if (step < currentStep) {
                            circle.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-blue-200');
                        } else if (step === currentStep) {
                            circle.classList.add('bg-black', 'text-white', 'border-black', 'ring', 'ring-blue-100');
                        } else {
                            circle.classList.add('bg-white', 'text-slate-400', 'border-slate-200');
                        }
                    }
                });

                connectors.forEach(connector => {
                    const index = Number(connector.dataset.stepConnector);
                    connector.classList.toggle('bg-blue-500', index < currentStep);
                    connector.classList.toggle('bg-slate-200', index >= currentStep);
                });

                stepPanels.forEach(panel => {
                    const step = Number(panel.dataset.stepPanel);
                    if (step === currentStep) {
                        panel.classList.remove('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }
                });

                prevButton.classList.toggle('hidden', currentStep === 1);
                nextButton.classList.toggle('hidden', currentStep === totalSteps);
                submitButton.classList.toggle('hidden', currentStep !== totalSteps);
            }

            stepButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetStep = Number(button.dataset.stepTrigger);
                    if (targetStep <= maxStepVisited) {
                        currentStep = targetStep;
                        updateStepVisuals();
                    }
                });
            });

            nextButton.addEventListener('click', () => {
                if (currentStep < totalSteps) {
                    currentStep += 1;
                    maxStepVisited = Math.max(maxStepVisited, currentStep);
                    updateStepVisuals();
                }
            });

            prevButton.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep -= 1;
                    updateStepVisuals();
                }
            });

            updateStepVisuals();

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? null;
            const citiesEndpoint = @json(route('cv.cities'));

            const fetchCitiesForCountry = async (country) => {
                if (!country) {
                    return [];
                }

                try {
                    const response = await fetch(citiesEndpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                        },
                        body: JSON.stringify({ country })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to fetch cities');
                    }

                    const payload = await response.json();
                    return Array.isArray(payload) ? payload : [];
                } catch (error) {
                    return [];
                }
            };

            const initLocationGroups = (root = document) => {
                const groups = root.matches?.('[data-location-group]') ? [root] : Array.from(root.querySelectorAll('[data-location-group]'));

                groups.forEach(group => {
                    if (!group || group.dataset.locationReady === 'true') {
                        return;
                    }

                    const countryField = group.querySelector('[data-country-select]');
                    const cityField = group.querySelector('[data-city-select]');
                    if (!countryField || !cityField) {
                        return;
                    }

                    group.dataset.locationReady = 'true';
                    let rememberedCity = cityField.dataset.selectedCity || '';

                    const populateCities = (cities, selectedCity) => {
                        cityField.innerHTML = '<option value="">Select city</option>';
                        if (!Array.isArray(cities) || cities.length === 0) {
                            return;
                        }

                        cities.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city;
                            option.textContent = city;
                            if (selectedCity && selectedCity === city) {
                                option.selected = true;
                            }
                            cityField.appendChild(option);
                        });

                        if (selectedCity && cityField.value !== selectedCity) {
                            const fallback = document.createElement('option');
                            fallback.value = selectedCity;
                            fallback.textContent = selectedCity;
                            fallback.selected = true;
                            cityField.appendChild(fallback);
                        }

                        cityField.dataset.selectedCity = cityField.value || '';
                    };

                    const loadCities = async (country, selectedCity = '') => {
                        if (!country) {
                            cityField.innerHTML = '<option value="">Select city</option>';
                            cityField.dataset.selectedCity = '';
                            cityField.disabled = false;
                            return;
                        }

                        cityField.disabled = true;
                        cityField.innerHTML = '<option value="">Loading...</option>';

                        const cities = await fetchCitiesForCountry(country);
                        cityField.disabled = false;

                        if (!cities.length) {
                            cityField.innerHTML = '<option value="">No cities found</option>';
                            return;
                        }

                        populateCities(cities, selectedCity);
                    };

                    countryField.addEventListener('change', () => {
                        rememberedCity = '';
                        loadCities(countryField.value, '');
                    });

                    cityField.addEventListener('change', () => {
                        rememberedCity = cityField.value || '';
                        cityField.dataset.selectedCity = rememberedCity;
                    });

                    if (countryField.value) {
                        loadCities(countryField.value, rememberedCity);
                    }
                });
            };

            const initExperienceItem = (scope) => {
                const checkbox = scope.querySelector('[data-currently-checkbox]');
                const endInput = scope.querySelector('[data-end-input]');
                if (!checkbox || !endInput || checkbox.dataset.ready === 'true') {
                    return;
                }

                const toggleEndDate = () => {
                    const active = checkbox.checked;
                    endInput.disabled = active;
                    endInput.classList.toggle('opacity-60', active);
                    if (active) {
                        endInput.value = '';
                    }
                };

                checkbox.addEventListener('change', toggleEndDate);
                checkbox.dataset.ready = 'true';
                toggleEndDate();
            };

            const setupCollection = (name, { onCreate } = {}) => {
                const container = document.querySelector(`[data-collection="${name}"]`);
                const template = document.getElementById(`${name}-template`);
                const addButton = document.querySelector(`[data-add="${name}"]`);
                if (!container || !template) {
                    return;
                }

                const initialItems = Array.from(container.querySelectorAll('[data-collection-item]'));
                const minItems = Number(container.dataset.minItems || 1);
                let nextIndex = Number(container.dataset.nextIndex ?? initialItems.length);
                if (Number.isNaN(nextIndex)) {
                    nextIndex = initialItems.length;
                }
                nextIndex = Math.max(nextIndex, initialItems.length);

                const updateRemoveButtons = () => {
                    const items = container.querySelectorAll('[data-collection-item]');
                    items.forEach(item => {
                        const removeButton = item.querySelector('[data-action="remove"]');
                        if (!removeButton) {
                            return;
                        }
                        if (items.length <= minItems) {
                            removeButton.classList.add('hidden');
                        } else {
                            removeButton.classList.remove('hidden');
                        }
                    });
                };

                const renderTemplate = (index) => {
                    const html = template.innerHTML.replace(/__INDEX__/g, index);
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = html.trim();
                    return wrapper.firstElementChild;
                };

                const registerItem = (item, index) => {
                    item.dataset.collectionIndex = index;
                    initLocationGroups(item);
                    if (typeof onCreate === 'function') {
                        onCreate(item, index);
                    }
                };

                initialItems.forEach((item, index) => {
                    registerItem(item, index);
                });

                addButton?.addEventListener('click', () => {
                    const item = renderTemplate(nextIndex);
                    container.appendChild(item);
                    registerItem(item, nextIndex);
                    nextIndex += 1;
                    container.dataset.nextIndex = String(nextIndex);
                    updateRemoveButtons();

                    const focusable = item.querySelector('input, select, textarea');
                    if (focusable) {
                        focusable.focus();
                    }
                });

                container.addEventListener('click', event => {
                    const removeButton = event.target.closest('[data-action="remove"]');
                    if (!removeButton) {
                        return;
                    }

                    const item = removeButton.closest('[data-collection-item]');
                    if (!item) {
                        return;
                    }

                    const items = container.querySelectorAll('[data-collection-item]');
                    if (items.length <= minItems) {
                        item.querySelectorAll('input, textarea, select').forEach(field => {
                            if (field.type === 'checkbox' || field.type === 'radio') {
                                field.checked = false;
                            } else {
                                field.value = '';
                            }
                        });

                        item.querySelectorAll('[data-city-select]').forEach(select => {
                            select.innerHTML = '<option value="">Select city</option>';
                            select.dataset.selectedCity = '';
                        });

                        return;
                    }

                    item.remove();
                    updateRemoveButtons();
                });

                updateRemoveButtons();
            };

            const setupHobbyCollection = () => {
                const container = document.querySelector('[data-hobby-collection]');
                const template = document.getElementById('hobby-template');
                const addButton = document.querySelector('[data-add-hobby]');
                if (!container || !template) {
                    return;
                }

                let nextIndex = Number(container.dataset.nextIndex ?? container.querySelectorAll('[data-hobby-item]').length);
                if (Number.isNaN(nextIndex)) {
                    nextIndex = container.querySelectorAll('[data-hobby-item]').length;
                }

                const updateButtons = () => {
                    const items = container.querySelectorAll('[data-hobby-item]');
                    items.forEach(item => {
                        const removeButton = item.querySelector('[data-action="remove-hobby"]');
                        if (!removeButton) {
                            return;
                        }
                        if (items.length <= 1) {
                            removeButton.classList.add('hidden');
                        } else {
                            removeButton.classList.remove('hidden');
                        }
                    });
                };

                const renderTemplate = (index) => {
                    const html = template.innerHTML.replace(/__INDEX__/g, index);
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = html.trim();
                    return wrapper.firstElementChild;
                };

                addButton?.addEventListener('click', () => {
                    const item = renderTemplate(nextIndex);
                    container.appendChild(item);
                    nextIndex += 1;
                    container.dataset.nextIndex = String(nextIndex);
                    updateButtons();
                    const input = item.querySelector('input');
                    if (input) {
                        input.focus();
                    }
                });

                container.addEventListener('click', event => {
                    const removeButton = event.target.closest('[data-action="remove-hobby"]');
                    if (!removeButton) {
                        return;
                    }

                    const item = removeButton.closest('[data-hobby-item]');
                    if (!item) {
                        return;
                    }

                    const items = container.querySelectorAll('[data-hobby-item]');
                    if (items.length <= 1) {
                        const input = item.querySelector('input');
                        if (input) {
                            input.value = '';
                            input.focus();
                        }
                        return;
                    }

                    item.remove();
                    updateButtons();
                });

                updateButtons();
            };

            initLocationGroups();
            setupCollection('education');
            setupCollection('experience', { onCreate: initExperienceItem });
            setupHobbyCollection();
        });
    </script>
</x-app-layout>
