<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\VaccinationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/register');
})->name('home');

Route::get('/register', [RegistrationController::class, 'create'])->name('register.create');
Route::post('/register', [RegistrationController::class, 'store']);

Route::get('/search/view', [VaccinationController::class, 'search_view'])->name('search.view');
Route::get('/search', [VaccinationController::class, 'search'])->name('search');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegistrationController::class, 'create'])
        ->name('register');

    Route::post('register', [RegistrationController::class, 'store']);

    Route::get('login', [RegistrationController::class, 'create'])
        ->name('login');

    Route::post('login', [RegistrationController::class, 'store']);

    Route::get('forgot-password', [RegistrationController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [RegistrationController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [RegistrationController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [RegistrationController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {

    Route::get('confirm-password', [RegistrationController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [RegistrationController::class, 'store']);

    Route::put('password', [RegistrationController::class, 'update'])->name('password.update');

    Route::post('logout', [RegistrationController::class, 'destroy'])
        ->name('logout');
});
