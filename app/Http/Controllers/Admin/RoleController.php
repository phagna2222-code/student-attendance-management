<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends ResourceController
{
    protected string $modelClass = Role::class;
    protected string $viewPath = 'admin.roles';
    protected string $routePrefix = 'admin.roles';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'slug'        => ['required', 'string', 'max:100', Rule::unique('roles', 'slug')->ignore($model?->id)],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ];
    }

    protected function extraData(): array
    {
        return ['permissions' => Permission::orderBy('group')->orderBy('name')->get()->groupBy('group')];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules());
        $perms = $data['permissions'] ?? [];
        unset($data['permissions']);
        $role = Role::create($data);
        $role->permissions()->sync($perms);
        flash()->success(__('admin.roles').' — '.__('Created successfully'));
        return redirect()->route('admin.roles.index');
    }

    public function update(Request $request, int $id)
    {
        $role = Role::findOrFail($id);
        $data = $request->validate($this->validationRules($role));
        $perms = $data['permissions'] ?? [];
        unset($data['permissions']);
        $role->update($data);
        $role->permissions()->sync($perms);
        flash()->success(__('admin.roles').' — '.__('Updated successfully'));
        return redirect()->route('admin.roles.index');
    }
}
