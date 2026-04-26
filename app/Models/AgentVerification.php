<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class AgentVerification extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'agent_id',
        'id_front_image',
        'id_back_image',
        'selfie_image',
        'license_image',
        'additional_docs',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'additional_docs' => 'array',
            'reviewed_at' => 'datetime',
        ];
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopeByStatus($query, ?string $status)
    {
        if (! $status) {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (! $search) {
            return $query;
        }

        return $query->whereHas('agent.user', fn ($subQuery) => $subQuery
            ->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%"));
    }
}
