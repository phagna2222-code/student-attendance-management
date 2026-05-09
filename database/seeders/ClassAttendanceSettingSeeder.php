<?php

namespace Database\Seeders;

use App\Models\ClassAttendanceSetting;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class ClassAttendanceSettingSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SchoolClass::all() as $class) {
            ClassAttendanceSetting::updateOrCreate(
                ['class_id' => $class->id],
                [
                    'study_days'                => [1, 2, 3, 4, 5, 6],
                    'check_in_start_time'       => '07:00:00',
                    'check_in_end_time'         => '07:30:00',
                    'check_out_time'            => '12:00:00',
                    'late_grace_minutes'        => 10,
                    'allow_manual_attendance'   => true,
                    'allow_qr_attendance'       => true,
                    'allow_barcode_attendance'  => false,
                    'allow_rfid_attendance'     => false,
                    'auto_mark_absent'          => false,
                ]
            );
        }
    }
}
