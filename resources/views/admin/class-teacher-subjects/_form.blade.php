<div class="row">
  @include('admin.partials._select', ['name'=>'class_id','label'=>"Class",'value'=>$model->class_id ?? '','options'=>$classes,'col'=>4,'required'=>true])
  @include('admin.partials._select', ['name'=>'teacher_id','label'=>"Teacher",'value'=>$model->teacher_id ?? '','options'=>$teachers,'labelKey'=>'name_en','col'=>4,'required'=>true])
  @include('admin.partials._select', ['name'=>'subject_id','label'=>"Subject",'value'=>$model->subject_id ?? '','options'=>$subjects,'labelKey'=>'name_en','col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'academic_year_id','label'=>"Academic Year",'value'=>$model->academic_year_id ?? '','options'=>$academicYears,'col'=>4,'required'=>true])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'active','display'=>'Active'], ['id'=>'inactive','display'=>'Inactive']],'col'=>4,'required'=>true])
</div>
