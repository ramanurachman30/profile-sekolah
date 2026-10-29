<?php

namespace App\Models;

use Database\Factories\CmsBannerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsBanner extends Model
{
    /** @use HasFactory<CmsBannerFactory> */
    use HasFactory;

    protected $table = 'cms_banners';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'placement',
        'badge_text',
        'title',
        'subtitle',
        'cta_primary_text',
        'cta_primary_url',
        'cta_secondary_text',
        'cta_secondary_url',
        'media_asset_id',
        'start_date',
        'end_date',
        'sort_order',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    /**
     * Relasi ke file background/gambar banner di MediaAsset.
     */
    public function mediaAsset(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'media_asset_id');
    }

    /**
     * Scope untuk mengambil banner aktif berdasarkan lokasi penempatan.
     */
    public function scopeActiveFor(Builder $query, string $placement): Builder
    {
        return $query->where('is_active', true)
            ->where('placement', $placement)
            ->where(function (Builder $q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function (Builder $q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->orderBy('sort_order');
    }
}
