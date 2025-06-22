<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstallationController;
use App\Http\Controllers\SingleController;
use App\Http\Controllers\ResultsController;
use Illuminate\Support\Facades\Route;



//installation
Route::get('/install', [InstallationController::class, 'step1'])->name('install.step1');
Route::post('/install/step1', [InstallationController::class, 'postStep1'])->name('install.postStep1');

Route::get('/install/step2', [InstallationController::class, 'step2'])->name('install.step2');
Route::post('/install/step2', [InstallationController::class, 'postStep2'])->name('install.postStep2');

Route::get('/install/step3', [InstallationController::class, 'step3'])->name('install.step3');
Route::post('/install/step3', [InstallationController::class, 'postStep3'])->name('install.postStep3');




// Keep your original routes:
Route::prefix('download')->name('single.')->group(function () {
    Route::get('{param1}/{param2}/{param3}', [SingleController::class, 'index'])->name('index');
    Route::get('{param1}/{param3}', [SingleController::class, 'index'])->name('index');
    Route::get('{param2}/{param3}', [SingleController::class, 'index'])->name('index');
    Route::get('{param3}', [SingleController::class, 'index'])->name('index');
});

Route::prefix('search')->name('result.')->group(function () {
    Route::get('{param1}/{param2}/{param3}', [ResultsController::class, 'index'])->name('index');
    Route::get('{param1}/{param3}', [ResultsController::class, 'index'])->name('index');
    Route::get('{param2}/{param3}', [ResultsController::class, 'index'])->name('index');
    Route::get('{param3}', [ResultsController::class, 'index'])->name('index');
});


Route::get('/{param1?}/{param2?}', [HomeController::class, 'index'])->name('home');




Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');