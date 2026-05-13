<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\AttendanceStatus;
use App\Models\AuditLog;
use App\Models\Branch;
use App\Models\GeneratedReport;
use App\Models\LeaveRequest;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\Role;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use App\Services\BranchContext;
use App\Services\Reports\ReportExporter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function __construct(
        private readonly BranchContext $branchContext,
        private readonly ReportExporter $exporter,
    ) {}

    public function index()
    {
        return view('admin.reports.index', [
            'classes'  => SchoolClass::orderBy('name')->get(),
            'branches' => Branch::orderBy('name_en')->get(),
            'history'  => GeneratedReport::query()->latest()->limit(20)->get(),
        ]);
    }

    public function run(Request $request, string $key)
    {
        $payload = $this->dispatch($key, $request);
        $format = $request->input('format', 'view');

        if ($format === 'view') {
            return view('admin.reports.results', $payload + ['key' => $key]);
        }

        $report = GeneratedReport::create([
            'report_no'    => 'RPT-'.now()->format('Ymd-His').'-'.strtoupper(substr(bin2hex(random_bytes(2)), 0, 4)).'-'.strtoupper(substr($key, 0, 5)),
            'report_type'  => $this->mapToReportTypeEnum($payload['report_type'] ?? $key),
            'branch_id'    => $request->input('branch_id'),
            'class_id'     => $request->input('class_id'),
            'student_id'   => $request->input('student_id'),
            'teacher_id'   => $request->input('teacher_id'),
            'subject_id'   => $request->input('subject_id'),
            'date_from'    => $request->input('date_from'),
            'date_to'      => $request->input('date_to'),
            'filters'      => $request->except(['_token', 'format']),
            'summary'      => $payload['summary'] ?? [],
            'generated_by' => auth()->id(),
            'generated_at' => now(),
        ]);

        return $this->exporter->export($report, $key, $payload, $format);
    }

    /**
     * Map an internal report key/payload type to one of the enum values allowed by
     * generated_reports.report_type. Migration enum is fixed, so we route any
     * extra reports (pending_leave, class_roster, enrolment_movement,
     * notification_delivery, audit_log, user_activity, permission_matrix, ...) to
     * the closest valid bucket. The full key is preserved in `filters` for tracing.
     */
    protected function mapToReportTypeEnum(string $key): string
    {
        return match ($key) {
            'daily_attendance_sheet', 'daily_attendance'                            => 'daily_attendance',
            'monthly_attendance_summary', 'monthly_attendance'                      => 'monthly_attendance',
            'student_attendance_history', 'student_attendance', 'student_history'   => 'student_history',
            'teacher_submission_compliance', 'teacher_submission'                   => 'teacher_submission',
            'absent_students'                                                        => 'absent_students',
            'late_students'                                                          => 'late_students',
            'consecutive_absent'                                                     => 'consecutive_absent',
            'pending_leave', 'permission_students'                                  => 'permission_students',
            'class_roster', 'class_summary',
            'enrolment_movement', 'notification_delivery',
            'audit_log', 'user_activity', 'permission_matrix'                       => 'class_summary',
            'subject_attendance'                                                     => 'subject_attendance',
            'yearly_attendance'                                                      => 'yearly_attendance',
            'campus_attendance'                                                      => 'campus_attendance',
            default                                                                  => 'class_summary',
        };
    }

    protected function dispatch(string $key, Request $request): array
    {
        $branchId = $request->input('branch_id') ?: $this->branchContext->currentId();
        $classId  = $request->input('class_id');
        $studentId= $request->input('student_id');
        $from     = $request->input('date_from') ? Carbon::parse($request->input('date_from')) : now()->startOfMonth();
        $to       = $request->input('date_to')   ? Carbon::parse($request->input('date_to'))   : now();

        return match ($key) {
            'daily_attendance_sheet'      => $this->dailyAttendanceSheet($branchId, $classId, $from),
            'monthly_attendance_summary'  => $this->monthlyAttendanceSummary($branchId, $classId, $from),
            'student_attendance_history'  => $this->studentAttendanceHistory($studentId, $from, $to),
            'teacher_submission_compliance' => $this->teacherSubmissionCompliance($branchId, $from, $to),
            'absent_students'             => $this->absentStudents($branchId, $classId, $from, $to),
            'late_students'               => $this->lateStudents($branchId, $classId, $from, $to),
            'consecutive_absent'          => $this->consecutiveAbsent($branchId, (int) $request->input('threshold', 3), $from, $to),
            'pending_leave'               => $this->pendingLeave($branchId),
            'class_roster'                => $this->classRoster($classId),
            'enrolment_movement'          => $this->enrolmentMovement($branchId, $from, $to),
            'notification_delivery'       => $this->notificationDelivery($from, $to),
            'audit_log_search'            => $this->auditLogSearch($request),
            'user_activity'               => $this->userActivity(),
            'permission_matrix'           => $this->permissionMatrix(),
            default                       => throw new \InvalidArgumentException('Unknown report: '.$key),
        };
    }

    // -- R-01 Daily Attendance Sheet --
    protected function dailyAttendanceSheet(?int $branchId, ?int $classId, Carbon $date): array
    {
        $sessions = AttendanceSession::query()
            ->whereDate('attendance_date', $date->toDateString())
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->when($classId,  fn ($q) => $q->where('class_id', $classId))
            ->with(['schoolClass:id,name', 'records.student:id,name_en,name_kh,student_code', 'records.status:id,code,name_en,name_kh,color'])
            ->get();

        $rows = $sessions->flatMap(function ($s) {
            return $s->records->map(fn ($r) => [
                'class'   => $s->schoolClass?->name,
                'session' => $s->session_type.' #'.$s->id,
                'student' => $r->student?->localizedName(),
                'code'    => $r->student?->student_code,
                'status'  => $r->status?->code,
                'late'    => $r->late_minutes,
                'note'    => $r->teacher_note,
            ]);
        });

        return [
            'title'       => __('admin.report_r01'),
            'report_type' => 'daily_attendance',
            'date'        => $date->toDateString(),
            'rows'        => $rows->values()->all(),
            'summary'     => ['count' => $rows->count()],
        ];
    }

    // -- R-02 Monthly Attendance Summary --
    protected function monthlyAttendanceSummary(?int $branchId, ?int $classId, Carbon $date): array
    {
        $from = $date->copy()->startOfMonth();
        $to   = $date->copy()->endOfMonth();

        $records = AttendanceRecord::query()
            ->with(['session:id,attendance_date,class_id,branch_id', 'status:id,code,counts_as_present,counts_as_absent,counts_as_late', 'student:id,name_en,name_kh,student_code'])
            ->whereHas('session', fn ($q) => $q
                ->whereBetween('attendance_date', [$from, $to])
                ->when($branchId, fn ($x) => $x->where('branch_id', $branchId))
                ->when($classId, fn ($x) => $x->where('class_id', $classId)))
            ->get();

        $rows = $records->groupBy('student_id')->map(function ($g) {
            $student = $g->first()->student;
            return [
                'student' => $student?->localizedName(),
                'code'    => $student?->student_code,
                'present' => $g->filter(fn ($r) => $r->status?->counts_as_present)->count(),
                'absent'  => $g->filter(fn ($r) => $r->status?->counts_as_absent)->count(),
                'late'    => $g->filter(fn ($r) => $r->status?->counts_as_late)->count(),
                'total'   => $g->count(),
            ];
        })->values()->all();

        return [
            'title' => __('admin.report_r02'),
            'report_type' => 'monthly_attendance',
            'date_from' => $from->toDateString(),
            'date_to'   => $to->toDateString(),
            'rows'      => $rows,
            'summary'   => ['students' => count($rows)],
        ];
    }

    // -- R-04 Student Attendance History --
    protected function studentAttendanceHistory(?int $studentId, Carbon $from, Carbon $to): array
    {
        if (! $studentId) return ['title' => __('admin.report_r04'), 'rows' => [], 'summary' => []];

        $records = AttendanceRecord::query()
            ->with(['session:id,attendance_date,class_id', 'session.schoolClass:id,name', 'status:id,code,name_en'])
            ->where('student_id', $studentId)
            ->whereHas('session', fn ($q) => $q->whereBetween('attendance_date', [$from, $to]))
            ->get();

        $rows = $records->map(fn ($r) => [
            'date'   => $r->session?->attendance_date?->toDateString(),
            'class'  => $r->session?->schoolClass?->name,
            'status' => $r->status?->code,
            'late'   => $r->late_minutes,
            'note'   => $r->teacher_note,
        ])->sortBy('date')->values()->all();

        return [
            'title'       => __('admin.report_r04'),
            'report_type' => 'student_attendance',
            'student'     => Student::find($studentId)?->localizedName(),
            'date_from'   => $from->toDateString(),
            'date_to'     => $to->toDateString(),
            'rows'        => $rows,
            'summary'     => ['count' => count($rows)],
        ];
    }

    // -- R-07 Teacher Submission Compliance --
    protected function teacherSubmissionCompliance(?int $branchId, Carbon $from, Carbon $to): array
    {
        $sessions = AttendanceSession::query()
            ->with(['teacher:id,name_en,name_kh', 'schoolClass:id,name'])
            ->whereBetween('attendance_date', [$from, $to])
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->get();

        $rows = $sessions->map(fn ($s) => [
            'date'      => $s->attendance_date?->toDateString(),
            'class'     => $s->schoolClass?->name,
            'teacher'   => $s->teacher?->localizedName(),
            'status'    => $s->submission_status,
            'submitted' => $s->submitted_at?->toDateTimeString(),
            'late_submit' => $s->submitted_at ? $s->submitted_at->isAfter($s->attendance_date->copy()->endOfDay()) : null,
        ])->values()->all();

        return [
            'title' => __('admin.report_r07'),
            'report_type' => 'teacher_submission',
            'rows' => $rows,
            'summary' => ['sessions' => count($rows), 'unsubmitted' => collect($rows)->where('status', 'draft')->count()],
        ];
    }

    // -- R-08 Absent Students --
    protected function absentStudents(?int $branchId, ?int $classId, Carbon $from, Carbon $to): array
    {
        $records = AttendanceRecord::query()
            ->with(['student:id,name_en,name_kh,student_code', 'session:id,attendance_date,class_id', 'session.schoolClass:id,name', 'status'])
            ->whereHas('status', fn ($q) => $q->where('counts_as_absent', true))
            ->whereHas('session', fn ($q) => $q
                ->whereBetween('attendance_date', [$from, $to])
                ->when($branchId, fn ($x) => $x->where('branch_id', $branchId))
                ->when($classId, fn ($x) => $x->where('class_id', $classId)))
            ->get();

        $rows = $records->map(fn ($r) => [
            'date'    => $r->session?->attendance_date?->toDateString(),
            'class'   => $r->session?->schoolClass?->name,
            'student' => $r->student?->localizedName(),
            'code'    => $r->student?->student_code,
            'status'  => $r->status?->code,
        ])->values()->all();

        return [
            'title' => __('admin.report_r08'),
            'report_type' => 'absent_students',
            'rows' => $rows,
            'summary' => ['count' => count($rows)],
        ];
    }

    // -- R-09 Late Students --
    protected function lateStudents(?int $branchId, ?int $classId, Carbon $from, Carbon $to): array
    {
        $records = AttendanceRecord::query()
            ->with(['student:id,name_en,name_kh,student_code', 'session:id,attendance_date,class_id', 'session.schoolClass:id,name'])
            ->where('is_late', true)
            ->whereHas('session', fn ($q) => $q
                ->whereBetween('attendance_date', [$from, $to])
                ->when($branchId, fn ($x) => $x->where('branch_id', $branchId))
                ->when($classId, fn ($x) => $x->where('class_id', $classId)))
            ->get();

        $rows = $records->map(fn ($r) => [
            'date'    => $r->session?->attendance_date?->toDateString(),
            'class'   => $r->session?->schoolClass?->name,
            'student' => $r->student?->localizedName(),
            'code'    => $r->student?->student_code,
            'minutes' => $r->late_minutes,
        ])->sortByDesc('minutes')->values()->all();

        return [
            'title' => __('admin.report_r09'),
            'report_type' => 'late_students',
            'rows' => $rows,
            'summary' => ['count' => count($rows), 'avg_minutes' => count($rows) ? round(collect($rows)->avg('minutes'), 1) : 0],
        ];
    }

    // -- R-11 Consecutive Absent --
    protected function consecutiveAbsent(?int $branchId, int $threshold, Carbon $from, Carbon $to): array
    {
        $records = AttendanceRecord::query()
            ->with(['session:id,attendance_date,branch_id', 'student:id,name_en,name_kh,student_code', 'status'])
            ->whereHas('status', fn ($q) => $q->where('counts_as_absent', true))
            ->whereHas('session', fn ($q) => $q
                ->whereBetween('attendance_date', [$from, $to])
                ->when($branchId, fn ($x) => $x->where('branch_id', $branchId)))
            ->get()
            ->groupBy('student_id');

        $rows = [];
        foreach ($records as $studentId => $g) {
            $dates = $g->pluck('session.attendance_date')->filter()->map(fn ($d) => $d->toDateString())->sort()->values();
            $maxStreak = 1; $cur = 1;
            for ($i = 1, $n = count($dates); $i < $n; $i++) {
                $diff = Carbon::parse($dates[$i])->diffInDays(Carbon::parse($dates[$i - 1]));
                if ($diff <= 1) { $cur++; $maxStreak = max($maxStreak, $cur); }
                else { $cur = 1; }
            }
            if ($maxStreak >= $threshold) {
                $student = $g->first()->student;
                $rows[] = [
                    'student' => $student?->localizedName(),
                    'code'    => $student?->student_code,
                    'consecutive_days' => $maxStreak,
                    'total_absent_days' => count($dates),
                ];
            }
        }

        usort($rows, fn ($a, $b) => $b['consecutive_days'] <=> $a['consecutive_days']);

        return [
            'title' => __('admin.report_r11'),
            'report_type' => 'consecutive_absent',
            'rows' => $rows,
            'summary' => ['threshold' => $threshold, 'count' => count($rows)],
        ];
    }

    // -- R-19 Pending Leave Queue --
    protected function pendingLeave(?int $branchId): array
    {
        $leaves = LeaveRequest::query()
            ->with(['student:id,name_en,name_kh,student_code'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $rows = $leaves->map(fn ($l) => [
            'request_no' => $l->request_no,
            'student'    => $l->student?->localizedName(),
            'type'       => $l->leave_type,
            'from'       => $l->start_date?->toDateString(),
            'to'         => $l->end_date?->toDateString(),
            'days'       => $l->total_days,
            'age_days'   => $l->created_at?->diffInDays(now()),
        ])->values()->all();

        return [
            'title' => __('admin.report_r19'),
            'report_type' => 'pending_leave',
            'rows' => $rows,
            'summary' => ['pending' => count($rows)],
        ];
    }

    // -- R-27 Class Roster --
    protected function classRoster(?int $classId): array
    {
        if (! $classId) return ['title' => __('admin.report_r27'), 'rows' => [], 'summary' => []];

        $class = SchoolClass::with(['students.parents:id,name_en,name_kh,phone,email'])->find($classId);
        if (! $class) return ['title' => __('admin.report_r27'), 'rows' => [], 'summary' => []];

        $rows = $class->students->map(fn ($s) => [
            'code'    => $s->student_code,
            'student' => $s->localizedName(),
            'gender'  => $s->gender,
            'phone'   => $s->phone,
            'parents' => $s->parents->map(fn ($p) => $p->localizedName().' ('.($p->pivot->relationship ?? 'guardian').', '.$p->phone.')')->implode('; '),
        ])->values()->all();

        return [
            'title' => __('admin.report_r27'),
            'report_type' => 'class_roster',
            'class' => $class->name,
            'rows' => $rows,
            'summary' => ['students' => count($rows)],
        ];
    }

    // -- R-29 Enrolment Movement --
    protected function enrolmentMovement(?int $branchId, Carbon $from, Carbon $to): array
    {
        $base = Student::query()->when($branchId, fn ($q) => $q->where('branch_id', $branchId));

        $admitted = (clone $base)->whereBetween('admission_date', [$from, $to])->count();
        $withdrew = (clone $base)->whereBetween('exit_date', [$from, $to])->count();
        $active   = (clone $base)->whereIn('status', ['active', 'studying'])->count();
        $byStatus = (clone $base)->selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status')->all();

        return [
            'title' => __('admin.report_r29'),
            'report_type' => 'enrolment_movement',
            'rows' => collect($byStatus)->map(fn ($c, $s) => ['status' => $s, 'count' => $c])->values()->all(),
            'summary' => compact('admitted', 'withdrew', 'active'),
        ];
    }

    // -- R-33 Notification Delivery --
    protected function notificationDelivery(Carbon $from, Carbon $to): array
    {
        $base = Notification::query()->whereBetween('created_at', [$from, $to]);

        $byStatus  = (clone $base)->selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status')->all();
        $byChannel = (clone $base)->selectRaw('channel, count(*) as c')->groupBy('channel')->pluck('c', 'channel')->all();

        return [
            'title' => __('admin.report_r33'),
            'report_type' => 'notification_delivery',
            'rows' => collect($byStatus)->map(fn ($c, $s) => ['status' => $s, 'count' => $c])->values()->all(),
            'summary' => compact('byChannel'),
        ];
    }

    // -- R-37 Audit Log Search --
    protected function auditLogSearch(Request $request): array
    {
        $q = AuditLog::query()->with('user:id,name');
        if ($request->filled('user_id'))   $q->where('user_id', $request->user_id);
        if ($request->filled('event'))     $q->where('event', 'like', '%'.$request->event.'%');
        if ($request->filled('date_from')) $q->whereDate('created_at', '>=', $request->date_from);
        if ($request->filled('date_to'))   $q->whereDate('created_at', '<=', $request->date_to);

        $rows = $q->latest()->limit(500)->get()->map(fn ($l) => [
            'date'    => $l->created_at?->format('Y-m-d H:i:s'),
            'user'    => $l->user?->name,
            'event'   => $l->event,
            'entity'  => class_basename($l->auditable_type).'#'.$l->auditable_id,
            'ip'      => $l->ip_address,
            'url'     => $l->url,
        ])->all();

        return [
            'title' => __('admin.report_r37'),
            'report_type' => 'audit_log',
            'rows' => $rows,
            'summary' => ['count' => count($rows)],
        ];
    }

    // -- R-38 User Activity --
    protected function userActivity(): array
    {
        $rows = User::query()
            ->select('id', 'name', 'email', 'user_type', 'status', 'last_login_at', 'last_login_ip', 'failed_login_attempts', 'locked_until')
            ->latest('last_login_at')
            ->get()
            ->map(fn ($u) => [
                'user'           => $u->name,
                'email'          => $u->email,
                'type'           => $u->user_type,
                'status'         => $u->status,
                'last_login'     => $u->last_login_at?->toDateTimeString(),
                'last_ip'        => $u->last_login_ip,
                'failed'         => $u->failed_login_attempts,
                'locked_until'   => $u->locked_until?->toDateTimeString(),
            ])->all();

        return [
            'title' => __('admin.report_r38'),
            'report_type' => 'user_activity',
            'rows' => $rows,
            'summary' => ['users' => count($rows)],
        ];
    }

    // -- R-39 Permission Matrix --
    protected function permissionMatrix(): array
    {
        $roles = Role::with('permissions:id,slug')->get();
        $permissions = Permission::orderBy('group')->orderBy('slug')->get();

        $rows = $permissions->map(function ($p) use ($roles) {
            $row = ['group' => $p->group, 'permission' => $p->slug, 'name' => $p->name];
            foreach ($roles as $r) {
                $row[$r->slug] = $r->permissions->contains('id', $p->id) ? '✓' : '';
            }
            return $row;
        })->all();

        return [
            'title' => __('admin.report_r39'),
            'report_type' => 'permission_matrix',
            'rows' => $rows,
            'columns' => array_merge(['group', 'permission', 'name'], $roles->pluck('slug')->all()),
            'summary' => ['roles' => $roles->count(), 'permissions' => $permissions->count()],
        ];
    }
}
