<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationLogController extends Controller
{
    public function index()
    {
        return view('admin.notification-logs.index');
    }

    public function datatable(Request $request)
    {
        return DataTables::eloquent(
            NotificationLog::query()->with('notification:id,type,channel,recipient_name,recipient_contact')
        )
        ->addColumn('notification_summary', function ($r) {
            $n = $r->notification;
            if (! $n) return '—';
            return e($n->type).' / '.e($n->channel).' → '.e($n->recipient_name);
        })
        ->editColumn('status', fn ($r) => '<span class="badge bg-'.($r->status === 'success' ? 'success' : 'danger').'">'.e($r->status).'</span>')
        ->editColumn('created_at', fn ($r) => $r->created_at?->format('Y-m-d H:i'))
        ->rawColumns(['status'])
        ->toJson();
    }
}
