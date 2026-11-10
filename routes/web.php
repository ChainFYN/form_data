<?php

use App\Http\Controllers\Auth\WargaAuthController;
use App\Http\Controllers\Kecamatan\BastController as KecamatanBast;
use App\Http\Controllers\Kecamatan\DashboardController as KecamatanDashboard;
use App\Http\Controllers\Kecamatan\ReportController as KecamatanReport;
use App\Http\Controllers\Kecamatan\ValidationController as KecamatanValidation;
use App\Http\Controllers\Pupr\BastController as PUPRBastController;
use App\Http\Controllers\Pupr\DashboardController as PUPRDashboardController;
use App\Http\Controllers\Pupr\LaporanController as PUPRLaporanController;
use App\Http\Controllers\Pupr\ProgresController;
use App\Http\Controllers\Pupr\TimLapanganController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\LaporanController as WargaLaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (session()->has('warga_id')) {
        return redirect()->route('warga.dashboard');
    }
    if (session()->has('pupr_id')) {
        return redirect()->route('pupr.dashboard');
    }
    if (session()->has('kecamatan_id')) {
        return redirect()->route('kecamatan.dashboard');
    }

    return redirect()->route('warga.login');
});

// Warga Routes (Standardized prefix and naming matching PUPR & Kecamatan)
Route::prefix('warga')->name('warga.')->group(function () {
    // Auth Routes
    Route::get('/login', [WargaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [WargaAuthController::class, 'login']);
    Route::get('/register', [WargaAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [WargaAuthController::class, 'register']);
    Route::post('/logout', [WargaAuthController::class, 'logout'])->name('logout');

    // Protected Warga Area
    Route::middleware(['warga.auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('laporan', WargaLaporanController::class);
    });
});

// Backward compatibility redirects for legacy paths
Route::get('/login', fn () => redirect()->route('warga.login'));
Route::get('/register', fn () => redirect()->route('warga.register'));
Route::get('/dashboard', fn () => redirect()->route('warga.dashboard'));
Route::get('/laporan', fn () => redirect()->route('warga.laporan.index'));

// PUPR Routes
Route::prefix('pupr')->name('pupr.')->group(function () {
    Route::get('/login', function () {
        return redirect()->route('warga.login');
    })->name('login');
    Route::post('/logout', [WargaAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [PUPRDashboardController::class, 'index'])->name('dashboard');

    Route::get('/laporan', [PUPRLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [PUPRLaporanController::class, 'show'])->name('laporan.show');
    Route::post('/laporan/{id}/progress', [PUPRLaporanController::class, 'updateProgress'])->name('laporan.update-progress');
    Route::post('/laporan/{id}/selesai', [PUPRLaporanController::class, 'selesaiBast'])->name('laporan.selesai-bast');

    Route::get('/progres', [ProgresController::class, 'index'])->name('progres.index');
    Route::get('/progres/{id}', [ProgresController::class, 'show'])->name('progres.show');
    Route::post('/progres/{id}', [ProgresController::class, 'update'])->name('progres.update');
    // Tim Lapangan Routes
    Route::get('/tim-lapangan', [TimLapanganController::class, 'index'])->name('tim-lapangan.index');
    Route::put('/tim-lapangan/{id}/status', [TimLapanganController::class, 'updateStatus'])->name('tim-lapangan.update-status');
    Route::put('/tim-lapangan/{id}/personel', [TimLapanganController::class, 'updatePersonel'])->name('tim-lapangan.update-personel');

    // BAST PDF Route
    Route::get('/bast/{id}/generate', [PUPRBastController::class, 'generatePdf'])->name('bast.generate');
});

// Kecamatan Routes
Route::prefix('kecamatan')->name('kecamatan.')->group(function () {
    Route::get('/dashboard', [KecamatanDashboard::class, 'index'])->name('dashboard');
    Route::get('/validasi', [KecamatanValidation::class, 'index'])->name('validation.index');
    Route::post('/validasi/{id}', [KecamatanValidation::class, 'update'])->name('validation.update');
    Route::get('/rekapitulasi', [KecamatanReport::class, 'recapitulation'])->name('reports.recapitulation');
    Route::get('/statistik', [KecamatanReport::class, 'statistics'])->name('reports.statistics');
    Route::get('/master-desa', [KecamatanReport::class, 'masterDesa'])->name('reports.master-desa');
    Route::get('/peta-gis', [KecamatanReport::class, 'gisMap'])->name('reports.gis-map');
    Route::get('/cetak-bap/{id}', [KecamatanReport::class, 'printBap'])->name('reports.print-bap');
    Route::get('/ekspor-bap', [KecamatanReport::class, 'exportBap'])->name('reports.export-bap');
    Route::get('/lapor-baru', [KecamatanReport::class, 'create'])->name('reports.create');
    Route::post('/lapor-baru', [KecamatanReport::class, 'store'])->name('reports.store');
    Route::get('/bast', [KecamatanBast::class, 'index'])->name('bast.index');
    Route::post('/bast/{id}', [KecamatanBast::class, 'update'])->name('bast.update');
    Route::post('/logout', [WargaAuthController::class, 'logout'])->name('logout');
});
