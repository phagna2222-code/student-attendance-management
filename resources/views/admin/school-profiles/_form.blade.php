<div class="row">
  @include('admin.partials._select', ['name'=>'branch_id','label'=>__('admin.branch'),'value'=>$model->branch_id ?? '','options'=>$branches,'labelKey'=>'name_en','col'=>4,'required'=>true])
  @include('admin.partials._input', ['name'=>'school_name_en','label'=>__('admin.name_en'),'value'=>$model->school_name_en ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'school_name_kh','label'=>__('admin.name_kh'),'value'=>$model->school_name_kh ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'phone','label'=>__('admin.phone'),'value'=>$model->phone ?? '','col'=>4,'required'=>false,'type'=>'tel'])
  @include('admin.partials._input', ['name'=>'email','label'=>__('admin.email'),'value'=>$model->email ?? '','col'=>4,'required'=>false,'type'=>'email'])
  @include('admin.partials._input', ['name'=>'website','label'=>__('admin.website'),'value'=>$model->website ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._textarea', ['name'=>'address','label'=>__('admin.address'),'value'=>$model->address ?? '','rows'=>3,'required'=>false])
</div>
