<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PenggunaResource extends JsonResource
{
    /**
     * Transform the resource into an array for Flutter JSON API.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_pengguna,
            'nama_lengkap' => $this->nama_lengkap,
            'nik' => $this->nik,
            'masked_nik' => $this->masked_nik,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'masked_telepon' => $this->masked_telepon,
            'inisial' => $this->inisial,

            // Info Peran
            'peran' => [
                'id' => $this->id_peran,
                'nama' => $this->peran->nama_peran ?? 'Warga',
            ],

            // Domisili Warga
            'wilayah' => [
                'id_desa' => $this->id_desa,
                'desa' => $this->desa->nama_desa ?? null,
                'id_kecamatan' => $this->desa->kecamatan->id_kecamatan ?? null,
                'kecamatan' => $this->desa->kecamatan->nama_kecamatan ?? null,
            ],

            'terdaftar_sejak' => $this->created_at ? $this->created_at->format('d M Y') : null,
        ];
    }
}
