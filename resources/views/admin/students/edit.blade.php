@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.students'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.students')" :action="route('admin.students.update', $model->id)" method="PUT" :cancel-url="route('admin.students.index')">
    @include('admin.students._form')
  </x-admin.form-card>
@endsection
