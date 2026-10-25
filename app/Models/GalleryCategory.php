<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $table = 'mst_gallery_categories';
    public $timestamps = false;

    protected $fillable = [
        'category_name',
        'slug',
    ];

    public function galleryItems(): HasMany
    {
        return $this->hasMany(GalleryItem::class, 'category_id');
    }
}
