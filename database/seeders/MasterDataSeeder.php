<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Peran
        \DB::table('peran')->insert([
            ['nama_peran' => 'Warga', 'created_at' => now(), 'updated_at' => now()],
            ['nama_peran' => 'Kecamatan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_peran' => 'PUPR', 'created_at' => now(), 'updated_at' => now()],
            ['nama_peran' => 'Super Admin', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Kecamatan
        \DB::table('kecamatan')->insert([
            ['nama_kecamatan' => 'Kecamatan Sukajadi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kecamatan' => 'Kecamatan Cibiru', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Desa
        \DB::table('desa')->insert([
            ['id_kecamatan' => 1, 'nama_desa' => 'Desa Mekar Jaya', 'created_at' => now(), 'updated_at' => now()],
            ['id_kecamatan' => 1, 'nama_desa' => 'Desa Suka Makmur', 'created_at' => now(), 'updated_at' => now()],
            ['id_kecamatan' => 2, 'nama_desa' => 'Desa Cibiru Wetan', 'created_at' => now(), 'updated_at' => now()],
            ['id_kecamatan' => 2, 'nama_desa' => 'Desa Cibiru Kulon', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Status Laporan
        \DB::table('status_laporan')->insert([
            ['nama_status' => 'Menunggu Validasi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'Diproses PUPR', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'Selesai', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'Ditolak', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Kategori Kerusakan
        \DB::table('kategori_kerusakan')->insert([
            ['nama_kategori' => 'Lubang', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Retak', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Ambles', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Bergelombang', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Lainnya', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
