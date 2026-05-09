<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['group' => 'attendance',   'key' => 'attendance.default_grace_period_minutes', 'value' => 10,                       'value_type' => 'number',  'is_public' => false],
            ['group' => 'attendance',   'key' => 'attendance.allow_qr',                     'value' => true,                     'value_type' => 'boolean', 'is_public' => false],
            ['group' => 'attendance',   'key' => 'attendance.allow_barcode',                'value' => false,                    'value_type' => 'boolean', 'is_public' => false],
            ['group' => 'attendance',   'key' => 'attendance.allow_rfid',                   'value' => false,                    'value_type' => 'boolean', 'is_public' => false],
            ['group' => 'code_format',  'key' => 'student_code_format',                     'value' => 'STD-{YYYY}-{0000}',      'value_type' => 'string',  'is_public' => false],
            ['group' => 'code_format',  'key' => 'teacher_code_format',                     'value' => 'TCH-{YYYY}-{0000}',      'value_type' => 'string',  'is_public' => false],
            ['group' => 'security',     'key' => 'login_attempt_limit',                     'value' => 5,                        'value_type' => 'number',  'is_public' => false],
            ['group' => 'security',     'key' => 'login_lock_minutes',                      'value' => 15,                       'value_type' => 'number',  'is_public' => false],
            ['group' => 'backup',       'key' => 'daily_database_backup_enabled',           'value' => true,                     'value_type' => 'boolean', 'is_public' => false],
            ['group' => 'localization', 'key' => 'default_locale',                          'value' => 'en',                     'value_type' => 'string',  'is_public' => true],
            ['group' => 'localization', 'key' => 'available_locales',                       'value' => ['en', 'km'],             'value_type' => 'json',    'is_public' => true],
            ['group' => 'school',       'key' => 'school_motto',                            'value' => 'Discipline · Knowledge · Character', 'value_type' => 'string',  'is_public' => true],
        ];

        foreach ($rows as $r) {
            SystemSetting::updateOrCreate(
                ['key' => $r['key']],
                [
                    'group'      => $r['group'],
                    'value'      => $r['value'],
                    'value_type' => $r['value_type'],
                    'is_public'  => $r['is_public'],
                ]
            );
        }
    }
}
