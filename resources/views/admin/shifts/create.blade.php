@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.shifts'))
@section('content')
  @php $model = $model ?? new \App\Models\Shift(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.shifts')" :action="route('admin.shifts.store')" method="POST" :cancel-url="route('admin.shifts.index')">
    @include('admin.shifts._form')
  </x-admin.form-card>
@endsection
