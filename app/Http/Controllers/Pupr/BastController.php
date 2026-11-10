<?php

namespace App\Http\Controllers\Pupr;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\TimLapangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BastController extends Controller
{
    public function index()
    {
        $laporan = Laporan::with(['jalan.desa.kecamatan', 'timLapangan', 'pengguna'])
            ->where('status_bast', 'MENUNGGU_VERIFIKASI')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pupr.bast.index', compact('laporan'));
    }

    public function generatePdf($id)
    {
        $laporan = Laporan::with(['jalan.desa.kecamatan', 'timLapangan', 'pengguna', 'logProses'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('pupr.bast.pdf', compact('laporan'));

        return $pdf->download('BAST_Laporan_' . $laporan->id_laporan . '.pdf');
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'no_bast' => 'required|max:50',
            'url_pdf_bast' => 'required|file|mimes:pdf|max:10240',
        ]);

        $laporan = Laporan::findOrFail($id);

        $pdfPath = $request->file('url_pdf_bast')->store('bast', 'public');

        $laporan->update([
            'no_bast' => $request->no_bast,
            'status_bast' => 'MENUNGGU_VERIFIKASI',
            'url_pdf_bast' => $pdfPath,
        ]);

        return redirect()->route('pupr.bast.index')->with('success', 'BAST berhasil dibuat dan dikirim ke Kecamatan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_bast' => 'required|in:DITOLAK,DITERIMA',
            'catatan_revisi' => 'nullable|string',
        ]);

        $laporan = Laporan::findOrFail($id);

        if ($request->status_bast == 'DITERIMA') {
            // Update status laporan menjadi Selesai
            $laporan->update([
                'id_status' => 3, // Selesai
                'status_bast' => 'DITERIMA',
            ]);

            // Update tim menjadi Tersedia
            if ($laporan->timLapangan) {
                $laporan->timLapangan->update(['status' => 'Tersedia']);
            }
        } else {
            // Update status BAST ke DITOLAK dan kembalikan status laporan ke diproses
            $laporan->update([
                'status_bast' => 'DITOLAK',
                'catatan_revisi' => $request->catatan_revisi,
            ]);
        }

        return redirect()->route('pupr.bast.index')->with('success', 'Status BAST berhasil diupdate!');
    }
}
