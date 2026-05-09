<?php

namespace Database\Seeders;

use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\AttendanceStatus;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceRecordSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = AttendanceStatus::all()->keyBy('code');
        $teacher  = User::where('email', 'teacher@example.com')->first();

        $present    = $statuses['P']  ?? null;
        $absent     = $statuses['A']  ?? null;
        $late       = $statuses['L']  ?? null;
        $permission = $statuses['PM'] ?? null;
        if (! $present || ! $absent) return;

        AttendanceSession::orderBy('id')->get()->each(function (AttendanceSession $session) use ($present, $absent, $late, $permission, $teacher) {
            $students = Student::where('current_class_id', $session->class_id)->orderBy('id')->get();
            foreach ($students as $i => $student) {
                // Distribution: ~70% present, 10% late, 10% permission, 10% absent
                $mod = ($i + $session->id) % 10;
                $status = match (true) {
                    $mod < 7  => $present,
                    $mod === 7 => $late,
                    $mod === 8 => $permission ?? $present,
                    default   => $absent,
                };
                if (! $status) $status = $present;

                $isLate     = $status->code === 'L';
                $lateMin    = $isLate ? (5 + ($i % 20)) : 0;
                $checkIn    = $isLate ? '07:'.str_pad((string) (35 + ($i % 20)), 2, '0', STR_PAD_LEFT).':00' : '07:'.str_pad((string) (15 + ($i % 15)), 2, '0', STR_PAD_LEFT).':00';

                AttendanceRecord::updateOrCreate(
                    ['attendance_session_id' => $session->id, 'student_id' => $student->id],
                    [
                        'attendance_status_id' => $status->id,
                        'check_in_time'        => $status->code === 'A' ? null : $checkIn,
                        'check_out_time'       => $status->code === 'A' ? null : '12:00:00',
                        'marked_at'            => $session->attendance_date->copy()->setTime(7, 30),
                        'method'               => 'manual',
                        'is_late'              => $isLate,
                        'late_minutes'         => $lateMin,
                        'teacher_note'         => null,
                        'admin_note'           => null,
                        'marked_by'            => optional($teacher)->id,
                        'updated_by'           => optional($teacher)->id,
                    ]
                );
            }
        });
    }
}
