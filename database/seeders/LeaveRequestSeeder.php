<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        $parent = User::where('email', 'parent@example.com')->first();
        $admin  = User::where('email', 'admin@example.com')->first();

        $students = Student::orderBy('id')->limit(6)->get();
        $samples = [
            ['leave_type' => 'sick',       'reason' => 'Stomach flu — visited clinic.',          'days' => 1, 'status' => 'approved'],
            ['leave_type' => 'family',     'reason' => 'Family event in province.',              'days' => 2, 'status' => 'approved'],
            ['leave_type' => 'permission', 'reason' => 'Doctor appointment.',                     'days' => 1, 'status' => 'pending'],
            ['leave_type' => 'leave',      'reason' => 'Travel during the holiday.',              'days' => 3, 'status' => 'rejected'],
            ['leave_type' => 'sick',       'reason' => 'High fever — needs rest.',                'days' => 2, 'status' => 'pending'],
            ['leave_type' => 'permission', 'reason' => 'Wedding ceremony of close relative.',     'days' => 1, 'status' => 'approved'],
        ];

        foreach ($students as $i => $student) {
            $s = $samples[$i % count($samples)];
            $start = now()->copy()->subDays(7 - $i)->startOfDay();
            $end = $start->copy()->addDays(max(0, $s['days'] - 1));

            LeaveRequest::updateOrCreate(
                ['request_no' => 'LR-2025-'.str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT)],
                [
                    'student_id'    => $student->id,
                    'requested_by'  => optional($parent)->id,
                    'approved_by'   => $s['status'] === 'pending' ? null : optional($admin)->id,
                    'start_date'    => $start->toDateString(),
                    'end_date'      => $end->toDateString(),
                    'total_days'    => $s['days'],
                    'leave_type'    => $s['leave_type'],
                    'reason'        => $s['reason'],
                    'status'        => $s['status'],
                    'submitted_at'  => $start->copy()->subDay(),
                    'approved_at'   => $s['status'] === 'approved' ? $start->copy()->subHours(8) : null,
                    'reject_reason' => $s['status'] === 'rejected' ? 'Insufficient documentation.' : null,
                ]
            );
        }
    }
}
