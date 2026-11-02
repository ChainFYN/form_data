<?php

namespace Database\Seeders;

use App\Models\Pengguna;
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
        // Update atau create Kecamatan user
        $kecamatan = Pengguna::updateOrCreate(
            ['email' => 'kecamatan@gmail.com'],
            [
                'nik' => null,
                'password' => Hash::make('12345678'),
                'nama_lengkap' => 'Admin Kecamatan',
                'telepon' => '081234567890',
                'id_peran' => 2,
                'id_desa' => null,
            ]
        );

        // Update atau create PUPR user
        $pupr = Pengguna::updateOrCreate(
            ['email' => 'pupr@gmail.com'],
            [
                'nik' => null,
                'password' => Hash::make('12345678'),
                'nama_lengkap' => 'Admin PUPR',
                'telepon' => '081234567891',
                'id_peran' => 3,
                'id_desa' => null,
            ]
        );

        // Update atau create Warga user
        $warga = Pengguna::updateOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'nik' => '3515061234567890',
                'password' => Hash::make('12345678'),
                'nama_lengkap' => 'Warga Test',
                'telepon' => '081234567892',
                'id_peran' => 1,
                'id_desa' => 1,
            ]
        );

        $this->command->info('Users updated/created.');
    }
}
