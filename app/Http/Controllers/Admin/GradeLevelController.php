<?php

namespace App\Http\Controllers\Admin;

use App\Models\GradeLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class GradeLevelController extends ResourceController
{
    protected string $modelClass = GradeLevel::class;
    protected string $viewPath = 'admin.grade-levels';
    protected string $routePrefix = 'admin.grade-levels';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'code'        => ['required', 'string', 'max:50', Rule::unique('grade_levels', 'code')->ignore($model?->id)],
            'name_kh'     => ['nullable', 'string', 'max:255'],
            'name_en'     => ['required', 'string', 'max:255'],
            'level_order' => ['nullable', 'integer', 'min:1'],
            'status'      => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
