@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.school_profiles'))
@section('content')
  @php $model = $model ?? new \App\Models\SchoolProfile(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.school_profiles')" :action="route('admin.school-profiles.store')" method="POST" :cancel-url="route('admin.school-profiles.index')">
    @include('admin.school-profiles._form')
  </x-admin.form-card>
@endsection
