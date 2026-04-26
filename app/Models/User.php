<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    public const ROLE_USER = 'user';
    public const ROLE_AGENT = 'agent';
    public const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function agent(): HasOne
    {
        return $this->hasOne(Agent::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteProperties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'favorites')->withTimestamps();
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function propertyComments(): HasMany
    {
        return $this->hasMany(PropertyComment::class);
    }

    public function customNotifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function reviewedAgentVerifications(): HasMany
    {
        return $this->hasMany(AgentVerification::class, 'reviewed_by');
    }

    public function approvedProperties(): HasMany
    {
        return $this->hasMany(Property::class, 'approved_by');
    }

    public function resolvedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'resolved_by');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(Auditlog::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAgent(): bool
    {
        return $this->role === self::ROLE_AGENT;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, ?string $role)
    {
        if (! $role) {
            return $query;
        }

        return $query->where('role', $role);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (! $search) {
            return $query;
        }

        return $query->where(function ($subQuery) use ($search) {
            $subQuery->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
