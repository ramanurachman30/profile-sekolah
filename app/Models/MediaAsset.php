<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaAsset extends Model
{
    use HasFactory;

    protected $table = 'sys_media_assets';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = null;

    protected $fillable = [
        'file_path',
        'file_name',
        'file_type',
        'mime_type',
        'file_size_kb',
        'alt_text',
    ];

    protected function casts(): array
    {
        return [
            'file_size_kb' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    /**
     * URL publik untuk aset file.
     */
    public function getUrlAttribute(): string
    {
        if (empty($this->file_path)) {
            return '';
        }

        if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
            return $this->file_path;
        }

        return Storage::disk('public')->url($this->file_path);
    }
}
