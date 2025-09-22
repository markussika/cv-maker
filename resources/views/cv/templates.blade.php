<x-app-layout>
    @php
        $templateMeta = [
            'classic' => ['title' => 'Classic', 'description' => 'Timeless layout for every industry.', 'preview' => 'from-slate-200 via-white to-slate-100'],
            'modern' => ['title' => 'Modern', 'description' => 'Bold typography with clear sections.', 'preview' => 'from-blue-200 via-blue-100 to-slate-50'],
            'creative' => ['title' => 'Creative', 'description' => 'Vibrant gradients and playful accents.', 'preview' => 'from-pink-200 via-purple-200 to-sky-100'],
            'minimal' => ['title' => 'Minimal', 'description' => 'Lightweight design with maximum clarity.', 'preview' => 'from-white via-slate-50 to-slate-200'],
            'elegant' => ['title' => 'Elegant', 'description' => 'Serif details and delicate lines.', 'preview' => 'from-amber-100 via-rose-50 to-white'],
            'corporate' => ['title' => 'Corporate', 'description' => 'Structured blocks for formal roles.', 'preview' => 'from-slate-300 via-slate-200 to-white'],
            'gradient' => ['title' => 'Gradient', 'description' => 'Dynamic blend ideal for tech teams.', 'preview' => 'from-emerald-200 via-teal-200 to-cyan-100'],
            'darkmode' => ['title' => 'Dark Mode', 'description' => 'High contrast for late-night readers.', 'preview' => 'from-slate-900 via-slate-800 to-black'],
            'futuristic' => ['title' => 'Futuristic', 'description' => 'Neon glow with geometric rhythm.', 'preview' => 'from-indigo-300 via-purple-300 to-slate-100'],
        ];
    @endphp

    <div class="bg-slate-950 text-white py-12 sm:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="grid gap-6 lg:grid-cols-[1.6fr,1fr] lg:items-center">
                <div class="space-y-4">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs uppercase tracking-[0.4em]">Templates</span>
                    <h1 class="text-4xl sm:text-5xl font-semibold tracking-tight">Select a look that feels like you</h1>
                    <p class="text-slate-300 text-base sm:text-lg max-w-2xl">Each template is built to pair with the guided builder. Choose one now or inside the form &mdash; your choice is saved with your CV so you can revisit it later.</p>
                    <div class="flex flex-wrap gap-3 text-sm text-slate-200">
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2"><span class="h-2 w-2 rounded-full bg-emerald-400"></span> Instant preview</span>
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2"><span class="h-2 w-2 rounded-full bg-sky-400"></span> PDF ready</span>
                    </div>
                </div>
                <div class="rounded-3xl bg-white/10 p-6 space-y-4 shadow-2xl shadow-blue-500/10">
                    <p class="text-sm text-slate-200">Already saved a CV?</p>
                    <p class="text-lg font-semibold text-white">Your most recent draft opens with the same template.</p>
                    <a href="{{ route('cv.create') }}" class="inline-flex items-center gap-2 rounded-full bg-white text-slate-900 px-4 py-2 text-sm font-semibold hover:-translate-y-0.5 hover:shadow-lg transition">
                        Open builder
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 py-12 sm:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($templates as $template)
                            @php
                                $meta = $templateMeta[$template] ?? ['title' => ucfirst($template), 'description' => 'Beautiful layout ready for your details.', 'preview' => 'from-slate-200 via-white to-slate-100'];
                            @endphp
                            <div class="group relative flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-2xl">
                                <div class="relative h-44 bg-gradient-to-br {{ $meta['preview'] }}">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-40 rounded-2xl bg-white/85 p-4 shadow-xl shadow-slate-300/50">
                                            <div class="h-2 w-24 rounded-full bg-slate-200"></div>
                                            <div class="mt-3 space-y-2">
                                                <div class="h-2 w-28 rounded-full bg-slate-300"></div>
                                                <div class="h-2 w-32 rounded-full bg-slate-200"></div>
                                                <div class="h-16 rounded-2xl border border-slate-100 bg-slate-50"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="absolute top-4 right-4 flex items-center gap-1 rounded-full bg-white/80 px-3 py-1 text-xs font-medium text-slate-600 shadow-sm">
                                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                        Ready to use
                                    </div>
                                </div>
                                <div class="flex flex-1 flex-col gap-4 p-6">
                                    <div>
                                        <h2 class="text-xl font-semibold text-slate-900">{{ $meta['title'] }}</h2>
                                        <p class="mt-2 text-sm text-slate-500">{{ $meta['description'] }}</p>
                                    </div>
                                    <div class="mt-auto flex flex-wrap items-center justify-between gap-3">
                                        <a href="{{ route('cv.create', ['template' => $template]) }}" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition group-hover:bg-black">
                                            Use template
                                            <span aria-hidden="true">&rarr;</span>
                                        </a>
                                        <span class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ strtoupper($template) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-slate-900">Saved drafts</h3>
                        <p class="mt-2 text-sm text-slate-500">Recent CVs are kept for you, ready for the upcoming history section.</p>
                        <div class="mt-4 space-y-3">
                            @forelse($recentCvs as $item)
                                <div class="rounded-2xl border border-slate-200 px-4 py-3">
                                    <p class="text-sm font-semibold text-slate-800">{{ $item->full_name ?: 'Untitled CV' }}</p>
                                    <p class="text-xs text-slate-400 uppercase tracking-[0.3em] mt-1">{{ strtoupper($item->template ?? 'classic') }}</p>
                                    <p class="mt-1 text-xs text-slate-500">Updated {{ $item->updated_at->diffForHumans() }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400">Once you save a CV, it will appear here.</p>
                            @endforelse
                        </div>
                        <a href="{{ route('cv.preview') }}" class="mt-4 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:-translate-y-0.5 hover:shadow-lg transition">
                            View latest preview
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-slate-900">Why templates matter</h3>
                        <ul class="mt-3 space-y-2 text-sm text-slate-500 list-disc list-inside">
                            <li>They ensure consistent spacing and typography.</li>
                            <li>You can swap designs without re-entering details.</li>
                            <li>Each template works perfectly with PDF export.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
