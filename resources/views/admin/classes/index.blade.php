@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.classes'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.classes'),
    'createUrl' => route('admin.classes.create'),
    'datatableUrl' => route('admin.classes.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'code', 'title'=>'Code'],
      ['data'=>'name', 'title'=>'Name'],
      ['data'=>'branch_name', 'title'=>'Branch', 'name'=>'branch.name_en'],
      ['data'=>'grade_level_name', 'title'=>'Grade', 'name'=>'gradeLevel.name_en'],
      ['data'=>'academic_year_name', 'title'=>'Year', 'name'=>'academicYear.name'],
      ['data'=>'teacher_name', 'title'=>'Teacher', 'name'=>'classTeacher.name_en'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
