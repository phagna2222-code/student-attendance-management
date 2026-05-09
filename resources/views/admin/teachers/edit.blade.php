@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.teachers'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.teachers')" :action="route('admin.teachers.update', $model->id)" method="PUT" :cancel-url="route('admin.teachers.index')">
    @include('admin.teachers._form')
  </x-admin.form-card>
@endsection
