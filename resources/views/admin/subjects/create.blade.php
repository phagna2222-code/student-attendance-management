@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.subjects'))
@section('content')
  @php $model = $model ?? new \App\Models\Subject(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.subjects')" :action="route('admin.subjects.store')" method="POST" :cancel-url="route('admin.subjects.index')">
    @include('admin.subjects._form')
  </x-admin.form-card>
@endsection
