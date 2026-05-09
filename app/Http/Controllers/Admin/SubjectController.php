<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class SubjectController extends ResourceController
{
    protected string $modelClass = Subject::class;
    protected string $viewPath = 'admin.subjects';
    protected string $routePrefix = 'admin.subjects';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'code'        => ['required', 'string', 'max:50', Rule::unique('subjects', 'code')->ignore($model?->id)],
            'name_kh'     => ['nullable', 'string', 'max:255'],
            'name_en'     => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
