<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\SchoolProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolProfileController extends ResourceController
{
    protected string $modelClass = SchoolProfile::class;
    protected string $viewPath = 'admin.school-profiles';
    protected string $routePrefix = 'admin.school-profiles';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'branch_id'      => ['required', 'exists:branches,id', Rule::unique('school_profiles', 'branch_id')->ignore($model?->id)],
            'school_name_kh' => ['nullable', 'string', 'max:255'],
            'school_name_en' => ['required', 'string', 'max:255'],
            'phone'          => ['nullable', 'string', 'max:50'],
            'email'          => ['nullable', 'email', 'max:255'],
            'website'        => ['nullable', 'string', 'max:255'],
            'address'        => ['nullable', 'string'],
        ];
    }

    protected function extraData(): array
    {
        return ['branches' => Branch::orderBy('name_en')->get()];
    }

    protected function dataTableQuery(Request $request): Builder
    {
        return SchoolProfile::query()->with('branch:id,name_en,name_kh');
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('branch_name', fn ($r) => $r->branch?->localizedName());
    }
}
