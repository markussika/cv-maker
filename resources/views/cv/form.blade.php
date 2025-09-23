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
        $rawEducation = $prefill ? data_get($prefill, 'education') : null;
        if ($rawEducation) {
            $prefillEducation = $rawEducation;
            if (is_string($prefillEducation)) {
                $decodedEducation = json_decode($prefillEducation, true);
                $prefillEducation = is_array($decodedEducation) ? $decodedEducation : [];
            }
            if (is_array($prefillEducation) && isset($prefillEducation[0]) && is_array($prefillEducation[0])) {
                $prefillEducation = $prefillEducation[0];
            }
        }

        $prefillExperience = [];
        if ($prefill) {
            $rawExperience = data_get($prefill, 'work_experience', data_get($prefill, 'experience', []));
            if (is_string($rawExperience)) {
                $decodedExperience = json_decode($rawExperience, true);
                $rawExperience = is_array($decodedExperience) ? $decodedExperience : [];
            }
            if (is_array($rawExperience) && isset($rawExperience[0]) && is_array($rawExperience[0])) {
                $prefillExperience = $rawExperience[0];
            } elseif (is_array($rawExperience)) {
                $prefillExperience = $rawExperience;
            }
        }

        $prefillEducation = is_array($prefillEducation) ? $prefillEducation : [];
        $prefillExperience = is_array($prefillExperience) ? $prefillExperience : [];

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
                            <div class="grid gap-6 md:grid-cols-2 md:col-span-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600">Country</label>
                                    <select name="country" id="country" class="{{ $inputClasses }} appearance-none pr-10">
                                        <option value="">Select country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}" @selected($initialCountry === $country)>{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600">City</label>
                                    <select name="city" id="city" class="{{ $inputClasses }} appearance-none pr-10" data-selected-city="{{ $initialCity }}">
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
                            <p class="text-sm text-slate-500 mt-1">Highlight your academic background and achievements.</p>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-600">School / University</label>
                                <input type="text" name="education[institution]" value="{{ old('education.institution', $prefillEducation['institution'] ?? ($prefillEducation['school'] ?? '')) }}" class="{{ $inputClasses }}" placeholder="Stanford University">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Degree</label>
                                <input type="text" name="education[degree]" value="{{ old('education.degree', $prefillEducation['degree'] ?? '') }}" class="{{ $inputClasses }}" placeholder="MBA">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Field of study</label>
                                <input type="text" name="education[field]" value="{{ old('education.field', $prefillEducation['field'] ?? '') }}" class="{{ $inputClasses }}" placeholder="Business Administration">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Start year</label>
                                <input type="text" name="education[start_year]" value="{{ old('education.start_year', $prefillEducation['start_year'] ?? '') }}" class="{{ $inputClasses }}" placeholder="2017">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Graduation year</label>
                                <input type="text" name="education[end_year]" value="{{ old('education.end_year', $prefillEducation['end_year'] ?? '') }}" class="{{ $inputClasses }}" placeholder="2021">
                            </div>
                        </div>
                    </div>

                    <div data-step-panel="3" class="space-y-6 hidden">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900">Experience</h2>
                            <p class="text-sm text-slate-500 mt-1">Share your most relevant role so far.</p>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Role / Position</label>
                                <input type="text" name="experience[position]" value="{{ old('experience.position', $prefillExperience['position'] ?? '') }}" class="{{ $inputClasses }}" placeholder="Product Manager">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Company</label>
                                <input type="text" name="experience[company]" value="{{ old('experience.company', $prefillExperience['company'] ?? '') }}" class="{{ $inputClasses }}" placeholder="Apple">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Country</label>
                                <input type="text" name="experience[country]" value="{{ old('experience.country', $prefillExperience['country'] ?? '') }}" class="{{ $inputClasses }}" placeholder="Latvia">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">City</label>
                                <input type="text" name="experience[city]" value="{{ old('experience.city', $prefillExperience['city'] ?? '') }}" class="{{ $inputClasses }}" placeholder="Rīga">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Start date</label>
                                <input type="month" name="experience[from]" value="{{ old('experience.from', $prefillExperience['from'] ?? '') }}" class="{{ $inputClasses }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">End date</label>
                                <input type="month" id="experience-to" name="experience[to]" value="{{ old('experience.to', $prefillExperience['to'] ?? '') }}" class="{{ $inputClasses }}">
                            </div>
                            <div class="md:col-span-2 flex items-center gap-3">
                                <input type="checkbox" id="experience-currently" name="experience[currently]" value="1" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" @checked(old('experience.currently', $prefillExperience['currently'] ?? false))>
                                <label for="experience-currently" class="text-sm text-slate-600">I&rsquo;m currently working in this role</label>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-600">Key achievements</label>
                                <textarea name="experience[achievements]" rows="4" class="{{ $inputClasses }}" placeholder="Summarise measurable achievements">{{ old('experience.achievements', $prefillExperience['achievements'] ?? '') }}</textarea>
                            </div>
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

            // Country and city dynamic behaviour
            const countrySelect = document.getElementById('country');
            const citySelect = document.getElementById('city');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? null;
            const citiesEndpoint = @json(route('cv.cities'));
            const preselectedCountry = countrySelect ? countrySelect.value : null;
            const preselectedCity = citySelect ? citySelect.dataset.selectedCity || null : null;
            let rememberedCity = preselectedCity;

            async function fetchCities(country, selectedCity = rememberedCity) {
                if (!country || !citySelect) {
                    return;
                }

                citySelect.disabled = true;
                citySelect.innerHTML = '<option value="">Loading...</option>';

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
                        throw new Error(`Failed to fetch cities for ${country}`);
                    }

                    const cities = await response.json();
                    citySelect.innerHTML = '<option value="">Select city</option>';

                    if (!Array.isArray(cities) || cities.length === 0) {
                        citySelect.innerHTML = '<option value="">No cities found</option>';
                        return;
                    }

                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city;
                        option.textContent = city;
                        if (selectedCity && selectedCity === city) {
                            option.selected = true;
                        }
                        citySelect.appendChild(option);
                    });

                    if (selectedCity && citySelect.value !== selectedCity) {
                        const existingOption = Array.from(citySelect.options).find(option => option.value === selectedCity);
                        if (existingOption) {
                            existingOption.selected = true;
                        }
                    }

                    if (citySelect.value) {
                        citySelect.dataset.selectedCity = citySelect.value;
                        rememberedCity = citySelect.value;
                    }
                } catch (error) {
                    citySelect.innerHTML = '<option value="">Unable to load cities</option>';
                } finally {
                    citySelect.disabled = false;
                }
            }

            if (countrySelect) {
                countrySelect.addEventListener('change', () => {
                    if (!citySelect) {
                        return;
                    }
                    const selected = countrySelect.value;
                    rememberedCity = null;
                    citySelect.dataset.selectedCity = '';
                    if (selected) {
                        fetchCities(selected, null);
                    } else if (citySelect) {
                        citySelect.innerHTML = '<option value="">Select city</option>';
                    }
                });

                if (preselectedCountry) {
                    fetchCities(preselectedCountry, preselectedCity);
                }
            }

            if (citySelect) {
                citySelect.addEventListener('change', () => {
                    rememberedCity = citySelect.value || null;
                    citySelect.dataset.selectedCity = citySelect.value || '';
                });
            }

            const currentlyCheckbox = document.getElementById('experience-currently');
            const experienceToInput = document.getElementById('experience-to');
            if (currentlyCheckbox && experienceToInput) {
                const toggleEndDate = () => {
                    const isChecked = currentlyCheckbox.checked;
                    experienceToInput.disabled = isChecked;
                    experienceToInput.classList.toggle('opacity-60', isChecked);
                    if (isChecked) {
                        experienceToInput.value = '';
                    }
                };
                currentlyCheckbox.addEventListener('change', toggleEndDate);
                toggleEndDate();
            }
        });
    </script>
</x-app-layout>
