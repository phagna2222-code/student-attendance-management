<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GeneratedReport extends Model
{
    use HasFactory;

    protected $table = 'generated_reports';

    protected $fillable = [
        'report_no', 'report_type', 'branch_id', 'class_id', 'student_id',
        'teacher_id', 'subject_id', 'date_from', 'date_to',
        'filters', 'summary', 'generated_by', 'generated_at',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
        'filters' => 'array',
        'summary' => 'array',
        'generated_at' => 'datetime',
    ];

    public function exports(): HasMany
    {
        return $this->hasMany(ReportExport::class);
    }
}
