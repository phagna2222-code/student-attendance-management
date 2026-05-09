@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.class_teacher_subjects'))
@section('content')
  @php $model = $model ?? new \App\Models\ClassTeacherSubject(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.class_teacher_subjects')" :action="route('admin.class-teacher-subjects.store')" method="POST" :cancel-url="route('admin.class-teacher-subjects.index')">
    @include('admin.class-teacher-subjects._form')
  </x-admin.form-card>
@endsection
