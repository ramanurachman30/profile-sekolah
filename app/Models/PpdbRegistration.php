<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpdbRegistration extends Model
{
    use HasFactory;

    protected $table = 'trn_ppdb_registrations';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = null;

    protected $fillable = [
        'period_id',
        'registration_number',
        'track',
        'child_full_name',
        'child_nik',
        'child_gender',
        'child_birth_place',
        'child_birth_date',
        'child_age_years',
        'child_age_months',
        'parent_name',
        'parent_nik',
        'parent_phone',
        'parent_email',
        'parent_occupation',
        'home_address',
        'distance_meters',
        'document_kk_asset_id',
        'document_akta_asset_id',
        'document_kia_asset_id',
        'verification_status',
        'verified_by_user_id',
        'verified_at',
        'rejection_reason',
        'enrolled_student_id',
    ];

    protected function casts(): array
    {
        return [
            'child_birth_date' => 'date',
            'child_age_years' => 'integer',
            'child_age_months' => 'integer',
            'distance_meters' => 'integer',
            'verified_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(PpdbPeriod::class, 'period_id');
    }

    public function documentKk(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'document_kk_asset_id');
    }

    public function documentAkta(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'document_akta_asset_id');
    }

    public function documentKia(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'document_kia_asset_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by_user_id');
    }

    public function enrolledStudent(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'enrolled_student_id');
    }

    public function getTrackLabelAttribute(): string
    {
        return match ($this->track) {
            'zonasi' => 'Zonasi',
            'afirmasi' => 'Afirmasi (Keluarga Prasejahtera)',
            'perpindahan_ortu' => 'Perpindahan Tugas Orang Tua',
            'reguler' => 'Reguler / Umum',
            default => ucfirst($this->track),
        };
    }

    public function getVerificationStatusLabelAttribute(): string
    {
        return match ($this->verification_status) {
            'menunggu' => 'Menunggu Verifikasi',
            'diverifikasi' => 'Sedang Diverifikasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => ucfirst($this->verification_status),
        };
    }
}
