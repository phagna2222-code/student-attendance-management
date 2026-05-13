<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotificationTemplate extends Model
{
    use HasFactory;

    protected $table = 'notification_templates';

    protected $fillable = [
        'code', 'name', 'channel', 'subject', 'body', 'variables', 'status',
    ];

    protected $casts = [
        'variables' => 'array',
    ];

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'template_id');
    }
}
