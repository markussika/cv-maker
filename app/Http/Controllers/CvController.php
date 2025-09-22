<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PDF;

class CvController extends Controller
{
    public function create(Request $request)
    {
        $templates = $this->availableTemplates();
        $initialTemplate = $request->string('template')->toString();

        if (! $initialTemplate && $request->user()?->cvs()->exists()) {
            $initialTemplate = $request->user()->cvs()->latest()->value('template');
        }

        if ($initialTemplate && ! in_array($initialTemplate, $templates, true)) {
            $initialTemplate = null;
        }

        $countries = $this->resolveCountries();
        $latestCv = $request->user()?->cvs()->latest()->first();

        return view('cv.form', [
            'countries' => $countries,
            'templates' => $templates,
            'initialTemplate' => $initialTemplate ?? ($templates[0] ?? 'classic'),
            'cv' => $latestCv,
        ]);
    }

    public function store(Request $request)
    {
        $templates = $this->availableTemplates();

        $validated = $request->validate([
            'cv_id' => ['nullable', 'integer'],
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:60'],
            'birthday' => ['nullable', 'date', 'before:tomorrow'],
            'address' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:120'],
            'city' => ['nullable', 'string', 'max:120'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'github' => ['nullable', 'url', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'summary' => ['nullable', 'string'],
            'education' => ['nullable', 'array'],
            'education.institution' => ['nullable', 'string', 'max:255'],
            'education.degree' => ['nullable', 'string', 'max:255'],
            'education.field' => ['nullable', 'string', 'max:255'],
            'education.start_year' => ['nullable', 'string', 'max:20'],
            'education.end_year' => ['nullable', 'string', 'max:20'],
            'experience' => ['nullable', 'array'],
            'experience.position' => ['nullable', 'string', 'max:255'],
            'experience.company' => ['nullable', 'string', 'max:255'],
            'experience.country' => ['nullable', 'string', 'max:120'],
            'experience.city' => ['nullable', 'string', 'max:120'],
            'experience.from' => ['nullable', 'string', 'max:30'],
            'experience.to' => ['nullable', 'string', 'max:30'],
            'experience.currently' => ['nullable', 'boolean'],
            'experience.achievements' => ['nullable', 'string'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['nullable', 'string', 'max:120'],
            'languages' => ['nullable', 'array'],
            'languages.*' => ['nullable', 'string', 'max:120'],
            'hobbies' => ['nullable', 'array'],
            'hobbies.*' => ['nullable', 'string', 'max:120'],
            'activities' => ['nullable', 'array'],
            'activities.*' => ['nullable', 'string', 'max:160'],
            'template' => ['required', 'string', 'in:' . implode(',', $templates)],
        ]);

        $education = $this->cleanAssociative($validated['education'] ?? []);
        $experience = $this->cleanAssociative($validated['experience'] ?? []);

        if (! empty($experience)) {
            $experience['currently'] = (bool) ($experience['currently'] ?? false);
            if ($experience['currently']) {
                $experience['to'] = null;
            }
        }

        $payload = [
            'user_id' => $request->user()->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'birth_date' => Arr::get($validated, 'birthday'),
            'address' => $validated['address'] ?? null,
            'country' => $validated['country'] ?? null,
            'city' => $validated['city'] ?? null,
            'linkedin' => $validated['linkedin'] ?? null,
            'github' => $validated['github'] ?? null,
            'website' => $validated['website'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'template' => $validated['template'],
            'education' => empty($education) ? null : [$education],
            'work_experience' => empty($experience) ? null : [$experience],
            'skills' => $this->cleanList($validated['skills'] ?? []),
            'languages' => $this->cleanList($validated['languages'] ?? []),
            'hobbies' => $this->cleanList($validated['hobbies'] ?? []),
            'extra_curriculum_activities' => $this->cleanList($validated['activities'] ?? []),
        ];

        $cv = null;

        if (! empty($validated['cv_id'])) {
            $cv = Cv::where('id', $validated['cv_id'])
                ->where('user_id', $request->user()->id)
                ->first();
        }

        if ($cv) {
            $cv->fill($payload);
        } else {
            $cv = new Cv($payload);
        }

        $cv->save();

        session([
            'cv_id' => $cv->id,
            'cv_data' => $cv->toArray(),
        ]);

        return redirect()->route('cv.preview')->with('status', 'CV information saved successfully.');
    }

    public function preview()
    {
        $templates = $this->availableTemplates();
        $cv = null;

        $sessionCvId = session('cv_id');
        if ($sessionCvId) {
            $cv = auth()->user()->cvs()->find($sessionCvId);
        }

        if (! $cv) {
            $cv = auth()->user()->cvs()->latest()->first();
        }

        return view('cv.preview', [
            'cv' => $cv,
            'templates' => $templates,
        ]);
    }

    public function pdf(Request $request)
    {
        $cv = auth()->user()->cvs()->latest()->first();

        if (! $cv) {
            abort(404);
        }

        $pdf = PDF::loadView('cv.pdf', ['data' => $cv->toArray()]);
        return $pdf->download('cv.pdf');
    }

    public function getCities(Request $request)
    {
        $country = $request->input('country');
        if (! $country) {
            return response()->json([]);
        }

        $cities = [];

        try {
            $response = Http::withoutProxy()->timeout(10)->post('https://countriesnow.space/api/v0.1/countries/cities', [
                'country' => $country,
            ]);

            if ($response->successful()) {
                $cities = collect($response->json('data'))
                    ->filter(fn ($city) => is_string($city) && filled($city))
                    ->map(fn ($city) => Str::of($city)->squish()->title())
                    ->unique()
                    ->sort()
                    ->values()
                    ->all();
            }
        } catch (\Throwable $e) {
            // Network failure is fine, we will fall back
        }

        if (empty($cities)) {
            $fallback = config('location.city_map', []);
            $cities = $fallback[$country] ?? collect($fallback)
                ->first(fn ($list, $key) => strcasecmp($key, $country) === 0, []);
        }

        return response()->json($cities);
    }

    public function getCompanies(Request $request)
    {
        $country = $request->input('country');
        $city = $request->input('city');

        $fakeCompanies = [
            'Tech Solutions Ltd','Global IT Services','Future Innovations','Smart Systems Inc','NextGen Software'
        ];

        if (!$country || !$city) return response()->json($fakeCompanies);

        $response = Http::withoutProxy()->withHeaders([
            'Authorization' => 'Bearer '.config('services.companies_api.key')
        ])->timeout(10)->get('https://www.thecompaniesapi.com/api/enrich-company-from-domain', [
            'country' => $country,
            'city' => $city
        ]);

        if ($response->failed()) return response()->json($fakeCompanies);

        $data = $response->json();
        $companies = [];
        if (isset($data['companies']) && is_array($data['companies'])) {
            foreach ($data['companies'] as $company) {
                $companies[] = $company['name'] ?? '';
            }
        }
        if (empty($companies)) $companies = $fakeCompanies;

        return response()->json($companies);
    }

    public function templates()
    {
        $templates = $this->availableTemplates();
        $recentCvs = auth()->user()->cvs()->latest()->take(6)->get();

        return view('cv.templates', compact('templates', 'recentCvs'));
    }

    public function download($template)
    {
        $templates = $this->availableTemplates();

        if (! in_array($template, $templates, true)) {
            abort(404);
        }

        $cv = auth()->user()->cvs()->find(session('cv_id'))
            ?? auth()->user()->cvs()->latest()->first();

        if (! $cv) {
            abort(404);
        }

        return PDF::loadView('cv.pdf', ['data' => $cv->toArray()])->download("cv-{$template}.pdf");
    }

    public function guide()
    {
        return view('cv.guide');
    }

    protected function availableTemplates(): array
    {
        return ['classic', 'modern', 'creative', 'minimal', 'elegant', 'corporate', 'gradient', 'darkmode', 'futuristic'];
    }

    protected function resolveCountries(): array
    {
        $fallback = collect(config('location.countries', []));

        try {
            $response = Http::withoutProxy()->timeout(10)->get('https://countriesnow.space/api/v0.1/countries/positions');

            if ($response->successful()) {
                $countries = collect($response->json('data'))
                    ->pluck('name')
                    ->filter()
                    ->map(fn ($country) => Str::of($country)->squish()->title())
                    ->unique()
                    ->sort()
                    ->values();

                if ($countries->isNotEmpty()) {
                    return $countries->all();
                }
            }
        } catch (\Throwable $e) {
            // swallow network errors and use fallback list
        }

        return $fallback->map(fn ($country) => Str::of($country)->squish()->title())
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    protected function cleanAssociative(?array $payload): array
    {
        return collect($payload ?? [])
            ->mapWithKeys(fn ($value, $key) => [$key => is_string($value) ? trim($value) : $value])
            ->filter(fn ($value) => ! is_null($value) && $value !== '' && $value !== [])
            ->toArray();
    }

    protected function cleanList(?array $values): ?array
    {
        $list = collect($values ?? [])
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)
            ->filter(fn ($value) => is_string($value) && $value !== '')
            ->values()
            ->all();

        return empty($list) ? null : $list;
    }
}
