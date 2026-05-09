@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.academic_years'))
@section('content')
  @php $model = $model ?? new \App\Models\AcademicYear(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.academic_years')" :action="route('admin.academic-years.store')" method="POST" :cancel-url="route('admin.academic-years.index')">
    @include('admin.academic-years._form')
  </x-admin.form-card>
@endsection
