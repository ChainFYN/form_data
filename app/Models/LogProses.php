<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogProses extends Model
{
    protected $table = 'log_proses';
    protected $primaryKey = 'id_log';
    protected $fillable = ['id_laporan', 'id_pengguna', 'id_status', 'catatan_update', 'url_foto_selesai'];

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