@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.class_attendance_settings'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.class_attendance_settings')" :action="route('admin.class-attendance-settings.update', $model->id)" method="PUT" :cancel-url="route('admin.class-attendance-settings.index')">
    @include('admin.class-attendance-settings._form')
  </x-admin.form-card>
@endsection
