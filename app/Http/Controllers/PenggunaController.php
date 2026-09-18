<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Peran;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $pengguna = Pengguna::with(['peran', 'desa'])->get();
        return view('pengguna.index', compact('pengguna'));
    }

    // Menampilkan form tambah pengguna
    public function create()
    {
        $peran = Peran::all();
        $desa = Desa::all();
        return view('pengguna.create', compact('peran', 'desa'));
    }

    // Menyimpan data pengguna baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:pengguna,username|max:50',
            'email' => 'required|email|unique:pengguna,email|max:100',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required|max:100',
            'id_peran' => 'required|exists:peran,id_peran',
            'id_desa' => 'nullable|exists:desa,id_desa',
        ]);

        Pengguna::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'telepon' => $request->telepon,
            'id_peran' => $request->id_peran,
            'id_desa' => $request->id_desa,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // Menampilkan form edit pengguna
    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $peran = Peran::all();
        $desa = Desa::all();
        return view('pengguna.edit', compact('pengguna', 'peran', 'desa'));
    }

    // Memperbarui data pengguna di database
    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        $request->validate([
            'username' => 'required|max:50|unique:pengguna,username,' . $id . ',id_pengguna',
            'email' => 'required|email|max:100|unique:pengguna,email,' . $id . ',id_pengguna',
            'nama_lengkap' => 'required|max:100',
            'id_peran' => 'required|exists:peran,id_peran',
            'id_desa' => 'nullable|exists:desa,id_desa',
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'nama_lengkap' => $request->nama_lengkap,
            'telepon' => $request->telepon,
            'id_peran' => $request->id_peran,
            'id_desa' => $request->id_desa,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
