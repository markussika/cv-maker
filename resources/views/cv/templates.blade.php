<x-app-layout>
    @php
        $templateMeta = [
            'classic' => [
                'title' => 'Classic',
                'description' => 'A timeless layout for any industry.',
                'preview' => 'from-slate-200 via-white to-slate-100',
                'partial' => 'templates.previews.classic',
            ],
            'modern' => [
                'title' => 'Modern',
                'description' => 'Bold typography with confident accents.',
                'preview' => 'from-blue-200 via-blue-100 to-slate-50',
                'partial' => 'templates.previews.modern',
            ],
            'creative' => [
                'title' => 'Creative',
                'description' => 'Playful composition for imaginative roles.',
                'preview' => 'from-pink-200 via-purple-200 to-sky-100',
                'partial' => 'templates.previews.creative',
            ],
            'minimal' => [
                'title' => 'Minimal',
                'description' => 'Crisp, airy layout that lets content breathe.',
                'preview' => 'from-white via-slate-50 to-slate-100',
                'partial' => 'templates.previews.minimal',
            ],
            'elegant' => [
                'title' => 'Elegant',
                'description' => 'Serif details and refined dividers.',
                'preview' => 'from-amber-100 via-rose-50 to-white',
                'partial' => 'templates.previews.elegant',
            ],
            'corporate' => [
                'title' => 'Corporate',
                'description' => 'Structured sections for senior roles.',
                'preview' => 'from-slate-300 via-slate-200 to-white',
                'partial' => 'templates.previews.corporate',
            ],
            'gradient' => [
                'title' => 'Gradient',
                'description' => 'Colourful blend that feels dynamic.',
                'preview' => 'from-emerald-200 via-teal-200 to-cyan-100',
                'partial' => 'templates.previews.gradient',
            ],
            'darkmode' => [
                'title' => 'Dark Mode',
                'description' => 'High-contrast styling that stands out.',
                'preview' => 'from-slate-900 via-slate-800 to-black',
                'partial' => 'templates.previews.darkmode',
            ],
            'futuristic' => [
                'title' => 'Futuristic',
                'description' => 'Tech inspired shapes and glow.',
                'preview' => 'from-indigo-300 via-purple-300 to-slate-100',
                'partial' => 'templates.previews.futuristic',
            ],
        ];

        $sampleCv = [
            'first_name' => 'Jordan',
            'last_name' => 'Rivera',
            'headline' => 'Product Designer',
            'email' => 'jordan.rivera@example.com',
            'phone' => '+1 (555) 123-4567',
            'city' => 'Toronto',
            'country' => 'Canada',
            'summary' => 'Designer blending research, motion, and storytelling to craft delightful digital experiences.',
            'work_experience' => [
                [
                    'position' => 'Senior Product Designer',
                    'company' => 'Northwind Studio',
                    'city' => 'Toronto',
                    'country' => 'Canada',
                    'from' => '2021-02',
                    'currently' => true,
                    'achievements' => 'Led cross-functional sprints and launched a design system that lifted activation by 28%.',
                ],
                [
                    'position' => 'Product Designer',
                    'company' => 'Aurora Labs',
                    'city' => 'Vancouver',
                    'country' => 'Canada',
                    'from' => '2018-05',
                    'to' => '2021-01',
                    'achievements' => 'Prototyped immersive flows that increased retention across mobile and web surfaces.',
                ],
            ],
            'education' => [
                [
                    'degree' => 'B.A. Interaction Design',
                    'institution' => 'University of British Columbia',
                    'city' => 'Vancouver',
                    'country' => 'Canada',
                    'start_year' => '2014',
                    'end_year' => '2018',
                    'field' => 'Design & Technology',
                ],
            ],
            'skills' => ['Design Systems', 'User Research', 'Prototyping', 'Motion'],
            'languages' => [
                ['name' => 'English', 'level' => 'native'],
                ['name' => 'French', 'level' => 'advanced'],
            ],
            'hobbies' => ['Gallery hopping', 'Cycling', 'Synth music'],
        ];
    @endphp

    <div class="space-y-10">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-black p-10 text-white shadow-2xl">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-semibold tracking-tight">Choose your CV template</h1>
                <p class="mt-4 text-lg text-slate-300">Browse our curated selection of templates. Each style is ready to showcase your story beautifully, and you can switch designs at any time during editing.</p>
                
            </div>
            <div class="pointer-events-none absolute -right-16 -bottom-16 h-64 w-64 rounded-full bg-blue-500/40 blur-3xl"></div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($templates as $template)
                @php
                    $meta = $templateMeta[$template] ?? [
                        'title' => ucfirst($template),
                        'description' => 'Beautiful layout ready for your details.',
                        'preview' => 'from-slate-200 via-white to-slate-100',
                        'partial' => 'templates.previews.classic',
                    ];
                    $previewId = 'template-preview-' . $template;
                    $previewSource = view('templates.' . $template, [
                        'cv' => (object) array_merge($sampleCv, ['template' => $template]),
                    ])->render();
                @endphp
                <div class="group createit-template-card">
                    <div class="createit-template-card__preview bg-gradient-to-br {{ $meta['preview'] }}">
                        @isset($meta['partial'])
                            @include($meta['partial'])
                        @endisset
                        <div class="createit-template-card__badge">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            {{ __('Preview ready') }}
                        </div>
                    </div>
                    <div class="createit-template-card__body">
                        <div>
                            <h2 class="createit-template-card__title">{{ $meta['title'] }}</h2>
                            <p class="createit-template-card__description">{{ $meta['description'] }}</p>
                        </div>
                        <div class="createit-template-card__actions">
                            <a href="{{ route('cv.create', ['template' => $template]) }}" class="createit-template-card__action">
                                {{ __('Use template') }}
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                            <a href="{{ route('cv.preview', ['template' => $template]) }}" class="createit-template-card__preview-button" data-preview-trigger="{{ $previewId }}">
                                {{ __('Preview') }}
                            </a>
                        </div>
                    </div>
                </div>

                <dialog id="{{ $previewId }}" class="createit-modal" aria-label="{{ $meta['title'] }} template preview">
                    <div class="createit-modal__header">
                        <h3 class="createit-modal__title">{{ $meta['title'] }} {{ __('template preview') }}</h3>
                        <button type="button" class="createit-modal__close" data-preview-close>{{ __('Close') }}</button>
                    </div>
                    <div class="createit-modal__body">
                        <div class="createit-modal__iframe-wrapper">
                            <iframe class="createit-modal__iframe" srcdoc="{{ e($previewSource) }}" title="{{ $meta['title'] }} template preview"></iframe>
                        </div>
                    </div>
                </dialog>
            @endforeach
        </div>
    </div>
</x-app-layout>

@push('scripts')
    @vite('resources/js/templates.js')
@endpush
