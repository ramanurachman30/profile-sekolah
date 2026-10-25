<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'mst_teachers';
    public $timestamps = false;

    protected $fillable = [
        'nip',
        'full_name',
        'gender',
        'education',
        'role_title',
        'consultation_hours',
        'motto',
        'phone',
        'email',
        'photo_asset_id',
        'sort_order',
        'is_active',
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

    public function photo(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'photo_asset_id');
    }

    public function homeroomClasses(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'homeroom_teacher_id');
    }

    public function extracurriculars(): HasMany
    {
        return $this->hasMany(Extracurricular::class, 'instructor_teacher_id');
    }

    public function mentoredAchievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'mentor_teacher_id');
    }

    public function userAccount(): HasOne
    {
        return $this->hasOne(User::class, 'teacher_id');
    }
}
