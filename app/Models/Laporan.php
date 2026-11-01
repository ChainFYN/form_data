<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_pengguna',
        'id_jalan',
        'id_kategori',
        'id_status',
        'deskripsi',
        'latitude',
        'longitude',
        'url_foto',
        'tingkat_bahaya',
        'status_bast',
        'catatan_bast',
        'tgl_verifikasi_bast',
    ];

    /**
     * Atribut dinamis (accessor) yang otomatis disertakan saat model di-convert ke Array/JSON (API).
     */
    protected $appends = [
        'kode_tiket',
        'foto_url',
        'time_ago',
        'status_badge',
        'tingkat_bahaya_badge',
    ];

    /* =========================================================================
     * ACCESSORS
     * ========================================================================= */

    /**
     * Accessor untuk kode tiket rapi (contoh: #LP-2026-0012).
     */
    protected function kodeTiket(): Attribute
    {
        return Attribute::make(
            get: function () {
                $year = $this->created_at ? $this->created_at->format('Y') : date('Y');
                return '#LP-' . $year . '-' . str_pad($this->id_laporan, 4, '0', STR_PAD_LEFT);
            }
        );
    }

    /**
     * Accessor untuk URL foto lengkap (full URL) agar siap dipakai oleh Flutter Image.network().
     */
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->url_foto) {
                    return null;
                }
                // Jika sudah berupa URL lengkap (http/https)
                if (str_starts_with($this->url_foto, 'http://') || str_starts_with($this->url_foto, 'https://')) {
                    return $this->url_foto;
                }
                $cleanPath = ltrim($this->url_foto, '/');
                if (str_starts_with($cleanPath, 'storage/')) {
                    return asset($cleanPath);
                }
                return asset('storage/' . $cleanPath);
            }
        );
    }

    /**
     * Accessor waktu relatif manusia (contoh: '2 jam yang lalu').
     */
    protected function timeAgo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at ? $this->created_at->diffForHumans() : 'baru saja'
        );
    }

    /**
     * Accessor kelas badge warna Tailwind untuk status laporan.
     */
    protected function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match ((int) $this->id_status) {
                    1 => 'bg-amber-50 text-amber-700 border-amber-200',      // Menunggu
                    2 => 'bg-blue-50 text-blue-700 border-blue-200',        // Diproses
                    3 => 'bg-emerald-50 text-emerald-700 border-emerald-200', // Selesai
                    4 => 'bg-rose-50 text-rose-700 border-rose-200',          // Ditolak
                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                };
            }
        );
    }

    /**
     * Accessor kelas badge warna Tailwind untuk tingkat bahaya.
     */
    protected function tingkatBahayaBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match (strtolower($this->tingkat_bahaya ?? '')) {
                    'tinggi', 'berat', 'bahaya tinggi' => 'bg-rose-50 text-rose-700 border-rose-200',
                    'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                    'rendah', 'ringan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                };
            }
        );
    }

    /* =========================================================================
     * RELATIONSHIPS
     * ========================================================================= */

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function jalan()
    {
        return $this->belongsTo(Jalan::class, 'id_jalan', 'id_jalan');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriKerusakan::class, 'id_kategori', 'id_kategori');
    }

    public function status()
    {
        return $this->belongsTo(StatusLaporan::class, 'id_status', 'id_status');
    }

    public function validasi()
    {
        return $this->hasOne(Validasi::class, 'id_laporan', 'id_laporan');
    }

    public function logProses()
    {
        return $this->hasMany(LogProses::class, 'id_laporan', 'id_laporan');
    }
}
