<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsSnapshot extends Model
{
    use HasFactory;

    protected $table = 'analytics_snapshots';

    protected $fillable = [
        'branch_id', 'class_id', 'student_id',
        'snapshot_date', 'period_type',
        'total_students', 'present_count', 'absent_count', 'late_count',
        'permission_count', 'leave_count',
        'attendance_rate', 'absence_rate', 'late_rate', 'details',
    ];

    protected $casts = [
        'snapshot_date' => 'date',
        'details' => 'array',
        'attendance_rate' => 'decimal:2',
        'absence_rate' => 'decimal:2',
        'late_rate' => 'decimal:2',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
