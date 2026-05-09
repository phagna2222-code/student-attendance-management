<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'template_id', 'student_id', 'parent_id', 'class_id', 'created_by',
        'type', 'channel', 'recipient_name', 'recipient_contact',
        'subject', 'message', 'payload', 'status',
        'scheduled_at', 'sent_at', 'read_at', 'failure_reason',
    ];

    protected $casts = [
        'payload' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class, 'template_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(NotificationLog::class);
    }
}
