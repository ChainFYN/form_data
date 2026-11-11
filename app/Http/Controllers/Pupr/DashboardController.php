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

    public function riwayat(Request $request)
    {
        if (! session()->has('pupr_id')) {
            return redirect()->route('warga.login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        $filterStatus = $request->query('status', 'semua'); // semua, 25-75, 100
        $search = $request->query('search', '');

        // Ambil laporan yang statusnya diproses (2) atau selesai (3)
        $query = Laporan::with(['kategori', 'jalan.desa.kecamatan', 'pengguna', 'logProses', 'timLapangan'])
            ->whereIn('id_status', [2, 3]);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id_laporan', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('jalan', fn ($q2) => $q2->where('nama_jalan', 'like', "%{$search}%"));
            });
        }

        $laporanList = $query->orderBy('updated_at', 'desc')->get();

        // Petakan progres dan status validasi untuk masing-masing laporan
        $riwayatLaporan = $laporanList->map(function ($laporan) {
            $latestLog = $laporan->logProses->sortByDesc('created_at')->first();
            $persen = 0;

            if ($laporan->id_status == 3 || $laporan->status_bast === 'DIVERIFIKASI' || $laporan->status_bast === 'MENUNGGU_VERIFIKASI') {
                $persen = 100;
            } elseif ($latestLog && preg_match('/Progres\s*(\d+)%/i', $latestLog->catatan_update, $matches)) {
                $persen = (int) $matches[1];
            }

            // Tentukan status validasi khusus 100%
            $statusValidasi = null;
            if ($persen >= 100) {
                if ($laporan->status_bast === 'DIVERIFIKASI' || $laporan->id_status == 3) {
                    $statusValidasi = 'tervalidasi';
                } elseif ($laporan->status_bast === 'DITOLAK') {
                    $statusValidasi = 'tidak_tervalidasi';
                } else {
                    $statusValidasi = 'menunggu_validasi';
                }
            }

            $laporan->progres_persen = $persen;
            $laporan->status_validasi_100 = $statusValidasi;
            $laporan->latest_log = $latestLog;

            return $laporan;
        })->filter(function ($laporan) {
            // Hanya ambil laporan dengan progres 25% sampai 100%
            return $laporan->progres_persen >= 25 && $laporan->progres_persen <= 100;
        });

        // Filter tab jika dipilih
        if ($filterStatus === '25-75') {
            $riwayatLaporan = $riwayatLaporan->where('progres_persen', '<', 100);
        } elseif ($filterStatus === '100') {
            $riwayatLaporan = $riwayatLaporan->where('progres_persen', '>=', 100);
        }

        return view('pupr.riwayat.index', compact('riwayatLaporan', 'filterStatus', 'search'));
    }
}
