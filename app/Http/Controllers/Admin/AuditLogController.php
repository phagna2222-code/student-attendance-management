<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuditLogController extends Controller
{
    public function index()
    {
        return view('admin.audit-logs.index');
    }

    public function datatable(Request $request)
    {
        return DataTables::eloquent(AuditLog::query()->with('user:id,name')->select('audit_logs.*'))
            ->addColumn('user_name', fn ($r) => $r->user?->name)
            ->editColumn('created_at', fn ($r) => $r->created_at?->format('Y-m-d H:i:s'))
            ->toJson();
    }
}
