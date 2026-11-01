<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\MasterDataController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Hanya untuk Tamu / Form Registrasi)
|--------------------------------------------------------------------------
*/

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Wilayah untuk Form Register Calon Warga di Flutter
Route::get('/kecamatan', [MasterDataController::class, 'kecamatan']);
Route::get('/desa', [MasterDataController::class, 'desa']);


/*
|--------------------------------------------------------------------------
| 2. PROTECTED ROUTES (WAJIB LOGIN / Ada Bearer Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Profil & Logout
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Master Data Form Laporan
    Route::get('/kategori', [MasterDataController::class, 'kategori']);
    Route::get('/jalan', [MasterDataController::class, 'jalan']);

    // Manajemen Laporan Warga (Wajib Login)
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::post('/laporan', [LaporanController::class, 'store']);
    Route::get('/laporan/{id}', [LaporanController::class, 'show']); // <-- Pindah ke sini

});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
