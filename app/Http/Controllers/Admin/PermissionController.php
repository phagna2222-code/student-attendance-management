<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class PermissionController extends ResourceController
{
    protected string $modelClass = Permission::class;
    protected string $viewPath = 'admin.permissions';
    protected string $routePrefix = 'admin.permissions';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'group'       => ['required', 'string', 'max:100'],
            'slug'        => ['required', 'string', 'max:150', Rule::unique('permissions', 'slug')->ignore($model?->id)],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
