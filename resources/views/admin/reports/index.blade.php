@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.reports_and_analytics'))
@section('pageBreadcrumbTitle', __('admin.reports_and_analytics'))

@php
$cards = [
  ['key'=>'daily_attendance_sheet',      'name'=>__('admin.report_r01'), 'icon'=>'bx-calendar-check',  'cat'=>'attendance'],
  ['key'=>'monthly_attendance_summary',  'name'=>__('admin.report_r02'), 'icon'=>'bx-calendar-event',  'cat'=>'attendance'],
  ['key'=>'student_attendance_history',  'name'=>__('admin.report_r04'), 'icon'=>'bx-history',         'cat'=>'attendance'],
  ['key'=>'teacher_submission_compliance','name'=>__('admin.report_r07'),'icon'=>'bx-task',            'cat'=>'attendance'],
  ['key'=>'absent_students',             'name'=>__('admin.report_r08'), 'icon'=>'bx-user-x',          'cat'=>'attendance'],
  ['key'=>'late_students',               'name'=>__('admin.report_r09'), 'icon'=>'bx-time',            'cat'=>'attendance'],
  ['key'=>'consecutive_absent',          'name'=>__('admin.report_r11'), 'icon'=>'bx-error-circle',    'cat'=>'attendance'],
  ['key'=>'pending_leave',               'name'=>__('admin.report_r19'), 'icon'=>'bx-time-five',       'cat'=>'leave'],
  ['key'=>'class_roster',                'name'=>__('admin.report_r27'), 'icon'=>'bx-list-ul',         'cat'=>'class'],
  ['key'=>'enrolment_movement',          'name'=>__('admin.report_r29'), 'icon'=>'bx-transfer',        'cat'=>'student'],
  ['key'=>'notification_delivery',       'name'=>__('admin.report_r33'), 'icon'=>'bx-mail-send',       'cat'=>'communication'],
  ['key'=>'audit_log_search',            'name'=>__('admin.report_r37'), 'icon'=>'bx-search-alt',      'cat'=>'audit'],
  ['key'=>'user_activity',               'name'=>__('admin.report_r38'), 'icon'=>'bx-user-check',      'cat'=>'audit'],
  ['key'=>'permission_matrix',           'name'=>__('admin.report_r39'), 'icon'=>'bx-shield-quarter',  'cat'=>'audit'],
];
$categories = [
  'attendance'=>['label'=>__('admin.category_attendance'),'color'=>'primary'],
  'leave'=>['label'=>__('admin.category_leave'),'color'=>'warning'],
  'class'=>['label'=>__('admin.category_class'),'color'=>'info'],
  'student'=>['label'=>__('admin.category_student'),'color'=>'success'],
  'communication'=>['label'=>__('admin.category_communication'),'color'=>'secondary'],
  'audit'=>['label'=>__('admin.category_audit'),'color'=>'dark'],
];
@endphp

@section('content')
<div class="row g-3">
  @foreach($cards as $c)
    <div class="col-md-6 col-xl-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <i class="bx {{ $c['icon'] }} fs-2 me-2 text-primary"></i>
            <div>
              <span class="badge bg-{{ $categories[$c['cat']]['color'] }} text-uppercase">{{ $categories[$c['cat']]['label'] }}</span>
              <div class="fw-semibold">{{ $c['name'] }}</div>
            </div>
          </div>
          <form method="POST" action="{{ route('admin.reports.run', $c['key']) }}" target="_blank">
            @csrf
            <div class="row g-2 mb-2">
              @if(in_array($c['key'], ['daily_attendance_sheet']))
                <div class="col-12">
                  <input type="text" name="date_from" class="form-control form-control-sm flatpickr" placeholder="{{ __('admin.date') }}" value="{{ now()->toDateString() }}">
                </div>
              @elseif(in_array($c['key'], ['monthly_attendance_summary']))
                <div class="col-12">
                  <input type="text" name="date_from" class="form-control form-control-sm flatpickr" placeholder="{{ __('admin.month_any_day') }}" value="{{ now()->toDateString() }}">
                </div>
              @elseif(in_array($c['key'], ['student_attendance_history']))
                <div class="col-12">
                  <input type="number" name="student_id" class="form-control form-control-sm" placeholder="{{ __('admin.student_id') }}" required>
                </div>
                <div class="col-6"><input type="text" name="date_from" class="form-control form-control-sm flatpickr" placeholder="{{ __('admin.from') }}"></div>
                <div class="col-6"><input type="text" name="date_to"   class="form-control form-control-sm flatpickr" placeholder="{{ __('admin.to') }}"></div>
              @elseif(in_array($c['key'], ['class_roster']))
                <div class="col-12">
                  <select name="class_id" class="form-select form-select-sm tom-select" required>
                    <option value="">{{ __('admin.select_class') }}</option>
                    @foreach($classes as $cl)<option value="{{ $cl->id }}">{{ $cl->name }}</option>@endforeach
                  </select>
                </div>
              @elseif(in_array($c['key'], ['consecutive_absent']))
                <div class="col-12">
                  <input type="number" name="threshold" class="form-control form-control-sm" value="3" min="2">
                </div>
                <div class="col-6"><input type="text" name="date_from" class="form-control form-control-sm flatpickr" placeholder="{{ __('admin.from') }}"></div>
                <div class="col-6"><input type="text" name="date_to"   class="form-control form-control-sm flatpickr" placeholder="{{ __('admin.to') }}"></div>
              @elseif(in_array($c['key'], ['absent_students','late_students','teacher_submission_compliance','enrolment_movement','notification_delivery']))
                <div class="col-6"><input type="text" name="date_from" class="form-control form-control-sm flatpickr" placeholder="{{ __('admin.from') }}" value="{{ now()->startOfMonth()->toDateString() }}"></div>
                <div class="col-6"><input type="text" name="date_to"   class="form-control form-control-sm flatpickr" placeholder="{{ __('admin.to') }}"   value="{{ now()->toDateString() }}"></div>
              @endif
            </div>
            <div class="btn-group btn-group-sm w-100">
              <button class="btn btn-outline-primary"    type="submit" name="format" value="view"><i class="bx bx-show"></i> {{ __('admin.view') }}</button>
              <button class="btn btn-outline-danger"     type="submit" name="format" value="pdf"><i class="bx bxs-file-pdf"></i> PDF</button>
              <button class="btn btn-outline-success"    type="submit" name="format" value="excel"><i class="bx bxs-file-doc"></i> Excel</button>
              <button class="btn btn-outline-secondary"  type="submit" name="format" value="csv"><i class="bx bx-file"></i> CSV</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach
</div>

<div class="card mt-4">
  <div class="card-header"><strong>{{ __('admin.recent_reports') }}</strong></div>
  <div class="card-body">
    <table class="table table-sm">
      <thead><tr><th>#</th><th>{{ __('admin.report_no') }}</th><th>{{ __('admin.report_type') }}</th><th>{{ __('admin.generated_at') }}</th></tr></thead>
      <tbody>
        @forelse($history as $h)
          <tr>
            <td>{{ $h->id }}</td>
            <td>{{ $h->report_no }}</td>
            <td>{{ $h->report_type }}</td>
            <td>{{ $h->generated_at?->format('Y-m-d H:i') }}</td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-muted text-center">—</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
