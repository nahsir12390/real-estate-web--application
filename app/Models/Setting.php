<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    public function castedValue(): mixed
    {
        return match ($this->type) {
            'integer' => (int) $this->value,
            'boolean' => in_array((string) $this->value, ['1', 'true', 'on'], true),
            'json', 'array' => $this->value ? json_decode($this->value, true) : [],
            default => $this->value,
        };
    }

    public static function value(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting:{$key}", now()->addHours(6), function () use ($key, $default) {
            $setting = self::query()->where('key', $key)->first();

            return $setting ? $setting->castedValue() : $default;
        });
    }

    protected static function booted(): void
    {
        static::saved(fn (self $setting) => Cache::forget("setting:{$setting->key}"));
        static::deleted(fn (self $setting) => Cache::forget("setting:{$setting->key}"));
    }
}
