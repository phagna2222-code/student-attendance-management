<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportExport extends Model
{
    use HasFactory;

    protected $table = 'report_exports';

    protected $fillable = [
        'generated_report_id', 'format', 'file_path', 'exported_by', 'exported_at',
    ];

    protected $casts = [
        'exported_at' => 'datetime',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(GeneratedReport::class, 'generated_report_id');
    }
}
