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
        $selectedId = $request->query('ticket');

        // Laporan yang butuh verifikasi BAST oleh Camat
        $laporan_bast = Laporan::with(['jalan.desa.kecamatan', 'kategori', 'pengguna', 'logProses'])
            ->where(function ($q) {
                $q->where('status_bast', 'MENUNGGU_VERIFIKASI')
                    ->orWhere(function ($q2) {
                        $q2->where('id_status', 3)->whereNull('status_bast');
                    });
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        $activeBast = null;
        if ($selectedId) {
            $activeBast = $laporan_bast->firstWhere('id_laporan', (int) $selectedId);
        }
        if (! $activeBast && $laporan_bast->isNotEmpty()) {
            $activeBast = $laporan_bast->first();
        }

        return view('kecamatan.bast.index', compact('laporan_bast', 'activeBast'));
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
