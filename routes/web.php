<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Locale endpoints (also work without auth so login page can switch language)
Route::get('lang/{locale}', [LocaleController::class, 'bundle'])->name('locale.bundle');
Route::post('lang/{locale}/persist', [LocaleController::class, 'persist'])->name('locale.persist');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});
Route::post('logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/admin.php';
