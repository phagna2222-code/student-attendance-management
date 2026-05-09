@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.attendance_statuses'))
@section('content')
  @php $model = $model ?? new \App\Models\AttendanceStatus(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.attendance_statuses')" :action="route('admin.attendance-statuses.store')" method="POST" :cancel-url="route('admin.attendance-statuses.index')">
    @include('admin.attendance-statuses._form')
  </x-admin.form-card>
@endsection
