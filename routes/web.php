<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CvController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome page (public)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard (home page)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth routes for profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CV routes (all under auth)
Route::middleware('auth')->group(function () {
    // CV creation form
    Route::get('/cv/create', [CvController::class, 'create'])->name('cv.create');

    // CV preview
    Route::post('/cv/preview', [CvController::class, 'preview'])->name('cv.preview');

    // CV PDF download
    Route::post('/cv/pdf', [CvController::class, 'pdf'])->name('cv.pdf');

    // CV Guide page
    Route::get('/cv/guide', function () {
        return view('cv.guide');
    })->name('cv.guide');

    // CV Templates page
    Route::get('/cv/templates', function () {
        return view('cv.templates.index');
    })->name('cv.templates');
});

// Include default Laravel auth routes
require __DIR__.'/auth.php';
