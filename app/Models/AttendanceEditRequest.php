<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
