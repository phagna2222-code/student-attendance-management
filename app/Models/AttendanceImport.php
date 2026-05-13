<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceImport extends Model
{
    use HasFactory;

    protected $table = 'attendance_imports';

    protected $fillable = [
        'class_id', 'attendance_session_id', 'imported_by',
        'file_path', 'total_rows', 'success_rows', 'failed_rows',
        'errors', 'status',
    ];

    protected $casts = [
        'errors' => 'array',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(AttendanceSession::class, 'attendance_session_id');
    }

    public function importedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'imported_by');
    }
}
