<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Extracurricular extends Model
{
    use HasFactory;

    protected $table = 'mst_extracurriculars';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'badge_text',
        'schedule_info',
        'instructor_teacher_id',
        'external_coach_name',
        'description',
        'cover_asset_id',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1)->orderBy('sort_order')->orderBy('id');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'instructor_teacher_id');
    }

    public function cover(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'cover_asset_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'rel_student_extracurriculars', 'extracurricular_id', 'student_id')
                    ->withPivot('academic_year_id', 'role_note', 'joined_date');
    }
}
