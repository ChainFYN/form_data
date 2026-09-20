<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusLaporan extends Model
{
    protected $table = 'status_laporan';
    protected $primaryKey = 'id_status';
    protected $fillable = ['nama_status'];

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_status', 'id_status');
    }
}