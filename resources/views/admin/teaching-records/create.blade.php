@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.teaching_records'))
@section('content')
  @php $model = $model ?? new \App\Models\TeachingRecord(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.teaching_records')" :action="route('admin.teaching-records.store')" method="POST" :cancel-url="route('admin.teaching-records.index')">
    @include('admin.teaching-records._form')
  </x-admin.form-card>
@endsection
