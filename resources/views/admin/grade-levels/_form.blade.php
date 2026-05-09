<div class="row">
  @include('admin.partials._input', ['name'=>'code','label'=>"Code",'value'=>$model->code ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name_en','label'=>"Name (EN)",'value'=>$model->name_en ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name_kh','label'=>"Name (KH)",'value'=>$model->name_kh ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'level_order','label'=>"Order",'value'=>$model->level_order ?? '','col'=>4,'required'=>false,'type'=>'number'])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'active','display'=>'Active'], ['id'=>'inactive','display'=>'Inactive']],'col'=>4,'required'=>true])
</div>
