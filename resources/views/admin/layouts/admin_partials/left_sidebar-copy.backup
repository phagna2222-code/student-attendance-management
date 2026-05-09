<aside class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header">
    <div>
      <img src="{{asset('assets/backend')}}/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
    </div>
    <div>
      <h4 class="logo-text">{{ config('app.name', 'SAMS') }}</h4>
    </div>
    <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i></div>
  </div>
  <!--navigation-->
  <ul class="metismenu" id="menu">

    <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.dashboard') }}">
        <div class="parent-icon"><i class="bi bi-house-door"></i></div>
        <div class="menu-title" data-i18n="nav.dashboard">{{ __('admin.dashboard') }}</div>
      </a>
    </li>

    <li class="menu-label" data-i18n="nav.section.school">{{ __('admin.section_school') }}</li>

    <li class="{{ request()->routeIs('admin.branches.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.branches.index') }}">
        <div class="parent-icon"><i class="bi bi-building"></i></div>
        <div class="menu-title" data-i18n="nav.branches">{{ __('admin.branches') }}</div>
      </a>
    </li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-mortarboard"></i></div>
        <div class="menu-title" data-i18n="nav.academic">{{ __('admin.academic_section') }}</div>
      </a>
      <ul>
        <li><a href="{{ route('admin.academic-years.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.academic_years">{{ __('admin.academic_years') }}</span></a></li>
        <li><a href="{{ route('admin.terms.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.terms">{{ __('admin.terms') }}</span></a></li>
        <li><a href="{{ route('admin.shifts.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.shifts">{{ __('admin.shifts') }}</span></a></li>
        <li><a href="{{ route('admin.rooms.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.rooms">{{ __('admin.rooms') }}</span></a></li>
        <li><a href="{{ route('admin.grade-levels.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.grade_levels">{{ __('admin.grade_levels') }}</span></a></li>
        <li><a href="{{ route('admin.subjects.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.subjects">{{ __('admin.subjects') }}</span></a></li>
        <li><a href="{{ route('admin.attendance-statuses.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.attendance_statuses">{{ __('admin.attendance_statuses') }}</span></a></li>
      </ul>
    </li>

    <li class="menu-label" data-i18n="nav.section.people">{{ __('admin.section_people') }}</li>

    <li class="{{ request()->routeIs('admin.students.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.students.index') }}">
        <div class="parent-icon"><i class="bi bi-people"></i></div>
        <div class="menu-title" data-i18n="nav.students">{{ __('admin.students') }}</div>
      </a>
    </li>

    <li class="{{ request()->routeIs('admin.teachers.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.teachers.index') }}">
        <div class="parent-icon"><i class="bi bi-person-badge"></i></div>
        <div class="menu-title" data-i18n="nav.teachers">{{ __('admin.teachers') }}</div>
      </a>
    </li>

    <li class="{{ request()->routeIs('admin.parents.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.parents.index') }}">
        <div class="parent-icon"><i class="bi bi-person-hearts"></i></div>
        <div class="menu-title" data-i18n="nav.parents">{{ __('admin.parents') }}</div>
      </a>
    </li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-collection"></i></div>
        <div class="menu-title" data-i18n="nav.classes">{{ __('admin.classes') }}</div>
      </a>
      <ul>
        <li><a href="{{ route('admin.classes.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.class_list">{{ __('admin.class_list') }}</span></a></li>
        <li><a href="{{ route('admin.class-students.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.class_students">{{ __('admin.class_students') }}</span></a></li>
        <li><a href="{{ route('admin.class-teacher-subjects.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.class_teacher_subjects">{{ __('admin.class_teacher_subjects') }}</span></a></li>
        <li><a href="{{ route('admin.class-attendance-settings.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.class_attendance_settings">{{ __('admin.class_attendance_settings') }}</span></a></li>
        <li><a href="{{ route('admin.timetables.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.timetables">{{ __('admin.timetables') }}</span></a></li>
      </ul>
    </li>

    <li class="menu-label" data-i18n="nav.section.attendance">{{ __('admin.section_attendance') }}</li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-calendar2-check"></i></div>
        <div class="menu-title" data-i18n="nav.attendance">{{ __('admin.attendance') }}</div>
      </a>
      <ul>
        <li><a href="{{ route('admin.attendance-sessions.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.sessions">{{ __('admin.sessions') }}</span></a></li>
        <li><a href="{{ route('admin.attendance-records.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.records">{{ __('admin.records') }}</span></a></li>
        <li><a href="{{ route('admin.attendance-records.entry') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.entry">{{ __('admin.entry') }}</span></a></li>
        <li><a href="{{ route('admin.leave-requests.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.leave_requests">{{ __('admin.leave_requests') }}</span></a></li>
      </ul>
    </li>

    <li class="menu-label" data-i18n="nav.section.communication">{{ __('admin.section_communication') }}</li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-megaphone"></i></div>
        <div class="menu-title" data-i18n="nav.notifications">{{ __('admin.notifications') }}</div>
      </a>
      <ul>
        <li><a href="{{ route('admin.notification-templates.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.templates">{{ __('admin.templates') }}</span></a></li>
        <li><a href="{{ route('admin.notifications.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.notifications_list">{{ __('admin.notifications_list') }}</span></a></li>
      </ul>
    </li>

    <li class="menu-label" data-i18n="nav.section.security">{{ __('admin.section_security') }}</li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-shield-lock"></i></div>
        <div class="menu-title" data-i18n="nav.security">{{ __('admin.security') }}</div>
      </a>
      <ul>
        <li><a href="{{ route('admin.users.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.users">{{ __('admin.users') }}</span></a></li>
        <li><a href="{{ route('admin.roles.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.roles">{{ __('admin.roles') }}</span></a></li>
        <li><a href="{{ route('admin.permissions.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.permissions">{{ __('admin.permissions') }}</span></a></li>
        <li><a href="{{ route('admin.audit-logs.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="nav.audit_logs">{{ __('admin.audit_logs') }}</span></a></li>
      </ul>
    </li>

    <li class="{{ request()->routeIs('admin.reports.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.reports.index') }}">
        <div class="parent-icon"><i class="bi bi-bar-chart"></i></div>
        <div class="menu-title" data-i18n="nav.reports">{{ __('admin.reports') }}</div>
      </a>
    </li>

    <li class="{{ request()->routeIs('admin.system-settings.*') ? 'mm-active' : '' }}">
      <a href="{{ route('admin.system-settings.index') }}">
        <div class="parent-icon"><i class="bi bi-sliders"></i></div>
        <div class="menu-title" data-i18n="nav.settings">{{ __('admin.settings') }}</div>
      </a>
    </li>

  </ul>
  <!--end navigation-->
</aside>
