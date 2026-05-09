@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.branches'))
@section('content')
  @php $model = $model ?? new \App\Models\Branch(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.branches')" :action="route('admin.branches.store')" method="POST" :cancel-url="route('admin.branches.index')">
    @include('admin.branches._form')
  </x-admin.form-card>
@endsection
