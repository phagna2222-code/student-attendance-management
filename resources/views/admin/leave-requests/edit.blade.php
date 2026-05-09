@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.leave_requests'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.leave_requests')" :action="route('admin.leave-requests.update', $model->id)" method="PUT" :cancel-url="route('admin.leave-requests.index')">
    @include('admin.leave-requests._form')
  </x-admin.form-card>
@endsection
