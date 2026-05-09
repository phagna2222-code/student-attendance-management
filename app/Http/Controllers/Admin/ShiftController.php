<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class ShiftController extends ResourceController
{
    protected string $modelClass = Shift::class;
    protected string $viewPath = 'admin.shifts';
    protected string $routePrefix = 'admin.shifts';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'code'       => ['required', 'string', 'max:50', Rule::unique('shifts', 'code')->ignore($model?->id)],
            'name'       => ['required', 'string', 'max:255'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time'   => ['nullable', 'date_format:H:i'],
            'status'     => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
