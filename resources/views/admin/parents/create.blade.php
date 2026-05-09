@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.parents'))
@section('content')
  @php $model = $model ?? new \App\Models\StudentParent(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.parents')" :action="route('admin.parents.store')" method="POST" :cancel-url="route('admin.parents.index')">
    @include('admin.parents._form')
  </x-admin.form-card>
@endsection
