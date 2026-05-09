@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.users'))
@section('content')
  @php $model = $model ?? new \App\Models\User(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.users')" :action="route('admin.users.store')" method="POST" :cancel-url="route('admin.users.index')">
    @include('admin.users._form')
  </x-admin.form-card>
@endsection
