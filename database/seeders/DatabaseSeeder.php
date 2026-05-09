<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // ── Lookup tables ────────────────────────────────────────────
            AttendanceStatusSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            NotificationTemplateSeeder::class,
            SystemSettingSeeder::class,

            // ── School setup ─────────────────────────────────────────────
            BranchSeeder::class,
            SchoolProfileSeeder::class,
            AcademicYearSeeder::class,
            TermSeeder::class,
            ShiftSeeder::class,
            RoomSeeder::class,
            GradeLevelSeeder::class,
            SubjectSeeder::class,

            // ── People ───────────────────────────────────────────────────
            UserSeeder::class,
            TeacherSeeder::class,
            ParentSeeder::class,

            // ── Classes (depend on rooms, teachers, etc.) ────────────────
            SchoolClassSeeder::class,
            StudentSeeder::class,
            StudentDocumentSeeder::class,
            ParentStudentSeeder::class,
            ClassStudentSeeder::class,
            ClassTeacherSubjectSeeder::class,
            ClassAttendanceSettingSeeder::class,
            TimetableSeeder::class,

            // ── Attendance flow ─────────────────────────────────────────
            AttendanceSessionSeeder::class,
            AttendanceRecordSeeder::class,
            AttendanceImportSeeder::class,
            AttendanceEditRequestSeeder::class,
            LeaveRequestSeeder::class,
            LeaveRequestAttachmentSeeder::class,
            TeachingRecordSeeder::class,

            // ── Communications, analytics, audit ────────────────────────
            NotificationSeeder::class,
            NotificationLogSeeder::class,
            GeneratedReportSeeder::class,
            ReportExportSeeder::class,
            AnalyticsSnapshotSeeder::class,
            AuditLogSeeder::class,
            BackupLogSeeder::class,
        ]);
    }
}
