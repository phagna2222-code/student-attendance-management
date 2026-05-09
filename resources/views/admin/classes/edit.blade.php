@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.classes'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.classes')" :action="route('admin.classes.update', $model->id)" method="PUT" :cancel-url="route('admin.classes.index')">
    @include('admin.classes._form')
  </x-admin.form-card>
@endsection
