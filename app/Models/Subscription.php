<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_PENDING = 'pending';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_EXPIRED = 'expired';

    protected $fillable = [
        'agent_id',
        'plan_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'stripe_price_id',
        'stripe_status',
        'interval',
        'amount',
        'listing_limit',
        'used_listings',
        'starts_at',
        'ends_at',
        'trial_ends_at',
        'canceled_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'starts_at' => 'date',
            'ends_at' => 'date',
            'trial_ends_at' => 'date',
            'canceled_at' => 'datetime',
        ];
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)->whereDate('ends_at', '>=', now()->toDateString());
    }

    public function scopeByStatus($query, ?string $status)
    {
        if (! $status) {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function getRemainingListingsAttribute(): int
    {
        return max(0, $this->listing_limit - $this->used_listings);
    }
}
