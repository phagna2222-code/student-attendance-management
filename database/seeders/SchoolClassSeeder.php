<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Branch;
use App\Models\GradeLevel;
use App\Models\Room;
use App\Models\SchoolClass;
use App\Models\Shift;
use App\Models\Teacher;
use App\Models\Term;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
        $year = AcademicYear::where('code', '2025-2026')->first();
        if (! $year) return;

        $term = Term::where('academic_year_id', $year->id)->where('code', 'T1')->first();
        $morning = Shift::where('code', 'MORN')->first();
        $afternoon = Shift::where('code', 'AFTER')->first();

        $teachers = Teacher::all()->values();

        $matrix = [
            'MAIN' => [
                ['code' => 'G7-A',  'name' => 'Grade 7 — A',  'grade' => 'G7',  'shift' => $morning,   'room' => 'A101', 'limit' => 35],
                ['code' => 'G7-B',  'name' => 'Grade 7 — B',  'grade' => 'G7',  'shift' => $afternoon, 'room' => 'A101', 'limit' => 35],
                ['code' => 'G8-A',  'name' => 'Grade 8 — A',  'grade' => 'G8',  'shift' => $morning,   'room' => 'A102', 'limit' => 35],
                ['code' => 'G9-A',  'name' => 'Grade 9 — A',  'grade' => 'G9',  'shift' => $morning,   'room' => 'A201', 'limit' => 30],
                ['code' => 'G10-A', 'name' => 'Grade 10 — A', 'grade' => 'G10', 'shift' => $morning,   'room' => 'B101', 'limit' => 30],
                ['code' => 'G11-A', 'name' => 'Grade 11 — A', 'grade' => 'G11', 'shift' => $afternoon, 'room' => 'B101', 'limit' => 30],
                ['code' => 'G12-A', 'name' => 'Grade 12 — A', 'grade' => 'G12', 'shift' => $afternoon, 'room' => 'A201', 'limit' => 28],
            ],
            'BR2' => [
                ['code' => 'G7-A',  'name' => 'Grade 7 — A',  'grade' => 'G7',  'shift' => $morning,   'room' => 'A101', 'limit' => 30],
                ['code' => 'G8-A',  'name' => 'Grade 8 — A',  'grade' => 'G8',  'shift' => $morning,   'room' => 'A102', 'limit' => 30],
                ['code' => 'G9-A',  'name' => 'Grade 9 — A',  'grade' => 'G9',  'shift' => $afternoon, 'room' => 'A201', 'limit' => 25],
            ],
        ];

        $i = 0;
        foreach ($matrix as $branchCode => $classes) {
            $branch = Branch::where('code', $branchCode)->first();
            if (! $branch) continue;
            foreach ($classes as $c) {
                $grade = GradeLevel::where('code', $c['grade'])->first();
                $room  = Room::where('branch_id', $branch->id)->where('code', $c['room'])->first();
                $teacher = $teachers->isNotEmpty() ? $teachers[$i % $teachers->count()] : null;
                $i++;

                SchoolClass::updateOrCreate(
                    [
                        'branch_id'        => $branch->id,
                        'academic_year_id' => $year->id,
                        'code'             => $c['code'],
                    ],
                    [
                        'grade_level_id'   => optional($grade)->id,
                        'term_id'          => optional($term)->id,
                        'shift_id'         => optional($c['shift'])->id,
                        'room_id'          => optional($room)->id,
                        'class_teacher_id' => optional($teacher)->id,
                        'name'             => $c['name'],
                        'student_limit'    => $c['limit'],
                        'status'           => 'active',
                    ]
                );
            }
        }
    }
}
