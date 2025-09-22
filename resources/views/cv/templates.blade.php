<x-app-layout>
    @php
        $templateMeta = [
            'classic' => [
                'title' => 'Classic',
                'description' => 'A timeless layout for any industry.',
                'preview' => 'from-slate-200 via-white to-slate-100',
            ],
            'modern' => [
                'title' => 'Modern',
                'description' => 'Bold typography with confident accents.',
                'preview' => 'from-blue-200 via-blue-100 to-slate-50',
            ],
            'creative' => [
                'title' => 'Creative',
                'description' => 'Playful composition for imaginative roles.',
                'preview' => 'from-pink-200 via-purple-200 to-sky-100',
            ],
            'minimal' => [
                'title' => 'Minimal',
                'description' => 'Crisp, airy layout that lets content breathe.',
                'preview' => 'from-white via-slate-50 to-slate-100',
            ],
            'elegant' => [
                'title' => 'Elegant',
                'description' => 'Serif details and refined dividers.',
                'preview' => 'from-amber-100 via-rose-50 to-white',
            ],
            'corporate' => [
                'title' => 'Corporate',
                'description' => 'Structured sections for senior roles.',
                'preview' => 'from-slate-300 via-slate-200 to-white',
            ],
            'gradient' => [
                'title' => 'Gradient',
                'description' => 'Colourful blend that feels dynamic.',
                'preview' => 'from-emerald-200 via-teal-200 to-cyan-100',
            ],
            'darkmode' => [
                'title' => 'Dark Mode',
                'description' => 'High-contrast styling that stands out.',
                'preview' => 'from-slate-900 via-slate-800 to-black',
            ],
            'futuristic' => [
                'title' => 'Futuristic',
                'description' => 'Tech inspired shapes and glow.',
                'preview' => 'from-indigo-300 via-purple-300 to-slate-100',
            ],
        ];
    @endphp

    <div class="space-y-10">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-black p-10 text-white shadow-2xl">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-semibold tracking-tight">Choose your CV template</h1>
                <p class="mt-4 text-lg text-slate-300">Browse our curated selection of templates. Each style is ready to showcase your story beautifully, and you can switch designs at any time during editing.</p>
                <div class="mt-6 inline-flex items-center gap-3 rounded-full bg-white/10 px-5 py-2 text-sm text-slate-200 backdrop-blur">
                    <span class="inline-flex h-3 w-3 rounded-full bg-emerald-400"></span>
                    Templates render instantly when you open the CV builder.
                </div>
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
                    ];
                @endphp
                <div class="group relative flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-2xl">
                    <div class="relative h-48 bg-gradient-to-br {{ $meta['preview'] }}">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-40 rounded-2xl bg-white/80 p-4 shadow-xl shadow-slate-300/50">
                                <div class="h-2 w-24 rounded-full bg-slate-200"></div>
                                <div class="mt-3 space-y-2">
                                    <div class="h-2 w-28 rounded-full bg-slate-300"></div>
                                    <div class="h-2 w-32 rounded-full bg-slate-200"></div>
                                    <div class="h-16 rounded-2xl border border-slate-100 bg-slate-50"></div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4 flex items-center gap-1 rounded-full bg-white/70 px-3 py-1 text-xs font-medium text-slate-600 shadow-sm">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            Preview ready
                        </div>
                    </div>
                    <div class="flex flex-1 flex-col gap-4 p-6">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ $meta['title'] }}</h2>
                            <p class="mt-2 text-sm text-slate-500">{{ $meta['description'] }}</p>
                        </div>
                        <div class="mt-auto flex flex-wrap items-center justify-between gap-3">
                            <a href="{{ route('cv.create', ['template' => $template]) }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition group-hover:bg-black">
                                Use template
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                            <span class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ strtoupper($template) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
