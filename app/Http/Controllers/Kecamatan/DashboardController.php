<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // KPI Counters — menggunakan tabel laporan warga
        // id_status: 1=Menunggu Validasi, 2=Diproses, 3=Selesai, 4=Ditolak
        $menungguValidasiCount = Laporan::where('id_status', 1)->count()
            + Laporan::where('status_bast', 'MENUNGGU_VERIFIKASI')->count();

        $terverifikasiCount = Laporan::where('id_status', 2)
            ->where(function ($q) {
                $q->whereNull('status_bast')->orWhere('status_bast', 'DITOLAK');
            })->count();

        $ditolakCount = Laporan::where('id_status', 4)->count();
        $perluTindakanCount = Laporan::where('tingkat_bahaya', 'Bahaya Tinggi')
            ->where('id_status', 1)->count();

        // Priority validation queue (Menunggu validasi, sorted by urgency)
        $priorityReports = Laporan::with(['pengguna', 'jalan.desa', 'kategori', 'status'])
            ->where('id_status', 1)
            ->orderByRaw("CASE
                WHEN tingkat_bahaya = 'Bahaya Tinggi' THEN 1
                WHEN tingkat_bahaya = 'Sedang' THEN 2
                ELSE 3
            END")
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // SLA Warning: laporan bahaya tinggi yang belum divalidasi
        $slaAlerts = Laporan::with(['pengguna', 'jalan', 'kategori'])
            ->where('tingkat_bahaya', 'Bahaya Tinggi')
            ->where('id_status', 1)
            ->take(3)
            ->get();

        $totalResolvedRuas = Laporan::where('id_status', 3)
            ->where(function ($q) {
                $q->where('status_bast', 'DIVERIFIKASI')
                    ->orWhereNull('status_bast');
            })->count();

        // Kirim collection kosong agar view tidak error (Village tidak digunakan lagi)
        $villages = collect();

        return view('kecamatan.dashboard', compact(
            'perluTindakanCount',
            'menungguValidasiCount',
            'terverifikasiCount',
            'ditolakCount',
            'priorityReports',
            'slaAlerts',
            'totalResolvedRuas',
            'villages'
        ));
    }
}
