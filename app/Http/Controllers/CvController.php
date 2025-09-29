<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PDF;

class CvController extends Controller
{
    public function create(Request $request)
    {
        session()->forget('cv_data');

        $countries = $this->fetchCountries();
        $templates = $this->templateOptions();

        $initialTemplate = $templates[0] ?? 'classic';

        $requestedTemplate = $request->string('template')->toString();
        if ($requestedTemplate && in_array($requestedTemplate, $templates, true)) {
            $initialTemplate = $requestedTemplate;
        }

        return view('cv.form', [
            'countries' => $countries,
            'templates' => $templates,
            'initialTemplate' => $initialTemplate,
            'prefill' => null,
            'isEditing' => false,
            'formAction' => route('cv.store'),
            'formMethod' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $templates = $this->templateOptions();

        $validated = $this->validateCv($request, $templates);

        $attributes = $this->buildCvAttributes($validated);
        $attributes['user_id'] = $request->user()->id;

        if ($request->hasFile('profile_image')) {
            $attributes['profile_image'] = $request->file('profile_image')->store('cv-photos', 'public');
        }

        $cv = Cv::create($attributes);

        $cvData = $this->formatCvForView($cv);

        session(['cv_data' => $cvData]);

        return redirect()->route('cv.preview')->with('status', __('Your CV details have been saved.'));
    }

    public function history(Request $request)
    {
        $entries = $request->user()
            ->cvs()
            ->latest()
            ->get()
            ->map(fn (Cv $cv) => $this->summariseCv($cv))
            ->values();

        return view('cv.history', [
            'entries' => $entries,
        ]);
    }

    public function edit(Request $request, Cv $cv)
    {
        $this->ensureCvOwner($request, $cv);

        $countries = $this->fetchCountries();
        $templates = $this->templateOptions();

        $initialTemplate = in_array($cv->template, $templates, true) ? $cv->template : ($templates[0] ?? 'classic');

        return view('cv.form', [
            'countries' => $countries,
            'templates' => $templates,
            'initialTemplate' => $initialTemplate,
            'prefill' => $cv,
            'isEditing' => true,
            'formAction' => route('cv.update', $cv),
            'formMethod' => 'PUT',
        ]);
    }

    public function update(Request $request, Cv $cv)
    {
        $this->ensureCvOwner($request, $cv);

        $templates = $this->templateOptions();
        $validated = $this->validateCv($request, $templates);

        $attributes = $this->buildCvAttributes($validated);

        if ($request->hasFile('profile_image')) {
            if ($cv->profile_image) {
                Storage::disk('public')->delete($cv->profile_image);
            }

            $attributes['profile_image'] = $request->file('profile_image')->store('cv-photos', 'public');
        }

        $cv->fill($attributes)->save();
        $cv->refresh();

        session(['cv_data' => $this->formatCvForView($cv)]);

        return redirect()->route('cv.preview')->with('status', __('Your CV has been updated.'));
    }

    public function destroy(Request $request, Cv $cv)
    {
        $this->ensureCvOwner($request, $cv);

        $cv->delete();

        $stored = session('cv_data');
        if (is_array($stored) && (int) ($stored['id'] ?? 0) === $cv->id) {
            session()->forget('cv_data');
        }

        return redirect()->route('cv.history')->with('status', __('The CV has been deleted.'));
    }

    public function preview(Request $request)
    {
        $templates = $this->templateOptions();
        $cvData = $this->resolveCvData($request);

        $requestedTemplate = $request->query('template');
        if (is_string($requestedTemplate) && in_array($requestedTemplate, $templates, true)) {
            $cvData['template'] = $requestedTemplate;
        }

        return view('cv.preview', compact('cvData', 'templates'));
    }

    public function pdf(Request $request)
    {
        $cvData = $this->resolveCvData($request);
        $template = $cvData['template'] ?? 'classic';

        return $this->renderPdf($cvData, $template, $this->filenameForCv($cvData));
    }

    public function getCities(Request $request)
    {
        $country = trim((string) $request->input('country', ''));

        if ($country === '') {
            return response()->json([]);
        }

        try {
            $response = Http::timeout(8)->post('https://countriesnow.space/api/v0.1/countries/cities', [
                'country' => $country,
            ]);
        } catch (\Throwable $e) {
            return response()->json([]);
        }

        if ($response->failed()) {
            return response()->json([]);
        }

        $cities = $response->json('data');

        if (!is_array($cities)) {
            $cities = [];
        }

        $cities = collect($cities)
            ->filter(fn ($city) => is_string($city) && $city !== '')
            ->unique()
            ->sort()
            ->values()
            ->all();

        return response()->json($cities);
    }

    public function getCompanies(Request $request)
    {
        $country = $request->input('country');
        $city = $request->input('city');

        $fallback = [
            'Tech Solutions Ltd',
            'Global IT Services',
            'Future Innovations',
            'Smart Systems Inc',
            'NextGen Software',
        ];

        if (!$country || !$city) {
            return response()->json($fallback);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.companies_api.key'),
            ])->timeout(8)->get('https://www.thecompaniesapi.com/api/enrich-company-from-domain', [
                'country' => $country,
                'city' => $city,
            ]);
        } catch (\Throwable $e) {
            return response()->json($fallback);
        }

        if ($response->failed()) {
            return response()->json($fallback);
        }

        $data = $response->json();

        $companies = collect($data['companies'] ?? [])
            ->map(fn ($company) => is_array($company) ? ($company['name'] ?? null) : null)
            ->filter()
            ->values()
            ->all();

        if (empty($companies)) {
            $companies = $fallback;
        }

        return response()->json($companies);
    }

