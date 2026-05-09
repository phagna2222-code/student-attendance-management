<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    use HasFactory;

    protected $table = 'grade_levels';

    protected $fillable = ['code', 'name_kh', 'name_en', 'level_order', 'status'];

    public function localizedName(): string
    {
        return app()->getLocale() === 'km' && $this->name_kh ? $this->name_kh : $this->name_en;
    }
}
