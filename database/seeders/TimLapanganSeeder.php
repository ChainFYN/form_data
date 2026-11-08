<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimLapanganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tim_lapangan')->insert([
            ['nama_tim' => 'Tim 1', 'jumlah_personel' => 5, 'status' => 'Tersedia', 'created_at' => now(), 'updated_at' => now()],
            ['nama_tim' => 'Tim 2', 'jumlah_personel' => 4, 'status' => 'Tersedia', 'created_at' => now(), 'updated_at' => now()],
            ['nama_tim' => 'Tim 3', 'jumlah_personel' => 6, 'status' => 'Tersedia', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
