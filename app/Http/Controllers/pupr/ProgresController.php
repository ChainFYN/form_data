<?php

namespace App\Http\Controllers\Pupr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;

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
        $laporan = Laporan::with(['kategori', 'jalan.desa.kecamatan', 'pengguna'])->findOrFail($id);

        return view('pupr.progres.index', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_pekerjaan_id' => 'required',
            'persentase_capaian' => 'required',
            'catatan' => 'required|string',
        ]);

        $laporan = Laporan::findOrFail($id);
        
        // Simpan log proses (draft / update)
        $logData = [
            'id_laporan' => $laporan->id_laporan,
            'id_pengguna' => session('pupr_id') ?? 1, // atau auth user id jika ada
            'id_status' => $laporan->id_status,
            'catatan_update' => "Progres " . $request->persentase_capaian . "%: " . $request->catatan,
        ];

        if ($request->hasFile('foto_progres')) {
            $path = $request->file('foto_progres')->store('log_proses', 'public');
            $logData['url_foto_selesai'] = $path;
        }

        \App\Models\LogProses::create($logData);
        
        if ($request->persentase_capaian == 100) {
            $laporan->id_status = 3; // Selesai / Menunggu Verifikasi BAST
            $laporan->save();
            return redirect()->route('pupr.dashboard')->with('success', 'Laporan diselesaikan dan dikirim ke BAST Kecamatan.');
        }

        // Jika belum 100%
        return redirect()->route('pupr.dashboard')->with('success', 'Update progres berhasil disimpan dan dipublikasikan!');
    }
}