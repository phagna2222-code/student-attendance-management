@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.templates'))
@section('content')
  @php $model = $model ?? new \App\Models\NotificationTemplate(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.templates')" :action="route('admin.notification-templates.store')" method="POST" :cancel-url="route('admin.notification-templates.index')">
    @include('admin.notification-templates._form')
  </x-admin.form-card>
@endsection
