<?php

namespace App\Console\Commands;

use App\Models\AnalyticsSnapshot;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\SchoolClass;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class AnalyticsRebuildCommand extends Command
{
    protected $signature = 'analytics:rebuild
                            {--date= : Date YYYY-MM-DD (defaults to today)}
                            {--period=daily : daily|monthly|yearly}';

    protected $description = 'Rebuild analytics_snapshots for the given date/period from raw attendance_records.';

    public function handle(): int
    {
        $date   = $this->option('date') ? Carbon::parse($this->option('date')) : now();
        $period = $this->option('period');

        $this->info("Rebuilding {$period} analytics for {$date->toDateString()} ...");

        [$from, $to] = match ($period) {
            'monthly' => [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()],
            'yearly'  => [$date->copy()->startOfYear(),  $date->copy()->endOfYear()],
            default   => [$date->copy()->startOfDay(),   $date->copy()->endOfDay()],
        };

        $sessions = AttendanceSession::query()
            ->whereBetween('attendance_date', [$from, $to])
            ->get(['id', 'branch_id', 'class_id', 'attendance_date']);

        $sessionIds = $sessions->pluck('id');

        $records = AttendanceRecord::query()
            ->whereIn('attendance_session_id', $sessionIds)
            ->with('status:id,code,counts_as_present,counts_as_absent,counts_as_late')
            ->get();

        $byClass = $records->groupBy(fn ($r) => $sessions->firstWhere('id', $r->attendance_session_id)?->class_id);

        $written = 0;

        foreach ($byClass as $classId => $rows) {
            if (! $classId) continue;
            $branchId = optional(SchoolClass::find($classId))->branch_id;
            $present = $rows->filter(fn ($r) => $r->status?->counts_as_present)->count();
            $absent  = $rows->filter(fn ($r) => $r->status?->counts_as_absent)->count();
            $late    = $rows->filter(fn ($r) => $r->status?->counts_as_late)->count();
            $total   = $rows->count();
            $rate    = $total > 0 ? round(100 * $present / $total, 2) : 0;
            $absRate = $total > 0 ? round(100 * $absent  / $total, 2) : 0;
            $lateRate= $total > 0 ? round(100 * $late    / $total, 2) : 0;

            AnalyticsSnapshot::updateOrCreate(
                [
                    'branch_id' => $branchId,
                    'class_id'  => $classId,
                    'student_id'=> null,
                    'snapshot_date' => $from->toDateString(),
                    'period_type'   => $period,
                ],
                [
                    'total_students'   => $total,
                    'present_count'    => $present,
                    'absent_count'     => $absent,
                    'late_count'       => $late,
                    'permission_count' => 0,
                    'leave_count'      => 0,
                    'attendance_rate'  => $rate,
                    'absence_rate'     => $absRate,
                    'late_rate'        => $lateRate,
                ]
            );
            $written++;
        }

        $this->info("Done. {$written} snapshot rows updated.");
        return self::SUCCESS;
    }
}
