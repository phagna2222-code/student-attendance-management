@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.create_new').' — '.__('admin.terms'))
@section('content')
  @php $model = $model ?? new \App\Models\Term(); @endphp
  <x-admin.form-card :title="__('admin.create_new').' — '.__('admin.terms')" :action="route('admin.terms.store')" method="POST" :cancel-url="route('admin.terms.index')">
    @include('admin.terms._form')
  </x-admin.form-card>
@endsection
