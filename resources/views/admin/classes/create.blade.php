@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.classes'))
@section('content')
  @php $model = $model ?? new \App\Models\SchoolClass(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.classes')" :action="route('admin.classes.store')" method="POST" :cancel-url="route('admin.classes.index')">
    @include('admin.classes._form')
  </x-admin.form-card>
@endsection
