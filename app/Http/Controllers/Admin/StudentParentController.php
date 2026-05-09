<?php

namespace App\Http\Controllers\Admin;

use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class StudentParentController extends ResourceController
{
    protected string $modelClass = StudentParent::class;
    protected string $viewPath = 'admin.parents';
    protected string $routePrefix = 'admin.parents';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'user_id'         => ['nullable', 'exists:users,id', Rule::unique('parents', 'user_id')->ignore($model?->id)],
            'parent_code'     => ['nullable', 'string', 'max:50', Rule::unique('parents', 'parent_code')->ignore($model?->id)],
            'name_kh'         => ['nullable', 'string', 'max:255'],
            'name_en'         => ['required', 'string', 'max:255'],
            'gender'          => ['nullable', Rule::in(['male', 'female', 'other'])],
            'phone'           => ['nullable', 'string', 'max:50'],
            'secondary_phone' => ['nullable', 'string', 'max:50'],
            'email'           => ['nullable', 'email', 'max:255'],
            'telegram_chat_id'=> ['nullable', 'string', 'max:255'],
            'address'         => ['nullable', 'string'],
            'status'          => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    protected function extraData(): array
    {
        return ['users' => User::orderBy('name')->limit(500)->get()];
    }
}
