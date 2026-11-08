<?php

namespace App\Http\Controllers\PUPR;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\TimLapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::with(['kategori', 'jalan.desa.kecamatan', 'timLapangan', 'logProses.timLapangan'])
            ->whereNotNull('id_tim')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pupr.laporan.index', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = Laporan::with(['kategori', 'jalan.desa.kecamatan', 'pengguna', 'timLapangan', 'logProses.timLapangan', 'validasi'])
            ->findOrFail($id);

        $timTersedia = TimLapangan::where('status', 'Tersedia')->get();

        return view('pupr.laporan.show', compact('laporan', 'timTersedia'));
    }

    public function updateProgress(Request $request, $id)
    {
        $request->validate([
            'id_tim' => 'required|exists:tim_lapangan,id_tim',
            'catatan_update' => 'required|min:10',
            'foto_progress' => 'nullable|image|max:5120',
        ]);

        $laporan = Laporan::findOrFail($id);
        $tim = TimLapangan::findOrFail($request->id_tim);

        // Update status tim menjadi "Di Lapangan"
        $tim->update(['status' => 'Di Lapangan']);

        // Update laporan
        $laporan->update(['id_tim' => $request->id_tim]);

        // Upload foto progress
        $fotoPath = null;
        if ($request->hasFile('foto_progress')) {
            $fotoPath = $request->file('foto_progress')->store('laporan-progress', 'public');
        }

        // Tambah log progress
        \DB::table('log_proses')->insert([
            'id_laporan' => $id,
            'id_pengguna' => session('pupr_id'),
            'id_tim' => $request->id_tim,
            'id_status' => 2,
            'catatan_update' => $request->catatan_update,
            'url_foto_selesai' => $fotoPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Progress berhasil disimpan!');
    }

    public function selesaiBast(Request $request, $id)
    {
        $request->validate([
            'no_bast' => 'required|max:50',
            'url_pdf_bast' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $laporan = Laporan::findOrFail($id);
        $tim = TimLapangan::findOrFail($request->id_tim);

        // Upload PDF BAST
        $pdfPath = $request->file('url_pdf_bast')->store('bast', 'public');

        // Update laporan dengan data BAST
        $laporan->update([
            'no_bast' => $request->no_bast,
            'status_bast' => 'MENUNGGU_VERIFIKASI',
            'url_pdf_bast' => $pdfPath,
        ]);

        return redirect()->route('pupr.laporan.show', $id)->with('success', 'BAST berhasil dibuat dan dikirim ke Kecamatan untuk diverifikasi!');
    }
}
