@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.sessions'))
@section('content')
  @php $model = $model ?? new \App\Models\AttendanceSession(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.sessions')" :action="route('admin.attendance-sessions.store')" method="POST" :cancel-url="route('admin.attendance-sessions.index')">
    @include('admin.attendance-sessions._form')
  </x-admin.form-card>
@endsection
