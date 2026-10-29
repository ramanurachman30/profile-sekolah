<?php

namespace App\Models;

use Database\Factories\CmsAnnouncementFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsAnnouncement extends Model
{
    /** @use HasFactory<CmsAnnouncementFactory> */
    use HasFactory;

    protected $table = 'cms_announcements';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
        'announcement_type',
        'placement_target',
        'cta_text',
        'cta_url',
        'start_date',
        'end_date',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    /**
     * Scope untuk mengambil pengumuman yang sedang aktif berdasarkan rentang tanggal.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->latest('created_at');
    }

    /**
     * Scope untuk mengambil pengumuman aktif untuk penempatan tertentu.
     */
    public function scopeForPlacement(Builder $query, string $placement): Builder
    {
        return $this->scopeActive($query)
            ->where(function (Builder $q) use ($placement) {
                $q->where('placement_target', 'global_topbar')
                    ->orWhere('placement_target', $placement);
            });
    }
}
