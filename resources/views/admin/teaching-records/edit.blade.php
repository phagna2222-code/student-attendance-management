@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.teaching_records'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.teaching_records')" :action="route('admin.teaching-records.update', $model->id)" method="PUT" :cancel-url="route('admin.teaching-records.index')">
    @include('admin.teaching-records._form')
  </x-admin.form-card>
@endsection
