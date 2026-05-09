<?php

namespace App\Http\Controllers\Admin;

use App\Models\AcademicYear;
use App\Models\Term;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class TermController extends ResourceController
{
    protected string $modelClass = Term::class;
    protected string $viewPath = 'admin.terms';
    protected string $routePrefix = 'admin.terms';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'code'             => ['required', 'string', 'max:50'],
            'name'             => ['required', 'string', 'max:255'],
            'term_no'          => ['nullable', 'integer', 'min:1', 'max:10'],
            'start_date'       => ['required', 'date'],
            'end_date'         => ['required', 'date', 'after_or_equal:start_date'],
            'status'           => ['required', Rule::in(['planned', 'active', 'closed'])],
        ];
    }

    protected function extraData(): array
    {
        return ['academicYears' => AcademicYear::orderBy('name')->get()];
    }

    protected function buildDataTable(Builder $query)
    {
        $query->with('academicYear:id,name');
        return parent::buildDataTable($query)
            ->addColumn('academic_year_name', fn ($r) => $r->academicYear?->name ?? '');
    }
}
