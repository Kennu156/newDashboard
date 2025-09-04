<?php

use App\Http\Controllers\TahvelCookieController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {

        $user = auth()->user();

        $userData = $user->tahvelUser();
        $absenceData = $user->tahvelAbsence();

        if(! $userData) {
            $user->update(['tahvel_cookie' => null]);
        }

        return Inertia::render('Dashboard', [
            'userData' => $userData,
            'absenceData' => $absenceData,
        ]);
    })->name('dashboard');

    Route::put('save-tahvel-cookie', TahvelCookieController::class)->name('save-tahvel-cookie');
});




require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
