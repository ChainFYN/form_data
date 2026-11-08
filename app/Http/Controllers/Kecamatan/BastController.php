<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\LogProses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BastController extends Controller
{
    public function index(Request $request)
    {
        $timeFilter = $request->query('waktu', 'all');
        $search = $request->query('search', '');
        $selectedId = $request->query('ticket');

        $applyTimeFilter = function ($query) use ($timeFilter) {
            return match ($timeFilter) {
                'hari_ini', 'today' => $query->where(function ($q) {
                    $q->whereDate('updated_at', now()->today())
                        ->orWhereDate('created_at', now()->today());
                }),
                'kemarin', 'yesterday' => $query->where(function ($q) {
                    $q->whereDate('updated_at', now()->subDay()->toDateString())
                        ->orWhereDate('created_at', now()->subDay()->toDateString());
                }),
                '1_minggu', 'minggu_ini', 'week' => $query->where(function ($q) {
                    $q->where('updated_at', '>=', now()->subDays(7)->startOfDay())
                        ->orWhere('created_at', '>=', now()->subDays(7)->startOfDay());
                }),
                '1_bulan', 'bulan_ini', 'month' => $query->where(function ($q) {
                    $q->where('updated_at', '>=', now()->subDays(30)->startOfDay())
                        ->orWhere('created_at', '>=', now()->subDays(30)->startOfDay());
                }),
                default => $query,
            };
        };

        // Laporan yang butuh verifikasi BAST oleh Camat
        $query = Laporan::with(['jalan.desa.kecamatan', 'kategori', 'pengguna', 'logProses'])
            ->where(function ($q) {
                $q->where('status_bast', 'MENUNGGU_VERIFIKASI')
                    ->orWhere(function ($q2) {
                        $q2->where('id_status', 3)->whereNull('status_bast');
                    });
            });

        $query = $applyTimeFilter($query);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id_laporan', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('pengguna', fn ($q2) => $q2->where('nama_lengkap', 'like', "%{$search}%"))
                    ->orWhereHas('jalan', fn ($q2) => $q2->where('nama_jalan', 'like', "%{$search}%"));
            });
        }

        $laporan_bast = $query->orderBy('updated_at', 'desc')->get();

        $activeBast = null;
        if ($selectedId) {
            $activeBast = $laporan_bast->firstWhere('id_laporan', (int) $selectedId);
        }
        if (! $activeBast && $laporan_bast->isNotEmpty()) {
            $activeBast = $laporan_bast->first();
        }

        $filterLabel = match ($timeFilter) {
            'hari_ini', 'today' => 'Hari Ini',
            'kemarin', 'yesterday' => 'Kemarin',
            '1_minggu', 'minggu_ini', 'week' => '1 Minggu Terakhir',
            '1_bulan', 'bulan_ini', 'month' => 'Sebulan Terakhir',
            default => 'Semua Waktu',
        };

        return view('kecamatan.bast.index', compact('laporan_bast', 'activeBast', 'timeFilter', 'filterLabel', 'search'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $action = $request->input('action', 'acc');
        $catatan = trim((string) $request->input('catatan', ''));
        $kecamatanId = Session::get('kecamatan_id') ?? 1;

        if ($action === 'acc') {
            // Camat verifikasi BAST dan kirim ke warga
            $laporan->update([
                'id_status' => 3, // Selesai resmi
                'status_bast' => 'DIVERIFIKASI',
                'catatan_bast' => $catatan ?: 'Telah dilakukan uji petik lapangan dan disetujui BAST.',
                'tgl_verifikasi_bast' => now(),
            ]);

            LogProses::create([
                'id_laporan' => $laporan->id_laporan,
                'id_pengguna' => $kecamatanId,
                'id_status' => 3,
                'catatan_update' => 'BAST diverifikasi Camat & diterbitkan ke warga. Catatan: '.($catatan ?: 'Lolos uji petik & spesifikasi teknis.'),
            ]);

            return redirect()->route('kecamatan.bast.index')
                ->with('status', "BAST untuk Laporan #{$laporan->id_laporan} berhasil diverifikasi & dikirim ke warga!")
                ->with('status_type', 'success');
        } else {
            // Tolak / Minta Perbaikan Lapangan ke PUPR
            $laporan->update([
                'id_status' => 2, // Kembali Diproses PUPR
                'status_bast' => 'DITOLAK',
                'catatan_bast' => $catatan ?: 'Diminta perbaikan minor oleh Kecamatan.',
                'tgl_verifikasi_bast' => now(),
            ]);

            LogProses::create([
                'id_laporan' => $laporan->id_laporan,
                'id_pengguna' => $kecamatanId,
                'id_status' => 2,
                'catatan_update' => 'BAST ditolak oleh Camat. Diminta perbaikan lapangan: '.($catatan ?: 'Perbaikan minor belum memenuhi toleransi.'),
            ]);

            return redirect()->route('kecamatan.bast.index')
                ->with('status', "BAST Laporan #{$laporan->id_laporan} ditolak dan dikembalikan ke Dinas PUPR untuk perbaikan.")
                ->with('status_type', 'warning');
        }
    }
}
