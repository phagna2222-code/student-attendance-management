@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.subjects'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.subjects')" :action="route('admin.subjects.update', $model->id)" method="PUT" :cancel-url="route('admin.subjects.index')">
    @include('admin.subjects._form')
  </x-admin.form-card>
@endsection
