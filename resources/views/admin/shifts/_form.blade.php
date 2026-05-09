<div class="row">
  @include('admin.partials._input', ['name'=>'code','label'=>"Code",'value'=>$model->code ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name','label'=>"Name",'value'=>$model->name ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'start_time','label'=>"Start Time",'value'=>$model->start_time ?? '','col'=>4,'required'=>false,'type'=>'time'])
  @include('admin.partials._input', ['name'=>'end_time','label'=>"End Time",'value'=>$model->end_time ?? '','col'=>4,'required'=>false,'type'=>'time'])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'active','display'=>'Active'], ['id'=>'inactive','display'=>'Inactive']],'col'=>4,'required'=>true])
</div>
