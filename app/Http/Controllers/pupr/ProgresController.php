<?php

namespace App\Http\Controllers\Pupr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgresController extends Controller
{
    /**
     * Data dummy sementara untuk keperluan testing UI kelompok.
     * Nantinya, ini akan diganti dengan pemanggilan Model dari database,
     * misalnya: Progres::all() atau Progres::find($id)
     */
    private $dummyData = [
        1 => [
            'id' => 1,
            'nama_jalan' => 'Jl. Raya Mayor Oking No. 42',
            'lokasi' => 'Cibinong, Kab. Bogor',
            'status' => 'SEDANG DIKERJAKAN',
            'persentase' => 75,
            'update_terakhir' => '25 Sep 2026, 16:00 WIB'
        ],
        2 => [
            'id' => 2,
            'nama_jalan' => 'Jl. Tegar Beriman (Simpang Pemda)',
            'lokasi' => 'Cibinong, Kab. Bogor',
            'status' => 'PERSIAPAN (SUB-BASE)',
            'persentase' => 15,
            'update_terakhir' => '1 Okt 2026, 09:00 WIB'
        ]
    ];

    /**
     * Menampilkan daftar semua proyek rekonstruksi
     */
    public function index()
    {
        $progresList = $this->dummyData;
        
        // Memanggil file: resources/views/pupr/progres/index.blade.php
        return view('pupr.progres.index', compact('progresList'));
    }

    /**
     * Menampilkan detail spesifik dari satu proyek (halaman UI yang kita buat)
     */
    public function show($id)
    {
        // Cek apakah data dengan ID tersebut ada
        if (!isset($this->dummyData[$id])) {
            abort(404, 'Data Progres Lapangan tidak ditemukan');
        }

        $detailProgres = $this->dummyData[$id];

        // Memanggil file: resources/views/pupr/progres/show.blade.php
        return view('pupr.progres.show', compact('detailProgres'));
    }

public function update(Request $request, $id)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'status' => 'required|string',
            'catatan' => 'required|string',
            // 'foto_lapangan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // 2. LOGIKA DATABASE TIM (Nanti diletakkan di sini)
        // Contoh:
        // $progres = Progres::findOrFail($id);
        // $progres->status = $request->status;
        // $progres->catatan = $request->catatan;
        // $progres->save();

        // 3. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Update progres berhasil disimpan dan dipublikasikan!');
    }
}