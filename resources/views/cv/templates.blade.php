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
                @endphp
                <div class="group createit-template-card">
                    <div class="createit-template-card__preview">
                        <iframe
                            src="{{ route('cv.template-preview', $template) }}#toolbar=0&navpanes=0&scrollbar=0&zoom=page-fit"
                            title="{{ __('Preview of the :template template', ['template' => $meta['title']]) }}"
                            class="createit-template-card__preview-frame"
                            loading="lazy"
                        >
                            {{ __('PDF preview of the :template template.', ['template' => $meta['title']]) }}
                        </iframe>
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
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

