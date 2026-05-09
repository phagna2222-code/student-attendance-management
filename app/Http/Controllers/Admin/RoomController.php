<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends ResourceController
{
    protected string $modelClass = Room::class;
    protected string $viewPath = 'admin.rooms';
    protected string $routePrefix = 'admin.rooms';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'branch_id' => ['required', 'exists:branches,id'],
            'code'      => ['required', 'string', 'max:50'],
            'name'      => ['required', 'string', 'max:255'],
            'capacity'  => ['nullable', 'integer', 'min:1', 'max:65535'],
            'building'  => ['nullable', 'string', 'max:255'],
            'floor'     => ['nullable', 'string', 'max:255'],
            'status'    => ['required', Rule::in(['active', 'inactive', 'maintenance'])],
        ];
    }

    protected function extraData(): array
    {
        return ['branches' => Branch::orderBy('name_en')->get()];
    }

    protected function dataTableQuery(Request $request): Builder
    {
        return Room::query()->with('branch:id,name_en,name_kh');
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('branch_name', fn ($r) => $r->branch?->localizedName());
    }
}
