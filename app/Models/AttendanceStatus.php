<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceStatus extends Model
{
    use HasFactory;

    protected $table = 'attendance_statuses';

    protected $fillable = [
        'code', 'name_kh', 'name_en', 'color',
        'counts_as_present', 'counts_as_absent', 'requires_approval',
        'is_system', 'sort_order', 'status',
    ];

    protected $casts = [
        'counts_as_present' => 'boolean',
        'counts_as_absent' => 'boolean',
        'requires_approval' => 'boolean',
        'is_system' => 'boolean',
    ];

    public function localizedName(): string
    {
        return app()->getLocale() === 'km' && $this->name_kh ? $this->name_kh : $this->name_en;
    }
}
