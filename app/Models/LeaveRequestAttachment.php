<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequestAttachment extends Model
{
    use HasFactory;

    protected $table = 'leave_request_attachments';

    protected $fillable = [
        'leave_request_id', 'uploaded_by',
        'file_path', 'original_name', 'mime_type', 'file_size',
    ];

    public function leaveRequest(): BelongsTo
    {
        return $this->belongsTo(LeaveRequest::class);
    }
}
