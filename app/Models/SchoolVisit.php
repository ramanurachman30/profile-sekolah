<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolVisit extends Model
{
    use HasFactory;

    protected $table = 'trn_school_visits';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = null;

    protected $fillable = [
        'booking_code',
        'parent_name',
        'parent_phone',
        'visit_date',
        'visit_session',
        'attendees_count',
        'grade_interest',
        'visit_status',
        'handled_by_user_id',
        'internal_notes',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by_user_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->visit_status) {
            'menunggu' => 'Menunggu Konfirmasi',
            'dikonfirmasi' => 'Jadwal Dikonfirmasi',
            'selesai' => 'Kunjungan Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst($this->visit_status),
        };
    }
}
