<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WargaAuthController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\LaporanController;

Route::get('/', function () {
    return redirect()->route('warga.login');
});

// Warga Auth
Route::get('/login', [WargaAuthController::class, 'showLoginForm'])->name('warga.login');
Route::post('/login', [WargaAuthController::class, 'login']);
Route::get('/register', [WargaAuthController::class, 'showRegisterForm'])->name('warga.register');
Route::post('/register', [WargaAuthController::class, 'register']);
Route::post('/logout', [WargaAuthController::class, 'logout'])->name('warga.logout');

// Warga Dashboard (Middleware simple session check)
Route::middleware(['warga.auth'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('warga.dashboard');
    Route::resource('laporan', LaporanController::class, ['as' => 'warga']);
});

