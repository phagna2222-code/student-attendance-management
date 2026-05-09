<div class="row">
  @include('admin.partials._input', ['name'=>'request_no','label'=>"Request #",'value'=>$model->request_no ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._select', ['name'=>'student_id','label'=>"Student",'value'=>$model->student_id ?? '','options'=>$students,'col'=>4,'required'=>true])
  @include('admin.partials._input', ['name'=>'start_date','label'=>"Start Date",'value'=>$model->start_date ?? '','col'=>4,'required'=>true,'type'=>'date'])
  @include('admin.partials._input', ['name'=>'end_date','label'=>"End Date",'value'=>$model->end_date ?? '','col'=>4,'required'=>true,'type'=>'date'])
  @include('admin.partials._input', ['name'=>'total_days','label'=>"Total Days",'value'=>$model->total_days ?? '','col'=>4,'required'=>false,'type'=>'number'])
  @include('admin.partials._select', ['name'=>'leave_type','label'=>"Leave Type",'value'=>$model->leave_type ?? '','options'=>[['id'=>'permission','display'=>'Permission'], ['id'=>'leave','display'=>'Leave'], ['id'=>'sick','display'=>'Sick'], ['id'=>'family','display'=>'Family'], ['id'=>'other','display'=>'Other']],'col'=>4,'required'=>true])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'pending','display'=>'Pending'], ['id'=>'approved','display'=>'Approved'], ['id'=>'rejected','display'=>'Rejected'], ['id'=>'need_more_info','display'=>'Need More Info'], ['id'=>'cancelled','display'=>'Cancelled']],'col'=>4,'required'=>true])
  @include('admin.partials._textarea', ['name'=>'reason','label'=>"Reason",'value'=>$model->reason ?? '','rows'=>3,'required'=>false])
  @include('admin.partials._textarea', ['name'=>'reject_reason','label'=>"Reject Reason",'value'=>$model->reject_reason ?? '','rows'=>3,'required'=>false])
</div>
