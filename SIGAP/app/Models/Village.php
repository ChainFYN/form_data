<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'head_of_village',
        'phone',
        'coverage_km',
        'active_reports_count',
        'resolved_reports_count',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class, 'village', 'name');
    }
}
