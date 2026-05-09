@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.rooms'))
@section('content')
  @php $model = $model ?? new \App\Models\Room(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.rooms')" :action="route('admin.rooms.store')" method="POST" :cancel-url="route('admin.rooms.index')">
    @include('admin.rooms._form')
  </x-admin.form-card>
@endsection
