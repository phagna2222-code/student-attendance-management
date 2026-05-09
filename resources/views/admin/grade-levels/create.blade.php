@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.grade_levels'))
@section('content')
  @php $model = $model ?? new \App\Models\GradeLevel(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.grade_levels')" :action="route('admin.grade-levels.store')" method="POST" :cancel-url="route('admin.grade-levels.index')">
    @include('admin.grade-levels._form')
  </x-admin.form-card>
@endsection
