<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attendance_records';

    protected $fillable = [
        'attendance_session_id', 'student_id', 'attendance_status_id',
        'check_in_time', 'check_out_time', 'marked_at', 'method',
        'is_late', 'late_minutes', 'teacher_note', 'admin_note',
        'marked_by', 'updated_by',
    ];

    protected $casts = [
        'is_late' => 'boolean',
        'marked_at' => 'datetime',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(AttendanceSession::class, 'attendance_session_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(AttendanceStatus::class, 'attendance_status_id');
    }
}
