<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Services\BranchContext;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    public function index()
    {
        return view('admin.branches.index');
    }

    public function datatable(Request $request)
    {
        $query = Branch::query()->select('branches.*');
        return DataTables::eloquent($query)
            ->addColumn('actions', function ($row) {
                return view('admin.partials._row_actions', [
                    'editUrl' => route('admin.branches.edit', $row),
                    'deleteUrl' => route('admin.branches.destroy', $row),
                ])->render();
            })
            ->editColumn('is_main', fn ($row) => $row->is_main
                ? '<span class="badge bg-warning">'.e(__('admin.is_main')).'</span>'
                : '')
            ->editColumn('status', fn ($row) => '<span class="badge bg-'.($row->status==='active'?'success':'secondary').'">'.e(ucfirst($row->status)).'</span>')
            ->rawColumns(['actions', 'status', 'is_main'])
            ->toJson();
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Branch::create($data);
        flash()->success(__('admin.branches').' — '.__('Created successfully'));
        return redirect()->route('admin.branches.index');
    }

    public function edit(int $id)
    {
        $branch = Branch::findOrFail($id);
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, int $id)
    {
        $branch = Branch::findOrFail($id);
        $data = $this->validated($request, $branch->id);
        $branch->update($data);
        flash()->success(__('admin.branches').' — '.__('Updated successfully'));
        return redirect()->route('admin.branches.index');
    }

    public function destroy(int $id, BranchContext $context)
    {
        $branch = Branch::findOrFail($id);
        if ($context->currentId() === $branch->id) {
            $context->set(null);
        }
        $branch->delete();
        flash()->success(__('admin.branches').' — '.__('Deleted successfully'));
        return back();
    }

    public function setActive(Request $request, BranchContext $context)
    {
        $id = $request->input('branch_id');
        $context->set($id ? (int) $id : null);
        return back();
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $rule = ['nullable', 'string', 'max:50', 'unique:branches,code'];
        if ($ignoreId) $rule[2] .= ','.$ignoreId;
        return $request->validate([
            'code'     => ['required', 'string', 'max:50', \Illuminate\Validation\Rule::unique('branches', 'code')->ignore($ignoreId)],
            'name_kh'  => ['nullable', 'string', 'max:255'],
            'name_en'  => ['required', 'string', 'max:255'],
            'phone'    => ['nullable', 'string', 'max:50'],
            'email'    => ['nullable', 'email', 'max:255'],
            'website'  => ['nullable', 'string', 'max:255'],
            'address'  => ['nullable', 'string'],
            'is_main'  => ['nullable', 'boolean'],
            'status'   => ['required', 'in:active,inactive'],
        ]);
    }
}
