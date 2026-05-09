@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.parents'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.parents')" :action="route('admin.parents.update', $model->id)" method="PUT" :cancel-url="route('admin.parents.index')">
    @include('admin.parents._form')
  </x-admin.form-card>
@endsection
