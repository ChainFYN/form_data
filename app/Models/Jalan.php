<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{
    protected $table = 'jalan';
    protected $primaryKey = 'id_jalan';
    protected $fillable = ['id_desa', 'nama_jalan', 'klasifikasi'];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id_desa');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_jalan', 'id_jalan');
    }
}