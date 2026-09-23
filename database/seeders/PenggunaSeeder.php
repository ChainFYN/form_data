<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan peran yang dibutuhkan ada
        $idPeranKecamatan = DB::table('peran')->where('nama_peran', 'Kecamatan')->value('id_peran')
            ?? DB::table('peran')->insertGetId([
                'nama_peran' => 'Kecamatan',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        $idPeranPUPR = DB::table('peran')->where('nama_peran', 'PUPR')->value('id_peran')
            ?? DB::table('peran')->insertGetId([
                'nama_peran' => 'PUPR',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        // Ambil satu desa yang sudah ada (id_desa nullable, jadi boleh null kalau belum ada)
        $idDesa = DB::table('desa')->value('id_desa');

        DB::table('pengguna')->insert([
            [
                'username'     => 'camat',
                'email'        => 'camat@example.com',
                'password'     => Hash::make('password123'),
                'nama_lengkap' => 'Administrator Kecamatan',
                'telepon'      => '081234567890',
                'id_peran'     => $idPeranKecamatan,
                'id_desa'      => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'username'     => 'pupr',
                'email'        => 'pupr@example.com',
                'password'     => Hash::make('password123'),
                'nama_lengkap' => 'Operator PUPR',
                'telepon'      => '081234567891',
                'id_peran'     => $idPeranPUPR,
                'id_desa'      => $idDesa,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}