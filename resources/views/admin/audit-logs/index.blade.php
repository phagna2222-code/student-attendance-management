@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.audit_logs'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.audit_logs'),
    'createUrl' => null,
    'datatableUrl' => route('admin.audit-logs.datatable'),
    'columns' => [
      ['data'=>'id','title'=>'#'],
      ['data'=>'created_at','title'=>'Time'],
      ['data'=>'user_name','title'=>'User','orderable'=>false],
      ['data'=>'event','title'=>'Event'],
      ['data'=>'auditable_type','title'=>'Object'],
      ['data'=>'description','title'=>'Description'],
      ['data'=>'ip_address','title'=>'IP'],
    ],
  ])
@endsection
