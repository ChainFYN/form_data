<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKerusakan extends Model
{
    protected $table = 'kategori_kerusakan';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori'];

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_kategori', 'id_kategori');
    }
}