<div class="row">
  @include('admin.partials._input', ['name'=>'code','label'=>__('admin.code'),'value'=>$model->code ?? '','col'=>3,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name','label'=>__('admin.name'),'value'=>$model->name ?? '','col'=>5,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'start_date','label'=>"Start Date",'value'=>$model->start_date ?? '','col'=>4,'required'=>true,'type'=>'date'])
  @include('admin.partials._input', ['name'=>'end_date','label'=>"End Date",'value'=>$model->end_date ?? '','col'=>4,'required'=>true,'type'=>'date'])
  @include('admin.partials._checkbox', ['name'=>'is_current','label'=>"Is Current",'value'=>$model->is_current ?? false,'col'=>4])
  @include('admin.partials._select', ['name'=>'status','label'=>__('admin.status'),'value'=>$model->status ?? '','options'=>[['id'=>'planned','display'=>'Planned'], ['id'=>'active','display'=>'Active'], ['id'=>'closed','display'=>'Closed'], ['id'=>'archived','display'=>'Archived']],'col'=>4,'required'=>true])
</div>
