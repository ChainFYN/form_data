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
        $status = request('status');

        $laporan = Laporan::with(['jalan.desa.kecamatan', 'kategori', 'status'])
            ->where('id_pengguna', $wargaId)
            ->when($status === 'pending', fn ($query) => $query->where('id_status', 1))
            ->when($status === 'diproses', fn ($query) => $query->where('id_status', 2))
            ->when($status === 'selesai', fn ($query) => $query->where('id_status', 3))
            ->latest()
            ->get();

        $statistik = [
            'total' => Laporan::where('id_pengguna', $wargaId)->count(),
            'menunggu' => Laporan::where('id_pengguna', $wargaId)->where('id_status', 1)->count(),
            'diproses' => Laporan::where('id_pengguna', $wargaId)->where('id_status', 2)->count(),
            'selesai' => Laporan::where('id_pengguna', $wargaId)->where('id_status', 3)->count(),
            'ditolak' => Laporan::where('id_pengguna', $wargaId)->where('id_status', 4)->count(),
        ];

        $recentLaporan = $laporan->take(5);

        return view('warga.dashboard', compact('statistik', 'recentLaporan'));
    }
}
