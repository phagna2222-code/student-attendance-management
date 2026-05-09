<?php

namespace Database\Seeders;

use App\Models\AttendanceSession;
use App\Models\TeachingRecord;
use Illuminate\Database\Seeder;

class TeachingRecordSeeder extends Seeder
{
    public function run(): void
    {
        AttendanceSession::orderBy('id')->get()->each(function (AttendanceSession $session) {
            TeachingRecord::updateOrCreate(
                [
                    'attendance_session_id' => $session->id,
                    'class_id'              => $session->class_id,
                    'teaching_date'         => $session->attendance_date,
                ],
                [
                    'subject_id'         => $session->subject_id,
                    'teacher_id'         => $session->teacher_id,
                    'lesson_title'       => 'Chapter '.((int) date('z', strtotime($session->attendance_date)) % 12 + 1),
                    'lesson_content'     => 'Covered the planned lesson and reviewed last session.',
                    'homework'           => 'Exercises 1–5 on textbook page 42.',
                    'notes'              => null,
                    'attendance_summary' => null,
                ]
            );
        });
    }
}
