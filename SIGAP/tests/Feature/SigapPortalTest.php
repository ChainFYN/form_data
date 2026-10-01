<?php

namespace Tests\Feature;

use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SigapPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_dashboard_loads_properly(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('SIGAP');
        $response->assertSee('SIGAP');
        $response->assertSee('Halo, Admin Seksi Kecamatan Jember');
        $response->assertSee('Daftar Antrean Validasi Prioritas Tertinggi');
        $response->assertSee('ALUR SIKLUS VALIDASI KECAMATAN KE UPT DINAS PUPR');
    }

    public function test_validation_page_loads_with_tickets(): void
    {
        $response = $this->get('/validasi');
        $response->assertStatus(200);
        $response->assertSee('Pemeriksaan');
        $response->assertSee('Disposisi Aduan Warga');
        $response->assertSee('UNIT KONTROL EKBANG');
        $response->assertSee('Keputusan Verifikator Kecamatan');
        $response->assertSee('Teruskan ke PUPR');
    }

    public function test_validation_disposition_acc_updates_report(): void
    {
        $report = Report::where('status', 'menunggu_validasi')->first();
        $this->assertNotNull($report);

        $response = $this->post('/validasi/' . $report->id, [
            'action' => 'acc',
            'pupr_priority' => 'PRIORITAS 1 - DARURAT (SLA Penanganan 48 Jam)',
            'technical_estimate' => 'Penambalan Aspal Dingin/Hotmix (Patching)',
            'verifier_notes' => 'Catatan verifikasi resmi pengujian lapangan UPT Dinas PUPR.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reports', [
            'id' => $report->id,
            'status' => 'diteruskan_pupr',
            'decision' => 'acc',
        ]);
    }

    public function test_recapitulation_page_loads(): void
    {
        $response = $this->get('/rekapitulasi');
        $response->assertStatus(200);
        $response->assertSee('Rekapitulasi Progres Penanganan Jalan');
    }

    public function test_statistics_page_loads(): void
    {
        $response = $this->get('/statistik');
        $response->assertStatus(200);
        $response->assertSee('Statistik Kerusakan');
        $response->assertSee('Pemeliharaan Jalan');
    }

    public function test_master_desa_page_loads(): void
    {
        $response = $this->get('/master-desa');
        $response->assertStatus(200);
        $response->assertSee('Data Master Desa');
        $response->assertSee('Kelurahan Jember');
    }

    public function test_gis_map_page_loads(): void
    {
        $response = $this->get('/peta-gis');
        $response->assertStatus(200);
        $response->assertSee('Peta Pemetaan Titik Kerusakan Jalan');
    }

    public function test_print_bap_page_loads(): void
    {
        $report = Report::first();
        $response = $this->get('/cetak-bap/' . $report->id);
        $response->assertStatus(200);
        $response->assertSee('BERITA ACARA PEMERIKSAAN');
        $response->assertSee('PEMERINTAH KABUPATEN JEMBER');
    }

    public function test_citizen_can_submit_report(): void
    {
        $response = $this->post('/lapor-baru', [
            'road_name' => 'Jl. Tegar Beriman No. 10',
            'village' => 'Kelurahan Tengah',
            'category' => 'Kerusakan Struktur Perkerasan Jalan Kabupaten',
            'urgency' => 'tinggi',
            'description' => 'Lubang jalan sedalam 20cm dekat bundaran kantor bupati.',
            'reporter_name' => 'Bambang Tri',
            'reporter_nik' => '3201019999990001',
            'reporter_phone' => '081299998888',
            'reporter_address' => 'RT 02 / RW 01 Tengah',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reports', [
            'road_name' => 'Jl. Tegar Beriman No. 10',
            'reporter_name' => 'Bambang Tri',
        ]);
    }
}
