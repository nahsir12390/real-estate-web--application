<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'user_id',
        'property_id',
        'agent_id',
        'name',
        'email',
        'phone',
        'message',
        'agent_reply',
        'preferred_contact',
        'status',
        'admin_notes',
        'responded_at',
        'agent_replied_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
            'agent_replied_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function scopeByStatus($query, ?string $status)
    {
        if (! $status) {
            return $query;
        }

        return $query->where('status', $status);
    }
}
