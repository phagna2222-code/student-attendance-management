@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.leave_requests'))
@section('content')
  @php $model = $model ?? new \App\Models\LeaveRequest(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.leave_requests')" :action="route('admin.leave-requests.store')" method="POST" :cancel-url="route('admin.leave-requests.index')">
    @include('admin.leave-requests._form')
  </x-admin.form-card>
@endsection
