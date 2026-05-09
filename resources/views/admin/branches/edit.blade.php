@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.branches'))
@section('content')
  @php $model = $branch; @endphp
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.branches')" :action="route('admin.branches.update', $branch->id)" method="PUT" :cancel-url="route('admin.branches.index')">
    @include('admin.branches._form')
  </x-admin.form-card>
@endsection
