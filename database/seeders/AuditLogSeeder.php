<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Branch;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        $admin   = User::where('email', 'admin@example.com')->first();
        $teacher = User::where('email', 'teacher@example.com')->first();
        $branch  = Branch::where('code', 'MAIN')->first();
        $student = Student::orderBy('id')->first();

        $rows = [
            [
                'user'        => $admin,
                'event'       => 'login',
                'auditable'   => $admin ? [User::class, $admin->id] : null,
                'description' => 'User logged in successfully.',
                'method'      => 'POST',
                'url'         => '/login',
            ],
            [
                'user'        => $teacher,
                'event'       => 'attendance.submit',
                'auditable'   => $student ? [Student::class, $student->id] : null,
                'description' => 'Teacher submitted attendance for class G7-A.',
                'method'      => 'POST',
                'url'         => '/admin/attendance-sessions/1/submit',
            ],
            [
                'user'        => $admin,
                'event'       => 'student.update',
                'auditable'   => $student ? [Student::class, $student->id] : null,
                'description' => 'Updated student profile.',
                'method'      => 'PUT',
                'url'         => '/admin/students/'.optional($student)->id,
                'old_values'  => ['phone' => null],
                'new_values'  => ['phone' => '+855 12 999 999'],
            ],
        ];

        foreach ($rows as $r) {
            AuditLog::create([
                'user_id'        => optional($r['user'])->id,
                'branch_id'      => optional($branch)->id,
                'event'          => $r['event'],
                'auditable_type' => $r['auditable'][0] ?? null,
                'auditable_id'   => $r['auditable'][1] ?? null,
                'old_values'     => $r['old_values'] ?? null,
                'new_values'     => $r['new_values'] ?? null,
                'ip_address'     => '127.0.0.1',
                'user_agent'     => 'Mozilla/5.0 (Demo Seeder)',
                'url'            => $r['url'],
                'method'         => $r['method'],
                'description'    => $r['description'],
            ]);
        }
    }
}
