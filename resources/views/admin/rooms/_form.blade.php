<div class="row">
  @include('admin.partials._select', ['name'=>'branch_id','label'=>"Branch",'value'=>$model->branch_id ?? '','options'=>$branches,'labelKey'=>'name_en','col'=>4,'required'=>true])
  @include('admin.partials._input', ['name'=>'code','label'=>"Code",'value'=>$model->code ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name','label'=>"Name",'value'=>$model->name ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'capacity','label'=>"Capacity",'value'=>$model->capacity ?? '','col'=>4,'required'=>false,'type'=>'number'])
  @include('admin.partials._input', ['name'=>'building','label'=>"Building",'value'=>$model->building ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'floor','label'=>"Floor",'value'=>$model->floor ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'active','display'=>'Active'], ['id'=>'inactive','display'=>'Inactive'], ['id'=>'maintenance','display'=>'Maintenance']],'col'=>4,'required'=>true])
</div>
