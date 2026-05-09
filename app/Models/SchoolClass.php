<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SchoolClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'school_classes';

    protected $fillable = [
        'branch_id', 'grade_level_id', 'academic_year_id', 'term_id',
        'shift_id', 'room_id', 'class_teacher_id',
        'code', 'name', 'student_limit', 'status',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function gradeLevel(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function classTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'class_students', 'class_id', 'student_id')
            ->withPivot(['enrolled_at', 'left_at', 'status'])
            ->withTimestamps();
    }

    public function attendanceSettings(): HasOne
    {
        return $this->hasOne(ClassAttendanceSetting::class, 'class_id');
    }

    public function teacherSubjects(): HasMany
    {
        return $this->hasMany(ClassTeacherSubject::class, 'class_id');
    }

    public function timetables(): HasMany
    {
        return $this->hasMany(Timetable::class, 'class_id');
    }

    public function attendanceSessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class, 'class_id');
    }
}
