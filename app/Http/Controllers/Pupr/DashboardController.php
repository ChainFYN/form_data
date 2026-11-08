<?php

namespace App\Http\Controllers\PUPR;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\TimLapangan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('pupr_id')) {
            return redirect()->route('warga.login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        $laporan_diproses = Laporan::with(['kategori', 'jalan.desa.kecamatan', 'pengguna'])
            ->where('id_status', 2)
            ->where(function ($q) {
                $q->whereNull('status_bast')
                    ->orWhere('status_bast', 'DITOLAK');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $timLapangan = TimLapangan::all();
        $timTersediaCount = $timLapangan->where('status', 'Tersedia')->count();

        $menungguCamat = Laporan::where('id_status', 1)->count()
            + Laporan::where('status_bast', 'MENUNGGU_VERIFIKASI')->count();

        $diprosesAktif = Laporan::where('id_status', 2)
            ->where(function ($q) {
                $q->whereNull('status_bast')->orWhere('status_bast', 'DITOLAK');
            })->count();

        $selesaiDiverifikasi = Laporan::where('id_status', 3)->count();

        return view('pupr.dashboard', [
            'laporan_diproses' => $laporan_diproses,
            'timLapangan' => $timLapangan,
            'statistik' => [
                'total' => Laporan::count(),
                'menunggu' => $menungguCamat,
                'diproses' => $diprosesAktif,
                'selesai' => $selesaiDiverifikasi,
                'tim_tersedia' => $timTersediaCount
            ],
        ]);
    }
}
