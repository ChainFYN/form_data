<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanResource extends JsonResource
{
    /**
     * Transform the resource into an array for Flutter JSON API.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_laporan,
            'kode_tiket' => $this->kode_tiket,
            'deskripsi' => $this->deskripsi,
            'foto_url' => $this->foto_url,
            'tingkat_bahaya' => $this->tingkat_bahaya,
            'tingkat_bahaya_badge' => $this->tingkat_bahaya_badge,
            'waktu_lapor' => $this->time_ago,
            'tanggal' => $this->created_at ? $this->created_at->format('d M Y, H:i') : null,
            
            // Format koordinat GPS
            'koordinat' => [
                'latitude' => $this->latitude ? (float) $this->latitude : null,
                'longitude' => $this->longitude ? (float) $this->longitude : null,
            ],

            // Status Laporan
            'status' => [
                'id' => $this->id_status,
                'nama' => $this->status->nama_status ?? 'Menunggu',
                'badge' => $this->status_badge,
            ],

            // Lokasi Wilayah
            'lokasi' => [
                'id_jalan' => $this->id_jalan,
                'jalan' => $this->jalan->nama_jalan ?? '-',
                'klasifikasi_jalan' => $this->jalan->klasifikasi ?? '-',
                'desa' => $this->jalan->desa->nama_desa ?? '-',
                'kecamatan' => $this->jalan->desa->kecamatan->nama_kecamatan ?? '-',
            ],

            // Kategori Kerusakan
            'kategori' => [
                'id' => $this->id_kategori,
                'nama' => $this->kategori->nama_kategori ?? '-',
            ],

            // Info Pelapor
            'pelapor' => [
                'id' => $this->id_pengguna,
                'nama' => $this->pengguna->nama_lengkap ?? null,
                'nik_tersembunyi' => $this->pengguna->masked_nik ?? null,
            ],

            // Catatan Validasi Kecamatan (jika ada)
            'validasi' => $this->validasi ? [
                'status_valid' => (bool) $this->validasi->status_valid,
                'catatan' => $this->validasi->catatan,
                'waktu_validasi' => $this->validasi->created_at ? $this->validasi->created_at->format('d M Y, H:i') : null,
            ] : null,

            // Riwayat Log Pengerjaan PUPR (jika ada)
            'riwayat_proses' => $this->whenLoaded('logProses', function () {
                return $this->logProses->map(function ($log) {
                    return [
                        'id' => $log->id_log,
                        'status' => $log->status->nama_status ?? '-',
                        'catatan' => $log->catatan_update,
                        'foto_selesai_url' => $log->foto_selesai_url,
                        'waktu' => $log->created_at ? $log->created_at->format('d M Y, H:i') : null,
                        'time_ago' => $log->time_ago,
                    ];
                });
            }),
        ];
    }
}
