@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.reports'))
@section('content')
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card h-100"><div class="card-body">
        <h6>Daily Attendance Report</h6>
        <p class="text-muted small">Per-class daily attendance summary.</p>
        <button class="btn btn-light border" disabled>{{ __('Generate') }}</button>
      </div></div>
    </div>
    <div class="col-md-4">
      <div class="card h-100"><div class="card-body">
        <h6>Class Monthly Report</h6>
        <p class="text-muted small">Monthly attendance by class.</p>
        <button class="btn btn-light border" disabled>{{ __('Generate') }}</button>
      </div></div>
    </div>
    <div class="col-md-4">
      <div class="card h-100"><div class="card-body">
        <h6>Student Attendance Report</h6>
        <p class="text-muted small">Per-student attendance over a date range.</p>
        <button class="btn btn-light border" disabled>{{ __('Generate') }}</button>
      </div></div>
    </div>
  </div>
@endsection
