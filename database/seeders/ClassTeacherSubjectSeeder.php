<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassTeacherSubject;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class ClassTeacherSubjectSeeder extends Seeder
{
    public function run(): void
    {
        $year = AcademicYear::where('code', '2025-2026')->first();
        $teachers = Teacher::all()->values();
        $subjects = Subject::all()->values();
        if (! $year || $teachers->isEmpty() || $subjects->isEmpty()) return;

        $i = 0;
        foreach (SchoolClass::all() as $class) {
            // Each class gets 5 subject-teacher assignments
            for ($n = 0; $n < 5; $n++) {
                $teacher = $teachers[($i + $n) % $teachers->count()];
                $subject = $subjects[($i + $n) % $subjects->count()];
                ClassTeacherSubject::updateOrCreate(
                    [
                        'class_id'         => $class->id,
                        'teacher_id'       => $teacher->id,
                        'subject_id'       => $subject->id,
                        'academic_year_id' => $year->id,
                    ],
                    ['status' => 'active']
                );
            }
            $i += 2;
        }
    }
}