    public function templates()
    {
        return view('cv.templates', ['templates' => $this->templateOptions()]);
    }

    public function download(Request $request, string $template)
    {
        $templates = $this->templateOptions();
        if (!in_array($template, $templates, true)) {
            $template = $templates[0] ?? 'classic';
        }

        $cvData = $this->resolveCvData($request);
        $cvData['template'] = $template;

        return $this->renderPdf($cvData, $template, $this->filenameForCv($cvData));
    }

    public function guide()
    {
        return view('cv.guide');
    }

    protected function validateCv(Request $request, array $templates): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'headline' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:3000'],
            'website' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'github' => ['nullable', 'url', 'max:255'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
            'birthday' => ['nullable', 'date'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'template' => ['required', 'string', Rule::in($templates)],
            'education' => ['nullable', 'array'],
            'education.*.institution' => ['nullable', 'string', 'max:255'],
            'education.*.degree' => ['nullable', 'string', 'max:255'],
            'education.*.field' => ['nullable', 'string', 'max:255'],
            'education.*.country' => ['nullable', 'string', 'max:255'],
            'education.*.city' => ['nullable', 'string', 'max:255'],
            'education.*.start_year' => ['nullable', 'string', 'max:25'],
            'education.*.end_year' => ['nullable', 'string', 'max:25'],
            'experience' => ['nullable', 'array'],
            'experience.*.position' => ['nullable', 'string', 'max:255'],
            'experience.*.company' => ['nullable', 'string', 'max:255'],
            'experience.*.country' => ['nullable', 'string', 'max:255'],
            'experience.*.city' => ['nullable', 'string', 'max:255'],
            'experience.*.from' => ['nullable', 'string', 'max:25'],
            'experience.*.to' => ['nullable', 'string', 'max:25'],
            'experience.*.currently' => ['nullable', 'boolean'],
            'experience.*.achievements' => ['nullable', 'string', 'max:2000'],
            'hobbies' => ['nullable', 'array'],
            'hobbies.*' => ['nullable', 'string', 'max:120'],
            'languages' => ['nullable', 'array'],
            'languages.*.name' => ['nullable', 'string', 'max:120'],
            'languages.*.level' => ['nullable', 'string', 'max:120'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['nullable', 'string', 'max:120'],
        ]);
    }

