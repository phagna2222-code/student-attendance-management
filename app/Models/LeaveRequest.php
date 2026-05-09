<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'leave_requests';

    protected $fillable = [
        'request_no', 'student_id', 'requested_by', 'approved_by',
        'start_date', 'end_date', 'total_days', 'leave_type',
        'reason', 'status', 'submitted_at', 'approved_at', 'reject_reason',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'total_days' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(LeaveRequestAttachment::class);
    }
}
