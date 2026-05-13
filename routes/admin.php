<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\AnalyticsSnapshotController;
use App\Http\Controllers\Admin\AttendanceEditRequestController;
use App\Http\Controllers\Admin\AttendanceImportController;
use App\Http\Controllers\Admin\AttendanceRecordController;
use App\Http\Controllers\Admin\AttendanceSessionController;
use App\Http\Controllers\Admin\AttendanceStatusController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BackupLogController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ClassAttendanceSettingController;
use App\Http\Controllers\Admin\ClassStudentController;
use App\Http\Controllers\Admin\ClassTeacherSubjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeLevelController;
use App\Http\Controllers\Admin\LeaveRequestAttachmentController;
use App\Http\Controllers\Admin\LeaveRequestController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\NotificationLogController;
use App\Http\Controllers\Admin\NotificationTemplateController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentDocumentController;
use App\Http\Controllers\Admin\StudentParentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TeachingRecordController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', \App\Http\Middleware\EnsureAdminAuthenticated::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/', DashboardController::class)->name('dashboard');

    // Branch context
    Route::post('branch/set', [BranchController::class, 'setActive'])->name('branch.set');

    $resources = [
        'branches'                  => BranchController::class,
        'school-profiles'           => SchoolProfileController::class,
        'academic-years'            => AcademicYearController::class,
        'terms'                     => TermController::class,
        'shifts'                    => ShiftController::class,
        'rooms'                     => RoomController::class,
        'grade-levels'              => GradeLevelController::class,
        'subjects'                  => SubjectController::class,
        'attendance-statuses'       => AttendanceStatusController::class,
        'roles'                     => RoleController::class,
        'permissions'               => PermissionController::class,
        'users'                     => UserController::class,
        'teachers'                  => TeacherController::class,
        'parents'                   => StudentParentController::class,
        'students'                  => StudentController::class,
        'classes'                   => SchoolClassController::class,
        'class-teacher-subjects'    => ClassTeacherSubjectController::class,
        'class-attendance-settings' => ClassAttendanceSettingController::class,
        'timetables'                => TimetableController::class,
        'attendance-sessions'       => AttendanceSessionController::class,
        'leave-requests'            => LeaveRequestController::class,
        'notification-templates'    => NotificationTemplateController::class,
        'teaching-records'          => TeachingRecordController::class,
    ];

    foreach ($resources as $slug => $controller) {
        Route::get($slug.'/datatable', [$controller, 'datatable'])->name($slug.'.datatable');
        Route::resource($slug, $controller)->parameters([$slug => 'id'])->except(['show']);
    }

    // Attendance sessions: workflow actions
    Route::post('attendance-sessions/{id}/submit', [AttendanceSessionController::class, 'submit'])->name('attendance-sessions.submit');
    Route::post('attendance-sessions/{id}/lock',   [AttendanceSessionController::class, 'lock'])->name('attendance-sessions.lock');
    Route::post('attendance-sessions/{id}/cancel', [AttendanceSessionController::class, 'cancel'])->name('attendance-sessions.cancel');
    Route::post('attendance-sessions/{id}/reopen', [AttendanceSessionController::class, 'reopen'])->name('attendance-sessions.reopen');

    // Leave requests workflow
    Route::post('leave-requests/{id}/approve',   [LeaveRequestController::class, 'approve'])->name('leave-requests.approve');
    Route::post('leave-requests/{id}/reject',    [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');
    Route::post('leave-requests/{id}/need-info', [LeaveRequestController::class, 'needInfo'])->name('leave-requests.need-info');
    Route::post('leave-requests/{id}/cancel',    [LeaveRequestController::class, 'cancel'])->name('leave-requests.cancel');

    // Leave request attachments
    Route::post('leave-requests/{leaveId}/attachments',                 [LeaveRequestAttachmentController::class, 'store'])->name('leave-requests.attachments.store');
    Route::get('leave-requests/{leaveId}/attachments/{id}/download',    [LeaveRequestAttachmentController::class, 'download'])->name('leave-requests.attachments.download');
    Route::delete('leave-requests/{leaveId}/attachments/{id}',          [LeaveRequestAttachmentController::class, 'destroy'])->name('leave-requests.attachments.destroy');

    // Attendance records (bulk entry)
    Route::get('attendance-records',             [AttendanceRecordController::class, 'index'])->name('attendance-records.index');
    Route::get('attendance-records/datatable',   [AttendanceRecordController::class, 'datatable'])->name('attendance-records.datatable');
    Route::get('attendance-records/entry',       [AttendanceRecordController::class, 'entry'])->name('attendance-records.entry');
    Route::post('attendance-records/entry',      [AttendanceRecordController::class, 'submitEntry'])->name('attendance-records.submit');

    // Attendance imports
    Route::get('attendance-imports',                 [AttendanceImportController::class, 'index'])->name('attendance-imports.index');
    Route::get('attendance-imports/datatable',       [AttendanceImportController::class, 'datatable'])->name('attendance-imports.datatable');
    Route::post('attendance-imports',                [AttendanceImportController::class, 'store'])->name('attendance-imports.store');
    Route::get('attendance-imports/{id}/errors',     [AttendanceImportController::class, 'errors'])->name('attendance-imports.errors');

    // Attendance edit requests
    Route::get('attendance-edit-requests',                [AttendanceEditRequestController::class, 'index'])->name('attendance-edit-requests.index');
    Route::get('attendance-edit-requests/datatable',      [AttendanceEditRequestController::class, 'datatable'])->name('attendance-edit-requests.datatable');
    Route::post('attendance-edit-requests',               [AttendanceEditRequestController::class, 'store'])->name('attendance-edit-requests.store');
    Route::post('attendance-edit-requests/{id}/approve',  [AttendanceEditRequestController::class, 'approve'])->name('attendance-edit-requests.approve');
    Route::post('attendance-edit-requests/{id}/reject',   [AttendanceEditRequestController::class, 'reject'])->name('attendance-edit-requests.reject');

    // Class students (pivot)
    Route::get('class-students',                 [ClassStudentController::class, 'index'])->name('class-students.index');
    Route::get('class-students/datatable',       [ClassStudentController::class, 'datatable'])->name('class-students.datatable');
    Route::post('class-students',                [ClassStudentController::class, 'store'])->name('class-students.store');
    Route::delete('class-students/{id}',         [ClassStudentController::class, 'destroy'])->name('class-students.destroy');

    // Student documents
    Route::get('students/{studentId}/documents',                  [StudentDocumentController::class, 'index'])->name('students.documents.index');
    Route::post('students/{studentId}/documents',                 [StudentDocumentController::class, 'store'])->name('students.documents.store');
    Route::delete('students/{studentId}/documents/{id}',          [StudentDocumentController::class, 'destroy'])->name('students.documents.destroy');
    Route::get('students/{studentId}/documents/{id}/download',    [StudentDocumentController::class, 'download'])->name('students.documents.download');

    // Notifications: compose / send / list
    Route::get('notifications',                  [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/datatable',        [NotificationController::class, 'datatable'])->name('notifications.datatable');
    Route::get('notifications/compose',          [NotificationController::class, 'compose'])->name('notifications.compose');
    Route::post('notifications',                 [NotificationController::class, 'store'])->name('notifications.store');
    Route::post('notifications/{id}/send',       [NotificationController::class, 'send'])->name('notifications.send');

    // Notification logs (read-only)
    Route::get('notification-logs',              [NotificationLogController::class, 'index'])->name('notification-logs.index');
    Route::get('notification-logs/datatable',    [NotificationLogController::class, 'datatable'])->name('notification-logs.datatable');

    // Analytics snapshots
    Route::get('analytics-snapshots',            [AnalyticsSnapshotController::class, 'index'])->name('analytics-snapshots.index');
    Route::get('analytics-snapshots/datatable',  [AnalyticsSnapshotController::class, 'datatable'])->name('analytics-snapshots.datatable');
    Route::post('analytics-snapshots/rebuild',   [AnalyticsSnapshotController::class, 'rebuild'])->name('analytics-snapshots.rebuild');

    // Backup logs
    Route::get('backup-logs',                    [BackupLogController::class, 'index'])->name('backup-logs.index');
    Route::get('backup-logs/datatable',          [BackupLogController::class, 'datatable'])->name('backup-logs.datatable');
    Route::post('backup-logs/run',               [BackupLogController::class, 'run'])->name('backup-logs.run');
    Route::get('backup-logs/{id}/download',      [BackupLogController::class, 'download'])->name('backup-logs.download');

    // Audit logs (read-only)
    Route::get('audit-logs',                     [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('audit-logs/datatable',           [AuditLogController::class, 'datatable'])->name('audit-logs.datatable');

    // Reports
    Route::get('reports',                        [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/{key}/run',             [ReportController::class, 'run'])->name('reports.run');

    // System settings
    Route::get('system-settings',                [SystemSettingController::class, 'index'])->name('system-settings.index');
    Route::put('system-settings',                [SystemSettingController::class, 'update'])->name('system-settings.update');
});
