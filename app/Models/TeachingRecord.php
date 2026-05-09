<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeachingRecord extends Model
{
    use HasFactory;

    protected $table = 'teaching_records';

    protected $fillable = [
        'attendance_session_id', 'class_id', 'subject_id', 'teacher_id',
        'teaching_date', 'lesson_title', 'lesson_content', 'homework',
        'notes', 'attendance_summary',
    ];

    protected $casts = [
        'teaching_date' => 'date',
        'attendance_summary' => 'array',
    ];

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
}
