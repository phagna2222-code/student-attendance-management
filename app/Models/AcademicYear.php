<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'academic_years';

    protected $fillable = [
        'code', 'name', 'start_date', 'end_date',
        'is_current', 'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }
}
