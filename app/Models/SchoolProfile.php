<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $table = 'mst_school_profile';

    public const CREATED_AT = null;
    public const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'npsn',
        'school_name',
        'school_level',
        'accreditation',
        'headmaster_name',
        'headmaster_nip',
        'phone',
        'whatsapp',
        'email',
        'address',
        'sub_district',
        'district',
        'postal_code',
        'vision',
        'mission',
        'history_summary',
        'logo_asset_id',
    ];

    public function logo(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'logo_asset_id');
    }
}
