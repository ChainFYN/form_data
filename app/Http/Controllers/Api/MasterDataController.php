<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Desa;
use App\Models\Jalan;
use App\Models\KategoriKerusakan;
use App\Models\Kecamatan;

class MasterDataController extends Controller
{
    /**
        * List Kategori Kerusakan Jalan
        */
       public function kategori()
       {
           $kategori = KategoriKerusakan::select('id_kategori', 'nama_kategori')->get();

           return response()->json([
               'success' => true,
               'message' => 'Daftar kategori kerusakan jalan',
               'data'    => $kategori,
           ], 200);
       }

       /**
        * List Seluruh Kecamatan
        */
       public function kecamatan()
       {
           $kecamatan = Kecamatan::select('id_kecamatan', 'nama_kecamatan')->get();

           return response()->json([
               'success' => true,
               'message' => 'Daftar kecamatan',
               'data'    => $kecamatan,
           ], 200);
       }

       /**
        * List Desa (Bisa difilter berdasarkan ?id_kecamatan=X)
        */
       public function desa(Request $request)
       {
           $query = Desa::select('id_desa', 'id_kecamatan', 'nama_desa');

           if ($request->filled('id_kecamatan')) {
               $query->where('id_kecamatan', $request->id_kecamatan);
           }

           return response()->json([
               'success' => true,
               'message' => 'Daftar desa/kelurahan',
               'data'    => $query->get(),
           ], 200);
       }

       /**
        * List Ruas Jalan (Bisa difilter berdasarkan ?id_desa=X)
        */
       public function jalan(Request $request)
       {
           $query = Jalan::select('id_jalan', 'id_desa', 'nama_jalan', 'klasifikasi');

           if ($request->filled('id_desa')) {
               $query->where('id_desa', $request->id_desa);
           }

           return response()->json([
               'success' => true,
               'message' => 'Daftar ruas jalan',
               'data'    => $query->get(),
           ], 200);
       }
}