    protected function buildCvAttributes(array $validated): array
    {
        $education = $this->normaliseEducation($validated['education'] ?? []);
        $experience = $this->normaliseExperience($validated['experience'] ?? []);
        $hobbies = $this->normaliseHobbies($validated['hobbies'] ?? []);
        $languages = $this->normaliseLanguages($validated['languages'] ?? []);
        $skills = $this->normaliseSkills($validated['skills'] ?? []);

        return [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'headline' => $validated['headline'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'website' => $validated['website'] ?? null,
            'linkedin' => $validated['linkedin'] ?? null,
            'github' => $validated['github'] ?? null,
            'birthday' => $validated['birthday'] ?? null,
            'country' => $validated['country'] ?? null,
            'city' => $validated['city'] ?? null,
            'template' => $validated['template'],
            'education' => !empty($education) ? $education : null,
            'work_experience' => !empty($experience) ? $experience : null,
            'hobbies' => !empty($hobbies) ? $hobbies : null,
            'languages' => !empty($languages) ? $languages : null,
            'skills' => !empty($skills) ? $skills : null,
        ];
    }

    protected function ensureCvOwner(Request $request, Cv $cv): void
    {
        abort_unless($cv->user_id === $request->user()->id, 403);
    }

    protected function summariseCv(Cv $cv): array
    {
        $fullName = collect([$cv->first_name, $cv->last_name])
            ->filter(fn ($value) => is_string($value) && trim($value) !== '')
            ->map(fn ($value) => trim($value))
            ->implode(' ');

        return [
            'cv' => $cv,
            'title' => $fullName !== '' ? $fullName : __('Untitled CV'),
            'email' => $cv->email,
            'template' => $cv->template ?? 'classic',
            'updated_at' => $cv->updated_at,
            'created_at' => $cv->created_at,
            'education_count' => $this->countCollectionItems($cv->education),
            'experience_count' => $this->countCollectionItems($cv->work_experience),
            'hobby_count' => $this->countCollectionItems($cv->hobbies),
            'skill_count' => $this->countCollectionItems($cv->skills),
            'language_count' => $this->countCollectionItems($cv->languages),
        ];
    }

    protected function countCollectionItems(mixed $data): int
    {
        if (!is_array($data)) {
            return 0;
        }

        return collect($data)
            ->filter(function ($value) {
                if (is_array($value)) {
                    return collect($value)
                        ->filter(function ($item) {
                            if (is_string($item)) {
                                return trim($item) !== '';
                            }

                            return !empty($item);
                        })
                        ->isNotEmpty();
                }

                if (is_string($value)) {
                    return trim($value) !== '';
                }

                return !empty($value);
            })
            ->count();
    }

    protected function templateOptions(): array
    {
        return ['classic', 'modern', 'creative', 'minimal', 'elegant', 'corporate', 'gradient', 'darkmode', 'futuristic'];
    }

    protected function fetchCountries(): array
    {
        try {
            $response = Http::timeout(8)->get('https://countriesnow.space/api/v0.1/countries/positions');
            if ($response->successful()) {
                $countries = collect($response->json('data'))
                    ->pluck('name')
                    ->filter()
                    ->unique()
                    ->sort()
                    ->values()
                    ->all();

                if (!empty($countries)) {
                    return $countries;
                }
            }
        } catch (\Throwable $e) {
            // ignore network errors and use fallback list below
        }

        return [
            'Canada',
            'France',
            'Germany',
            'Latvia',
            'United Kingdom',
            'United States',
        ];
    }

    protected function normaliseEducation(?array $education): array
    {
        if (!is_array($education)) {
            return [];
        }

        $entries = [];

        foreach ($education as $entry) {
            if (!is_array($entry)) {
                continue;
            }

            if (!empty($entry['school']) && empty($entry['institution'])) {
                $entry['institution'] = $entry['school'];
            }

            $fields = ['institution', 'degree', 'field', 'country', 'city', 'start_year', 'end_year'];
            $clean = [];

            foreach ($fields as $field) {
                $value = $entry[$field] ?? null;
                if (is_string($value)) {
                    $value = trim($value);
                }

                if ($value !== '' && $value !== null) {
                    $clean[$field] = $value;
                }
            }

            if (!empty($clean)) {
                $entries[] = $clean;
            }
        }

        return $entries;
    }

    protected function normaliseExperience(?array $experience): array
    {
        if (!is_array($experience)) {
            return [];
        }

        $entries = [];

        foreach ($experience as $entry) {
            if (!is_array($entry)) {
                continue;
            }

            $fields = ['position', 'company', 'country', 'city', 'from', 'to', 'achievements'];
            $clean = [];

            foreach ($fields as $field) {
                $value = $entry[$field] ?? null;
                if (is_string($value)) {
                    $value = trim($value);
                }

                if ($value !== '' && $value !== null) {
                    $clean[$field] = $value;
                }
            }

            $clean['currently'] = !empty($entry['currently']);
            if ($clean['currently']) {
                unset($clean['to']);
            }

            $hasContent = $clean['currently'];
            foreach ($clean as $key => $value) {
                if ($key === 'currently') {
                    continue;
                }

                if ($value !== null && $value !== '') {
                    $hasContent = true;
                    break;
                }
            }

            if ($hasContent) {
                $entries[] = $clean;
            }
        }

        return $entries;
    }

    protected function normaliseHobbies(?array $hobbies): array
    {
        if (!is_array($hobbies)) {
            return [];
        }

        return collect($hobbies)
            ->filter(fn ($hobby) => is_string($hobby))
            ->map(fn ($hobby) => trim($hobby))
            ->filter(fn ($hobby) => $hobby !== '')
            ->values()
            ->all();
    }

    protected function normaliseLanguages(?array $languages): array
    {
        if (!is_array($languages)) {
            return [];
        }

        $entries = [];

        foreach ($languages as $language) {
            if (!is_array($language)) {
                if (is_string($language) && trim($language) !== '') {
                    $entries[] = ['name' => trim($language), 'level' => null];
                }

                continue;
            }

            $name = isset($language['name']) ? trim((string) $language['name']) : null;
            $level = isset($language['level']) ? trim((string) $language['level']) : null;

            if ($name !== null && $name !== '') {
                $entries[] = [
                    'name' => $name,
                    'level' => $level !== '' ? $level : null,
                ];
            }
        }

        return $entries;
    }

    protected function normaliseSkills(?array $skills): array
    {
        if (!is_array($skills)) {
            return [];
        }

        return collect($skills)
            ->map(function ($skill) {
                if (is_string($skill)) {
                    return trim($skill);
                }

                if (is_array($skill)) {
                    $label = $skill['name'] ?? $skill['title'] ?? null;
                    return is_string($label) ? trim($label) : null;
                }

                return null;
            })
            ->filter(fn ($skill) => is_string($skill) && $skill !== '')
            ->values()
            ->all();
    }

    protected function formatCvForView(Cv $cv): array
    {
        $education = $this->prepareCollection($cv->education ?? []);
        $experience = $this->prepareCollection($cv->work_experience ?? []);
        $hobbies = $this->prepareCollection($cv->hobbies ?? [], preserveKeys: false);
        $skills = $this->prepareCollection($cv->skills ?? [], preserveKeys: false);
        $languages = $this->prepareCollection($cv->languages ?? []);

        return [
            'id' => $cv->id,
            'first_name' => $cv->first_name,
            'last_name' => $cv->last_name,
            'email' => $cv->email,
            'phone' => $cv->phone,
            'headline' => $cv->headline,
            'summary' => $cv->summary,
            'website' => $cv->website,
            'linkedin' => $cv->linkedin,
            'github' => $cv->github,
            'birthday' => optional($cv->birthday)->toDateString(),
            'country' => $cv->country,
            'city' => $cv->city,
            'template' => $cv->template,
            'education' => $education,
            'experience' => $experience,
            'hobbies' => $hobbies,
            'skills' => $skills,
            'languages' => $languages,
            'profile_image' => $cv->profile_image ? Storage::disk('public')->url($cv->profile_image) : null,
        ];
    }

    protected function resolveCvData(Request $request): array
    {
        $requestedId = (int) $request->query('cv');
        if ($requestedId > 0) {
            $cv = $request->user()?->cvs()->find($requestedId);
            if ($cv) {
                return $this->formatCvForView($cv);
            }
        }

        $sessionData = session('cv_data');
        if (!empty($sessionData)) {
            return $sessionData;
        }

        return [];
    }

    protected function prepareCollection($data, bool $preserveKeys = true): array
    {
        if (!is_array($data)) {
            return [];
        }

        if ($preserveKeys) {
            if (!array_is_list($data)) {
                $data = [$data];
            }

            $items = [];
            foreach ($data as $item) {
                if (is_array($item)) {
                    $items[] = $item;
                }
            }

            return array_values($items);
        }

        $values = [];
        foreach ($data as $value) {
            if (!is_string($value)) {
                continue;
            }

            $trimmed = trim($value);
            if ($trimmed !== '') {
                $values[] = $trimmed;
            }
        }

        return $values;
    }

    protected function renderPdf(array $data, string $template, string $filename)
    {
        return PDF::loadView('cv.pdf.layout', [
            'data' => $data,
            'template' => $template,
            'accentColor' => $this->accentColour($template),
            'availableTemplates' => $this->templateOptions(),
        ])->download($filename);
    }

    protected function filenameForCv(array $cvData): string
    {
        $first = trim((string) ($cvData['first_name'] ?? ''));
        $last = trim((string) ($cvData['last_name'] ?? ''));

        $segments = collect([$first, $last])
            ->filter(fn ($value) => $value !== '')
            ->map(fn ($value) => (string) Str::of($value)
                ->ascii()
                ->replaceMatches('/[^A-Za-z0-9]+/', '_')
                ->trim('_')
                ->lower())
            ->filter(fn ($value) => $value !== '');

        if ($segments->isEmpty()) {
            return 'cv.pdf';
        }

        return $segments->implode('_') . '_cv.pdf';
    }

    protected function accentColour(string $template): string
    {
        return match ($template) {
            'modern' => '#2563eb',
            'creative' => '#ec4899',
            'minimal' => '#0f172a',
            'elegant' => '#c026d3',
            'corporate' => '#0f172a',
            'gradient' => '#0ea5e9',
            'darkmode' => '#1f2937',
            'futuristic' => '#7c3aed',
            default => '#1e293b',
        };
    }
}
