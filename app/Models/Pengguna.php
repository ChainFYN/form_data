<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    
    protected $fillable = [
        'username',
        'email',
        'password',
        'nama_lengkap',
        'telepon',
        'id_peran',
        'id_desa'
    ];

    protected $hidden = [
        'password'
    ];

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
