<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branches';

    protected $fillable = [
        'code', 'name_kh', 'name_en', 'phone', 'email', 'website',
        'address', 'is_main', 'status',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'branch_user')
            ->withPivot('is_default')->withTimestamps();
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function localizedName(): string
    {
        return app()->getLocale() === 'km' && $this->name_kh ? $this->name_kh : $this->name_en;
    }
}
