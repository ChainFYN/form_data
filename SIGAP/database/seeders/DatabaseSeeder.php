<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Village;
use App\Models\Report;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@jember.jemberkab.go.id'],
            [
                'name' => 'Drs. Bambang Suherman',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Villages / Kelurahan in Kecamatan Jember
        $villagesData = [
            ['name' => 'Desa Sukamaju', 'type' => 'Desa', 'head_of_village' => 'H. Mulyadi, S.AP', 'phone' => '021-8751234', 'coverage_km' => 14.5, 'active_reports_count' => 12, 'resolved_reports_count' => 18],
            ['name' => 'Kelurahan Cirimekar', 'type' => 'Kelurahan', 'head_of_village' => 'Dedi Iskandar, S.STP', 'phone' => '021-8755678', 'coverage_km' => 10.2, 'active_reports_count' => 8, 'resolved_reports_count' => 15],
            ['name' => 'Kelurahan Tengah', 'type' => 'Kelurahan', 'head_of_village' => 'Iwan Setiawan, S.Sos', 'phone' => '021-8759901', 'coverage_km' => 8.7, 'active_reports_count' => 5, 'resolved_reports_count' => 11],
            ['name' => 'Kelurahan Pakansari', 'type' => 'Kelurahan', 'head_of_village' => 'Agus Ramdhan, M.Si', 'phone' => '021-8762233', 'coverage_km' => 12.0, 'active_reports_count' => 2, 'resolved_reports_count' => 9],
            ['name' => 'Kelurahan Pabuaran', 'type' => 'Kelurahan', 'head_of_village' => 'Rahmat Hidayat, S.IP', 'phone' => '021-8764455', 'coverage_km' => 7.8, 'active_reports_count' => 3, 'resolved_reports_count' => 7],
            ['name' => 'Kelurahan Nanggewer', 'type' => 'Kelurahan', 'head_of_village' => 'Dra. Siti Aminah', 'phone' => '021-8767788', 'coverage_km' => 9.4, 'active_reports_count' => 1, 'resolved_reports_count' => 6],
        ];

        foreach ($villagesData as $v) {
            Village::updateOrCreate(['name' => $v['name']], $v);
        }

        // Realistic Road Damage Photos
        $imgPothole = 'https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&w=800&q=80';
        $imgLandslide = 'https://images.unsplash.com/photo-1578844251758-2f71da64c96f?auto=format&fit=crop&w=800&q=80';
        $imgDrainage = 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80';
        $imgCracks = 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=800&q=80';
        $imgRoad1 = 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?auto=format&fit=crop&w=800&q=80';

        // Core Reports matching Figma
        $reports = [
            [
                'ticket_number' => 'LP-2026-0842',
                'title' => 'Jl. Raya Cikaret KM 2 - Longsor Tebing Samping Ruas',
                'road_name' => 'Jl. Raya Cikaret KM 2',
                'subdistrict' => 'Kecamatan jember',
                'village' => 'Kelurahan Cirimekar',
                'road_class' => 'Ruas Utama jember',
                'category' => 'Kerusakan Struktur Perkerasan Jalan Kabupaten',
                'urgency' => 'darurat',
                'status' => 'menunggu_validasi',
                'sla_deadline' => Carbon::now()->addHours(2),
                'sla_text' => 'Sisa Waktu 2 Jam',
                'description' => 'Muntahan tanah dan bebatuan menutup separuh badan jalan kabupaten. Arus kendaraan padat tersendat. Butuh alat berat dan barikade beton pembatas agar tidak timbul korban jiwa.',
                'latitude' => -6.489100,
                'longitude' => 106.841900,
                'gps_accuracy_m' => 12,
                'reporter_name' => 'Fitri Tarigan',
                'reporter_nik' => '3201015609940001',
                'reporter_phone' => '0813-8891-2309',
                'reporter_address' => 'RT 02 / RW 05 Cikaret, jember',
                'reporter_reputation' => 96,
                'photo_path' => $imgLandslide,
                'pupr_priority' => 'PRIORITAS 1 - DARURAT (SLA Penanganan 48 Jam)',
                'technical_estimate' => 'Pembersihan Material Longsor / Alat Berat',
                'verifier_notes' => 'Laporan sangat kritis. Tebing tergerus hujan lebat. Diperlukan penanganan alat berat loader UPT Jalan Wilayah jember dalam kurun 24 jam.',
                'verified_by_name' => 'Hendra Wijaya, S.Sos',
                'verified_by_nip' => '19790623 200501 1 004',
                'verified_by_title' => 'Kasi Ekbang Kec. jember',
                'created_at' => Carbon::now()->subMinutes(15),
            ],
            [
                'ticket_number' => 'LP-2026-0841',
                'title' => 'Jl. Raya Mayor Oking No. 42 (Desa Sukamaju)',
                'road_name' => 'Jl. Raya Mayor Oking No. 42',
                'subdistrict' => 'Kecamatan jember',
                'village' => 'Desa Sukamaju',
                'road_class' => 'Ruas Utama jember',
                'category' => 'Kerusakan Struktur Perkerasan Jalan Kabupaten',
                'urgency' => 'tinggi',
                'status' => 'menunggu_validasi',
                'sla_deadline' => Carbon::now()->addHours(5),
                'sla_text' => 'Batas Waktu: 5 Jam',
                'description' => 'Lubang jalan diameter sekitar 70cm kedalaman 15cm di lajur kiri. Membahayakan pengendara sepeda motor terutama saat hujan tergenang air tidak terlihat di malam hari. Sudah terjadi 2 kali korban terjatuh.',
                'latitude' => -6.481500,
                'longitude' => 106.852200,
                'gps_accuracy_m' => 12,
                'reporter_name' => 'Ahmad Pratama',
                'reporter_nik' => '3201012304910003',
                'reporter_phone' => '0812-1234-xxxx',
                'reporter_address' => 'RT 04 / RW 02 Cirimekar',
                'reporter_reputation' => 94,
                'photo_path' => $imgPothole,
                'pupr_priority' => 'PRIORITAS 1 - DARURAT (SLA Penanganan 48 Jam)',
                'technical_estimate' => 'Penambalan Aspal Dingin/Hotmix (Patching)',
                'verifier_notes' => 'Laporan valid. Titik koordinat sesuai dengan ruas jalan kabupaten kelas 3B. Prioritas penambalan aspal hotmix darurat untuk mencegah korban kecelakaan lalu lintas lanjutan UPTD.',
                'verified_by_name' => 'Hendra Wijaya, S.Sos',
                'verified_by_nip' => '19790623 200501 1 004',
                'verified_by_title' => 'Kasi Ekbang Kec. jember',
                'created_at' => Carbon::now()->subMinutes(40),
            ],
            [
                'ticket_number' => 'LP-2026-0839',
                'title' => 'Jl. Flamboyan Gang 3 (Kelurahan Cirimekar)',
                'road_name' => 'Jl. Flamboyan Gang 3 (Pabuaran)',
                'subdistrict' => 'Kecamatan jember',
                'village' => 'Kelurahan Cirimekar',
                'road_class' => 'Kolektor Primer',
                'category' => 'Saluran Drainase Rusak & Genangan',
                'urgency' => 'sedang',
                'status' => 'menunggu_validasi',
                'sla_deadline' => Carbon::now()->addHours(10),
                'sla_text' => 'SLA Sisa 10 Jam',
                'description' => 'Saluran drainase tersumbat menyebabkan genangan dan aspal terkelupas membahayakan pengendara roda dua terutama saat malam hari.',
                'latitude' => -6.479000,
                'longitude' => 106.837500,
                'gps_accuracy_m' => 14,
                'reporter_name' => 'Siti Nurhaliza',
                'reporter_nik' => '3201016503950002',
                'reporter_phone' => '0857-1122-3344',
                'reporter_address' => 'RT 01 / RW 03 Pabuaran, jember',
                'reporter_reputation' => 91,
                'photo_path' => $imgDrainage,
                'pupr_priority' => 'PRIORITAS 3 - SEDANG (SLA Penanganan 14 Hari)',
                'technical_estimate' => 'Perbaikan Saluran Drainase & Gorong-gorong',
                'verifier_notes' => 'Drainase air limbah meluap mengikis sub-base jalan. Butuh pengerukan sedimen dan normalisasi saluran.',
                'verified_by_name' => 'Hendra Wijaya, S.Sos',
                'verified_by_nip' => '19790623 200501 1 004',
                'verified_by_title' => 'Kasi Ekbang Kec. jember',
                'created_at' => Carbon::now()->subHours(2),
            ],
            [
                'ticket_number' => 'LP-2026-0836',
                'title' => 'Jl. KSR Dadi Kusmayadi (Kelurahan Tengah)',
                'road_name' => 'Jl. KSR Dadi Kusmayadi',
                'subdistrict' => 'Kecamatan jember',
                'village' => 'Kelurahan Tengah',
                'road_class' => 'Jalan Lingkungan',
                'category' => 'Retak Buaya (Alligator Crack)',
                'urgency' => 'normal',
                'status' => 'menunggu_validasi',
                'sla_deadline' => Carbon::now()->addHours(17),
                'sla_text' => 'SLA Sisa 17 Jam',
                'description' => 'Retak buaya (alligator crack) sepanjang 40 meter memanjang di kedua lajur. Berpotensi berkembang menjadi lubang besar saat curah hujan tinggi.',
                'latitude' => -6.495000,
                'longitude' => 106.828000,
                'gps_accuracy_m' => 10,
                'reporter_name' => 'Hendri Setiawan',
                'reporter_nik' => '3201011208880004',
                'reporter_phone' => '0819-3344-5566',
                'reporter_address' => 'RT 03 / RW 01 Kelurahan Tengah',
                'reporter_reputation' => 88,
                'photo_path' => $imgCracks,
                'pupr_priority' => 'PRIORITAS 4 - RUTIN/PEMELIHARAAN BERKALA',
                'technical_estimate' => 'Rekonstruksi Badan Jalan / Overlay',
                'verifier_notes' => 'Perkerasan jalan mengalami fatigue cracking akibat beban kendaraan berat. Dijadwalkan pemeliharaan berkala.',
                'verified_by_name' => 'Hendra Wijaya, S.Sos',
                'verified_by_nip' => '19790623 200501 1 004',
                'verified_by_title' => 'Kasi Ekbang Kec. jember',
                'created_at' => Carbon::now()->subHours(4),
            ],
            // Additional pending / validated reports
            [
                'ticket_number' => 'LP-2026-0835',
                'title' => 'Jl. Gor Pakansari Pintu Barat',
                'road_name' => 'Jl. Kolonel Edy Yoso Martadipura',
                'subdistrict' => 'Kecamatan jember',
                'village' => 'Kelurahan Pakansari',
                'road_class' => 'Ruas Utama jember',
                'category' => 'Kerusakan Struktur Perkerasan Jalan Kabupaten',
                'urgency' => 'sedang',
                'status' => 'menunggu_validasi',
                'sla_deadline' => Carbon::now()->addHours(12),
                'sla_text' => 'SLA Sisa 12 Jam',
                'description' => 'Amblas pada sambungan jembatan saluran air dekat pintu masuk barat stadion Pakansari.',
                'latitude' => -6.491200,
                'longitude' => 106.833500,
                'gps_accuracy_m' => 8,
                'reporter_name' => 'Budi Santoso',
                'reporter_nik' => '3201011504900005',
                'reporter_phone' => '0878-9988-7766',
                'reporter_address' => 'Pakansari RT 01/RW 04',
                'reporter_reputation' => 92,
                'photo_path' => $imgRoad1,
                'pupr_priority' => 'PRIORITAS 2 - TINGGI (SLA Penanganan 5 Hari)',
                'technical_estimate' => 'Rekonstruksi Badan Jalan / Overlay',
                'created_at' => Carbon::now()->subHours(6),
            ],
            [
                'ticket_number' => 'LP-2026-0834',
                'title' => 'Jl. Nanggewer Mekar Dekat SMPN 2',
                'road_name' => 'Jl. Nanggewer Mekar',
                'subdistrict' => 'Kecamatan jember',
                'village' => 'Kelurahan Nanggewer',
                'road_class' => 'Jalan Lingkungan',
                'category' => 'Kerusakan Struktur Perkerasan Jalan Kabupaten',
                'urgency' => 'normal',
                'status' => 'menunggu_validasi',
                'sla_deadline' => Carbon::now()->addHours(20),
                'sla_text' => 'SLA Sisa 20 Jam',
                'description' => 'Aspal mengelupas dan batu kerikil berhamburan mengganggu akses anak sekolah.',
                'latitude' => -6.502000,
                'longitude' => 106.845000,
                'gps_accuracy_m' => 15,
                'reporter_name' => 'Dewi Lestari',
                'reporter_nik' => '3201014506920007',
                'reporter_phone' => '0812-4455-6677',
                'reporter_address' => 'Nanggewer RT 03/RW 02',
                'reporter_reputation' => 89,
                'photo_path' => $imgPothole,
                'pupr_priority' => 'PRIORITAS 4 - RUTIN/PEMELIHARAAN BERKALA',
                'technical_estimate' => 'Penambalan Aspal Dingin/Hotmix (Patching)',
                'created_at' => Carbon::now()->subHours(7),
            ],
        ];

        // Seed core reports
        foreach ($reports as $r) {
            Report::updateOrCreate(['ticket_number' => $r['ticket_number']], $r);
        }

        // Seed 42 forwarded/verified reports to match KPI (42 Aduan Selesai/Terverifikasi Diteruskan)
        for ($i = 1; $i <= 42; $i++) {
            $num = str_pad(830 - $i, 4, '0', STR_PAD_LEFT);
            Report::firstOrCreate(
                ['ticket_number' => "LP-2026-{$num}"],
                [
                    'title' => "Penanganan Perkerasan Ruas Sukamaju-jember #{$i}",
                    'road_name' => 'Ruas Jl. Raya Sukamaju No. ' . ($i * 2),
                    'subdistrict' => 'Kecamatan jember',
                    'village' => 'Desa Sukamaju',
                    'road_class' => 'Kolektor Primer',
                    'category' => 'Kerusakan Struktur Perkerasan Jalan Kabupaten',
                    'urgency' => 'tinggi',
                    'status' => 'diteruskan_pupr',
                    'decision' => 'acc',
                    'description' => 'Laporan telah diverifikasi secara administratif dan faktual oleh tim Kecamatan dan diteruskan ke UPT PUPR.',
                    'latitude' => -6.480000 + ($i * 0.0005),
                    'longitude' => 106.840000 + ($i * 0.0004),
                    'gps_accuracy_m' => 10,
                    'reporter_name' => 'Warga jember ' . $i,
                    'reporter_nik' => '320101' . str_pad($i, 10, '0', STR_PAD_LEFT),
                    'reporter_phone' => '0812-0000-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'reporter_address' => 'Kecamatan jember',
                    'reporter_reputation' => 95,
                    'photo_path' => $imgPothole,
                    'pupr_priority' => 'PRIORITAS 1 - DARURAT (SLA Penanganan 48 Jam)',
                    'technical_estimate' => 'Penambalan Aspal Dingin/Hotmix (Patching)',
                    'verifier_notes' => 'Disposisi resmi ACC diteruskan ke Dinas PUPR Kab. Jember.',
                    'verified_by_name' => 'Hendra Wijaya, S.Sos',
                    'verified_by_nip' => '19790623 200501 1 004',
                    'verified_by_title' => 'Kasi Ekbang Kec. jember',
                    'verified_at' => Carbon::now()->subDays(rand(1, 6)),
                    'created_at' => Carbon::now()->subDays(rand(2, 7)),
                ]
            );
        }

        // Seed 5 rejected reports to match KPI (5 Ditolak)
        for ($j = 1; $j <= 5; $j++) {
            $num = str_pad(780 - $j, 4, '0', STR_PAD_LEFT);
            Report::firstOrCreate(
                ['ticket_number' => "LP-2026-{$num}"],
                [
                    'title' => "Pengaduan Jalan Desa Non-Kewenangan Kabupaten #{$j}",
                    'road_name' => 'Gang Pribadi Warga No. ' . $j,
                    'subdistrict' => 'Kecamatan jember',
                    'village' => 'Kelurahan Cirimekar',
                    'road_class' => 'Non-Status',
                    'category' => 'Kerusakan Struktur Perkerasan Jalan Kabupaten',
                    'urgency' => 'normal',
                    'status' => 'ditolak',
                    'decision' => 'reject',
                    'description' => 'Laporan ditolak setelah diverifikasi: Ruas jalan merupakan lahan kavling pribadi / bukan aset jalan kabupaten.',
                    'latitude' => -6.485000,
                    'longitude' => 106.845000,
                    'gps_accuracy_m' => 18,
                    'reporter_name' => 'Pelapor ' . $j,
                    'reporter_nik' => '320101990000000' . $j,
                    'reporter_phone' => '0813-1111-222' . $j,
                    'reporter_address' => 'Cirimekar',
                    'reporter_reputation' => 70,
                    'photo_path' => $imgRoad1,
                    'verifier_notes' => 'Ditolak: Ruas jalan bukan merupakan kewenangan Kabupaten Jember, melainkan jalan swadaya perumahan/pribadi.',
                    'verified_by_name' => 'Hendra Wijaya, S.Sos',
                    'verified_by_nip' => '19790623 200501 1 004',
                    'verified_by_title' => 'Kasi Ekbang Kec. jember',
                    'verified_at' => Carbon::now()->subDays(rand(1, 4)),
                    'created_at' => Carbon::now()->subDays(rand(2, 5)),
                ]
            );
        }
    }
}
