<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $table = 'school_profiles';

    protected $fillable = [
        'branch_id', 'school_name_kh', 'school_name_en',
        'logo_path', 'seal_path', 'signature_path',
        'phone', 'email', 'website', 'address',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
