<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceStatus;
use App\Models\Branch;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\BranchContext;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __invoke(BranchContext $branchContext)
    {
        $branchId = $branchContext->currentId();
        $studentsQ = Student::query();
        $teachersQ = Teacher::query();
        $classesQ  = SchoolClass::query();
        if ($branchId) {
            $studentsQ->where('branch_id', $branchId);
            $teachersQ->where('branch_id', $branchId);
            $classesQ->where('branch_id', $branchId);
        }

        $stats = [
            'students' => $studentsQ->count(),
            'teachers' => $teachersQ->count(),
            'branches' => Branch::count(),
            'classes'  => $classesQ->count(),
        ];

        $statuses = AttendanceStatus::orderBy('sort_order')->get();
        $weekly = collect(range(6, 0))->map(function ($d) use ($branchId, $statuses) {
            $date = Carbon::today()->subDays($d);
            $base = AttendanceRecord::query()
                ->whereHas('session', function ($q) use ($date, $branchId) {
                    $q->whereDate('attendance_date', $date);
                    if ($branchId) $q->where('branch_id', $branchId);
                });
            $by = $base->clone()->select('attendance_status_id')
                ->selectRaw('count(*) as c')
                ->groupBy('attendance_status_id')
                ->pluck('c', 'attendance_status_id');
            $present = $absent = $late = 0;
            foreach ($statuses as $st) {
                $count = (int) ($by[$st->id] ?? 0);
                if ($st->code === 'A') $absent += $count;
                elseif ($st->code === 'L') $late += $count;
                elseif ($st->counts_as_present) $present += $count;
            }
            return [
                'label'   => $date->format('D'),
                'present' => $present,
                'absent'  => $absent,
                'late'    => $late,
            ];
        })->values();

        return view('admin.dashboard.index', compact('stats', 'weekly'));
    }
}
