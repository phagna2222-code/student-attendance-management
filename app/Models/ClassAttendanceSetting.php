<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassAttendanceSetting extends Model
{
    use HasFactory;

    protected $table = 'class_attendance_settings';

    protected $fillable = [
        'class_id', 'study_days',
        'check_in_start_time', 'check_in_end_time', 'check_out_time',
        'late_grace_minutes',
        'allow_manual_attendance', 'allow_qr_attendance',
        'allow_barcode_attendance', 'allow_rfid_attendance',
        'auto_mark_absent',
    ];

    protected $casts = [
        'study_days' => 'array',
        'allow_manual_attendance' => 'boolean',
        'allow_qr_attendance' => 'boolean',
        'allow_barcode_attendance' => 'boolean',
        'allow_rfid_attendance' => 'boolean',
        'auto_mark_absent' => 'boolean',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
