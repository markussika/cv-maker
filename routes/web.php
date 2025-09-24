<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
})->name('welcome');

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth','verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile','edit')->name('profile.edit');
        Route::patch('/profile','update')->name('profile.update');
        Route::delete('/profile','destroy')->name('profile.destroy');
    });

    Route::prefix('cv')->controller(CvController::class)->group(function () {
        Route::get('/create','create')->name('cv.create');
        Route::post('/store','store')->name('cv.store');
        Route::get('/history','history')->name('cv.history');
        Route::get('/{cv}/edit','edit')->name('cv.edit');
        Route::put('/{cv}','update')->name('cv.update');
        Route::delete('/{cv}','destroy')->name('cv.destroy');
        Route::get('/preview','preview')->name('cv.preview');
        Route::get('/templates','templates')->name('cv.templates');
        Route::get('/download/{template}','download')->name('cv.download');
        Route::get('/guide','guide')->name('cv.guide');

        // API endpoints routed to controller methods
        Route::post('/cities','getCities')->name('cv.cities');
        Route::post('/companies','getCompanies')->name('cv.companies');
    });

});

require __DIR__.'/auth.php';
