@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.permissions'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.permissions')" :action="route('admin.permissions.update', $model->id)" method="PUT" :cancel-url="route('admin.permissions.index')">
    @include('admin.permissions._form')
  </x-admin.form-card>
@endsection
