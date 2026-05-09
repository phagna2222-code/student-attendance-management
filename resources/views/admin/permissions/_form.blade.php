<div class="row">
  @include('admin.partials._input', ['name'=>'group','label'=>"Group",'value'=>$model->group ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'slug','label'=>"Slug",'value'=>$model->slug ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name','label'=>"Name",'value'=>$model->name ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._textarea', ['name'=>'description','label'=>"Description",'value'=>$model->description ?? '','rows'=>3,'required'=>false])
</div>
