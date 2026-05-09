<div class="row">
  @include('admin.partials._input', ['name'=>'code','label'=>"Code",'value'=>$model->code ?? '','col'=>3,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name_en','label'=>"Name (EN)",'value'=>$model->name_en ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name_kh','label'=>"Name (KH)",'value'=>$model->name_kh ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'color','label'=>"Color",'value'=>$model->color ?? '','col'=>3,'required'=>false,'type'=>'text','placeholder'=>'#22c55e'])
  @include('admin.partials._checkbox', ['name'=>'counts_as_present','label'=>"Counts as present",'value'=>$model->counts_as_present ?? false,'col'=>4])
  @include('admin.partials._checkbox', ['name'=>'counts_as_absent','label'=>"Counts as absent",'value'=>$model->counts_as_absent ?? false,'col'=>4])
  @include('admin.partials._checkbox', ['name'=>'requires_approval','label'=>"Requires approval",'value'=>$model->requires_approval ?? false,'col'=>4])
  @include('admin.partials._input', ['name'=>'sort_order','label'=>"Sort Order",'value'=>$model->sort_order ?? '','col'=>3,'required'=>false,'type'=>'number'])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'active','display'=>'Active'], ['id'=>'inactive','display'=>'Inactive']],'col'=>4,'required'=>true])
</div>
