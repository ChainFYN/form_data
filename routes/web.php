<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;

Route::get('/', function () {
    return redirect()->route('pengguna.index');
});

Route::resource('pengguna', PenggunaController::class);
