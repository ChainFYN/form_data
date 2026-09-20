<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Jalan;
use App\Models\KategoriKerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LaporanController extends Controller
{
    public function index()
    {
        $wargaId = Session::get('warga_id');
        $laporan = Laporan::with(['jalan.desa', 'kategori', 'status'])
            ->where('id_pengguna', $wargaId)
            ->latest()
            ->get();

        return view('warga.laporan.index', compact('laporan'));
    }

    public function create()
    {
        $kecamatan = Kecamatan::all();
        $desaGrouped = Desa::all()->groupBy('id_kecamatan');
        $jalanGrouped = Jalan::all()->groupBy('id_desa');
        $kategori = KategoriKerusakan::all();

        return view('warga.laporan.create', compact('kecamatan', 'desaGrouped', 'jalanGrouped', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jalan' => 'required|exists:jalan,id_jalan',
            'id_kategori' => 'required|exists:kategori_kerusakan,id_kategori',
            'tingkat_bahaya' => 'required|in:Rendah,Sedang,Bahaya Tinggi',
            'deskripsi' => 'required|min:10',
            'foto' => 'required|image|max:5120',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        Laporan::create([
            'id_pengguna' => Session::get('warga_id'),
            'id_jalan' => $request->id_jalan,
            'id_kategori' => $request->id_kategori,
            'tingkat_bahaya' => $request->tingkat_bahaya,
            'id_status' => 1, // Menunggu Validasi
            'deskripsi' => $request->deskripsi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'url_foto' => $fotoPath,
        ]);

        return redirect()->route('warga.laporan.index')->with('success', 'Laporan berhasil dikirim!');
    }

    public function show($id)
    {
        $wargaId = Session::get('warga_id');
        $laporan = Laporan::with(['jalan.desa.kecamatan', 'kategori', 'status', 'validasi', 'logProses.status'])
            ->where('id_pengguna', $wargaId)
            ->findOrFail($id);

        return view('warga.laporan.show', compact('laporan'));
    }
}
