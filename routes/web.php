<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TDSController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SettingController;
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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::middleware(['auth'])->group(function () {
    // Main dashboard route that handles redirection based on role
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // Owner-specific routes
    Route::middleware(['role:Pemilik'])->group(function () {
        Route::get('/owner-dashboard', [DashboardController::class, 'ownerDashboard'])->name('owner.dashboard');
        // Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::resource('user', UserController::class);
        Route::get('monthly-history', [HistoryController::class, 'monthly'])->name('monthly.history');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // Manager-specific routes
    Route::middleware(['role:Pengelola'])->group(function () {
        Route::get('/manager-dashboard', [DashboardController::class, 'managerDashboard'])->name('manager.dashboard');
        Route::get('tds-current', [TDSController::class, 'current'])->name('tds.current');
        Route::get('hourly-history', [HistoryController::class, 'hourly'])->name('hourly.history');
    });

    // Common routes for both roles
    Route::get('/history/monthly', [HistoryController::class, 'monthly'])->name('history.monthly');
    Route::get('/history/hourly', [HistoryController::class, 'hourly'])->name('history.hourly');
    Route::resource('profil', ProfilController::class);
});
