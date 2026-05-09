@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.timetables'))
@section('content')
  @php $model = $model ?? new \App\Models\Timetable(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.timetables')" :action="route('admin.timetables.store')" method="POST" :cancel-url="route('admin.timetables.index')">
    @include('admin.timetables._form')
  </x-admin.form-card>
@endsection
