@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.roles'))
@section('content')
  @php $model = $model ?? new \App\Models\Role(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.roles')" :action="route('admin.roles.store')" method="POST" :cancel-url="route('admin.roles.index')">
    @include('admin.roles._form')
  </x-admin.form-card>
@endsection
