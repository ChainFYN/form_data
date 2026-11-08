<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $timeFilter = $request->query('waktu', 'all');

        $applyTimeFilter = function ($query) use ($timeFilter) {
            return match ($timeFilter) {
                'hari_ini', 'today' => $query->whereDate('created_at', now()->today()),
                'kemarin', 'yesterday' => $query->whereDate('created_at', now()->subDay()->toDateString()),
                '1_minggu', 'minggu_ini', 'week' => $query->where('created_at', '>=', now()->subDays(7)->startOfDay()),
                '1_bulan', 'bulan_ini', 'month' => $query->where('created_at', '>=', now()->subDays(30)->startOfDay()),
                default => $query,
            };
        };

        // KPI Counters — menggunakan tabel laporan warga
        // id_status: 1=Menunggu Validasi, 2=Diproses, 3=Selesai, 4=Ditolak
        $menungguValidasiCount = $applyTimeFilter(Laporan::where('id_status', 1))->count()
            + $applyTimeFilter(Laporan::where('status_bast', 'MENUNGGU_VERIFIKASI'))->count();

        $terverifikasiCount = $applyTimeFilter(
            Laporan::where('id_status', 2)->where(function ($q) {
                $q->whereNull('status_bast')->orWhere('status_bast', 'DITOLAK');
            })
        )->count();

        $ditolakCount = $applyTimeFilter(Laporan::where('id_status', 4))->count();

        $perluTindakanCount = $applyTimeFilter(
            Laporan::where('tingkat_bahaya', 'Bahaya Tinggi')->where('id_status', 1)
        )->count();

        // Priority validation queue (Menunggu validasi, sorted by urgency)
        $priorityReports = $applyTimeFilter(
            Laporan::with(['pengguna', 'jalan.desa', 'kategori', 'status'])->where('id_status', 1)
        )->orderByRaw("CASE
                WHEN tingkat_bahaya = 'Bahaya Tinggi' THEN 1
                WHEN tingkat_bahaya = 'Sedang' THEN 2
                ELSE 3
            END")
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // SLA Warning: laporan bahaya tinggi yang belum divalidasi
        $slaAlerts = $applyTimeFilter(
            Laporan::with(['pengguna', 'jalan', 'kategori'])
                ->where('tingkat_bahaya', 'Bahaya Tinggi')
                ->where('id_status', 1)
        )->take(3)->get();

        $totalResolvedRuas = $applyTimeFilter(
            Laporan::where('id_status', 3)->where(function ($q) {
                $q->where('status_bast', 'DIVERIFIKASI')
                    ->orWhereNull('status_bast');
            })
        )->count();

        // Kirim collection kosong agar view tidak error (Village tidak digunakan lagi)
        $villages = collect();

        $filterLabel = match ($timeFilter) {
            'hari_ini', 'today' => 'Hari Ini',
            'kemarin', 'yesterday' => 'Kemarin',
            '1_minggu', 'minggu_ini', 'week' => '1 Minggu Terakhir',
            '1_bulan', 'bulan_ini', 'month' => 'Sebulan Terakhir',
            default => 'Semua Waktu',
        };

        if ($request->ajax()) {
            return view('kecamatan.partials.antrean_list', compact('priorityReports'));
        }

        return view('kecamatan.dashboard', compact(
            'perluTindakanCount',
            'menungguValidasiCount',
            'terverifikasiCount',
            'ditolakCount',
            'priorityReports',
            'slaAlerts',
            'totalResolvedRuas',
            'villages',
            'timeFilter',
            'filterLabel'
        ));
    }
}
