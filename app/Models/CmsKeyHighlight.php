<?php

namespace App\Models;

use Database\Factories\CmsKeyHighlightFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsKeyHighlight extends Model
{
    /** @use HasFactory<CmsKeyHighlightFactory> */
    use HasFactory;

    protected $table = 'cms_key_highlights';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'placement_target',
        'icon_name',
        'metric_value',
        'title',
        'description',
        'badge_color',
        'link_url',
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
        ];
    }

    /**
     * Scope untuk mengambil highlight aktif berdasarkan placement target.
     */
    public function scopeForTarget(Builder $query, string $target): Builder
    {
        return $query->where('is_active', true)
            ->where('placement_target', $target)
            ->orderBy('sort_order');
    }

    /**
     * Alias scope untuk konsistensi antar model CMS reusable.
     */
    public function scopeForPlacement(Builder $query, string $placement): Builder
    {
        return $this->scopeForTarget($query, $placement);
    }
}
