<x-app-layout>
    @php
        $user = auth()->user();
        $cvCount = $user ? $user->cvs()->count() : 0;
        $recentCv = $user ? $user->cvs()->latest('updated_at')->first() : null;
        $templateCount = $user ? $user->cvs()->select('template')->distinct()->count() : 0;

        $lastUpdatedLabel = $recentCv && $recentCv->updated_at ? $recentCv->updated_at->diffForHumans() : null;
        $recentTemplate = $recentCv && $recentCv->template ? ucfirst($recentCv->template) : null;
        $recentTitle = null;

        if ($recentCv) {
            $recentTitle = collect([
                $recentCv->first_name ?? null,
                $recentCv->last_name ?? null,
            ])
                ->filter(fn ($value) => is_string($value) && trim($value) !== '')
                ->map(fn ($value) => trim($value))
                ->implode(' ');

            if ($recentTitle === '') {
                $recentTitle = __('Untitled CV');
            }
        }

        $userName = $user ? ($user->name ?: ($user->first_name ?? null)) : null;
        $userGreeting = $userName ? __('Welcome back, :name!', ['name' => $userName]) : __('Welcome back!');
    @endphp

    <div class="createit-dashboard">
        <section class="createit-dashboard__hero">
            <div class="relative z-10 max-w-3xl">
                
                <h1 class="createit-dashboard__title">{{ $userGreeting }}</h1>
                <p class="createit-dashboard__subtitle">
                    {{ __('Keep iterating on your resumes, explore bold templates, and export polished PDFs whenever you are ready.') }}
                </p>
                <div class="createit-dashboard__actions">
                    <a href="{{ route('cv.create') }}" class="createit-dashboard__action">
                        {{ __('Open builder') }}
                        <span aria-hidden="true">→</span>
                    </a>
                    <a href="{{ route('cv.templates') }}" class="createit-navbar__primary">
                        {{ __('Browse templates') }}
                    </a>
                    
                </div>
            </div>
        </section>

        <div class="createit-dashboard__grid">
            <div class="lg:col-span-7 space-y-6">
                <article class="createit-dashboard__card">
                    <div class="absolute -top-20 -right-10 h-40 w-40 rounded-full bg-blue-500/10 blur-3xl"></div>
                    <span class="createit-dashboard__card-badge">{{ __('Builder') }}</span>
                    <h2 class="createit-dashboard__card-title">{{ __('Craft a new CV') }}</h2>
                    <p class="createit-dashboard__card-text">
                        {{ __('Follow the guided steps, auto-fill locations, and experiment with live previews to shape your next standout CV.') }}
                    </p>
                    <a href="{{ route('cv.create') }}" class="createit-dashboard__card-link">
                        {{ __('Start building') }}
                        <span aria-hidden="true">→</span>
                    </a>
                </article>

                <article class="createit-dashboard__card">
                    <div class="absolute -bottom-24 -left-16 h-44 w-44 rounded-full bg-emerald-400/10 blur-3xl"></div>
                    <span class="createit-dashboard__card-badge">{{ __('Resources') }}</span>
                    <h2 class="createit-dashboard__card-title">{{ __('Learn and iterate') }}</h2>
                    <p class="createit-dashboard__card-text">
                        {{ __('Access writing prompts, structure ideas with our guide, and keep previous drafts within reach while you refine your story.') }}
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('cv.guide') }}" class="createit-template-card__preview-button">
                            {{ __('Open CV guide') }}
                        </a>
                        <a href="{{ route('cv.history') }}" class="createit-template-card__preview-button">
                            {{ __('View saved CVs') }}
                        </a>
                    </div>
                </article>
            </div>

            <aside class="lg:col-span-5 space-y-6">
                <section class="createit-dashboard__card">
                    <span class="createit-dashboard__card-badge">{{ __('Insights') }}</span>
                    <h2 class="createit-dashboard__card-title">{{ __('Your progress') }}</h2>
                    <p class="createit-dashboard__card-text">
                        {{ __('Track how many resumes you have crafted and the styles you gravitate toward.') }}
                    </p>
                    <div class="createit-dashboard__stats mt-6">
                        <div class="createit-dashboard__stat">
                            <p class="createit-dashboard__stat-label">{{ __('CVs created') }}</p>
                            <p class="createit-dashboard__stat-value">{{ $cvCount }}</p>
                            <p class="createit-dashboard__stat-meta">{{ __('All time') }}</p>
                        </div>
                        <div class="createit-dashboard__stat">
                            <p class="createit-dashboard__stat-label">{{ __('Templates tried') }}</p>
                            <p class="createit-dashboard__stat-value">{{ $templateCount }}</p>
                            <p class="createit-dashboard__stat-meta">{{ __('Different looks explored') }}</p>
                        </div>
                    </div>
                </section>

                <section class="createit-dashboard__card">
                    <span class="createit-dashboard__card-badge">{{ __('Latest draft') }}</span>
                    <h2 class="createit-dashboard__card-title">
                        {{ $recentTitle ?? __('No CV saved yet') }}
                    </h2>
                    @if ($recentTemplate || $lastUpdatedLabel)
                        <ul class="mt-4 space-y-2 text-sm text-slate-500">
                            @if ($recentTemplate)
                                <li>
                                    <span class="font-medium text-slate-700">{{ __('Template') }}:</span>
                                    {{ $recentTemplate }}
                                </li>
                            @endif
                            @if ($lastUpdatedLabel)
                                <li>
                                    <span class="font-medium text-slate-700">{{ __('Updated') }}:</span>
                                    {{ $lastUpdatedLabel }}
                                </li>
                            @endif
                        </ul>
                    @else
                        <p class="createit-dashboard__card-text">
                            {{ __('Save your first CV to see quick insights here.') }}
                        </p>
                    @endif

                    <a href="{{ route('cv.templates') }}" class="createit-dashboard__card-link">
                        {{ __('Explore templates') }}
                        <span aria-hidden="true">→</span>
                    </a>
                </section>
            </aside>
        </div>
    </div>
</x-app-layout>
