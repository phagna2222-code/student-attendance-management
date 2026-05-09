@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.terms'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.terms')" :action="route('admin.terms.update', $model->id)" method="PUT" :cancel-url="route('admin.terms.index')">
    @include('admin.terms._form')
  </x-admin.form-card>
@endsection
