@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.rooms'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.rooms')" :action="route('admin.rooms.update', $model->id)" method="PUT" :cancel-url="route('admin.rooms.index')">
    @include('admin.rooms._form')
  </x-admin.form-card>
@endsection
