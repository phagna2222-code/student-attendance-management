<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherController extends ResourceController
{
    protected string $modelClass = Teacher::class;
    protected string $viewPath = 'admin.teachers';
    protected string $routePrefix = 'admin.teachers';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'user_id'      => ['nullable', 'exists:users,id', Rule::unique('teachers', 'user_id')->ignore($model?->id)],
            'branch_id'    => ['nullable', 'exists:branches,id'],
            'teacher_code' => ['required', 'string', 'max:50', Rule::unique('teachers', 'teacher_code')->ignore($model?->id)],
            'name_kh'      => ['nullable', 'string', 'max:255'],
            'name_en'      => ['required', 'string', 'max:255'],
            'gender'       => ['nullable', Rule::in(['male', 'female', 'other'])],
            'date_of_birth'=> ['nullable', 'date'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'email'        => ['nullable', 'email', 'max:255'],
            'address'      => ['nullable', 'string'],
            'status'       => ['required', Rule::in(['active', 'inactive', 'resigned', 'suspended'])],
        ];
    }

    protected function extraData(): array
    {
        return [
            'branches' => Branch::orderBy('name_en')->get(),
            'users'    => User::query()->whereNotNull('email')->orderBy('name')->limit(500)->get(),
        ];
    }

    protected function dataTableQuery(Request $request): Builder
    {
        return Teacher::query()->with(['branch:id,name_en,name_kh'])->select('teachers.*');
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('branch_name', fn ($r) => $r->branch?->localizedName());
    }
}
