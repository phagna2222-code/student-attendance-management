<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceEditRequest extends Model
{
    use HasFactory;

    protected $table = 'attendance_edit_requests';

    protected $fillable = [
        'attendance_record_id', 'requested_by', 'approved_by',
        'requested_status_id', 'reason', 'old_values', 'new_values',
        'status', 'approved_at', 'approval_note',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'approved_at' => 'datetime',
    ];

    public function record(): BelongsTo
    {
        return $this->belongsTo(AttendanceRecord::class, 'attendance_record_id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function requestedStatus(): BelongsTo
    {
        return $this->belongsTo(AttendanceStatus::class, 'requested_status_id');
    }
}
