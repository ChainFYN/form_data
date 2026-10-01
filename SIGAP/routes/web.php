<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes - SIGAP (Sistem Informasi Tanggap Pengaduan Jalan)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard Admin Kecamatan
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Validasi Laporan (Pemeriksaan & Disposisi Aduan Warga)
Route::get('/validasi', [ValidationController::class, 'index'])->name('validation.index');
Route::post('/validasi/{id}', [ValidationController::class, 'update'])->name('validation.update');

// Rekapitulasi Progres
Route::get('/rekapitulasi', [ReportController::class, 'recapitulation'])->name('reports.recapitulation');

// Statistik Wilayah
Route::get('/statistik', [ReportController::class, 'statistics'])->name('reports.statistics');

// Data Master Desa
Route::get('/master-desa', [ReportController::class, 'masterDesa'])->name('reports.master-desa');

// Peta GIS Interaktif
Route::get('/peta-gis', [ReportController::class, 'gisMap'])->name('reports.gis-map');

// Cetak & Ekspor Berita Acara Pemeriksaan (BAP)
Route::get('/cetak-bap/{id}', [ReportController::class, 'printBap'])->name('reports.print-bap');
Route::get('/ekspor-bap', [ReportController::class, 'exportBap'])->name('reports.export-bap');

// Form Input Aduan Baru (Warga)
Route::get('/lapor-baru', [ReportController::class, 'create'])->name('reports.create');
Route::post('/lapor-baru', [ReportController::class, 'store'])->name('reports.store');
