<?php

namespace App\Http\Controllers\Admin;

use App\Models\AttendanceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class AttendanceStatusController extends ResourceController
{
    protected string $modelClass = AttendanceStatus::class;
    protected string $viewPath = 'admin.attendance-statuses';
    protected string $routePrefix = 'admin.attendance-statuses';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'code'                => ['required', 'string', 'max:20', Rule::unique('attendance_statuses', 'code')->ignore($model?->id)],
            'name_kh'             => ['nullable', 'string', 'max:255'],
            'name_en'             => ['required', 'string', 'max:255'],
            'color'               => ['nullable', 'string', 'max:30'],
            'counts_as_present'   => ['nullable', 'boolean'],
            'counts_as_absent'    => ['nullable', 'boolean'],
            'requires_approval'   => ['nullable', 'boolean'],
            'sort_order'          => ['nullable', 'integer', 'min:0'],
            'status'              => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
