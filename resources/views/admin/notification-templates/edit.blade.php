@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.templates'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.templates')" :action="route('admin.notification-templates.update', $model->id)" method="PUT" :cancel-url="route('admin.notification-templates.index')">
    @include('admin.notification-templates._form')
  </x-admin.form-card>
@endsection
