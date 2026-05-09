<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassStudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::query()->whereNotNull('current_class_id')->each(function (Student $student) {
            DB::table('class_students')->updateOrInsert(
                ['class_id' => $student->current_class_id, 'student_id' => $student->id],
                [
                    'enrolled_at' => '2025-09-01',
                    'left_at'     => null,
                    'status'      => 'active',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        });
    }
}
