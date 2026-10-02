<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Pengguna;
use Illuminate\Http\Request;
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
            'login' => 'required',
            'password' => 'required',
        ], [
            'login.required' => 'NIK atau Email wajib diisi.',
        ]);

        $loginValue = $request->login;

        // Tentukan apakah login pakai NIK (16 digit angka) atau email
        if (preg_match('/^\d{16}$/', $loginValue)) {
            // Login sebagai Warga dengan NIK
            $user = Pengguna::where('nik', $loginValue)->first();
        } else {
            // Login sebagai Admin (Kecamatan/PUPR) dengan email
            $user = Pengguna::where('email', $loginValue)->first();
        }

        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->id_peran == 1) {
                Session::put('warga_id', $user->id_pengguna);
                Session::put('warga_name', $user->nama_lengkap);

                return redirect()->route('warga.dashboard')->with('success', 'Selamat datang Warga, '.$user->nama_lengkap);
            } elseif ($user->id_peran == 3) {
                Session::put('pupr_id', $user->id_pengguna);
                Session::put('pupr_name', $user->nama_lengkap);

                return redirect()->route('pupr.dashboard')->with('success', 'Selamat datang Admin PUPR, '.$user->nama_lengkap);
            } elseif ($user->id_peran == 2) {
                Session::put('kecamatan_id', $user->id_pengguna);
                Session::put('kecamatan_name', $user->nama_lengkap);

                return redirect()->route('kecamatan.dashboard')->with('success', 'Selamat datang Admin Kecamatan, '.$user->nama_lengkap);
            }

            return back()->withErrors(['login' => 'Role tidak sesuai dengan akun Anda.']);
        }

        return back()->withErrors(['login' => 'NIK/Email atau password salah.']);
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
            'nik' => ['required', 'digits:16', 'unique:pengguna,nik'],
            // Menggunakan regex khusus agar hanya menerima domain @gmail.com
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/', 'unique:pengguna,email', 'max:100'],
            'password' => ['required', 'min:8', 'max:12', 'confirmed'],
            'nama_lengkap' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:100'],
            'telepon' => ['required', 'digits_between:11,12'],
            'id_desa' => ['required', 'exists:desa,id_desa'],
        ], [
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar di sistem.',
            // Pesan error khusus untuk email yang bukan @gmail.com
            'email.regex' => 'Pendaftaran akun wajib menggunakan email berdomain @gmail.com.',
            'nama_lengkap.regex' => 'Nama lengkap hanya boleh berisi huruf.',
            'telepon.digits_between' => 'Nomor telepon harus berupa angka antara 12-15 digit.',
            'password.max' => 'Password tidak boleh lebih dari 12 karakter.',
        ]);

        $user = Pengguna::create([
            'nik' => $request->nik,
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
        Session::forget(['warga_id', 'warga_name', 'pupr_id', 'pupr_name', 'kecamatan_id', 'kecamatan_name']);

        return redirect()->route('warga.login')->with('success', 'Berhasil logout.');
    }
}
