<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CurriculumPhase extends Model
{
    use HasFactory;

    protected $table = 'mst_curriculum_phases';
    public $timestamps = false;

    protected $fillable = [
        'phase_code',
        'grades_coverage',
        'focus_description',
    ];

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'phase_id');
    }
}
