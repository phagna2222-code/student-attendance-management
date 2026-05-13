@php
  /** @var \App\Services\BranchContext|null $branchCtx */
  $branchCtx = app(\App\Services\BranchContext::class);
  $currentBranch = $branchCtx ? $branchCtx->current() : null;
@endphp

<aside class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header">
    <div>
      <img src="{{ asset('assets/backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
    </div>
    <div>
      <h4 class="logo-text">{{ config('app.name', 'SAMS') }}</h4>
    </div>
    <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i></div>
  </div>

  {{-- Active branch indicator --}}
  @auth
    <div class="sidebar-branch-indicator">
      <span class="sidebar-branch-icon">
        <i class="bi bi-{{ $currentBranch && $currentBranch->is_main ? 'star-fill' : 'building' }}"></i>
      </span>
      <div class="sidebar-branch-copy">
        <span class="sidebar-branch-label" data-i18n="admin.active_branch">{{ __('admin.active_branch') }}</span>
        <strong
          class="sidebar-branch-name">{{ $currentBranch ? $currentBranch->localizedName() : __('admin.all_branches') }}</strong>
      </div>
    </div>
  @endauth

  <!--navigation-->
  <ul class="metismenu" id="menu">

    {{-- ─────────────── Dashboard ─────────────── --}}
    <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.dashboard') }}">
        <div class="parent-icon"><i class="bi bi-house-door-fill"></i></div>
        <div class="menu-title" data-i18n="admin.dashboard">{{ __('admin.dashboard') }}</div>
      </a>
    </li>

    {{-- ─────────────── School ─────────────── --}}
    <li class="menu-label" data-i18n="admin.section_school">{{ __('admin.section_school') }}</li>

    <li class="{{ request()->routeIs('admin.branches.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.branches.index') }}">
        <div class="parent-icon"><i class="bi bi-diagram-3"></i></div>
        <div class="menu-title" data-i18n="admin.branches">{{ __('admin.branches') }}</div>
      </a>
    </li>

    <li class="{{ request()->routeIs('admin.school-profiles.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.school-profiles.index') }}">
        <div class="parent-icon"><i class="bi bi-building"></i></div>
        <div class="menu-title" data-i18n="admin.school_profile">{{ __('admin.school_profile') }}</div>
      </a>
    </li>

    <li
      class="{{ request()->routeIs('admin.academic-years.*', 'admin.terms.*', 'admin.shifts.*', 'admin.rooms.*', 'admin.grade-levels.*', 'admin.subjects.*', 'admin.attendance-statuses.*') ? 'mm-active' : '' }}">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-mortarboard"></i></div>
        <div class="menu-title" data-i18n="admin.academic_section">{{ __('admin.academic_section') }}</div>
      </a>
      <ul>
        <li class="{{ request()->routeIs('admin.academic-years.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.academic-years.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.academic_years">{{ __('admin.academic_years') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.terms.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.terms.index') }}">
            <i class="bi bi-arrow-right-short"></i><span data-i18n="admin.terms">{{ __('admin.terms') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.shifts.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.shifts.index') }}">
            <i class="bi bi-arrow-right-short"></i><span data-i18n="admin.shifts">{{ __('admin.shifts') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.rooms.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.rooms.index') }}">
            <i class="bi bi-arrow-right-short"></i><span data-i18n="admin.rooms">{{ __('admin.rooms') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.grade-levels.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.grade-levels.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.grade_levels">{{ __('admin.grade_levels') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.subjects.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.subjects.index') }}">
            <i class="bi bi-arrow-right-short"></i><span data-i18n="admin.subjects">{{ __('admin.subjects') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.attendance-statuses.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.attendance-statuses.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.attendance_statuses">{{ __('admin.attendance_statuses') }}</span>
          </a>
        </li>
      </ul>
    </li>

    {{-- ─────────────── People ─────────────── --}}
    <li class="menu-label" data-i18n="admin.section_people">{{ __('admin.section_people') }}</li>

    <li class="{{ request()->routeIs('admin.students.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.students.index') }}">
        <div class="parent-icon"><i class="bi bi-people"></i></div>
        <div class="menu-title" data-i18n="admin.students">{{ __('admin.students') }}</div>
      </a>
    </li>

    <li class="{{ request()->routeIs('admin.teachers.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.teachers.index') }}">
        <div class="parent-icon"><i class="bi bi-person-badge"></i></div>
        <div class="menu-title" data-i18n="admin.teachers">{{ __('admin.teachers') }}</div>
      </a>
    </li>

    <li class="{{ request()->routeIs('admin.parents.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.parents.index') }}">
        <div class="parent-icon"><i class="bi bi-person-hearts"></i></div>
        <div class="menu-title" data-i18n="admin.parents">{{ __('admin.parents') }}</div>
      </a>
    </li>

    {{-- ─────────────── Classes ─────────────── --}}
    <li class="menu-label" data-i18n="admin.section_classroom">{{ __('admin.section_classroom') }}</li>

    <li
      class="{{ request()->routeIs('admin.classes.*', 'admin.class-students.*', 'admin.class-teacher-subjects.*', 'admin.class-attendance-settings.*', 'admin.timetables.*') ? 'mm-active' : '' }}">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-collection"></i></div>
        <div class="menu-title" data-i18n="admin.classes">{{ __('admin.classes') }}</div>
      </a>
      <ul>
        <li class="{{ request()->routeIs('admin.classes.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.classes.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.class_list">{{ __('admin.class_list') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.class-students.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.class-students.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.class_students">{{ __('admin.class_students') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.class-teacher-subjects.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.class-teacher-subjects.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.class_teacher_subjects">{{ __('admin.class_teacher_subjects') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.class-attendance-settings.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.class-attendance-settings.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.class_attendance_settings">{{ __('admin.class_attendance_settings') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.timetables.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.timetables.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.timetables">{{ __('admin.timetables') }}</span>
          </a>
        </li>
      </ul>
    </li>

    {{-- ─────────────── Attendance ─────────────── --}}
    <li class="menu-label" data-i18n="admin.section_attendance">{{ __('admin.section_attendance') }}</li>

    <li class="{{ request()->routeIs('admin.attendance-records.entry') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.attendance-records.entry') }}">
        <div class="parent-icon"><i class="bi bi-ui-checks"></i></div>
        <div class="menu-title" data-i18n="admin.entry">{{ __('admin.entry') }}</div>
      </a>
    </li>

    <li
      class="{{ request()->routeIs('admin.attendance-sessions.*', 'admin.attendance-records.index', 'admin.leave-requests.*') ? 'mm-active' : '' }}">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-calendar2-check"></i></div>
        <div class="menu-title" data-i18n="admin.attendance">{{ __('admin.attendance') }}</div>
      </a>
      <ul>
        <li class="{{ request()->routeIs('admin.attendance-sessions.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.attendance-sessions.index') }}">
            <i class="bi bi-arrow-right-short"></i><span data-i18n="admin.sessions">{{ __('admin.sessions') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.attendance-records.index') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.attendance-records.index') }}">
            <i class="bi bi-arrow-right-short"></i><span data-i18n="admin.records">{{ __('admin.records') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.leave-requests.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.leave-requests.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.leave_requests">{{ __('admin.leave_requests') }}</span>
          </a>
        </li>
      </ul>
    </li>

    {{-- ─────────────── Communication ─────────────── --}}
    <li class="menu-label" data-i18n="admin.section_communication">{{ __('admin.section_communication') }}</li>

    <li class="{{ request()->routeIs('admin.notification-templates.*', 'admin.notifications.*') ? 'mm-active' : '' }}">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-megaphone"></i></div>
        <div class="menu-title" data-i18n="admin.notifications">{{ __('admin.notifications') }}</div>
      </a>
      <ul>
        <li class="{{ request()->routeIs('admin.notification-templates.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.notification-templates.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.templates">{{ __('admin.templates') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.notifications.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.notifications.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.notifications_list">{{ __('admin.notifications_list') }}</span>
          </a>
        </li>
      </ul>
    </li>

    {{-- ─────────────── Reports ─────────────── --}}
    <li class="menu-label" data-i18n="admin.section_reports">{{ __('admin.section_reports') }}</li>

    <li class="{{ request()->routeIs('admin.reports.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.reports.index') }}">
        <div class="parent-icon"><i class="bi bi-bar-chart-line"></i></div>
        <div class="menu-title" data-i18n="admin.reports">{{ __('admin.reports') }}</div>
      </a>
    </li>

    {{-- ─────────────── Security ─────────────── --}}
    <li class="menu-label" data-i18n="admin.section_security">{{ __('admin.section_security') }}</li>

    <li
      class="{{ request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.permissions.*', 'admin.audit-logs.*') ? 'mm-active' : '' }}">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-shield-lock"></i></div>
        <div class="menu-title" data-i18n="admin.security">{{ __('admin.security') }}</div>
      </a>
      <ul>
        <li class="{{ request()->routeIs('admin.users.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.users.index') }}">
            <i class="bi bi-arrow-right-short"></i><span data-i18n="admin.users">{{ __('admin.users') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.roles.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.roles.index') }}">
            <i class="bi bi-arrow-right-short"></i><span data-i18n="admin.roles">{{ __('admin.roles') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.permissions.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.permissions.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.permissions">{{ __('admin.permissions') }}</span>
          </a>
        </li>
        <li class="{{ request()->routeIs('admin.audit-logs.*') ? 'mm-active' : '' }}">
          <a href="{{ route('admin.audit-logs.index') }}">
            <i class="bi bi-arrow-right-short"></i><span
              data-i18n="admin.audit_logs">{{ __('admin.audit_logs') }}</span>
          </a>
        </li>
      </ul>
    </li>

    {{-- ─────────────── System ─────────────── --}}
    <li class="menu-label" data-i18n="admin.section_system">{{ __('admin.section_system') }}</li>

    <li class="{{ request()->routeIs('admin.system-settings.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.system-settings.index') }}">
        <div class="parent-icon"><i class="bi bi-sliders"></i></div>
        <div class="menu-title" data-i18n="admin.settings">{{ __('admin.settings') }}</div>
      </a>
    </li>

  </ul>
  <!--end navigation-->
</aside>
