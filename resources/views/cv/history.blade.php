<x-app-layout>
    @php
        $entries = collect($entries ?? []);
        $totalCount = $entries->count();
        $subtitle = $totalCount > 0
            ? trans_choice('Keep track of :count saved CV|Keep track of :count saved CVs', $totalCount, ['count' => $totalCount])
            : __('Start by crafting a CV and every version you save will appear here.');
        $templateOptions = collect($templates ?? []);
    @endphp

    <div class="space-y-10">
        <div class="rounded-3xl border border-slate-200 bg-white/90 p-8 shadow-sm">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">{{ __('CV history') }}</p>
                    <h1 class="mt-3 text-3xl font-semibold text-slate-900">{{ __('Saved CV library') }}</h1>
                    <p class="mt-2 text-sm text-slate-500">{{ $subtitle }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('cv.create') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-700">
                        {{ __('Create new CV') }}
                    </a>
                    <a href="{{ route('cv.templates') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-600 transition hover:-translate-y-0.5 hover:border-blue-500 hover:text-blue-600">
                        {{ __('Browse templates') }}
                    </a>
                </div>
            </div>
        </div>

        @if (session('status'))
            <x-alert type="success" :title="false">
                {{ session('status') }}
            </x-alert>
        @endif

        @if ($entries->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white/70 p-10 text-center shadow-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 text-blue-500">
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="h-8 w-8"><path fill="currentColor" d="M6 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6Zm0 2h12a1 1 0 0 1 1 1v8.17l-3.41-3.41a2 2 0 0 0-2.83 0L10 14.17l-1.76-1.76a2 2 0 0 0-2.83 0L5 12.83V6a1 1 0 0 1 1-1Zm9 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/></svg>
                </div>
                <h2 class="mt-6 text-2xl font-semibold text-slate-900">{{ __('No CVs saved yet') }}</h2>
                <p class="mt-3 text-sm text-slate-500">{{ __('Once you save a CV it will appear here with quick edit and delete actions.') }}</p>
                <a href="{{ route('cv.create') }}" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow transition hover:-translate-y-0.5 hover:bg-black">
                    {{ __('Start building') }}
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($entries as $entry)
                    @php
                        /** @var \App\Models\Cv $cv */
                        $cv = $entry['cv'];
                        $templateName = \Illuminate\Support\Str::of($entry['template'] ?? 'classic')->headline();
                        $updatedHuman = optional($entry['updated_at'])->diffForHumans() ?? __('just now');
                        $createdDate = optional($entry['created_at'])->toFormattedDateString();
                        $educationLabel = trans_choice(':count education entry|:count education entries', $entry['education_count'], ['count' => $entry['education_count']]);
                        $experienceLabel = trans_choice(':count experience entry|:count experience entries', $entry['experience_count'], ['count' => $entry['experience_count']]);
                        $hobbyLabel = trans_choice(':count hobby|:count hobbies', $entry['hobby_count'], ['count' => $entry['hobby_count']]);
                        $skillLabel = trans_choice(':count skill|:count skills', $entry['skill_count'], ['count' => $entry['skill_count']]);
                        $languageLabel = trans_choice(':count language|:count languages', $entry['language_count'], ['count' => $entry['language_count']]);
                        $templateSelectValue = old('cv_id') == (string) $cv->id
                            ? old('template', $entry['template'])
                            : ($entry['template'] ?? 'classic');
                        if (!in_array($templateSelectValue, $templateOptions->all(), true)) {
                            $templateSelectValue = $entry['template'] ?? 'classic';
                        }
                    @endphp

                    <div class="rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">{{ __('Template') }} · {{ $templateName }}</p>
                                <h3 class="mt-2 text-xl font-semibold text-slate-900">{{ $entry['title'] }}</h3>
                                @if (!empty($entry['email']))
                                    <p class="text-sm text-slate-500">{{ $entry['email'] }}</p>
                                @endif
                                @if ($createdDate)
                                    <p class="mt-2 text-xs text-slate-400">{{ __('Created :date', ['date' => $createdDate]) }}</p>
                                @endif
                            </div>
                            <div class="rounded-full bg-slate-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">
                                {{ __('Updated :time', ['time' => $updatedHuman]) }}
                            </div>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-3 text-xs text-slate-600">
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                                <span class="inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                                {{ $educationLabel }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                                <span class="inline-flex h-2 w-2 rounded-full bg-purple-500"></span>
                                {{ $experienceLabel }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                                <span class="inline-flex h-2 w-2 rounded-full bg-rose-500"></span>
                                {{ $hobbyLabel }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                                <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                {{ $skillLabel }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                                <span class="inline-flex h-2 w-2 rounded-full bg-amber-500"></span>
                                {{ $languageLabel }}
                            </span>
                        </div>

                        <div class="mt-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('cv.edit', $cv) }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow transition hover:-translate-y-0.5 hover:bg-blue-700">
                                    {{ __('Edit CV') }}
                                </a>
                                <button
                                    type="button"
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-cv-deletion-{{ $cv->id }}')"
                                    class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:-translate-y-0.5 hover:border-red-400 hover:text-red-600"
                                >
                                    {{ __('Delete') }}
                                </button>
                            </div>

                            <form method="POST" action="{{ route('cv.update-template', $cv) }}" class="flex flex-wrap items-center gap-3">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="cv_id" value="{{ $cv->id }}">
                                <input type="hidden" name="cv" value="{{ $cv->id }}">
                                <label for="template-{{ $cv->id }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                                    {{ __('Template') }}
                                </label>
                                <select id="template-{{ $cv->id }}" name="template" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                    @foreach ($templateOptions as $option)
                                        <option value="{{ $option }}" @selected($templateSelectValue === $option)>{{ \Illuminate\Support\Str::of($option)->headline() }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow transition hover:-translate-y-0.5 hover:bg-black">
                                    {{ __('Apply template') }}
                                </button>
                                <button type="submit" formmethod="GET" formaction="{{ route('cv.download') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:bg-slate-50">
                                    {{ __('Download PDF') }}
                                </button>
                                @if ($errors->has('template') && old('cv_id') == (string) $cv->id)
                                    <p class="basis-full text-sm text-red-600">{{ $errors->first('template') }}</p>
                                @endif
                            </form>
                        </div>
                    </div>
                    <x-modal name="confirm-cv-deletion-{{ $cv->id }}" focusable>
                        <form method="POST" action="{{ route('cv.destroy', $cv) }}" class="space-y-6 p-6">
                            @csrf
                            @method('DELETE')

                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-rose-500">
                                    <svg viewBox="0 0 24 24" aria-hidden="true" class="h-6 w-6">
                                        <path fill="currentColor" d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm0 15.25a1.25 1.25 0 1 1 1.25-1.25A1.251 1.251 0 0 1 12 17.25Zm1.75-6.75a1.75 1.75 0 0 1-3.5 0V7.75a1.75 1.75 0 0 1 3.5 0Z" />
                                    </svg>
                                </span>
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900">
                                        {{ __('Delete CV') }}
                                    </h2>
                                    <p class="mt-2 text-sm text-slate-600">
                                        {{ __('Are you sure you want to delete ":title"? This action cannot be undone.', ['title' => $entry['title']]) }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-wrap justify-end gap-3">
                                <button
                                    type="button"
                                    x-on:click="$dispatch('close')"
                                    class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:-translate-y-0.5 hover:border-slate-300 hover:text-slate-700"
                                >
                                    {{ __('Cancel') }}
                                </button>
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white shadow transition hover:-translate-y-0.5 hover:bg-rose-700">
                                    {{ __('Delete CV') }}
                                </button>
                            </div>
                        </form>
                    </x-modal>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
