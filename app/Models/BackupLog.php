<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupLog extends Model
{
    use HasFactory;

    protected $table = 'backup_logs';

    protected $fillable = [
        'type', 'destination', 'file_path', 'file_size',
        'status', 'requested_by', 'started_at', 'finished_at', 'message',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}
