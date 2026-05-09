<div class="row">
  @include('admin.partials._input', ['name'=>'code','label'=>__('admin.code'),'value'=>$model->code ?? '','required'=>true,'col'=>4])
  @include('admin.partials._input', ['name'=>'name_en','label'=>__('admin.name_en'),'value'=>$model->name_en ?? '','required'=>true,'col'=>4])
  @include('admin.partials._input', ['name'=>'name_kh','label'=>__('admin.name_kh'),'value'=>$model->name_kh ?? '','col'=>4])
  @include('admin.partials._input', ['name'=>'phone','label'=>__('admin.phone'),'value'=>$model->phone ?? '','col'=>4])
  @include('admin.partials._input', ['name'=>'email','label'=>__('admin.email'),'value'=>$model->email ?? '','type'=>'email','col'=>4])
  @include('admin.partials._input', ['name'=>'website','label'=>__('admin.website'),'value'=>$model->website ?? '','col'=>4])
  @include('admin.partials._textarea', ['name'=>'address','label'=>__('admin.address'),'value'=>$model->address ?? ''])
  @include('admin.partials._checkbox', ['name'=>'is_main','label'=>__('admin.is_main'),'value'=>$model->is_main ?? false,'col'=>4])
  @include('admin.partials._select', ['name'=>'status','label'=>__('admin.status'),'value'=>$model->status ?? 'active','options'=>[
    ['id'=>'active','display'=>__('admin.active')],
    ['id'=>'inactive','display'=>__('admin.inactive')],
  ],'required'=>true,'col'=>4])
</div>
