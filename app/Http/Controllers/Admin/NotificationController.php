<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications.index');
    }

    public function datatable(Request $request)
    {
        return DataTables::eloquent(Notification::query()->select('notifications.*'))
            ->editColumn('status', fn ($r) => '<span class="badge bg-info">'.e($r->status).'</span>')
            ->editColumn('created_at', fn ($r) => $r->created_at?->format('Y-m-d H:i'))
            ->addColumn('actions', fn ($r) => '<a class="btn btn-sm btn-light border" href="#"><i class="bi bi-eye"></i></a>')
            ->rawColumns(['status', 'actions'])
            ->toJson();
    }
}
