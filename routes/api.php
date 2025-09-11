<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

// Get all countries
Route::get('/countries', function () {
    $response = Http::get('https://countriesnow.space/api/v0.1/countries/positions');

    if ($response->failed()) {
        return response()->json([], 500);
    }

    $countries = collect($response->json('data'))->pluck('name');
    return response()->json($countries);
});

// Get cities for country
Route::get('/cities', function () {
    $country = request('country');

    $response = Http::post('https://countriesnow.space/api/v0.1/countries/cities', [
        'country' => $country,
    ]);

    if ($response->failed()) {
        return response()->json([], 500);
    }

    return response()->json($response->json('data'));
});

// Get companies for country + city
Route::get('/companies', function () {
    $country = request('country');
    $city = request('city');

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('COMPANIES_API_KEY'),
    ])->get("https://www.thecompaniesapi.com/api/enrich-company-from-domain", [
        'country' => $country,
        'city' => $city,
    ]);

    // Fallback fake companies
    $fakeCompanies = [
        'Tech Solutions Ltd',
        'Global IT Services',
        'Future Innovations',
        'Smart Systems Inc',
        'NextGen Software'
    ];

    if ($response->failed()) {
        return response()->json($fakeCompanies);
    }

    $data = $response->json();
    $companies = [];

    if (isset($data['companies']) && is_array($data['companies'])) {
        foreach ($data['companies'] as $company) {
            $companies[] = $company['name'] ?? '';
        }
    }

    // If API returned empty → use fake
    if (empty($companies)) {
        $companies = $fakeCompanies;
    }

    return response()->json($companies);
});
