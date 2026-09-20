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
        // Truncate existing data for clean seed
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('peran')->truncate();
        \DB::table('kecamatan')->truncate();
        \DB::table('desa')->truncate();
        \DB::table('status_laporan')->truncate();
        \DB::table('kategori_kerusakan')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Peran
        \DB::table('peran')->insert([
            ['id_peran' => 1, 'nama_peran' => 'Warga', 'created_at' => now(), 'updated_at' => now()],
            ['id_peran' => 2, 'nama_peran' => 'Kecamatan', 'created_at' => now(), 'updated_at' => now()],
            ['id_peran' => 3, 'nama_peran' => 'PUPR', 'created_at' => now(), 'updated_at' => now()],
            ['id_peran' => 4, 'nama_peran' => 'Super Admin', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Kecamatan Jember: Kaliwates, Sumbersari, Patrang
        \DB::table('kecamatan')->insert([
            ['id_kecamatan' => 1, 'nama_kecamatan' => 'Kaliwates', 'created_at' => now(), 'updated_at' => now()],
            ['id_kecamatan' => 2, 'nama_kecamatan' => 'Sumbersari', 'created_at' => now(), 'updated_at' => now()],
            ['id_kecamatan' => 3, 'nama_kecamatan' => 'Patrang', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Desa / Kelurahan Kaliwates
        $kaliwates = ['Kaliwates', 'Jember Kidul', 'Tegal Besar', 'Sempusari', 'Mangli', 'Kebon Agung', 'Kepatihan'];
        foreach ($kaliwates as $d) {
            \DB::table('desa')->insert(['id_kecamatan' => 1, 'nama_desa' => $d, 'created_at' => now(), 'updated_at' => now()]);
        }

        // Desa / Kelurahan Sumbersari
        $sumbersari = ['Sumbersari', 'Kebonsari', 'Karangrejo', 'Wirolegi', 'Tegalgede', 'Antirogo', 'Kranjingan'];
        foreach ($sumbersari as $d) {
            \DB::table('desa')->insert(['id_kecamatan' => 2, 'nama_desa' => $d, 'created_at' => now(), 'updated_at' => now()]);
        }

        // Desa / Kelurahan Patrang
        $patrang = ['Patrang', 'Jemberlor', 'Gebang', 'Banjarsengon', 'Baratan', 'Bintoro', 'Slawu', 'Jumerto'];
        foreach ($patrang as $d) {
            \DB::table('desa')->insert(['id_kecamatan' => 3, 'nama_desa' => $d, 'created_at' => now(), 'updated_at' => now()]);
        }

        // Status Laporan
        \DB::table('status_laporan')->insert([
            ['id_status' => 1, 'nama_status' => 'Menunggu Validasi', 'created_at' => now(), 'updated_at' => now()],
            ['id_status' => 2, 'nama_status' => 'Diproses PUPR', 'created_at' => now(), 'updated_at' => now()],
            ['id_status' => 3, 'nama_status' => 'Selesai', 'created_at' => now(), 'updated_at' => now()],
            ['id_status' => 4, 'nama_status' => 'Ditolak', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Kategori Kerusakan
        \DB::table('kategori_kerusakan')->insert([
            ['id_kategori' => 1, 'nama_kategori' => 'Berlubang', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 2, 'nama_kategori' => 'Bergelombang', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 3, 'nama_kategori' => 'Retak', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 4, 'nama_kategori' => 'Ambles/Longsor', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 5, 'nama_kategori' => 'Lainnya', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Jalan Sample Jember
        \DB::table('jalan')->insert([
            // Kecamatan Sumbersari (Desa ID 8-14)
            ['id_desa' => 8, 'nama_jalan' => 'Jl. Kalimantan', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 8, 'nama_jalan' => 'Jl. Jawa', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 8, 'nama_jalan' => 'Jl. Mastrip', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 8, 'nama_jalan' => 'Jl. Riau', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 8, 'nama_jalan' => 'Jl. Sumbersari', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 8, 'nama_jalan' => 'Jl. Danau Toba', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 9, 'nama_jalan' => 'Jl. Letjen Panjaitan', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 9, 'nama_jalan' => 'Jl. Letjen Suprapto', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 9, 'nama_jalan' => 'Jl. Kebonsari', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 9, 'nama_jalan' => 'Jl. Karimata', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 10, 'nama_jalan' => 'Jl. Piere Tendean', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 10, 'nama_jalan' => 'Jl. Wolter Monginsidi', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 10, 'nama_jalan' => 'Jl. Karangrejo', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 11, 'nama_jalan' => 'Jl. M.T. Haryono', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 11, 'nama_jalan' => 'Jl. Pakusari', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 11, 'nama_jalan' => 'Jl. Wirolegi', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 12, 'nama_jalan' => 'Jl. Tidar', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 12, 'nama_jalan' => 'Jl. Mastrip', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 12, 'nama_jalan' => 'Jl. Danau Toba', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 13, 'nama_jalan' => 'Jl. Ki Hajar Dewantara', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 13, 'nama_jalan' => 'Jl. Antirogo', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 13, 'nama_jalan' => 'Jl. Seruni', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 14, 'nama_jalan' => 'Jl. Gladak Pakem', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 14, 'nama_jalan' => 'Jl. Kranjingan', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 14, 'nama_jalan' => 'Jl. Sunan Drajat', 'created_at' => now(), 'updated_at' => now()],

            // Kecamatan Kaliwates (Desa ID 1-7)
            ['id_desa' => 1, 'nama_jalan' => 'Jl. Gajah Mada', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 1, 'nama_jalan' => 'Jl. Argopuro', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 1, 'nama_jalan' => 'Jl. Imam Bonjol', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 1, 'nama_jalan' => 'Jl. Melati', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 2, 'nama_jalan' => 'Jl. Hayam Wuruk', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 2, 'nama_jalan' => 'Jl. Mawar', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 2, 'nama_jalan' => 'Jl. Merak', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 2, 'nama_jalan' => 'Jl. Garuda', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 3, 'nama_jalan' => 'Jl. Basuki Rahmat', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 3, 'nama_jalan' => 'Jl. KH Yasin', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 3, 'nama_jalan' => 'Jl. Moh. Yamin', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 3, 'nama_jalan' => 'Jl. Gumuk Bago', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 4, 'nama_jalan' => 'Jl. Sultan Agung', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 4, 'nama_jalan' => 'Jl. Trunojoyo', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 4, 'nama_jalan' => 'Jl. Samanhudi', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 4, 'nama_jalan' => 'Jl. Agus Salim', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 5, 'nama_jalan' => 'Jl. Diponegoro', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 5, 'nama_jalan' => 'Jl. Pattimura', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 5, 'nama_jalan' => 'Jl. KH Siddiq', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 5, 'nama_jalan' => 'Jl. Hos Cokroaminoto', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 6, 'nama_jalan' => 'Jl. Hayam Wuruk', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 6, 'nama_jalan' => 'Jl. Otto Iskandardinata', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 6, 'nama_jalan' => 'Jl. KH Ahmad Dahlan', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 6, 'nama_jalan' => 'Jl. Rasamala', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 7, 'nama_jalan' => 'Jl. Gebang Taman', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 7, 'nama_jalan' => 'Jl. Bondoyudo', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 7, 'nama_jalan' => 'Jl. Bedadung', 'created_at' => now(), 'updated_at' => now()],

            // Kecamatan Patrang (Desa ID 15-22)
            ['id_desa' => 15, 'nama_jalan' => 'Jl. dr. Soebandi', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 15, 'nama_jalan' => 'Jl. Slamet Riyadi', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 15, 'nama_jalan' => 'Jl. Patrang', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 16, 'nama_jalan' => 'Jl. PB Sudirman', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 16, 'nama_jalan' => 'Jl. Bedadung', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 16, 'nama_jalan' => 'Jl. Anggrek', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 16, 'nama_jalan' => 'Jl. Mawar', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 17, 'nama_jalan' => 'Jl. Kenanga', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 17, 'nama_jalan' => 'Jl. Cendrawasih', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 17, 'nama_jalan' => 'Jl. Gebang Taman', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 18, 'nama_jalan' => 'Jl. Banjarsengon', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 18, 'nama_jalan' => 'Jl. Rembangan', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 19, 'nama_jalan' => 'Jl. Baratan', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 19, 'nama_jalan' => 'Jl. Dr. Soetomo', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 20, 'nama_jalan' => 'Jl. Bintoro', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 20, 'nama_jalan' => 'Jl. Danau Toba', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 21, 'nama_jalan' => 'Jl. Slawu', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 21, 'nama_jalan' => 'Jl. Tidar', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 22, 'nama_jalan' => 'Jl. Jumerto', 'created_at' => now(), 'updated_at' => now()],
            ['id_desa' => 22, 'nama_jalan' => 'Jl. Nusa Indah', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
