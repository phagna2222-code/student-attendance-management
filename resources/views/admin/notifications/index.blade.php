@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.notifications_list'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.notifications_list'),
    'createUrl' => null,
    'datatableUrl' => route('admin.notifications.datatable'),
    'columns' => [
      ['data'=>'id','title'=>'#'],
      ['data'=>'type','title'=>'Type'],
      ['data'=>'channel','title'=>'Channel'],
      ['data'=>'recipient_name','title'=>'Recipient'],
      ['data'=>'subject','title'=>'Subject'],
      ['data'=>'status','title'=>__('admin.status')],
      ['data'=>'created_at','title'=>__('admin.created_at')],
      ['data'=>'actions','title'=>__('admin.actions'),'orderable'=>false,'searchable'=>false],
    ],
  ])
@endsection
