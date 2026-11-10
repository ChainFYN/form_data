<?php

namespace App\Http\Controllers\Pupr;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\TimLapangan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (! session()->has('pupr_id')) {
            return redirect()->route('warga.login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

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

        $laporanQuery = Laporan::with(['kategori', 'jalan.desa.kecamatan', 'pengguna', 'logProses'])
            ->where(function ($q) {
                $q->where('id_status', 2)
                    ->orWhere('id_status', 3);
            });

        $laporan_diproses = $applyTimeFilter($laporanQuery)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung persentase dan tentukan tahap progres untuk masing-masing laporan
        $laporan_diproses->each(function ($laporan) {
            $latestLog = $laporan->logProses->sortByDesc('created_at')->first();
            $persen = 0;

            if ($laporan->id_status == 3 || $laporan->status_bast === 'DIVERIFIKASI' || $laporan->status_bast === 'MENUNGGU_VERIFIKASI') {
                $persen = 100;
            } elseif ($latestLog && preg_match('/Progres\s*(\d+)%/i', $latestLog->catatan_update, $matches)) {
                $persen = (int) $matches[1];
            }

            // Kategori tahapan:
            // 25% - 75% termasuk diproses
            // >= 100% atau status 3 termasuk selesai
            // < 25% (0%) termasuk siap dikerjakan
            if ($persen >= 100 || $laporan->id_status == 3) {
                $tahap = 'selesai';
            } elseif ($persen >= 25) {
                $tahap = 'diproses';
            } else {
                $tahap = 'siap_dikerjakan';
            }

            $laporan->progres_persen = $persen;
            $laporan->tahap_progres = $tahap;
        });

        $siapDikerjakanCount = $laporan_diproses->where('tahap_progres', 'siap_dikerjakan')->count();
        $diprosesCount = $laporan_diproses->where('tahap_progres', 'diproses')->count();
        $selesaiCount = $laporan_diproses->where('tahap_progres', 'selesai')->count();

        $timLapangan = TimLapangan::all();
        $timTersediaCount = $timLapangan->where('status', 'Tersedia')->count();

        $menungguCamat = $applyTimeFilter(Laporan::where('id_status', 1))->count()
            + $applyTimeFilter(Laporan::where('status_bast', 'MENUNGGU_VERIFIKASI'))->count();

        $diprosesAktif = $applyTimeFilter(
            Laporan::where('id_status', 2)
                ->where(function ($q) {
                    $q->whereNull('status_bast')->orWhere('status_bast', 'DITOLAK');
                })
        )->count();

        $selesaiDiverifikasi = $applyTimeFilter(Laporan::where('id_status', 3))->count();

        $totalLaporan = $applyTimeFilter(Laporan::query())->count();

        $filterLabel = match ($timeFilter) {
            'hari_ini', 'today' => 'Hari Ini',
            'kemarin', 'yesterday' => 'Kemarin',
            '1_minggu', 'minggu_ini', 'week' => '1 Minggu Terakhir',
            '1_bulan', 'bulan_ini', 'month' => 'Sebulan Terakhir',
            default => 'Semua Waktu',
        };

        return view('pupr.dashboard', [
            'laporan_diproses' => $laporan_diproses,
            'siapDikerjakanCount' => $siapDikerjakanCount,
            'diprosesCount' => $diprosesCount,
            'selesaiCount' => $selesaiCount,
            'timLapangan' => $timLapangan,
            'timeFilter' => $timeFilter,
            'filterLabel' => $filterLabel,
            'statistik' => [
                'total' => $totalLaporan,
                'menunggu' => $menungguCamat,
                'diproses' => $diprosesAktif,
                'selesai' => $selesaiDiverifikasi,
                'tim_tersedia' => $timTersediaCount,
            ],
        ]);
    }
}
