@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.shifts'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.shifts')" :action="route('admin.shifts.update', $model->id)" method="PUT" :cancel-url="route('admin.shifts.index')">
    @include('admin.shifts._form')
  </x-admin.form-card>
@endsection
