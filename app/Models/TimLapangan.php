<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimLapangan extends Model
{
    protected $table = 'tim_lapangan';
    protected $primaryKey = 'id_tim';

    protected $fillable = [
        'nama_tim',
        'jumlah_personel',
        'status',
        'id_kecamatan',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_tim', 'id_tim');
    }

    public function logProses()
    {
        return $this->hasMany(LogProses::class, 'id_tim', 'id_tim');
    }
}
