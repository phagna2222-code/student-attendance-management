@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.timetables'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.timetables')" :action="route('admin.timetables.update', $model->id)" method="PUT" :cancel-url="route('admin.timetables.index')">
    @include('admin.timetables._form')
  </x-admin.form-card>
@endsection
