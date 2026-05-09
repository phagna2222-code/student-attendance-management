@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.users'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.users')" :action="route('admin.users.update', $model->id)" method="PUT" :cancel-url="route('admin.users.index')">
    @include('admin.users._form')
  </x-admin.form-card>
@endsection
