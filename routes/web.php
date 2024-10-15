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

Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

Route::get('/search/view', [VaccinationController::class, 'search_view'])->name('search.view');
Route::get('/search', [VaccinationController::class, 'search'])->name('search');
