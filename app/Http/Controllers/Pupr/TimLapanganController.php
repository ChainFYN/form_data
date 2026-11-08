<?php

namespace App\Http\Controllers\PUPR;

use App\Http\Controllers\Controller;
use App\Models\TimLapangan;
use App\Models\Laporan;
use Illuminate\Http\Request;

class TimLapanganController extends Controller
{
    public function index()
    {
        $timLapangan = TimLapangan::withCount('laporan')->get();
        $timTersedia = TimLapangan::where('status', 'Tersedia')->count();
        $timDiLapangan = TimLapangan::where('status', 'Di Lapangan')->count();
        
        return view('pupr.tim-lapangan.index', compact('timLapangan', 'timTersedia', 'timDiLapangan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Tersedia,Di Lapangan,Standby',
        ]);

        $tim = TimLapangan::findOrFail($id);
        $tim->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status tim berhasil diupdate.');
    }

    public function updatePersonel(Request $request, $id)
    {
        $request->validate([
            'jumlah_personel' => 'required|integer|min:1',
        ]);

        $tim = TimLapangan::findOrFail($id);
        $tim->update([
            'jumlah_personel' => $request->jumlah_personel,
        ]);

        return back()->with('success', 'Jumlah personel berhasil diupdate.');
    }
}
