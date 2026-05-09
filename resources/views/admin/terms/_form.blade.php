<div class="row">
  @include('admin.partials._select', ['name'=>'academic_year_id','label'=>"Academic Year",'value'=>$model->academic_year_id ?? '','options'=>$academicYears,'col'=>4,'required'=>true])
  @include('admin.partials._input', ['name'=>'code','label'=>"Code",'value'=>$model->code ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name','label'=>"Name",'value'=>$model->name ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'term_no','label'=>"Term #",'value'=>$model->term_no ?? '','col'=>4,'required'=>false,'type'=>'number'])
  @include('admin.partials._input', ['name'=>'start_date','label'=>"Start",'value'=>$model->start_date ?? '','col'=>4,'required'=>true,'type'=>'date'])
  @include('admin.partials._input', ['name'=>'end_date','label'=>"End",'value'=>$model->end_date ?? '','col'=>4,'required'=>true,'type'=>'date'])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'planned','display'=>'Planned'], ['id'=>'active','display'=>'Active'], ['id'=>'closed','display'=>'Closed']],'col'=>4,'required'=>true])
</div>
