<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentStudentSeeder extends Seeder
{
    public function run(): void
    {
        $parents = StudentParent::orderBy('id')->get()->values();
        if ($parents->isEmpty()) return;

        $relationships = ['father', 'mother', 'guardian'];

        Student::orderBy('id')->get()->each(function (Student $student, $i) use ($parents, $relationships) {
            $parent = $parents[$i % $parents->count()];
            DB::table('parent_student')->updateOrInsert(
                ['parent_id' => $parent->id, 'student_id' => $student->id],
                [
                    'relationship'              => $relationships[$i % count($relationships)],
                    'is_primary'                => true,
                    'can_receive_notifications' => true,
                    'can_request_leave'         => true,
                    'created_at'                => now(),
                    'updated_at'                => now(),
                ]
            );
        });
    }
}
