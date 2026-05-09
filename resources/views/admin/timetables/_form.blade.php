<div class="row">
  @include('admin.partials._select', ['name'=>'class_id','label'=>"Class",'value'=>$model->class_id ?? '','options'=>$classes,'col'=>4,'required'=>true])
  @include('admin.partials._select', ['name'=>'subject_id','label'=>"Subject",'value'=>$model->subject_id ?? '','options'=>$subjects,'labelKey'=>'name_en','col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'teacher_id','label'=>"Teacher",'value'=>$model->teacher_id ?? '','options'=>$teachers,'labelKey'=>'name_en','col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'room_id','label'=>"Room",'value'=>$model->room_id ?? '','options'=>$rooms,'col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'term_id','label'=>"Term",'value'=>$model->term_id ?? '','options'=>$terms,'col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'day_of_week','label'=>"Day of Week",'value'=>$model->day_of_week ?? '','options'=>[['id'=>'0','display'=>'Sunday'], ['id'=>'1','display'=>'Monday'], ['id'=>'2','display'=>'Tuesday'], ['id'=>'3','display'=>'Wednesday'], ['id'=>'4','display'=>'Thursday'], ['id'=>'5','display'=>'Friday'], ['id'=>'6','display'=>'Saturday']],'col'=>4,'required'=>true])
  @include('admin.partials._input', ['name'=>'session_name','label'=>"Session Name",'value'=>$model->session_name ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'period_no','label'=>"Period #",'value'=>$model->period_no ?? '','col'=>4,'required'=>false,'type'=>'number'])
  @include('admin.partials._input', ['name'=>'start_time','label'=>"Start Time",'value'=>$model->start_time ?? '','col'=>4,'required'=>true,'type'=>'time'])
  @include('admin.partials._input', ['name'=>'end_time','label'=>"End Time",'value'=>$model->end_time ?? '','col'=>4,'required'=>true,'type'=>'time'])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'active','display'=>'Active'], ['id'=>'inactive','display'=>'Inactive']],'col'=>4,'required'=>true])
</div>
