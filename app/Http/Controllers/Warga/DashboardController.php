<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Session;
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

        $wargaId = Session::get('warga_id');
        $status = request('status');

        $laporanQuery = Laporan::with(['jalan.desa.kecamatan', 'kategori', 'status'])
            ->where('id_pengguna', $wargaId);

        $laporan = $applyTimeFilter($laporanQuery)
            ->when($status === 'pending', fn ($query) => $query->where('id_status', 1))
            ->when($status === 'diproses', fn ($query) => $query->where('id_status', 2))
            ->when($status === 'selesai', fn ($query) => $query->where('id_status', 3))
            ->latest()
            ->get();

        $statistik = [
            'total' => $applyTimeFilter(Laporan::where('id_pengguna', $wargaId))->count(),
            'menunggu' => $applyTimeFilter(Laporan::where('id_pengguna', $wargaId)->where('id_status', 1))->count(),
            'diproses' => $applyTimeFilter(Laporan::where('id_pengguna', $wargaId)->where('id_status', 2))->count(),
            'selesai' => $applyTimeFilter(Laporan::where('id_pengguna', $wargaId)->where('id_status', 3))->count(),
            'ditolak' => $applyTimeFilter(Laporan::where('id_pengguna', $wargaId)->where('id_status', 4))->count(),
        ];

        $recentLaporan = $laporan->take(5);

        if ($request->ajax()) {
            return view('warga.partials.riwayat_list', compact('recentLaporan'));
        }

        return view('warga.dashboard', compact('statistik', 'recentLaporan', 'timeFilter'));
    }
}
