<?php

namespace App\Http\Controllers\Pupr;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\LogProses;
use Illuminate\Http\Request;

class ProgresController extends Controller
{
    /**
     * Menampilkan daftar semua proyek rekonstruksi
     */
    public function index()
    {
        // Redirect ke dashboard karena progres rekonstruksi memerlukan ID spesifik
        return redirect()->route('pupr.dashboard');
    }

    /**
     * Menampilkan form update progres untuk laporan tertentu
     */
    public function show($id)
    {
        if (! session()->has('pupr_id')) {
            return redirect()->route('warga.login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        $laporan = Laporan::with(['kategori', 'jalan.desa.kecamatan', 'pengguna', 'logProses.pengguna', 'timLapangan'])
            ->findOrFail($id);

        // Ambil riwayat log terakhir untuk mengetahui progress terkini
        $latestLog = $laporan->logProses()->latest()->first();

        $currentPersen = 0;
        $currentStatus = 0;
        if ($latestLog && preg_match('/Progres\s*(\d+)%/i', $latestLog->catatan_update, $matches)) {
            $currentPersen = (int) $matches[1];
            $currentStatus = match (true) {
                $currentPersen >= 100 => 4,
                $currentPersen >= 75 => 3,
                $currentPersen >= 50 => 2,
                $currentPersen >= 25 => 1,
                default => 0,
            };
        }

        return view('pupr.progres.index', compact('laporan', 'latestLog', 'currentPersen', 'currentStatus'));
    }

    public function update(Request $request, $id)
    {
        if (! session()->has('pupr_id')) {
            return redirect()->route('warga.login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        $request->validate([
            'persentase_capaian' => 'nullable|numeric|min:0|max:100',
            'status_pekerjaan_id' => 'nullable',
            'catatan' => 'nullable|string',
            'foto_progres' => 'nullable|image|max:5120',
            'metode_penanganan' => 'nullable|string|max:100',
            'volume_kerusakan' => 'nullable|string|max:100',
            'material_asphalt' => 'nullable|numeric|min:0',
            'material_emulsi' => 'nullable|numeric|min:0',
            'material_agregat' => 'nullable|numeric|min:0',
            'estimasi_anggaran' => 'nullable|string|max:50',
            'target_selesai' => 'nullable|date',
        ]);

        $laporan = Laporan::findOrFail($id);
        $persen = (int) ($request->persentase_capaian ?? 0);

        $tahapanName = match ($persen) {
            25 => 'Pengecekan Lokasi',
            50 => 'Persiapan Material & Alat',
            75 => 'Pengerjaan Fisik / Eksekusi',
            100 => 'Selesai & Publikasi Progres',
            default => 'Pengerjaan Lapangan',
        };

        // Kumpulkan rincian spesifikasi teknis jika ada
        $specDetails = [];
        if ($request->filled('metode_penanganan')) {
            $specDetails[] = 'Metode: '.$request->metode_penanganan;
        }
        if ($request->filled('volume_kerusakan')) {
            $specDetails[] = 'Volume: '.$request->volume_kerusakan;
        }

        $materials = [];
        if ($request->filled('material_asphalt') && (float) $request->material_asphalt > 0) {
            $materials[] = 'Aspal '.$request->material_asphalt.' Ton';
        }
        if ($request->filled('material_emulsi') && (float) $request->material_emulsi > 0) {
            $materials[] = 'Emulsi '.$request->material_emulsi.' L';
        }
        if ($request->filled('material_agregat') && (float) $request->material_agregat > 0) {
            $materials[] = 'Agregat '.$request->material_agregat.' M³';
        }
        if (! empty($materials)) {
            $specDetails[] = 'Material: '.implode(', ', $materials);
        }

        if ($request->filled('estimasi_anggaran')) {
            $specDetails[] = 'Anggaran: Rp '.$request->estimasi_anggaran;
        }
        if ($request->filled('target_selesai')) {
            $specDetails[] = 'Target: '.$request->target_selesai;
        }

        $catatanUpdate = 'Progres '.$persen.'% ('.$tahapanName.')';
        if ($request->filled('catatan')) {
            $catatanUpdate .= ': '.$request->catatan;
        }
        if (! empty($specDetails)) {
            $catatanUpdate .= ' | '.implode(' • ', $specDetails);
        }

        // Simpan log proses
        $logData = [
            'id_laporan' => $laporan->id_laporan,
            'id_pengguna' => session('pupr_id') ?? 2,
            'id_tim' => $laporan->id_tim,
            'id_status' => $laporan->id_status,
            'catatan_update' => $catatanUpdate,
        ];

        if ($request->hasFile('foto_progres')) {
            $path = $request->file('foto_progres')->store('log_proses', 'public');
            $logData['url_foto_selesai'] = $path;
        }

        LogProses::create($logData);

        if ($persen === 100) {
            $laporan->id_status = 2; // Tetap Diproses sampai BAST diverifikasi Camat
            $laporan->status_bast = 'MENUNGGU_VERIFIKASI';
            $laporan->save();

            return redirect()->route('pupr.dashboard')->with('success', 'Laporan telah diselesaikan 100% dan berkas dikirim ke BAST Kecamatan (Menunggu Verifikasi Camat).');
        }

        return redirect()->route('pupr.progres.show', $id)->with('success', 'Update progres '.$persen.'% berhasil disimpan dan dipublikasikan!');
    }
}
