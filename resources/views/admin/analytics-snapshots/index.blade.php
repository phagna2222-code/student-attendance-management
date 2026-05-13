@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.analytics_snapshots'))
@section('content')
<div class="card mb-3">
  <div class="card-body d-flex align-items-center gap-2">
    <form method="POST" action="{{ route('admin.analytics-snapshots.rebuild') }}" class="d-flex gap-2 align-items-end">
      @csrf
      <div>
        <label class="form-label mb-1">{{ __('admin.date') }}</label>
        <input type="text" name="date" class="form-control form-control-sm flatpickr" value="{{ now()->toDateString() }}" required>
      </div>
      <button class="btn btn-primary btn-sm" type="submit"><i class="bx bx-refresh"></i> {{ __('admin.recompute_now') }}</button>
    </form>
  </div>
</div>

@include('admin.partials._card_index', [
  'title' => __('admin.analytics_snapshots'),
  'createUrl' => null,
  'datatableUrl' => route('admin.analytics-snapshots.datatable'),
  'columns' => [
    ['data'=>'id','title'=>'#'],
    ['data'=>'snapshot_date','title'=>__('admin.date')],
    ['data'=>'period_type','title'=>__('admin.period')],
    ['data'=>'branch_name','title'=>__('admin.branch')],
    ['data'=>'class_name','title'=>__('admin.class')],
    ['data'=>'student_name','title'=>__('admin.student')],
    ['data'=>'total_students','title'=>__('admin.total_students')],
    ['data'=>'present_count','title'=>'P'],
    ['data'=>'absent_count','title'=>'A'],
    ['data'=>'late_count','title'=>'L'],
    ['data'=>'attendance_rate','title'=>__('admin.attendance_rate')],
  ],
])
@endsection
