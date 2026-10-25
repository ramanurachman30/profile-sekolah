<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AchievementCategory extends Model
{
    use HasFactory;

    protected $table = 'mst_achievement_categories';
    public $timestamps = false;

    protected $fillable = [
        'category_name',
        'slug',
    ];

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'category_id');
    }
}
