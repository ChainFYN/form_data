<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PenggunaResource;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
        * Login untuk Flutter (Mengembalikan Bearer Token)
        */
       public function login(Request $request)
       {
           $request->validate([
               'login'    => 'required|string', // Bisa NIK (16 digit) atau Email
               'password' => 'required|string',
           ]);

           $loginValue = $request->login;

           // Cek login via NIK atau Email
           if (preg_match('/^\d{16}$/', $loginValue)) {
               $user = Pengguna::where('nik', $loginValue)->first();
           } else {
               $user = Pengguna::where('email', $loginValue)->first();
           }

           // Cek kecocokan password
           if (!$user || !Hash::check($request->password, $user->password)) {
               return response()->json([
                   'success' => false,
                   'message' => 'NIK / Email atau Password salah.',
               ], 401);
           }

           // Buat Token Sanctum khusus untuk Flutter
           $token = $user->createToken('flutter-mobile-app')->plainTextToken;

           return response()->json([
               'success' => true,
               'message' => 'Login berhasil!',
               'token'   => $token,
               'data'    => new PenggunaResource($user->load('desa.kecamatan', 'peran')),
           ], 200);
       }

       /**
        * Register Warga Baru dari Flutter
        */
       public function register(Request $request)
       {
           $request->validate([
               'nik'          => ['required', 'digits:16', 'unique:pengguna,nik'],
               'email'        => ['required', 'email', 'unique:pengguna,email', 'max:100'],
               'password'     => ['required', 'min:8', 'confirmed'],
               'nama_lengkap' => ['required', 'string', 'max:100'],
               'telepon'      => ['required', 'digits_between:10,15'],
               'id_desa'      => ['required', 'exists:desa,id_desa'],
           ]);

           $user = Pengguna::create([
               'nik'          => $request->nik,
               'email'        => $request->email,
               'password'     => Hash::make($request->password),
               'nama_lengkap' => $request->nama_lengkap,
               'telepon'      => $request->telepon,
               'id_peran'     => 1, // Otomatis Warga
               'id_desa'      => $request->id_desa,
           ]);

           // Langsung berikan token setelah registrasi sukses
           $token = $user->createToken('flutter-mobile-app')->plainTextToken;

           return response()->json([
               'success' => true,
               'message' => 'Registrasi akun berhasil!',
               'token'   => $token,
               'data'    => new PenggunaResource($user->load('desa.kecamatan', 'peran')),
           ], 201);
       }

       /**
        * Ambil Data Profil User yang Sedang Login
        */
       public function me(Request $request)
       {
           $user = $request->user()->load('desa.kecamatan', 'peran');

           return response()->json([
               'success' => true,
               'message' => 'Profil berhasil dimuat.',
               'data'    => new PenggunaResource($user),
           ], 200);
       }

       /**
        * Logout (Hapus Token Aktif)
        */
       public function logout(Request $request)
       {
           // Hapus token yang sedang digunakan request ini
           $request->user()->currentAccessToken()->delete();

           return response()->json([
               'success' => true,
               'message' => 'Logout berhasil, token telah dicabut.',
           ], 200);
       }
}
