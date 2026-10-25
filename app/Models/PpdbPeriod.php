<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PpdbPeriod extends Model
{
    use HasFactory;

    protected $table = 'trn_ppdb_periods';
    public $timestamps = false;

    protected $fillable = [
        'academic_year_id',
        'wave_name',
        'start_date',
        'end_date',
        'target_quota',
        'is_open',
    ];

    protected function casts(): array
    {
        return [
            'target_quota' => 'integer',
            'is_open' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('is_open', 1);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(PpdbRegistration::class, 'period_id');
    }

    public function getAcceptedCountAttribute(): int
    {
        return $this->registrations()->where('verification_status', 'diterima')->count();
    }

    public function getRemainingQuotaAttribute(): int
    {
        return max(0, $this->target_quota - $this->accepted_count);
    }
}
