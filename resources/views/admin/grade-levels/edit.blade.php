@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.grade_levels'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.grade_levels')" :action="route('admin.grade-levels.update', $model->id)" method="PUT" :cancel-url="route('admin.grade-levels.index')">
    @include('admin.grade-levels._form')
  </x-admin.form-card>
@endsection
