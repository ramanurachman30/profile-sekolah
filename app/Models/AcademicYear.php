<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use HasFactory;

    protected $table = 'mst_academic_years';
    public $timestamps = false;

    protected $fillable = [
        'year_code',
        'semester',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'semester' => 'integer',
            'is_active' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'academic_year_id');
    }

    public function ppdbPeriods(): HasMany
    {
        return $this->hasMany(PpdbPeriod::class, 'academic_year_id');
    }

    public function getSemesterNameAttribute(): string
    {
        return $this->semester === 1 ? 'Ganjil' : 'Genap';
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->year_code} - {$this->semester_name}";
    }
}
