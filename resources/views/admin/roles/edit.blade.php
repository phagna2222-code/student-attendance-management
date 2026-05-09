@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.roles'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.roles')" :action="route('admin.roles.update', $model->id)" method="PUT" :cancel-url="route('admin.roles.index')">
    @include('admin.roles._form')
  </x-admin.form-card>
@endsection
