@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.academic_years'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.academic_years')" :action="route('admin.academic-years.update', $model->id)" method="PUT" :cancel-url="route('admin.academic-years.index')">
    @include('admin.academic-years._form')
  </x-admin.form-card>
@endsection
