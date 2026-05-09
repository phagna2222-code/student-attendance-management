@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.edit').' — '.__('admin.school_profiles'))
@section('content')
  <x-admin.form-card :title="__('admin.edit').' — '.__('admin.school_profiles')" :action="route('admin.school-profiles.update', $model->id)" method="PUT" :cancel-url="route('admin.school-profiles.index')">
    @include('admin.school-profiles._form')
  </x-admin.form-card>
@endsection
