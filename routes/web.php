<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Http;

Route::get('/', fn() => view('welcome'))->name('welcome');
Route::get('/dashboard', fn() => view('dashboard'))->middleware(['auth','verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile','edit')->name('profile.edit');
        Route::patch('/profile','update')->name('profile.update');
        Route::delete('/profile','destroy')->name('profile.destroy');
    });

    // CV
    Route::controller(CvController::class)->group(function () {
        Route::get('/cv/create','create')->name('cv.create');
        Route::post('/cv/preview','preview')->name('cv.preview');
        Route::post('/cv/pdf','pdf')->name('cv.pdf');
        Route::get('/cv/guide', fn()=> view('cv.guide'))->name('cv.guide');
        Route::get('/cv/templates', fn()=> view('cv.templates.index'))->name('cv.templates');
    });

    // API endpoints for dynamic dropdowns
    Route::get('/countries', function () {
        $response = Http::get('https://countriesnow.space/api/v0.1/countries/positions');
        return response()->json(collect($response->json('data'))->pluck('name'));
    });

    Route::get('/cities', function () {
        $country = request('country');
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/cities', ['country'=>$country]);
        return response()->json($response->json('data'));
    });

    Route::get('/companies', function () {
        $country = request('country');
        $city = request('city');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.config('services.companies_api.key')
        ])->get("https://www.thecompaniesapi.com/api/enrich-company-from-domain", [
            'country'=>$country,'city'=>$city
        ]);

        $fakeCompanies = [
            'Tech Solutions Ltd','Global IT Services','Future Innovations','Smart Systems Inc','NextGen Software'
        ];

        if($response->failed()){
            return response()->json($fakeCompanies);
        }

        $data = $response->json();
        $companies = [];
        if(isset($data['companies']) && is_array($data['companies'])){
            foreach($data['companies'] as $company){
                $companies[] = $company['name'] ?? '';
            }
        }
        if(empty($companies)) $companies=$fakeCompanies;

        return response()->json($companies);
    });

});

require __DIR__.'/auth.php';
