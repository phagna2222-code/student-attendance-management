<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\AttendanceSession;
use App\Models\SchoolClass;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSessionSeeder extends Seeder
{
    public function run(): void
    {
        $year     = AcademicYear::where('code', '2025-2026')->first();
        $term     = $year ? Term::where('academic_year_id', $year->id)->where('code', 'T1')->first() : null;
        $teacher  = User::where('email', 'teacher@example.com')->first();
        $admin    = User::where('email', 'admin@example.com')->first();

        // Create one daily session per class for the last 5 weekdays
        $today = now()->startOfDay();
        foreach (SchoolClass::all() as $class) {
            for ($d = 4; $d >= 0; $d--) {
                $date = $today->copy()->subDays($d);
                if (in_array($date->dayOfWeek, [0])) continue; // skip Sunday

                AttendanceSession::updateOrCreate(
                    [
                        'class_id'         => $class->id,
                        'subject_id'       => null,
                        'attendance_date'  => $date->toDateString(),
                        'session_type'     => 'daily',
                        'period_no'        => null,
                    ],
                    [
                        'branch_id'        => $class->branch_id,
                        'teacher_id'       => $class->class_teacher_id,
                        'timetable_id'     => null,
                        'academic_year_id' => optional($year)->id,
                        'term_id'          => optional($term)->id,
                        'start_time'       => '07:30:00',
                        'end_time'         => '12:00:00',
                        'submission_status'=> $d === 0 ? 'draft' : 'submitted',
                        'created_by'       => optional($teacher)->id,
                        'submitted_by'     => $d === 0 ? null : optional($teacher)->id,
                        'submitted_at'     => $d === 0 ? null : $date->copy()->setTime(12, 5),
                        'locked_by'        => $d > 1 ? optional($admin)->id : null,
                        'locked_at'        => $d > 1 ? $date->copy()->setTime(13, 0) : null,
                        'note'             => null,
                    ]
                );
            }
        }
    }
}
