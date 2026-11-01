<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class LogProses extends Model
{
    protected $table = 'log_proses';

    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_laporan',
        'id_pengguna',
        'id_status',
        'catatan_update',
        'url_foto_selesai',
    ];

    protected $appends = [
        'foto_selesai_url',
        'time_ago',
    ];

    /**
     * Accessor untuk URL foto selesai.
     */
    protected function fotoSelesaiUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->url_foto_selesai) {
                    return null;
                }
                if (str_starts_with($this->url_foto_selesai, 'http://') || str_starts_with($this->url_foto_selesai, 'https://')) {
                    return $this->url_foto_selesai;
                }
                return url('storage/' . $this->url_foto_selesai);
            }
        );
    }

    /**
     * Accessor waktu update log.
     */
    protected function timeAgo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at ? $this->created_at->diffForHumans() : 'baru saja'
        );
    }

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function status()
    {
        return $this->belongsTo(StatusLaporan::class, 'id_status', 'id_status');
    }
}
