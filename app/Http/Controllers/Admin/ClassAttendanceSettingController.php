<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClassAttendanceSetting;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassAttendanceSettingController extends ResourceController
{
    protected string $modelClass = ClassAttendanceSetting::class;
    protected string $viewPath = 'admin.class-attendance-settings';
    protected string $routePrefix = 'admin.class-attendance-settings';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'class_id'                => ['required', 'exists:school_classes,id', Rule::unique('class_attendance_settings', 'class_id')->ignore($model?->id)],
            'study_days'              => ['nullable', 'array'],
            'study_days.*'            => ['integer', 'min:0', 'max:6'],
            'check_in_start_time'     => ['nullable', 'date_format:H:i'],
            'check_in_end_time'       => ['nullable', 'date_format:H:i'],
            'check_out_time'          => ['nullable', 'date_format:H:i'],
            'late_grace_minutes'      => ['nullable', 'integer', 'min:0'],
            'allow_manual_attendance' => ['nullable', 'boolean'],
            'allow_qr_attendance'     => ['nullable', 'boolean'],
            'allow_barcode_attendance'=> ['nullable', 'boolean'],
            'allow_rfid_attendance'   => ['nullable', 'boolean'],
            'auto_mark_absent'        => ['nullable', 'boolean'],
        ];
    }

    protected function extraData(): array
    {
        return ['classes' => SchoolClass::orderBy('name')->get()];
    }

    protected function dataTableQuery(Request $request): Builder
    {
        return ClassAttendanceSetting::query()->with('schoolClass:id,name');
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('class_name', fn ($r) => $r->schoolClass?->name);
    }
}
