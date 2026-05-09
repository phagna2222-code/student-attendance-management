<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudentParent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'parents';

    protected $fillable = [
        'user_id', 'parent_code', 'name_kh', 'name_en',
        'gender', 'phone', 'secondary_phone', 'email',
        'telegram_chat_id', 'address', 'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'parent_id', 'student_id')
            ->withPivot(['relationship', 'is_primary', 'can_receive_notifications', 'can_request_leave'])
            ->withTimestamps();
    }

    public function localizedName(): string
    {
        return app()->getLocale() === 'km' && $this->name_kh ? $this->name_kh : $this->name_en;
    }
}
