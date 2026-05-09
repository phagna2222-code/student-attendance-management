@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.attendance_statuses'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.attendance_statuses')" :action="route('admin.attendance-statuses.update', $model->id)" method="PUT" :cancel-url="route('admin.attendance-statuses.index')">
    @include('admin.attendance-statuses._form')
  </x-admin.form-card>
@endsection
