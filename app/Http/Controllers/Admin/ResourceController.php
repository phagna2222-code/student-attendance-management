<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * Abstract base controller providing standard CRUD + Yajra DataTables for a model.
 *
 * Concrete controllers must define:
 *  - $modelClass        — fully qualified Eloquent model class.
 *  - $viewPath          — view folder under resources/views/admin/, e.g. "academic-years".
 *  - $routePrefix       — route name prefix, e.g. "admin.academic-years" (without trailing dot).
 *  - validationRules()  — array of validation rules (also used to build the form fields).
 *
 * Override hooks (optional):
 *  - dataTableQuery()   — base query used for the DataTable AJAX response.
 *  - buildDataTable()   — Yajra DataTable construction (add columns, transformations).
 *  - extraData()        — extra data passed to create/edit views (e.g. dropdown options).
 *  - mapInput()         — translate request input into model attributes.
 */
abstract class ResourceController extends Controller
{
    /** @var class-string<Model> */
    protected string $modelClass;
    protected string $viewPath;
    protected string $routePrefix;

    abstract protected function validationRules(?Model $model = null): array;

    public function index()
    {
        return view($this->viewPath . '.index', $this->extraData());
    }

    public function create()
    {
        $instance = new $this->modelClass();
        return view($this->viewPath . '.create', array_merge($this->extraData(), [
            'model' => $instance,
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules());
        $data = $this->mapInput($data, $request);
        $model = $this->modelClass::create($data);
        flash()->success(__($this->moduleLabel()).' — '.__('Created successfully'));
        return redirect()->route($this->routePrefix . '.index');
    }

    public function edit(int $id)
    {
        $model = $this->modelClass::findOrFail($id);
        return view($this->viewPath . '.edit', array_merge($this->extraData(), [
            'model' => $model,
        ]));
    }

    public function update(Request $request, int $id)
    {
        $model = $this->modelClass::findOrFail($id);
        $data = $request->validate($this->validationRules($model));
        $data = $this->mapInput($data, $request, $model);
        $model->update($data);
        flash()->success(__($this->moduleLabel()).' — '.__('Updated successfully'));
        return redirect()->route($this->routePrefix . '.index');
    }

    public function destroy(int $id)
    {
        $model = $this->modelClass::findOrFail($id);
        $model->delete();
        flash()->success(__($this->moduleLabel()).' — '.__('Deleted successfully'));
        return back();
    }

    public function datatable(Request $request)
    {
        $query = $this->dataTableQuery($request);
        return $this->buildDataTable($query)->toJson();
    }

    protected function dataTableQuery(Request $request): Builder
    {
        return $this->modelClass::query();
    }

    protected function buildDataTable(Builder $query)
    {
        $routePrefix = $this->routePrefix;
        return DataTables::eloquent($query)
            ->addColumn('actions', function ($row) use ($routePrefix) {
                return view('admin.partials._row_actions', [
                    'editUrl'   => route($routePrefix . '.edit', $row->id),
                    'deleteUrl' => route($routePrefix . '.destroy', $row->id),
                ])->render();
            })
            ->editColumn('status', function ($row) {
                if (! isset($row->status)) return '';
                $cls = match ($row->status) {
                    'active', 'approved', 'submitted', 'success', 'sent', 'completed' => 'success',
                    'pending', 'queued', 'planned', 'draft', 'processing', 'running' => 'warning',
                    'inactive', 'cancelled', 'closed', 'archived', 'rejected', 'failed' => 'secondary',
                    'blocked', 'suspended', 'dropout' => 'danger',
                    default => 'info',
                };
                return '<span class="badge bg-'.$cls.'">'.e(ucfirst(str_replace('_', ' ', (string) $row->status))).'</span>';
            })
            ->rawColumns(['actions', 'status']);
    }

    protected function extraData(): array
    {
        return [];
    }

    protected function mapInput(array $data, Request $request, ?Model $existing = null): array
    {
        return $data;
    }

    protected function moduleLabel(): string
    {
        return 'admin.' . str_replace('-', '_', basename(str_replace('.', '/', $this->routePrefix)));
    }
}
