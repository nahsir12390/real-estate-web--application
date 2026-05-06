<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    public const TYPE_HOUSE = 'house';
    public const TYPE_APARTMENT = 'apartment';
    public const TYPE_LAND = 'land';

    public const PROPERTY_TYPES = [
        self::TYPE_HOUSE => 'House',
        self::TYPE_APARTMENT => 'Apartment',
        self::TYPE_LAND => 'Land',
    ];

    public const LISTING_SALE = 'sale';
    public const LISTING_RENT = 'rent';

    public const LISTING_TYPES = [
        self::LISTING_SALE => 'For Sale',
        self::LISTING_RENT => 'For Rent',
    ];

    public const PRICE_UNITS = [
        'total' => 'Total Price',
        'per_month' => 'Per Month',
        'per_year' => 'Per Year',
    ];

    public const AREA_UNITS = [
        'sqm' => 'Square Meters',
        'sqft' => 'Square Feet',
    ];

    public const TYPE_DETAIL_FIELDS = [
        self::TYPE_HOUSE => ['bedrooms', 'bathrooms', 'garages', 'area', 'year_built', 'amenities'],
        self::TYPE_APARTMENT => ['bedrooms', 'bathrooms', 'area', 'year_built', 'amenities'],
        self::TYPE_LAND => ['area', 'amenities'],
    ];

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_SOLD = 'sold';
    public const STATUS_RENTED = 'rented';

    public const QUOTA_COUNTED_STATUSES = ['draft', 'pending', 'approved'];

    protected $fillable = [
        'agent_id',
        'title',
        'slug',
        'description',
        'short_description',
        'property_type',
        'listing_type',
        'price',
        'price_unit',
        'area',
        'area_unit',
        'bedrooms',
        'bathrooms',
        'garages',
        'year_built',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'latitude',
        'longitude',
        'amenities',
        'status',
        'is_featured',
        'is_premium',
        'views',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'area' => 'decimal:2',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'amenities' => 'array',
            'is_featured' => 'boolean',
            'is_premium' => 'boolean',
            'approved_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(PropertyImage::class)->where('is_primary', true);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PropertyComment::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeCountedInQuota($query)
    {
        return $query->whereIn('status', self::QUOTA_COUNTED_STATUSES);
    }

    public function scopeByStatus($query, ?string $status)
    {
        if (! $status) {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function scopeByType($query, ?string $type)
    {
        if (! $type) {
            return $query;
        }

        return $query->where('property_type', $type);
    }

    public function scopeByListingType($query, ?string $listingType)
    {
        if (! $listingType) {
            return $query;
        }

        return $query->where('listing_type', $listingType);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (! $search) {
            return $query;
        }

        return $query->where('title', 'like', "%{$search}%");
    }

    public static function detailFieldsForType(?string $type): array
    {
        return self::TYPE_DETAIL_FIELDS[$type] ?? self::TYPE_DETAIL_FIELDS[self::TYPE_HOUSE];
    }

    public static function supportsDetailField(?string $type, string $field): bool
    {
        return in_array($field, self::detailFieldsForType($type), true);
    }
}
