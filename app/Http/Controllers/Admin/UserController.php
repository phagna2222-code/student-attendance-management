<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends ResourceController
{
    protected string $modelClass = User::class;
    protected string $viewPath = 'admin.users';
    protected string $routePrefix = 'admin.users';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'branch_id' => ['nullable', 'exists:branches,id'],
            'name'      => ['required', 'string', 'max:255'],
            'username'  => ['nullable', 'string', 'max:100', Rule::unique('users', 'username')->ignore($model?->id)],
            'email'     => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($model?->id)],
            'phone'     => ['nullable', 'string', 'max:50'],
            'password'  => [$model ? 'nullable' : 'required', 'string', 'min:6'],
            'user_type' => ['required', Rule::in(['super_admin', 'school_admin', 'teacher', 'secretary', 'parent', 'student', 'auditor'])],
            'status'    => ['required', Rule::in(['active', 'inactive', 'blocked', 'pending'])],
            'roles'     => ['nullable', 'array'],
            'roles.*'   => ['integer', 'exists:roles,id'],
        ];
    }

    protected function extraData(): array
    {
        return [
            'branches' => Branch::orderBy('name_en')->get(),
            'roles'    => Role::orderBy('name')->get(),
            'userTypes' => ['super_admin', 'school_admin', 'teacher', 'secretary', 'parent', 'student', 'auditor'],
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules());
        $roles = $data['roles'] ?? [];
        unset($data['roles']);
        if (! empty($data['password'])) $data['password'] = Hash::make($data['password']);
        else unset($data['password']);
        $user = User::create($data);
        $user->roles()->sync($roles);
        flash()->success(__('admin.users').' — '.__('Created successfully'));
        return redirect()->route('admin.users.index');
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate($this->validationRules($user));
        $roles = $data['roles'] ?? [];
        unset($data['roles']);
        if (! empty($data['password'])) $data['password'] = Hash::make($data['password']);
        else unset($data['password']);
        $user->update($data);
        $user->roles()->sync($roles);
        flash()->success(__('admin.users').' — '.__('Updated successfully'));
        return redirect()->route('admin.users.index');
    }

    protected function dataTableQuery(Request $request): Builder
    {
        return User::query()->with('branch:id,name_en,name_kh')->select('users.*');
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->editColumn('user_type', fn ($r) => '<span class="badge bg-info">'.e(str_replace('_', ' ', (string) $r->user_type)).'</span>')
            ->addColumn('branch_name', fn ($r) => $r->branch?->localizedName())
            ->rawColumns(['actions', 'status', 'user_type']);
    }
}
