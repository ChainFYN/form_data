<?php

use App\Http\Controllers\Auth\WargaAuthController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\LaporanController;
use App\Http\Controllers\Kecamatan\DashboardController as KecamatanDashboard;
use App\Http\Controllers\Kecamatan\ValidationController as KecamatanValidation;
use App\Http\Controllers\Kecamatan\ReportController as KecamatanReport;
use App\Http\Controllers\Kecamatan\BastController as KecamatanBast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pupr\ProgresController;

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
Route::middleware(['warga.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('warga.dashboard');
    Route::resource('laporan', LaporanController::class, ['as' => 'warga']);
});

// PUPR Preview Routes (MOCK)
Route::prefix('pupr')->name('pupr.')->group(function () {
    Route::get('/login', function () {
        return redirect()->route('warga.login');
    })->name('login');
    Route::post('/logout', [WargaAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        if (! session()->has('pupr_id')) {
            return redirect()->route('warga.login')->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        $laporan_diproses = \App\Models\Laporan::with(['kategori', 'jalan.desa.kecamatan', 'pengguna'])
            ->where('id_status', 2)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pupr.dashboard', [
            'laporan_diproses' => $laporan_diproses,
            'statistik' => [
                'total' => \App\Models\Laporan::count(),
                'menunggu' => \App\Models\Laporan::where('id_status', 1)->count(),
                'diproses' => \App\Models\Laporan::where('id_status', 2)->count(),
                'selesai' => \App\Models\Laporan::where('id_status', 3)->count(),
            ],
        ]);
    })->name('dashboard');

    Route::get('/laporan', function () {
        return view('pupr.laporan.index', ['laporan' => []]);
    })->name('laporan.index');

    Route::get('/laporan/1', function () {
        // Mock data laporan agar view tidak error
        $laporan = (object) [
            'id_laporan' => 1,
            'created_at' => now(),
            'tingkat_bahaya' => 'Bahaya Tinggi',
            'deskripsi' => 'Ada lubang besar di tengah jalan, sangat bahaya kalau malam hari.',
            'id_status' => 2,
            'status' => (object) ['nama_status' => 'Diproses'],
            'kategori' => (object) ['nama_kategori' => 'Jalan Berlubang'],
            'jalan' => (object) [
                'nama_jalan' => 'Gajah Mada',
                'desa' => (object) [
                    'nama_desa' => 'Jember Kidul',
                    'kecamatan' => (object) ['nama_kecamatan' => 'Kaliwates'],
                ],
            ],
            'pengguna' => (object) ['nama_lengkap' => 'Warga Tester'],
            'foto' => 'default.jpg',
        ];

        return view('pupr.laporan.show', ['laporan' => $laporan]);
    })->name('laporan.show');

    Route::post('/laporan/{id}/log', function ($id) {
        return back()->with('success', 'Log berhasil disimpan (Mock)');
    })->name('laporan.log');
    Route::post('/laporan/{id}/rekomendasi', function ($id) {
        return back()->with('success', 'Rekomendasi berhasil disimpan (Mock)');
    })->name('laporan.rekomendasi');
    Route::get('/progres', [ProgresController::class, 'index'])->name('progres.index');
    Route::get('/progres/{id}', [ProgresController::class, 'show'])->name('progres.show');
    Route::post('/progres/{id}', [ProgresController::class, 'update'])->name('progres.update');
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
});

