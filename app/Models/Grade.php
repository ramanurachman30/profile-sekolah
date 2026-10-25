<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'mst_grades';
    public $timestamps = false;

    protected $fillable = [
        'grade_level',
        'phase_id',
        'dismissal_time',
    ];

    protected function casts(): array
    {
        return [
            'grade_level' => 'integer',
        ];
    }

    public function phase(): BelongsTo
    {
        return $this->belongsTo(CurriculumPhase::class, 'phase_id');
    }

    public function classes(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'grade_id');
    }

    public function getFormattedDismissalTimeAttribute(): string
    {
        if (empty($this->dismissal_time)) {
            return '';
        }
        return substr($this->dismissal_time, 0, 5) . ' WIB';
    }
}
