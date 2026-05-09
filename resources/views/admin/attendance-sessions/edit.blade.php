@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.sessions'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.sessions')" :action="route('admin.attendance-sessions.update', $model->id)" method="PUT" :cancel-url="route('admin.attendance-sessions.index')">
    @include('admin.attendance-sessions._form')
  </x-admin.form-card>
@endsection
