<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'notification_logs';

    protected $fillable = [
        'notification_id', 'provider', 'provider_message_id',
        'request_payload', 'response_payload', 'status', 'error_message',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
    ];

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}
