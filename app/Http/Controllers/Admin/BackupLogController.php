<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackupLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BackupLogController extends Controller
{
    public function index()
    {
        return view('admin.backup-logs.index');
    }

    public function datatable(Request $request)
    {
        return DataTables::eloquent(BackupLog::query()->with('requestedBy:id,name'))
            ->addColumn('requested_by_name', fn ($r) => $r->requestedBy?->name)
            ->editColumn('status', fn ($r) => '<span class="badge bg-'.($r->status === 'success' ? 'success' : ($r->status === 'failed' ? 'danger' : 'warning')).'">'.e($r->status).'</span>')
            ->editColumn('file_size', fn ($r) => $r->file_size ? number_format($r->file_size / 1024, 1).' KB' : '—')
            ->editColumn('started_at', fn ($r) => $r->started_at?->format('Y-m-d H:i'))
            ->editColumn('finished_at', fn ($r) => $r->finished_at?->format('Y-m-d H:i'))
            ->addColumn('actions', function ($r) {
                if (! $r->file_path) return '<span class="text-muted small">—</span>';
                return '<a class="btn btn-sm btn-outline-secondary" href="'.route('admin.backup-logs.download', $r->id).'"><i class="bx bx-download"></i></a>';
            })
            ->rawColumns(['status', 'actions'])
            ->toJson();
    }

    public function run(Request $request)
    {
        $type = $request->input('type', 'database');
        Artisan::call('backup:run', ['--type' => $type]);
        flash()->success(__('admin.backup_started').": {$type}");
        return back();
    }

    public function download(int $id)
    {
        $log = BackupLog::findOrFail($id);
        if (! $log->file_path) abort(404);
        $disk = Storage::disk('local');
        if (! $disk->exists($log->file_path)) abort(404);
        return $disk->download($log->file_path);
    }
}
