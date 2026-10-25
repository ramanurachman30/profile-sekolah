<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable;

    protected $table = 'sys_users';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = null;

    protected $fillable = [
        'username',
        'password_hash',
        'full_name',
        'email',
        'role',
        'teacher_id',
        'is_active',
        'last_login',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_login' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Tentukan nama kolom password untuk otentikasi.
     */
    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    /**
     * Relasi ke data Guru di mst_teachers (opsional).
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * Helper Role Checking
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdminTu(): bool
    {
        return $this->role === 'admin_tu';
    }

    public function isGuruHumas(): bool
    {
        return $this->role === 'guru_humas';
    }

    public function isPanitiaPpdb(): bool
    {
        return $this->role === 'panitia_ppdb';
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles, true);
        }
        return $this->role === $roles;
    }

    /**
     * Filament Panel Authorization Check.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active && in_array($this->role, ['superadmin', 'admin_tu', 'guru_humas', 'panitia_ppdb']);
    }

    /**
     * Filament Display Name.
     */
    public function getFilamentName(): string
    {
        return $this->full_name;
    }

    public function getNameAttribute(): string
    {
        return $this->full_name;
    }
}
