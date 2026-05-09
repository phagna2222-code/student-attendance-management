@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.class_attendance_settings'))
@section('content')
  @php $model = $model ?? new \App\Models\ClassAttendanceSetting(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.class_attendance_settings')" :action="route('admin.class-attendance-settings.store')" method="POST" :cancel-url="route('admin.class-attendance-settings.index')">
    @include('admin.class-attendance-settings._form')
  </x-admin.form-card>
@endsection
