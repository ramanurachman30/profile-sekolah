<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facility extends Model
{
    use HasFactory;

    protected $table = 'mst_facilities';
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'facility_code',
        'name',
        'capacity',
        'condition_status',
        'description',
        'cover_asset_id',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FacilityCategory::class, 'category_id');
    }

    public function cover(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'cover_asset_id');
    }

    public function getConditionLabelAttribute(): string
    {
        return match ($this->condition_status) {
            'sangat_baik' => 'Sangat Baik',
            'baik' => 'Baik',
            'pemeliharaan' => 'Dalam Pemeliharaan',
            default => ucfirst($this->condition_status),
        };
    }
}
