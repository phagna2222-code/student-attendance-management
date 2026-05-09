<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendanceSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attendance_sessions';

    protected $fillable = [
        'branch_id', 'class_id', 'subject_id', 'teacher_id', 'timetable_id',
        'academic_year_id', 'term_id', 'attendance_date',
        'session_type', 'period_no', 'start_time', 'end_time',
        'submission_status', 'created_by', 'submitted_by', 'submitted_at',
        'locked_by', 'locked_at', 'note',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'submitted_at' => 'datetime',
        'locked_at' => 'datetime',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
