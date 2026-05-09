@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.teachers'))
@section('content')
  @php $model = $model ?? new \App\Models\Teacher(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.teachers')" :action="route('admin.teachers.store')" method="POST" :cancel-url="route('admin.teachers.index')">
    @include('admin.teachers._form')
  </x-admin.form-card>
@endsection
