<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'students';

    protected $fillable = [
        'user_id', 'branch_id', 'current_class_id', 'academic_year_id', 'shift_id',
        'student_code', 'student_no', 'name_kh', 'name_en',
        'gender', 'date_of_birth', 'phone', 'address', 'photo_path',
        'qr_code_value', 'qr_code_path', 'barcode_value', 'rfid_uid',
        'status', 'admission_date', 'exit_date',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
        'exit_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function currentClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'current_class_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(StudentParent::class, 'parent_student', 'student_id', 'parent_id')
            ->withPivot(['relationship', 'is_primary', 'can_receive_notifications', 'can_request_leave'])
            ->withTimestamps();
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_students', 'student_id', 'class_id')
            ->withPivot(['enrolled_at', 'left_at', 'status'])
            ->withTimestamps();
    }

    public function documents(): HasMany
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function localizedName(): string
    {
        return app()->getLocale() === 'km' && $this->name_kh ? $this->name_kh : $this->name_en;
    }
}
