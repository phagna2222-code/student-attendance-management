@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.class_teacher_subjects'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.class_teacher_subjects')" :action="route('admin.class-teacher-subjects.update', $model->id)" method="PUT" :cancel-url="route('admin.class-teacher-subjects.index')">
    @include('admin.class-teacher-subjects._form')
  </x-admin.form-card>
@endsection
