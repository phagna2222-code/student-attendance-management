<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Branch;
use App\Models\GradeLevel;
use App\Models\Role;
use App\Models\Shift;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Branches
        $main = Branch::firstOrCreate(['code' => 'MAIN'], [
            'name_en' => 'Main Campus',
            'name_kh' => 'សាខាមេ',
            'phone' => '+855 23 000 000',
            'email' => 'main@example.com',
            'address' => 'Phnom Penh, Cambodia',
            'is_main' => true,
            'status' => 'active',
        ]);
        $b2 = Branch::firstOrCreate(['code' => 'BR2'], [
            'name_en' => 'Branch 2',
            'name_kh' => 'សាខាទី២',
            'phone' => '+855 23 000 001',
            'email' => 'br2@example.com',
            'address' => 'Siem Reap, Cambodia',
            'is_main' => false,
            'status' => 'active',
        ]);

        // Admin user
        $admin = User::firstOrCreate(['email' => 'admin@example.com'], [
            'branch_id' => $main->id,
            'name' => 'System Administrator',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'user_type' => 'super_admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $superRole = Role::where('slug', 'super-admin')->first();
        if ($superRole) $admin->roles()->syncWithoutDetaching([$superRole->id]);

        // Branch user pivot
        DB::table('branch_user')->updateOrInsert([
            'branch_id' => $main->id, 'user_id' => $admin->id,
        ], ['is_default' => true, 'created_at' => now(), 'updated_at' => now()]);

        // Teacher demo user
        $teacher = User::firstOrCreate(['email' => 'teacher@example.com'], [
            'branch_id' => $main->id,
            'name' => 'Demo Teacher',
            'username' => 'teacher',
            'password' => Hash::make('password'),
            'user_type' => 'teacher',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $teacherRole = Role::where('slug', 'teacher')->first();
        if ($teacherRole) $teacher->roles()->syncWithoutDetaching([$teacherRole->id]);

        // Academic year
        $year = AcademicYear::firstOrCreate(['code' => '2025-2026'], [
            'name' => 'Academic Year 2025-2026',
            'start_date' => '2025-09-01',
            'end_date' => '2026-07-31',
            'is_current' => true,
            'status' => 'active',
        ]);

        // Shifts
        Shift::firstOrCreate(['code' => 'MORN'], ['name' => 'Morning', 'start_time' => '07:00:00', 'end_time' => '12:00:00', 'status' => 'active']);
        Shift::firstOrCreate(['code' => 'AFTER'], ['name' => 'Afternoon', 'start_time' => '13:00:00', 'end_time' => '17:00:00', 'status' => 'active']);

        // Grade levels
        foreach ([
            ['code' => 'G7', 'name_en' => 'Grade 7', 'name_kh' => 'ថ្នាក់ទី៧', 'level_order' => 7],
            ['code' => 'G8', 'name_en' => 'Grade 8', 'name_kh' => 'ថ្នាក់ទី៨', 'level_order' => 8],
            ['code' => 'G9', 'name_en' => 'Grade 9', 'name_kh' => 'ថ្នាក់ទី៩', 'level_order' => 9],
            ['code' => 'G10', 'name_en' => 'Grade 10', 'name_kh' => 'ថ្នាក់ទី១០', 'level_order' => 10],
            ['code' => 'G11', 'name_en' => 'Grade 11', 'name_kh' => 'ថ្នាក់ទី១១', 'level_order' => 11],
            ['code' => 'G12', 'name_en' => 'Grade 12', 'name_kh' => 'ថ្នាក់ទី១២', 'level_order' => 12],
        ] as $gl) {
            GradeLevel::firstOrCreate(['code' => $gl['code']], $gl + ['status' => 'active']);
        }

        // Subjects
        foreach ([
            ['code' => 'MATH', 'name_en' => 'Mathematics', 'name_kh' => 'គណិតវិទ្យា'],
            ['code' => 'KH', 'name_en' => 'Khmer Language', 'name_kh' => 'ភាសាខ្មែរ'],
            ['code' => 'EN', 'name_en' => 'English Language', 'name_kh' => 'ភាសាអង់គ្លេស'],
            ['code' => 'PHY', 'name_en' => 'Physics', 'name_kh' => 'រូបវិទ្យា'],
            ['code' => 'CHE', 'name_en' => 'Chemistry', 'name_kh' => 'គីមីវិទ្យា'],
        ] as $s) {
            Subject::firstOrCreate(['code' => $s['code']], $s + ['status' => 'active']);
        }
    }
}
