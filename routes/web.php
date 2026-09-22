<?php

use App\Http\Controllers\Auth\WargaAuthController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\LaporanController;
use Illuminate\Support\Facades\Route;

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

        return view('pupr.dashboard', [
            'statistik' => [
                'total' => 15,
                'menunggu' => 5,
                'diproses' => 8,
                'selesai' => 2,
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
});
