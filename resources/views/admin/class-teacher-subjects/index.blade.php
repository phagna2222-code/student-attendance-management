@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.class_teacher_subjects'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.class_teacher_subjects'),
    'createUrl' => route('admin.class-teacher-subjects.create'),
    'datatableUrl' => route('admin.class-teacher-subjects.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'class_name', 'title'=>'Class', 'name'=>'schoolClass.name'],
      ['data'=>'teacher_name', 'title'=>'Teacher', 'name'=>'teacher.name_en'],
      ['data'=>'subject_name', 'title'=>'Subject', 'name'=>'subject.name_en'],
      ['data'=>'academic_year_name', 'title'=>'Year', 'name'=>'academicYear.name'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
