<div class="row">
  @include('admin.partials._select', ['name'=>'branch_id','label'=>"Branch",'value'=>$model->branch_id ?? '','options'=>$branches,'labelKey'=>'name_en','col'=>4,'required'=>true])
  @include('admin.partials._select', ['name'=>'grade_level_id','label'=>"Grade Level",'value'=>$model->grade_level_id ?? '','options'=>$gradeLevels,'labelKey'=>'name_en','col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'academic_year_id','label'=>"Academic Year",'value'=>$model->academic_year_id ?? '','options'=>$academicYears,'col'=>4,'required'=>true])
  @include('admin.partials._select', ['name'=>'term_id','label'=>"Term",'value'=>$model->term_id ?? '','options'=>$terms,'col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'shift_id','label'=>"Shift",'value'=>$model->shift_id ?? '','options'=>$shifts,'col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'room_id','label'=>"Room",'value'=>$model->room_id ?? '','options'=>$rooms,'col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'class_teacher_id','label'=>"Class Teacher",'value'=>$model->class_teacher_id ?? '','options'=>$teachers,'labelKey'=>'name_en','col'=>4,'required'=>false])
  @include('admin.partials._input', ['name'=>'code','label'=>"Class Code",'value'=>$model->code ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name','label'=>"Class Name",'value'=>$model->name ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'student_limit','label'=>"Student Limit",'value'=>$model->student_limit ?? '','col'=>4,'required'=>false,'type'=>'number'])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'planned','display'=>'Planned'], ['id'=>'active','display'=>'Active'], ['id'=>'closed','display'=>'Closed'], ['id'=>'archived','display'=>'Archived']],'col'=>4,'required'=>true])
</div>
