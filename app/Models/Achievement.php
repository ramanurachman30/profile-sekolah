<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    use HasFactory;

    protected $table = 'trn_achievements';
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'academic_year_id',
        'achievement_title',
        'competition_name',
        'level',
        'ranking_position',
        'competition_date',
        'mentor_teacher_id',
        'parent_rep_name',
        'recipient_summary',
        'description',
        'photo_asset_id',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'competition_date' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', 1);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AchievementCategory::class, 'category_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function mentorTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'mentor_teacher_id');
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'photo_asset_id');
    }

    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'rel_achievement_recipients', 'achievement_id', 'student_id');
    }
}
