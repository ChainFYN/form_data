<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $wargaId = Session::get('warga_id');
        $laporan = Laporan::where('id_pengguna', $wargaId)->get();

        $statistik = [
            'total' => $laporan->count(),
            'menunggu' => $laporan->where('id_status', 1)->count(),
            'diproses' => $laporan->where('id_status', 2)->count(),
            'selesai' => $laporan->where('id_status', 3)->count(),
            'ditolak' => $laporan->where('id_status', 4)->count(),
        ];

        return view('warga.dashboard', compact('statistik'));
    }
}
