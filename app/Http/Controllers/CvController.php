<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use PDF;

class CvController extends Controller
{
    public function create(Request $request)
    {
        $countries = $this->fetchCountries();
        $templates = $this->templateOptions();

        $prefill = $request->user()?->cvs()->latest()->first();

        $initialTemplate = $templates[0] ?? 'classic';
        if ($prefill && in_array($prefill->template, $templates, true)) {
            $initialTemplate = $prefill->template;
        }

        $requestedTemplate = $request->string('template')->toString();
        if ($requestedTemplate && in_array($requestedTemplate, $templates, true)) {
            $initialTemplate = $requestedTemplate;
        }

        return view('cv.form', [
            'countries' => $countries,
            'templates' => $templates,
            'initialTemplate' => $initialTemplate,
            'prefill' => $prefill,
        ]);
    }

    public function store(Request $request)
    {
        $templates = $this->templateOptions();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
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
        ]);

        $education = $this->normaliseEducation($validated['education'] ?? []);
        $experience = $this->normaliseExperience($validated['experience'] ?? []);
        $hobbies = $this->normaliseHobbies($validated['hobbies'] ?? []);

        $cv = Cv::create([
            'user_id' => $request->user()->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'birthday' => $validated['birthday'] ?? null,
            'country' => $validated['country'] ?? null,
            'city' => $validated['city'] ?? null,
            'template' => $validated['template'],
            'education' => !empty($education) ? $education : null,
            'work_experience' => !empty($experience) ? $experience : null,
            'hobbies' => !empty($hobbies) ? $hobbies : null,
        ]);

        $cvData = $this->formatCvForView($cv);

        session(['cv_data' => $cvData]);

        return redirect()->route('cv.preview')->with('status', __('Your CV details have been saved.'));
    }

    public function preview(Request $request)
    {
        $templates = $this->templateOptions();
        $cvData = $this->resolveCvData($request);

        return view('cv.preview', compact('cvData', 'templates'));
    }

    public function pdf(Request $request)
    {
        $cvData = $this->resolveCvData($request);
        $template = $cvData['template'] ?? 'classic';

        return $this->renderPdf($cvData, $template, 'cv.pdf');
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

        return $this->renderPdf($cvData, $template, "cv-{$template}.pdf");
    }

    public function guide()
    {
        return view('cv.guide');
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

    protected function formatCvForView(Cv $cv): array
    {
        $education = $this->prepareCollection($cv->education ?? []);
        $experience = $this->prepareCollection($cv->work_experience ?? []);
        $hobbies = $this->prepareCollection($cv->hobbies ?? [], preserveKeys: false);

        return [
            'id' => $cv->id,
            'first_name' => $cv->first_name,
            'last_name' => $cv->last_name,
            'email' => $cv->email,
            'phone' => $cv->phone,
            'birthday' => optional($cv->birthday)->toDateString(),
            'country' => $cv->country,
            'city' => $cv->city,
            'template' => $cv->template,
            'education' => $education,
            'experience' => $experience,
            'hobbies' => $hobbies,
        ];
    }

    protected function resolveCvData(Request $request): array
    {
        $sessionData = session('cv_data');
        if (!empty($sessionData)) {
            return $sessionData;
        }

        $cv = $request->user()?->cvs()->latest()->first();

        return $cv ? $this->formatCvForView($cv) : [];
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
        return PDF::loadView('cv.pdf', [
            'data' => $data,
            'template' => $template,
            'accentColor' => $this->accentColour($template),
        ])->download($filename);
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
