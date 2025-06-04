<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstallationController;
use Illuminate\Support\Facades\Route;



//installation
Route::get('/install', [InstallationController::class, 'step1'])->name('install.step1');
Route::post('/install/step1', [InstallationController::class, 'postStep1'])->name('install.postStep1');

Route::get('/install/step2', [InstallationController::class, 'step2'])->name('install.step2');
Route::post('/install/step2', [InstallationController::class, 'postStep2'])->name('install.postStep2');

Route::get('/install/step3', [InstallationController::class, 'step3'])->name('install.step3');
Route::post('/install/step3', [InstallationController::class, 'postStep3'])->name('install.postStep3');

Route::get('/{param1?}/{param2?}', [HomeController::class, 'index'])->name('home');


Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');