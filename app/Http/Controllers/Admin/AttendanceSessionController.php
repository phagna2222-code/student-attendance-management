<?php

namespace App\Http\Controllers\Admin;

use App\Models\AcademicYear;
use App\Models\AttendanceSession;
use App\Models\Branch;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Term;
use App\Services\BranchContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceSessionController extends ResourceController
{
    protected string $modelClass = AttendanceSession::class;
    protected string $viewPath = 'admin.attendance-sessions';
    protected string $routePrefix = 'admin.attendance-sessions';

    public function __construct(private readonly BranchContext $branchContext)
    {
    }

    protected function validationRules(?Model $model = null): array
    {
        return [
            'branch_id'         => ['required', 'exists:branches,id'],
            'class_id'          => ['required', 'exists:school_classes,id'],
            'subject_id'        => ['nullable', 'exists:subjects,id'],
            'teacher_id'        => ['nullable', 'exists:teachers,id'],
            'academic_year_id'  => ['nullable', 'exists:academic_years,id'],
            'term_id'           => ['nullable', 'exists:terms,id'],
            'attendance_date'   => ['required', 'date'],
            'session_type'      => ['required', Rule::in(['daily', 'period', 'morning', 'afternoon', 'evening'])],
            'period_no'         => ['nullable', 'integer'],
            'start_time'        => ['nullable', 'date_format:H:i'],
            'end_time'          => ['nullable', 'date_format:H:i'],
            'submission_status' => ['required', Rule::in(['draft', 'submitted', 'locked', 'cancelled'])],
            'note'              => ['nullable', 'string'],
        ];
    }

    protected function extraData(): array
    {
        $branchId = $this->branchContext->currentId();
        return [
            'branches'      => Branch::orderBy('name_en')->get(),
            'classes'       => SchoolClass::query()
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->orderBy('name')->get(),
            'subjects'      => Subject::orderBy('name_en')->get(),
            'teachers'      => Teacher::orderBy('name_en')->get(),
            'academicYears' => AcademicYear::orderBy('name')->get(),
            'terms'         => Term::orderBy('name')->get(),
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules());
        $data['created_by'] = auth()->id();
        $session = AttendanceSession::create($data);
        flash()->success(__('admin.sessions').' — '.__('Created successfully'));
        return redirect()->route('admin.attendance-records.entry', ['session_id' => $session->id]);
    }

    public function submit(int $id)
    {
        $session = AttendanceSession::findOrFail($id);
        if ($session->submission_status === 'locked') {
            flash()->error(__('admin.session_already_locked'));
            return back();
        }
        $session->update([
            'submission_status' => 'submitted',
            'submitted_by' => auth()->id(),
            'submitted_at' => now(),
        ]);
        flash()->success(__('admin.session_submitted'));
        return back();
    }

    public function lock(int $id)
    {
        $session = AttendanceSession::findOrFail($id);
        $session->update([
            'submission_status' => 'locked',
            'locked_by' => auth()->id(),
            'locked_at' => now(),
        ]);
        flash()->success(__('admin.session_locked'));
        return back();
    }

    public function cancel(int $id)
    {
        $session = AttendanceSession::findOrFail($id);
        $session->update(['submission_status' => 'cancelled']);
        flash()->success(__('admin.session_cancelled'));
        return back();
    }

    public function reopen(int $id)
    {
        $session = AttendanceSession::findOrFail($id);
        $session->update([
            'submission_status' => 'draft',
            'submitted_at' => null,
            'submitted_by' => null,
            'locked_at' => null,
            'locked_by' => null,
        ]);
        flash()->success(__('admin.session_reopened'));
        return back();
    }

    protected function dataTableQuery(Request $request): Builder
    {
        $q = AttendanceSession::query()->with([
            'branch:id,name_en,name_kh',
            'schoolClass:id,name',
            'subject:id,name_en,name_kh',
            'teacher:id,name_en,name_kh',
        ]);
        $branchId = $this->branchContext->currentId();
        if ($branchId) $q->where('branch_id', $branchId);
        return $q;
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('branch_name', fn ($r) => $r->branch?->localizedName())
            ->addColumn('class_name', fn ($r) => $r->schoolClass?->name)
            ->addColumn('subject_name', fn ($r) => $r->subject?->localizedName())
            ->addColumn('teacher_name', fn ($r) => $r->teacher?->localizedName())
            ->editColumn('attendance_date', fn ($r) => $r->attendance_date?->format('Y-m-d'))
            ->editColumn('submission_status', fn ($r) => '<span class="badge bg-info">'.e($r->submission_status).'</span>')
            ->rawColumns(['actions', 'status', 'submission_status']);
    }
}
