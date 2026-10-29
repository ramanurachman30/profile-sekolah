<?php

namespace App\Models;

use Database\Factories\CmsPageSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPageSection extends Model
{
    /** @use HasFactory<CmsPageSectionFactory> */
    use HasFactory;

    protected $table = 'cms_page_sections';

    public const CREATED_AT = null;

    public const UPDATED_AT = 'updated_at';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'page_code',
        'section_key',
        'badge_title',
        'title',
        'subtitle',
        'is_visible',
        'sort_order',
        'metadata_json',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'sort_order' => 'integer',
            'metadata_json' => 'array',
        ];
    }

    /**
     * Mengambil dictionary konfigurasi section untuk halaman tertentu.
     *
     * @return array<string, self>
     */
    public static function getSectionsForPage(string $pageCode): array
    {
        return static::where('page_code', $pageCode)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key')
            ->all();
    }
}
