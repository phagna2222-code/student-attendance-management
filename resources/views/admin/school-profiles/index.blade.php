@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.school_profiles'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.school_profiles'),
    'createUrl' => route('admin.school-profiles.create'),
    'datatableUrl' => route('admin.school-profiles.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'branch_name', 'title'=>'Branch', 'name'=>'branch.name_en'],
      ['data'=>'school_name_en', 'title'=>'Name (EN)'],
      ['data'=>'school_name_kh', 'title'=>'Name (KH)'],
      ['data'=>'phone', 'title'=>'Phone'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
