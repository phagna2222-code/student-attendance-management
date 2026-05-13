<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceEditRequest;
use App\Models\AttendanceRecord;
use App\Models\AttendanceStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class AttendanceEditRequestController extends Controller
{
    public function index()
    {
        $statuses = AttendanceStatus::orderBy('sort_order')->get();
        return view('admin.attendance-edit-requests.index', compact('statuses'));
    }

    public function datatable(Request $request)
    {
        $q = AttendanceEditRequest::query()->with([
            'record.student:id,name_en,name_kh,student_code',
            'record.session:id,attendance_date,class_id',
            'record.session.schoolClass:id,name',
            'requestedBy:id,name',
            'approvedBy:id,name',
            'requestedStatus:id,code,name_en,name_kh,color',
        ]);
        return DataTables::eloquent($q)
            ->addColumn('student_name', fn ($r) => $r->record?->student?->localizedName())
            ->addColumn('class_name', fn ($r) => $r->record?->session?->schoolClass?->name)
            ->addColumn('attendance_date', fn ($r) => $r->record?->session?->attendance_date?->format('Y-m-d'))
            ->addColumn('requested_by_name', fn ($r) => $r->requestedBy?->name)
            ->addColumn('approved_by_name', fn ($r) => $r->approvedBy?->name)
            ->addColumn('requested_status_name', fn ($r) => $r->requestedStatus
                ? '<span class="badge" style="background:'.e($r->requestedStatus->color).'">'.e($r->requestedStatus->localizedName()).'</span>'
                : '')
            ->addColumn('actions', function ($r) {
                $approve = route('admin.attendance-edit-requests.approve', $r->id);
                $reject  = route('admin.attendance-edit-requests.reject', $r->id);
                if ($r->status !== 'pending') {
                    return '<span class="text-muted small">—</span>';
                }
                return view('admin.attendance-edit-requests._actions', compact('approve', 'reject'))->render();
            })
            ->editColumn('status', fn ($r) => '<span class="badge bg-'.($r->status === 'approved' ? 'success' : ($r->status === 'rejected' ? 'danger' : 'warning')).'">'.e($r->status).'</span>')
            ->rawColumns(['actions', 'status', 'requested_status_name'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'attendance_record_id'   => ['required', 'exists:attendance_records,id'],
            'requested_status_id'    => ['required', 'exists:attendance_statuses,id'],
            'reason'                 => ['required', 'string', 'max:1000'],
        ]);

        $record = AttendanceRecord::findOrFail($data['attendance_record_id']);
        AttendanceEditRequest::create([
            'attendance_record_id' => $record->id,
            'requested_by' => auth()->id(),
            'requested_status_id' => $data['requested_status_id'],
            'reason' => $data['reason'],
            'old_values' => ['attendance_status_id' => $record->attendance_status_id],
            'new_values' => ['attendance_status_id' => $data['requested_status_id']],
            'status' => 'pending',
        ]);
        flash()->success(__('admin.edit_request_submitted'));
        return back();
    }

    public function approve(Request $request, int $id)
    {
        $data = $request->validate(['approval_note' => ['nullable', 'string', 'max:1000']]);
        $req = AttendanceEditRequest::with('record')->findOrFail($id);

        if ($req->record && $req->requested_status_id) {
            $req->record->update([
                'attendance_status_id' => $req->requested_status_id,
                'updated_by' => auth()->id(),
            ]);
        }
        $req->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'approval_note' => $data['approval_note'] ?? null,
        ]);
        flash()->success(__('admin.edit_request_approved'));
        return back();
    }

    public function reject(Request $request, int $id)
    {
        $data = $request->validate(['approval_note' => ['required', 'string', 'max:1000']]);
        $req = AttendanceEditRequest::findOrFail($id);
        $req->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'approval_note' => $data['approval_note'],
        ]);
        flash()->success(__('admin.edit_request_rejected'));
        return back();
    }
}
