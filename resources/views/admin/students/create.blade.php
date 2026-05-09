@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.students'))
@section('content')
  @php $model = $model ?? new \App\Models\Student(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.students')" :action="route('admin.students.store')" method="POST" :cancel-url="route('admin.students.index')">
    @include('admin.students._form')
  </x-admin.form-card>
@endsection
