<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'title',
        'road_name',
        'subdistrict',
        'village',
        'road_class',
        'category',
        'urgency',
        'status',
        'sla_deadline',
        'sla_text',
        'description',
        'latitude',
        'longitude',
        'gps_accuracy_m',
        'reporter_name',
        'reporter_nik',
        'reporter_phone',
        'reporter_address',
        'reporter_reputation',
        'photo_path',
        'pupr_priority',
        'technical_estimate',
        'verifier_notes',
        'verified_by_name',
        'verified_by_nip',
        'verified_by_title',
        'verified_at',
        'decision',
    ];

    protected $casts = [
        'sla_deadline' => 'datetime',
        'verified_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
        'gps_accuracy_m' => 'integer',
        'reporter_reputation' => 'integer',
    ];

    public function villageModel()
    {
        return $this->belongsTo(Village::class, 'village', 'name');
    }

    public function getUrgencyBadgeAttribute(): string
    {
        return match ($this->urgency) {
            'darurat' => 'bg-red-500 text-white',
            'tinggi' => 'bg-amber-500 text-white',
            'sedang' => 'bg-blue-600 text-white',
            'normal' => 'bg-emerald-600 text-white',
            default => 'bg-gray-600 text-white',
        };
    }

    public function getUrgencyLabelAttribute(): string
    {
        return match ($this->urgency) {
            'darurat' => 'DARURAT',
            'tinggi' => 'KURANG DARI 24 JAM',
            'sedang' => 'SEDANG',
            'normal' => 'NORMAL',
            default => strtoupper($this->urgency),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_validasi' => 'Menunggu Validasi',
            'diteruskan_pupr' => 'Diteruskan ke PUPR',
            'ditolak' => 'Ditolak',
            'selesai' => 'Selesai',
            'draf' => 'Draf Pemeriksaan',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at ? $this->created_at->diffForHumans() : 'baru saja';
    }

    public function getMaskedNikAttribute(): string
    {
        if (strlen($this->reporter_nik) >= 12) {
            return substr($this->reporter_nik, 0, 12) . '****';
        }
        return $this->reporter_nik;
    }
}
