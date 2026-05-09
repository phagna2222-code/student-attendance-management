@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.dashboard'))
@section('pageBreadcrumbTitle', __('admin.dashboard'))

@section('content')
  <div data-react="dashboard-summary" data-props='@json(["stats"=>$stats,"weekly"=>$weekly])'></div>
@endsection
