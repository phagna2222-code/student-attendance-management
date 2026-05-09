<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'teachers';

    protected $fillable = [
        'user_id', 'branch_id', 'teacher_code',
        'name_kh', 'name_en', 'gender', 'date_of_birth',
        'phone', 'email', 'address', 'photo_path', 'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'class_teacher_id');
    }

    public function classTeacherSubjects(): HasMany
    {
        return $this->hasMany(ClassTeacherSubject::class);
    }

    public function localizedName(): string
    {
        return app()->getLocale() === 'km' && $this->name_kh ? $this->name_kh : $this->name_en;
    }
}
