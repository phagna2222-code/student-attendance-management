<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
