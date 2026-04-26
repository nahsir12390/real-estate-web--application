<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'company_name',
        'nin',
        'license_number',
        'experience_years',
        'specialization',
        'verification_status',
        'verified_at',
        'rejection_reason',
        'total_listings',
        'active_listings',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(AgentVerification::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->where('status', Subscription::STATUS_ACTIVE)
            ->whereDate('ends_at', '>=', now()->toDateString())
            ->latestOfMany('ends_at');
    }

    public function isVerified(): bool
    {
        return $this->verification_status === self::STATUS_VERIFIED;
    }

    public function scopeByVerificationStatus($query, ?string $status)
    {
        if (! $status) {
            return $query;
        }

        return $query->where('verification_status', $status);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (! $search) {
            return $query;
        }

        return $query->whereHas('user', fn ($subQuery) => $subQuery
            ->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%"));
    }

    public function scopeVerified($query)
    {
        return $query->where('verification_status', self::STATUS_VERIFIED);
    }
}
