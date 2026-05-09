@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.branches'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.branches'),
    'createUrl' => route('admin.branches.create'),
    'datatableUrl' => route('admin.branches.datatable'),
    'columns' => [
      ['data'=>'id','title'=>'#'],
      ['data'=>'code','title'=>__('admin.code')],
      ['data'=>'name_en','title'=>__('admin.name_en')],
      ['data'=>'name_kh','title'=>__('admin.name_kh')],
      ['data'=>'phone','title'=>__('admin.phone')],
      ['data'=>'is_main','title'=>__('admin.is_main')],
      ['data'=>'status','title'=>__('admin.status')],
      ['data'=>'actions','title'=>__('admin.actions'),'orderable'=>false,'searchable'=>false],
    ],
  ])
@endsection
