<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    
    protected $fillable = [
        'id_pengguna', 'id_jalan', 'id_kategori', 'id_status', 
        'deskripsi', 'latitude', 'longitude', 'url_foto', 'tingkat_bahaya'
    ];

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