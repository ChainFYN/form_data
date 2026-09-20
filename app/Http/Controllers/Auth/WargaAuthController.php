<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class WargaAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.warga.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Pengguna::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Cek role harus Warga (id_peran = 1)
            if ($user->id_peran == 1) {
                // Login manual karena tabel berbeda dari default 'users'
                Session::put('warga_id', $user->id_pengguna);
                Session::put('warga_name', $user->nama_lengkap);
                
                return redirect()->route('warga.dashboard')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
            }
            return back()->withErrors(['email' => 'Halaman ini khusus untuk Warga/Pelapor.']);
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegisterForm()
    {
        $kecamatan = Kecamatan::all();
        $desaGrouped = Desa::all()->groupBy('id_kecamatan');
        return view('auth.warga.register', compact('kecamatan', 'desaGrouped'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'alpha', 'max:10', 'unique:pengguna,username'],
            'email' => ['required', 'email', 'unique:pengguna,email', 'max:100'],
            'password' => ['required', 'min:8', 'confirmed'],
            'nama_lengkap' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:100'],
            'telepon' => ['required', 'digits_between:12,15'],
            'id_desa' => ['required', 'exists:desa,id_desa'],
        ], [
            'username.alpha' => 'Username hanya boleh berisi huruf.',
            'username.max' => 'Username maksimal 10 karakter.',
            'nama_lengkap.regex' => 'Nama lengkap hanya boleh berisi huruf.',
            'telepon.digits_between' => 'Nomor telepon harus berupa angka antara 12-15 digit.',
        ]);

        $user = Pengguna::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'telepon' => $request->telepon,
            'id_peran' => 1,
            'id_desa' => $request->id_desa,
        ]);

        Session::put('warga_id', $user->id_pengguna);
        Session::put('warga_name', $user->nama_lengkap);

        return redirect()->route('warga.dashboard')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout()
    {
        Session::forget(['warga_id', 'warga_name']);
        return redirect()->route('warga.login')->with('success', 'Berhasil logout.');
    }
}
