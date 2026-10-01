<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BastController extends Controller
{
    public function index()
    {
        // Laporan yang sudah selesai (id_status = 3) dan butuh verifikasi BAST
        $laporan_bast = \App\Models\Laporan::with(['jalan.desa.kecamatan', 'kategori', 'pengguna'])
                        ->where('id_status', 3)
                        ->orderBy('updated_at', 'desc')
                        ->get();

        return view('kecamatan.bast.index', compact('laporan_bast'));
    }
}
