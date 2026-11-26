<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'is_active',
        'account_status',
        'account_review_note',
        'account_reviewed_at',
        'email_otp_hash',
        'email_otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_otp_hash',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'account_reviewed_at' => 'datetime',
            'email_otp_expires_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /** Send a branded, Indonesian password reset email with the named reset route. */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // Relations
    public function umkmProfiles(): HasMany
    {
        return $this->hasMany(UmkmProfile::class);
    }

    public function umkmProfile(): HasOne
    {
        return $this->hasOne(UmkmProfile::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    // Helpers
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isUmkmOwner(): bool
    {
        return $this->hasRole('umkm_owner');
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0B5ED7&color=fff';
    }
}
