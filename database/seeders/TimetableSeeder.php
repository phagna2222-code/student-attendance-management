<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassTeacherSubject;
use App\Models\SchoolClass;
use App\Models\Term;
use App\Models\Timetable;
use Illuminate\Database\Seeder;

class TimetableSeeder extends Seeder
{
    public function run(): void
    {
        $year = AcademicYear::where('code', '2025-2026')->first();
        if (! $year) return;
        $term = Term::where('academic_year_id', $year->id)->where('code', 'T1')->first();

        $slots = [
            ['day' => 1, 'period' => 1, 'start' => '07:30:00', 'end' => '08:15:00', 'session' => 'P1'],
            ['day' => 1, 'period' => 2, 'start' => '08:20:00', 'end' => '09:05:00', 'session' => 'P2'],
            ['day' => 2, 'period' => 1, 'start' => '07:30:00', 'end' => '08:15:00', 'session' => 'P1'],
            ['day' => 3, 'period' => 1, 'start' => '07:30:00', 'end' => '08:15:00', 'session' => 'P1'],
            ['day' => 4, 'period' => 1, 'start' => '07:30:00', 'end' => '08:15:00', 'session' => 'P1'],
            ['day' => 5, 'period' => 1, 'start' => '07:30:00', 'end' => '08:15:00', 'session' => 'P1'],
        ];

        foreach (SchoolClass::all() as $class) {
            $assignments = ClassTeacherSubject::where('class_id', $class->id)->get()->values();
            if ($assignments->isEmpty()) continue;

            foreach ($slots as $i => $slot) {
                $a = $assignments[$i % $assignments->count()];
                Timetable::updateOrCreate(
                    [
                        'class_id'   => $class->id,
                        'day_of_week'=> $slot['day'],
                        'start_time' => $slot['start'],
                        'subject_id' => $a->subject_id,
                    ],
                    [
                        'teacher_id'   => $a->teacher_id,
                        'room_id'      => $class->room_id,
                        'term_id'      => optional($term)->id,
                        'session_name' => $slot['session'],
                        'period_no'    => $slot['period'],
                        'end_time'     => $slot['end'],
                        'status'       => 'active',
                    ]
                );
            }
        }
    }
}
