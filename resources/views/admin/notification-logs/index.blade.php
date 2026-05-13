@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.notification_logs'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.notification_logs'),
    'createUrl' => null,
    'datatableUrl' => route('admin.notification-logs.datatable'),
    'columns' => [
      ['data'=>'id','title'=>'#'],
      ['data'=>'notification_summary','title'=>__('admin.notification')],
      ['data'=>'provider','title'=>__('admin.provider')],
      ['data'=>'provider_message_id','title'=>__('admin.provider_message_id')],
      ['data'=>'status','title'=>__('admin.status')],
      ['data'=>'error_message','title'=>__('admin.error')],
      ['data'=>'created_at','title'=>__('admin.created_at')],
    ],
  ])
@endsection
