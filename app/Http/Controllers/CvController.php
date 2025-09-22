<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDF;

class CvController extends Controller
{
    public function create()
    {
        // Valstu saraksts no API
        $response = Http::get('https://countriesnow.space/api/v0.1/countries/positions');
        $countries = collect($response->json('data'))->pluck('name')->toArray();

        // Example templates list
        $templates = ['classic','modern','creative','minimal','elegant','corporate','gradient','darkmode','futuristic'];

        $initialTemplate = request('template');
        if ($initialTemplate && !in_array($initialTemplate, $templates, true)) {
            $initialTemplate = null;
        }

        return view('cv.form', compact('countries', 'templates', 'initialTemplate'));
    }

    public function store(Request $request)
    {
        // (optional) validate what you need here
        // $request->validate([...]);

        // Save all form data into session so preview/download can use it
        session(['cv_data' => $request->all()]);

        // Redirect to preview which will read from session
        return redirect()->route('cv.preview');
    }

    public function preview()
    {
        // Always provide $cvData (array) to the view to avoid undefined variable
        $cvData = session('cv_data', []);
        $templates = ['classic','modern','creative','minimal','elegant','corporate','gradient','darkmode','futuristic'];

        return view('cv.preview', compact('cvData', 'templates'));
    }

    public function pdf(Request $request)
    {
        $data = $request->all();
        $pdf = PDF::loadView('cv.pdf', compact('data'));
        return $pdf->download('cv.pdf');
    }

    public function getCities(Request $request)
    {
        $country = $request->input('country');
        if (!$country) return response()->json([]);

        $response = Http::post('https://countriesnow.space/api/v0.1/countries/cities', [
            'country' => $country
        ]);

        return response()->json($response->json('data') ?? []);
    }

    public function getCompanies(Request $request)
    {
        $country = $request->input('country');
        $city = $request->input('city');

        $fakeCompanies = [
            'Tech Solutions Ltd','Global IT Services','Future Innovations','Smart Systems Inc','NextGen Software'
        ];

        if (!$country || !$city) return response()->json($fakeCompanies);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.config('services.companies_api.key')
        ])->get('https://www.thecompaniesapi.com/api/enrich-company-from-domain', [
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
        $templates = ['classic','modern','creative','minimal','elegant','corporate','gradient','darkmode','futuristic'];
        return view('cv.templates', compact('templates'));
    }

    public function download($template)
    {
        $data = session('cv_data', []);
        // Ensure template exists; adjust path to your template blades
        return PDF::loadView("cv.templates.pdf.$template", compact('data'))->download("cv-{$template}.pdf");
    }

    public function guide()
    {
        return view('cv.guide');
    }
}
