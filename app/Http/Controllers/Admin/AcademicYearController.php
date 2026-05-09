<?php

namespace App\Http\Controllers\Admin;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class AcademicYearController extends ResourceController
{
    protected string $modelClass = AcademicYear::class;
    protected string $viewPath = 'admin.academic-years';
    protected string $routePrefix = 'admin.academic-years';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'code'       => ['required', 'string', 'max:50', Rule::unique('academic_years', 'code')->ignore($model?->id)],
            'name'       => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'status'     => ['required', Rule::in(['planned', 'active', 'closed', 'archived'])],
        ];
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->editColumn('start_date', fn ($r) => $r->start_date?->format('Y-m-d'))
            ->editColumn('end_date', fn ($r) => $r->end_date?->format('Y-m-d'))
            ->editColumn('is_current', fn ($r) => $r->is_current ? '<span class="badge bg-info">'.__('admin.active').'</span>' : '')
            ->rawColumns(['actions', 'status', 'is_current']);
    }
}
