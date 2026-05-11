<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\AttendanceStatus;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Services\BranchContext;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttendanceRecordController extends Controller
{
    public function __construct(private readonly BranchContext $branchContext)
    {
    }

    public function index()
    {
        return view('admin.attendance-records.index');
    }

    public function datatable(Request $request)
    {
        $query = AttendanceRecord::query()
            ->with([
                'session:id,branch_id,class_id,attendance_date,session_type',
                'session.schoolClass:id,name',
                'student:id,name_en,name_kh,student_code',
                'status:id,code,name_en,name_kh,color',
            ])
            ->select('attendance_records.*');

        if ($branchId = $this->branchContext->currentId()) {
            $query->whereHas('session', fn ($q) => $q->where('branch_id', $branchId));
        }

        return DataTables::eloquent($query)
            ->addColumn('class_name', fn ($r) => $r->session?->schoolClass?->name)
            ->addColumn('attendance_date', fn ($r) => $r->session?->attendance_date?->format('Y-m-d'))
            ->addColumn('student_name', fn ($r) => $r->student?->localizedName())
            ->addColumn('student_code', fn ($r) => $r->student?->student_code)
            ->addColumn('status_name', fn ($r) => $r->status
                ? '<span class="badge" style="background:'.e($r->status->color).'">'.e($r->status->localizedName()).'</span>'
                : '')
            ->editColumn('is_late', fn ($r) => $r->is_late ? '<span class="badge bg-warning">'.$r->late_minutes.' min</span>' : '')
            ->rawColumns(['status_name', 'is_late'])
            ->toJson();
    }

    public function entry(Request $request)
    {
        $sessionId = $request->integer('session_id');
        $session = $sessionId
            ? AttendanceSession::with([
                'schoolClass.gradeLevel',
                'schoolClass.academicYear',
                'schoolClass.term',
                'schoolClass.shift',
                'schoolClass.room',
                'subject',
                'teacher',
                'records',
            ])->find($sessionId)
            : null;

        $classes = SchoolClass::query()
            ->when($this->branchContext->currentId(), fn ($q, $bid) => $q->where('branch_id', $bid))
            ->orderBy('name')->get();

        $statuses = AttendanceStatus::query()
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get(['id', 'code', 'name_en', 'name_kh', 'color', 'counts_as_present']);

        $students = collect();
        $initial = [];
        if ($session) {
            $students = Student::query()
                ->whereHas('classes', fn ($q) => $q->where('class_id', $session->class_id))
                ->orderBy('student_no')
                ->orderBy('student_code')
                ->orderBy('name_en')
                ->get(['id', 'name_en', 'name_kh', 'student_code', 'student_no', 'gender']);
            foreach ($session->records as $rec) {
                $initial[$rec->student_id] = [
                    'attendance_status_id' => $rec->attendance_status_id,
                    'late_minutes'         => $rec->late_minutes,
                    'teacher_note'         => $rec->teacher_note,
                ];
            }
        }

        return view('admin.attendance-records.entry', [
            'sessions' => AttendanceSession::query()
                ->with('schoolClass:id,name')
                ->when($this->branchContext->currentId(), fn ($q, $bid) => $q->where('branch_id', $bid))
                ->latest('attendance_date')->limit(50)->get(),
            'session'  => $session,
            'classes'  => $classes,
            'statuses' => $statuses,
            'students' => $students,
            'initial'  => $initial,
        ]);
    }

    public function submitEntry(Request $request)
    {
        $data = $request->validate([
            'session_id'       => ['required', 'exists:attendance_sessions,id'],
            'records'          => ['required', 'array'],
            'records.*.attendance_status_id' => ['required', 'exists:attendance_statuses,id'],
            'records.*.late_minutes'         => ['nullable', 'integer', 'min:0'],
            'records.*.teacher_note'         => ['nullable', 'string'],
        ]);

        $session = AttendanceSession::findOrFail($data['session_id']);
        if ($session->submission_status === 'locked') {
            return response()->json(['ok' => false, 'message' => 'Session is locked'], 422);
        }

        foreach ($data['records'] as $studentId => $r) {
            AttendanceRecord::updateOrCreate(
                [
                    'attendance_session_id' => $session->id,
                    'student_id'            => $studentId,
                ],
                [
                    'attendance_status_id' => $r['attendance_status_id'],
                    'late_minutes'         => $r['late_minutes'] ?? 0,
                    'is_late'              => ($r['late_minutes'] ?? 0) > 0,
                    'teacher_note'         => $r['teacher_note'] ?? null,
                    'method'               => 'manual',
                    'marked_at'            => now(),
                    'marked_by'            => auth()->id(),
                ]
            );
        }

        $session->update([
            'submission_status' => 'submitted',
            'submitted_by'      => auth()->id(),
            'submitted_at'      => now(),
        ]);

        return response()->json(['ok' => true, 'message' => __('Saved successfully')]);
    }
}
