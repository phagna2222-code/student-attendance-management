<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsSnapshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;

class AnalyticsSnapshotController extends Controller
{
    public function index()
    {
        return view('admin.analytics-snapshots.index');
    }

    public function datatable(Request $request)
    {
        return DataTables::eloquent(
            AnalyticsSnapshot::query()->with(['branch:id,name_en', 'schoolClass:id,name', 'student:id,name_en,student_code'])
        )
        ->addColumn('branch_name', fn ($r) => $r->branch?->localizedName())
        ->addColumn('class_name', fn ($r) => $r->schoolClass?->name)
        ->addColumn('student_name', fn ($r) => $r->student?->localizedName())
        ->editColumn('snapshot_date', fn ($r) => $r->snapshot_date?->format('Y-m-d'))
        ->toJson();
    }

    public function rebuild(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        Artisan::call('analytics:rebuild', ['--date' => $date]);
        flash()->success(__('admin.analytics_rebuilt').": {$date}");
        return back();
    }
}
