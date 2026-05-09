<?php

namespace Database\Seeders;

use App\Models\AnalyticsSnapshot;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\AttendanceStatus;
use App\Models\Branch;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class AnalyticsSnapshotSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = AttendanceStatus::all()->keyBy('code');

        $sessionsByDate = AttendanceSession::all()->groupBy(fn ($s) => (string) $s->attendance_date);

        // Build per-day snapshots per branch and per class
        foreach ($sessionsByDate as $date => $sessionsForDate) {
            // Per branch
            foreach (Branch::all() as $branch) {
                $branchSessionIds = $sessionsForDate->where('branch_id', $branch->id)->pluck('id');
                if ($branchSessionIds->isEmpty()) continue;
                $records = AttendanceRecord::whereIn('attendance_session_id', $branchSessionIds)->get();
                self::storeSnapshot($branch->id, null, null, $date, $records, $statuses);
            }

            // Per class
            foreach ($sessionsForDate->groupBy('class_id') as $classId => $sessions) {
                $records = AttendanceRecord::whereIn('attendance_session_id', $sessions->pluck('id'))->get();
                $class   = SchoolClass::find($classId);
                self::storeSnapshot(optional($class)->branch_id, $classId, null, $date, $records, $statuses);
            }
        }
    }

    private static function storeSnapshot(?int $branchId, ?int $classId, ?int $studentId, string $date, $records, $statuses): void
    {
        $total      = $records->count();
        if ($total === 0) return;
        $present    = $records->where('attendance_status_id', optional($statuses['P']  ?? null)->id)->count();
        $absent     = $records->where('attendance_status_id', optional($statuses['A']  ?? null)->id)->count();
        $late       = $records->where('attendance_status_id', optional($statuses['L']  ?? null)->id)->count();
        $permission = $records->where('attendance_status_id', optional($statuses['PM'] ?? null)->id)->count();
        $leave      = $records->where('attendance_status_id', optional($statuses['LV'] ?? null)->id)->count();

        AnalyticsSnapshot::updateOrCreate(
            [
                'branch_id'     => $branchId,
                'class_id'      => $classId,
                'student_id'    => $studentId,
                'snapshot_date' => $date,
                'period_type'   => 'daily',
            ],
            [
                'total_students'   => $total,
                'present_count'    => $present,
                'absent_count'     => $absent,
                'late_count'       => $late,
                'permission_count' => $permission,
                'leave_count'      => $leave,
                'attendance_rate'  => round(($present + $late) / max($total, 1) * 100, 2),
                'absence_rate'     => round($absent / max($total, 1) * 100, 2),
                'late_rate'        => round($late / max($total, 1) * 100, 2),
                'details'          => null,
            ]
        );
    }
}
