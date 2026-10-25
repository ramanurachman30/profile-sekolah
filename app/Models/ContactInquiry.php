<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInquiry extends Model
{
    use HasFactory;

    protected $table = 'trn_contact_inquiries';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = null;

    protected $fillable = [
        'ticket_number',
        'sender_name',
        'sender_phone',
        'sender_email',
        'category',
        'subject',
        'message',
        'preferred_channel',
        'ticket_status',
        'assigned_to_teacher_id',
        'response_notes',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function assignedTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'assigned_to_teacher_id');
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'ppdb' => 'Informasi PPDB',
            'administrasi' => 'Administrasi & Surat',
            'mutasi' => 'Mutasi Siswa',
            'konsultasi' => 'Konsultasi Belajar',
            default => 'Lainnya',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->ticket_status) {
            'baru' => 'Tiket Baru',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'arsip' => 'Diarsipkan',
            default => ucfirst($this->ticket_status),
        };
    }
}
