@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.academic_years'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.academic_years'),
    'createUrl' => route('admin.academic-years.create'),
    'datatableUrl' => route('admin.academic-years.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'code', 'title'=>'Code'],
      ['data'=>'name', 'title'=>'Name'],
      ['data'=>'start_date', 'title'=>'Start'],
      ['data'=>'end_date', 'title'=>'End'],
      ['data'=>'is_current', 'title'=>'Current'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
