<?php

namespace App\Http\Controllers\Admin;

use App\Models\NotificationTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NotificationTemplateController extends ResourceController
{
    protected string $modelClass = NotificationTemplate::class;
    protected string $viewPath = 'admin.notification-templates';
    protected string $routePrefix = 'admin.notification-templates';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'code'      => ['required', 'string', 'max:100', Rule::unique('notification_templates', 'code')->ignore($model?->id)],
            'name'      => ['required', 'string', 'max:255'],
            'channel'   => ['required', Rule::in(['sms', 'email', 'telegram', 'portal', 'push'])],
            'subject'   => ['nullable', 'string', 'max:255'],
            'body'      => ['required', 'string'],
            'variables' => ['nullable', 'string'],
            'status'    => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    protected function mapInput(array $data, Request $request, ?Model $existing = null): array
    {
        if (! empty($data['variables'])) {
            $data['variables'] = array_filter(array_map('trim', explode(',', $data['variables'])));
        }
        return $data;
    }
}
