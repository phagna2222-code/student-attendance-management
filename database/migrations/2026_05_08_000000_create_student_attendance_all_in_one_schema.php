<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Student Attendance Management System - All-in-One Laravel Migration
     * Target: PHP 8.4, Laravel, MySQL 8.4, InnoDB, utf8mb4
     *
     * Covered modules:
     * Dashboard, Student Management, Class Management, Attendance Entry,
     * Attendance Status, Leave Requests, Timetable/Sessions, Teacher Role,
     * Parent Notifications, Reports, Analytics, Parent/Student Portal,
     * Branch/Campus, Roles/Permissions, Security/Audit Log, System Settings.
     */
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name_kh')->nullable();
            $table->string('name_en');
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_main')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('school_profiles', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnUpdate()->nullOnDelete();
            $table->string('school_name_kh')->nullable();
            $table->string('school_name_en');
            $table->string('logo_path')->nullable();
            $table->string('seal_path')->nullable();
            $table->string('signature_path')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('academic_years', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_current')->default(false);
            $table->enum('status', ['planned', 'active', 'closed', 'archived'])->default('planned');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['start_date', 'end_date']);
        });

        Schema::create('terms', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('code', 50);
            $table->string('name');
            $table->unsignedTinyInteger('term_no')->default(1);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['planned', 'active', 'closed'])->default('planned');
            $table->timestamps();
            $table->unique(['academic_year_id', 'code']);
            $table->index(['start_date', 'end_date']);
        });

        Schema::create('shifts', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('code', 50);
            $table->string('name');
            $table->unsignedSmallInteger('capacity')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['branch_id', 'code']);
        });

        Schema::create('grade_levels', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name_kh')->nullable();
            $table->string('name_en');
            $table->unsignedSmallInteger('level_order')->default(1);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name_kh')->nullable();
            $table->string('name_en');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('attendance_statuses', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name_kh')->nullable();
            $table->string('name_en');
            $table->string('color', 30)->nullable();
            $table->boolean('counts_as_present')->default(false);
            $table->boolean('counts_as_absent')->default(false);
            $table->boolean('requires_approval')->default(false);
            $table->boolean('is_system')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_system')->default(false);
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('group', 100)->index();
            $table->string('slug', 150)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['permission_id', 'role_id']);
        });

        Schema::create('users', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnUpdate()->nullOnDelete();
            $table->string('name');
            $table->string('username', 100)->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('phone', 50)->nullable()->index();
            $table->string('password');
            $table->string('avatar_path')->nullable();
            $table->enum('user_type', ['super_admin', 'school_admin', 'teacher', 'secretary', 'parent', 'student', 'auditor'])->default('student');
            $table->enum('status', ['active', 'inactive', 'blocked', 'pending'])->default('active');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->unsignedSmallInteger('failed_login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['branch_id', 'user_type', 'status']);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['role_id', 'user_id']);
        });

        Schema::create('branch_user', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->unique(['branch_id', 'user_id']);
        });

        Schema::create('teachers', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnUpdate()->nullOnDelete();
            $table->string('teacher_code', 50)->unique();
            $table->string('name_kh')->nullable();
            $table->string('name_en');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('photo_path')->nullable();
            $table->enum('status', ['active', 'inactive', 'resigned', 'suspended'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['branch_id', 'status']);
        });

        Schema::create('parents', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('parent_code', 50)->nullable()->unique();
            $table->string('name_kh')->nullable();
            $table->string('name_en');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('phone', 50)->nullable()->index();
            $table->string('secondary_phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('telegram_chat_id')->nullable();
            $table->text('address')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('school_classes', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('grade_level_id')->nullable()->constrained('grade_levels')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('term_id')->nullable()->constrained('terms')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('class_teacher_id')->nullable()->constrained('teachers')->cascadeOnUpdate()->nullOnDelete();
            $table->string('code', 80);
            $table->string('name');
            $table->unsignedSmallInteger('student_limit')->nullable();
            $table->enum('status', ['planned', 'active', 'closed', 'archived'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['branch_id', 'academic_year_id', 'code']);
            $table->index(['branch_id', 'academic_year_id', 'status']);
        });

        Schema::create('students', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('current_class_id')->nullable()->constrained('school_classes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->cascadeOnUpdate()->nullOnDelete();
            $table->string('student_code', 80)->unique();
            $table->string('student_no', 80)->nullable()->index();
            $table->string('name_kh')->nullable();
            $table->string('name_en');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('qr_code_value')->nullable()->unique();
            $table->string('qr_code_path')->nullable();
            $table->string('barcode_value')->nullable()->unique();
            $table->string('rfid_uid')->nullable()->unique();
            $table->enum('status', ['active', 'studying', 'suspended', 'dropout', 'graduated', 'transferred'])->default('studying');
            $table->date('admission_date')->nullable();
            $table->date('exit_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['branch_id', 'current_class_id', 'status']);
        });

        Schema::create('student_documents', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('document_type', 100)->nullable();
            $table->string('title');
            $table->string('file_path');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();
        });

        Schema::create('parent_student', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('parent_id')->constrained('parents')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('relationship', ['father', 'mother', 'guardian', 'relative', 'other'])->default('guardian');
            $table->boolean('is_primary')->default(false);
            $table->boolean('can_receive_notifications')->default(true);
            $table->boolean('can_request_leave')->default(true);
            $table->timestamps();
            $table->unique(['parent_id', 'student_id']);
        });

        Schema::create('class_students', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('class_id')->constrained('school_classes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('enrolled_at')->nullable();
            $table->date('left_at')->nullable();
            $table->enum('status', ['active', 'transferred', 'left', 'completed'])->default('active');
            $table->timestamps();
            $table->unique(['class_id', 'student_id']);
            $table->index(['student_id', 'status']);
        });

        Schema::create('class_teacher_subjects', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('class_id')->constrained('school_classes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->unique(['class_id', 'teacher_id', 'subject_id', 'academic_year_id'], 'class_teacher_subject_unique');
        });

        Schema::create('class_attendance_settings', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('class_id')->unique()->constrained('school_classes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->json('study_days')->nullable()->comment('Example: [1,2,3,4,5,6] where 0=Sunday');
            $table->time('check_in_start_time')->nullable();
            $table->time('check_in_end_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->unsignedSmallInteger('late_grace_minutes')->default(0);
            $table->boolean('allow_manual_attendance')->default(true);
            $table->boolean('allow_qr_attendance')->default(true);
            $table->boolean('allow_barcode_attendance')->default(false);
            $table->boolean('allow_rfid_attendance')->default(false);
            $table->boolean('auto_mark_absent')->default(false);
            $table->timestamps();
        });

        Schema::create('timetables', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('class_id')->constrained('school_classes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('term_id')->nullable()->constrained('terms')->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedTinyInteger('day_of_week')->comment('0=Sunday, 6=Saturday');
            $table->string('session_name', 100)->nullable();
            $table->unsignedSmallInteger('period_no')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->index(['class_id', 'day_of_week', 'start_time']);
        });

        Schema::create('attendance_sessions', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('school_classes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('timetable_id')->nullable()->constrained('timetables')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('term_id')->nullable()->constrained('terms')->cascadeOnUpdate()->nullOnDelete();
            $table->date('attendance_date');
            $table->enum('session_type', ['daily', 'period', 'morning', 'afternoon', 'evening'])->default('daily');
            $table->unsignedSmallInteger('period_no')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('submission_status', ['draft', 'submitted', 'locked', 'cancelled'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('locked_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamp('locked_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['class_id', 'subject_id', 'attendance_date', 'session_type', 'period_no'], 'attendance_session_unique');
            $table->index(['branch_id', 'attendance_date', 'submission_status']);
        });

        Schema::create('attendance_records', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('attendance_session_id')->constrained('attendance_sessions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('attendance_status_id')->constrained('attendance_statuses')->cascadeOnUpdate()->restrictOnDelete();
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->timestamp('marked_at')->nullable();
            $table->enum('method', ['manual', 'qr_code', 'barcode', 'rfid', 'import', 'system'])->default('manual');
            $table->boolean('is_late')->default(false);
            $table->unsignedSmallInteger('late_minutes')->default(0);
            $table->text('teacher_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->foreignId('marked_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['attendance_session_id', 'student_id'], 'attendance_record_session_student_unique');
            $table->index(['student_id', 'attendance_status_id']);
            $table->index(['is_late', 'late_minutes']);
        });

        Schema::create('attendance_imports', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('class_id')->nullable()->constrained('school_classes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('attendance_session_id')->nullable()->constrained('attendance_sessions')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('imported_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('file_path');
            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('success_rows')->default(0);
            $table->unsignedInteger('failed_rows')->default(0);
            $table->json('errors')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });

        Schema::create('attendance_edit_requests', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('attendance_record_id')->constrained('attendance_records')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('requested_status_id')->nullable()->constrained('attendance_statuses')->cascadeOnUpdate()->nullOnDelete();
            $table->text('reason');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_note')->nullable();
            $table->timestamps();
        });

        Schema::create('leave_requests', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('request_no', 80)->unique();
            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('requested_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_days', 5, 2)->default(1);
            $table->enum('leave_type', ['permission', 'leave', 'sick', 'family', 'other'])->default('permission');
            $table->text('reason');
            $table->enum('status', ['pending', 'approved', 'rejected', 'need_more_info', 'cancelled'])->default('pending');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('reject_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['student_id', 'start_date', 'end_date']);
            $table->index(['status', 'submitted_at']);
        });

        Schema::create('leave_request_attachments', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('leave_request_id')->constrained('leave_requests')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();
        });

        Schema::create('teaching_records', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('attendance_session_id')->nullable()->constrained('attendance_sessions')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('class_id')->constrained('school_classes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->cascadeOnUpdate()->nullOnDelete();
            $table->date('teaching_date');
            $table->string('lesson_title')->nullable();
            $table->text('lesson_content')->nullable();
            $table->text('homework')->nullable();
            $table->text('notes')->nullable();
            $table->json('attendance_summary')->nullable();
            $table->timestamps();
            $table->index(['class_id', 'teaching_date']);
        });

        Schema::create('notification_templates', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('code', 100)->unique();
            $table->string('name');
            $table->enum('channel', ['sms', 'email', 'telegram', 'portal', 'push']);
            $table->string('subject')->nullable();
            $table->text('body');
            $table->json('variables')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('template_id')->nullable()->constrained('notification_templates')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('student_id')->nullable()->constrained('students')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('parents')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('school_classes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->enum('type', ['absent_alert', 'late_alert', 'early_leave_alert', 'leave_approved', 'leave_rejected', 'monthly_summary', 'consecutive_absent_warning', 'general'])->default('general');
            $table->enum('channel', ['sms', 'email', 'telegram', 'portal', 'push']);
            $table->string('recipient_name')->nullable();
            $table->string('recipient_contact')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->json('payload')->nullable();
            $table->enum('status', ['queued', 'sent', 'failed', 'cancelled', 'read'])->default('queued');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();
            $table->index(['type', 'channel', 'status']);
            $table->index(['student_id', 'parent_id']);
        });

        Schema::create('notification_logs', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('notification_id')->constrained('notifications')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('provider', 100)->nullable();
            $table->string('provider_message_id')->nullable();
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->enum('status', ['success', 'failed'])->default('success');
            $table->text('error_message')->nullable();
            $table->timestamps();
        });

        Schema::create('generated_reports', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('report_no', 80)->nullable()->unique();
            $table->enum('report_type', ['daily_attendance', 'monthly_attendance', 'yearly_attendance', 'student_history', 'class_summary', 'subject_attendance', 'teacher_submission', 'absent_students', 'late_students', 'permission_students', 'consecutive_absent', 'campus_attendance'])->index();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('school_classes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('student_id')->nullable()->constrained('students')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->cascadeOnUpdate()->nullOnDelete();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->json('filters')->nullable();
            $table->json('summary')->nullable();
            $table->foreignId('generated_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('report_exports', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('generated_report_id')->constrained('generated_reports')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('format', ['pdf', 'excel', 'csv', 'word', 'print'])->default('pdf');
            $table->string('file_path')->nullable();
            $table->foreignId('exported_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamp('exported_at')->nullable();
            $table->timestamps();
        });

        Schema::create('analytics_snapshots', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('school_classes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('student_id')->nullable()->constrained('students')->cascadeOnUpdate()->nullOnDelete();
            $table->date('snapshot_date')->index();
            $table->enum('period_type', ['daily', 'monthly', 'yearly'])->default('daily');
            $table->unsignedInteger('total_students')->default(0);
            $table->unsignedInteger('present_count')->default(0);
            $table->unsignedInteger('absent_count')->default(0);
            $table->unsignedInteger('late_count')->default(0);
            $table->unsignedInteger('permission_count')->default(0);
            $table->unsignedInteger('leave_count')->default(0);
            $table->decimal('attendance_rate', 6, 2)->default(0);
            $table->decimal('absence_rate', 6, 2)->default(0);
            $table->decimal('late_rate', 6, 2)->default(0);
            $table->json('details')->nullable();
            $table->timestamps();
            $table->unique(['branch_id', 'class_id', 'student_id', 'snapshot_date', 'period_type'], 'analytics_snapshot_unique');
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnUpdate()->nullOnDelete();
            $table->string('event', 150)->index();
            $table->string('auditable_type')->nullable();
            $table->unsignedBigInteger('auditable_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string('method', 20)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index(['auditable_type', 'auditable_id']);
        });

        Schema::create('backup_logs', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->enum('type', ['database', 'files', 'full'])->default('database');
            $table->enum('destination', ['local', 'cloud', 'download'])->default('local');
            $table->string('file_path')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->enum('status', ['pending', 'running', 'success', 'failed', 'restored', 'tested'])->default('pending');
            $table->foreignId('requested_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $this->tableDefaults($table);
            $table->id();
            $table->string('group', 100)->default('general')->index();
            $table->string('key', 150)->unique();
            $table->json('value')->nullable();
            $table->enum('value_type', ['string', 'number', 'boolean', 'json', 'array'])->default('string');
            $table->boolean('is_public')->default(false);
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });

        $this->insertDefaultAttendanceStatuses();
        $this->insertDefaultRoles();
        $this->insertDefaultNotificationTemplates();
        $this->insertDefaultSystemSettings();
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('backup_logs');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('analytics_snapshots');
        Schema::dropIfExists('report_exports');
        Schema::dropIfExists('generated_reports');
        Schema::dropIfExists('notification_logs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('notification_templates');
        Schema::dropIfExists('teaching_records');
        Schema::dropIfExists('leave_request_attachments');
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('attendance_edit_requests');
        Schema::dropIfExists('attendance_imports');
        Schema::dropIfExists('attendance_records');
        Schema::dropIfExists('attendance_sessions');
        Schema::dropIfExists('timetables');
        Schema::dropIfExists('class_attendance_settings');
        Schema::dropIfExists('class_teacher_subjects');
        Schema::dropIfExists('class_students');
        Schema::dropIfExists('parent_student');
        Schema::dropIfExists('student_documents');
        Schema::dropIfExists('students');
        Schema::dropIfExists('school_classes');
        Schema::dropIfExists('parents');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('branch_user');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('users');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('attendance_statuses');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('grade_levels');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('terms');
        Schema::dropIfExists('academic_years');
        Schema::dropIfExists('school_profiles');
        Schema::dropIfExists('branches');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function tableDefaults(Blueprint $table): void
    {
        $table->engine = 'InnoDB';
        $table->charset = 'utf8mb4';
        $table->collation = 'utf8mb4_unicode_ci';
    }

    private function insertDefaultAttendanceStatuses(): void
    {
        DB::table('attendance_statuses')->insert([
            [
                'code' => 'P',
                'name_kh' => 'មានវត្តមាន',
                'name_en' => 'Present',
                'color' => '#16a34a',
                'counts_as_present' => true,
                'counts_as_absent' => false,
                'requires_approval' => false,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'A',
                'name_kh' => 'អវត្តមាន',
                'name_en' => 'Absent',
                'color' => '#dc2626',
                'counts_as_present' => false,
                'counts_as_absent' => true,
                'requires_approval' => false,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'L',
                'name_kh' => 'មកយឺត',
                'name_en' => 'Late',
                'color' => '#f59e0b',
                'counts_as_present' => true,
                'counts_as_absent' => false,
                'requires_approval' => false,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PM',
                'name_kh' => 'មានច្បាប់',
                'name_en' => 'Permission',
                'color' => '#2563eb',
                'counts_as_present' => false,
                'counts_as_absent' => false,
                'requires_approval' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'LV',
                'name_kh' => 'ឈប់សម្រាក',
                'name_en' => 'Leave',
                'color' => '#7c3aed',
                'counts_as_present' => false,
                'counts_as_absent' => false,
                'requires_approval' => true,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EL',
                'name_kh' => 'ចេញមុនម៉ោង',
                'name_en' => 'Early Leave',
                'color' => '#9333ea',
                'counts_as_present' => true,
                'counts_as_absent' => false,
                'requires_approval' => true,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    private function insertDefaultRoles(): void
    {
        DB::table('roles')->insert([
            ['slug' => 'super-admin', 'name' => 'Super Admin', 'description' => 'Full system management access.', 'is_system' => true, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'school-admin', 'name' => 'School Admin', 'description' => 'Manage students, classes, attendance, and reports.', 'is_system' => true, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'teacher', 'name' => 'Teacher', 'description' => 'Mark and submit attendance for assigned classes.', 'is_system' => true, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'secretary', 'name' => 'Secretary', 'description' => 'Assist with student lists, reports, and notifications.', 'is_system' => true, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'parent', 'name' => 'Parent', 'description' => 'View child attendance and request leave.', 'is_system' => true, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'student', 'name' => 'Student', 'description' => 'View own attendance, timetable, and leave status.', 'is_system' => true, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'auditor', 'name' => 'Auditor', 'description' => 'Read-only reporting and audit access.', 'is_system' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $permissions = [
            ['dashboard', 'dashboard.view', 'View Dashboard'],
            ['students', 'students.view', 'View Students'],
            ['students', 'students.create', 'Create Students'],
            ['students', 'students.update', 'Update Students'],
            ['students', 'students.delete', 'Delete Students'],
            ['classes', 'classes.manage', 'Manage Classes'],
            ['attendance', 'attendance.view', 'View Attendance'],
            ['attendance', 'attendance.mark', 'Mark Attendance'],
            ['attendance', 'attendance.submit', 'Submit Attendance'],
            ['attendance', 'attendance.lock', 'Lock Attendance'],
            ['attendance', 'attendance.edit-after-lock', 'Edit Attendance After Lock'],
            ['leave', 'leave.request', 'Request Leave'],
            ['leave', 'leave.approve', 'Approve Leave'],
            ['notifications', 'notifications.send', 'Send Notifications'],
            ['reports', 'reports.view', 'View Reports'],
            ['reports', 'reports.export', 'Export Reports'],
            ['analytics', 'analytics.view', 'View Analytics'],
            ['settings', 'settings.manage', 'Manage Settings'],
            ['security', 'audit.view', 'View Audit Logs'],
            ['backup', 'backup.manage', 'Manage Backups'],
        ];

        foreach ($permissions as [$group, $slug, $name]) {
            DB::table('permissions')->insert([
                'group' => $group,
                'slug' => $slug,
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function insertDefaultNotificationTemplates(): void
    {
        DB::table('notification_templates')->insert([
            [
                'code' => 'ABSENT_ALERT_SMS',
                'name' => 'Absent Alert SMS',
                'channel' => 'sms',
                'subject' => null,
                'body' => 'Dear parent, {student_name} is absent from {class_name} on {date}. Please contact the school if needed.',
                'variables' => json_encode(['student_name', 'class_name', 'date']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'LATE_ALERT_SMS',
                'name' => 'Late Alert SMS',
                'channel' => 'sms',
                'subject' => null,
                'body' => 'Dear parent, {student_name} arrived late at {check_in_time} on {date}.',
                'variables' => json_encode(['student_name', 'check_in_time', 'date']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'MONTHLY_SUMMARY_EMAIL',
                'name' => 'Monthly Attendance Summary Email',
                'channel' => 'email',
                'subject' => 'Monthly Attendance Summary for {student_name}',
                'body' => 'Present: {present_count}, Absent: {absent_count}, Late: {late_count}, Permission: {permission_count}.',
                'variables' => json_encode(['student_name', 'present_count', 'absent_count', 'late_count', 'permission_count']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    private function insertDefaultSystemSettings(): void
    {
        DB::table('system_settings')->insert([
            [
                'group' => 'attendance',
                'key' => 'attendance.default_grace_period_minutes',
                'value' => json_encode(10),
                'value_type' => 'number',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'code_format',
                'key' => 'student_code_format',
                'value' => json_encode('STD-{YYYY}-{0000}'),
                'value_type' => 'string',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'security',
                'key' => 'login_attempt_limit',
                'value' => json_encode(5),
                'value_type' => 'number',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'backup',
                'key' => 'daily_database_backup_enabled',
                'value' => json_encode(true),
                'value_type' => 'boolean',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
};
