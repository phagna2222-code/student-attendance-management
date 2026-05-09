@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.permissions'))
@section('content')
  @php $model = $model ?? new \App\Models\Permission(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.permissions')" :action="route('admin.permissions.store')" method="POST" :cancel-url="route('admin.permissions.index')">
    @include('admin.permissions._form')
  </x-admin.form-card>
@endsection
