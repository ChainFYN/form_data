<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Pengguna extends Model
{
    use HasApiTokens;

    protected $table = 'pengguna';

    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'nik',
        'email',
        'password',
        'nama_lengkap',
        'telepon',
        'id_peran',
        'id_desa',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Atribut dinamis (accessor) yang otomatis disertakan saat model di-convert ke Array/JSON (API).
     */
    protected $appends = [
        'masked_nik',
        'inisial',
    ];

    /* =========================================================================
     * ACCESSORS
     * ========================================================================= */

    /**
     * Accessor untuk menyamarkan NIK demi privasi (contoh: 32012345****7890).
     */
    protected function maskedNik(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->nik) {
                    return null;
                }
                $len = strlen($this->nik);
                if ($len >= 12) {
                    return substr($this->nik, 0, 8) . '****' . substr($this->nik, -4);
                }
                return $this->nik;
            }
        );
    }

    /**
     * Accessor untuk menyamarkan nomor telepon (contoh: 0812****890).
     */
    protected function maskedTelepon(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->telepon) {
                    return null;
                }
                $len = strlen($this->telepon);
                if ($len >= 8) {
                    return substr($this->telepon, 0, 4) . '****' . substr($this->telepon, -3);
                }
                return $this->telepon;
            }
        );
    }

    /**
     * Accessor untuk inisial nama pelapor (contoh: "Ahmad Dahlan" -> "AD").
     */
    protected function inisial(): Attribute
    {
        return Attribute::make(
            get: function () {
                $words = preg_split('/\s+/', trim($this->nama_lengkap ?? ''));
                $initials = '';
                foreach (array_slice($words, 0, 2) as $w) {
                    $initials .= strtoupper(substr($w, 0, 1));
                }
                return $initials ?: 'U';
            }
        );
    }

    /* =========================================================================
     * RELATIONSHIPS
     * ========================================================================= */

    // Relasi ke Peran
    public function peran()
    {
        return $this->belongsTo(Peran::class, 'id_peran', 'id_peran');
    }

    // Relasi ke Desa
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id_desa');
    }

    // Relasi ke Laporan (warga yang membuat laporan)
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_pengguna', 'id_pengguna');
    }

    // Relasi ke Validasi (admin kecamatan yang validasi)
    public function validasi()
    {
        return $this->hasMany(Validasi::class, 'id_pengguna', 'id_pengguna');
    }

    // Relasi ke LogProses (petugas PUPR yang update progress)
    public function logProses()
    {
        return $this->hasMany(LogProses::class, 'id_pengguna', 'id_pengguna');
    }
}
