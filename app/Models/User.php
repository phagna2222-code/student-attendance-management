<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'branch_id', 'name', 'username', 'email', 'phone',
        'password', 'avatar_path', 'user_type', 'status',
        'email_verified_at', 'last_login_at', 'last_login_ip',
        'failed_login_attempts', 'locked_until',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'branch_user')
            ->withPivot('is_default')->withTimestamps();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function studentParent(): HasOne
    {
        return $this->hasOne(StudentParent::class, 'user_id');
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    public function hasUserType(string|array $types): bool
    {
        $types = is_array($types) ? $types : [$types];
        return in_array($this->user_type, $types, true);
    }

    public function isSuperAdmin(): bool
    {
        return $this->user_type === 'super_admin' || $this->hasRole('super-admin');
    }
}
