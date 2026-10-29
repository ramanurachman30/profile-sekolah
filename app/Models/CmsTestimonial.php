<?php

namespace App\Models;

use Database\Factories\CmsTestimonialFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsTestimonial extends Model
{
    /** @use HasFactory<CmsTestimonialFactory> */
    use HasFactory;

    protected $table = 'cms_testimonials';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'person_name',
        'person_category',
        'role_title',
        'testimonial_text',
        'rating',
        'avatar_asset_id',
        'placement',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Relasi ke foto avatar di MediaAsset.
     */
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'avatar_asset_id');
    }

    /**
     * Scope untuk mengambil testimoni aktif berdasarkan target halaman/placement.
     */
    public function scopeForPlacement(Builder $query, string $placement): Builder
    {
        return $query->where('is_active', true)
            ->where(function (Builder $q) use ($placement) {
                $q->where('placement', 'all')->orWhere('placement', $placement);
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order');
    }
}
