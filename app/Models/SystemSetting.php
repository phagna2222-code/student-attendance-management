<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $table = 'system_settings';

    protected $fillable = [
        'group', 'key', 'value', 'value_type', 'is_public', 'updated_by',
    ];

    protected $casts = [
        'value' => 'array',
        'is_public' => 'boolean',
    ];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $row = static::query()->where('key', $key)->first();
        return $row?->value ?? $default;
    }

    public static function setValue(string $key, mixed $value, string $group = 'general', string $type = 'string'): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['group' => $group, 'value' => $value, 'value_type' => $type, 'updated_by' => auth()->id()]
        );
    }
}
