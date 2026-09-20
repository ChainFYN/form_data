<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desa';
    protected $primaryKey = 'id_desa';
    protected $fillable = ['id_kecamatan', 'nama_desa'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_desa', 'id_desa');
    }

    public function jalan()
    {
        return $this->hasMany(Jalan::class, 'id_desa', 'id_desa');
    }
}