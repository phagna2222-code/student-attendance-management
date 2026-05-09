<div class="row">
  @include('admin.partials._select', ['name'=>'user_id','label'=>"User Account",'value'=>$model->user_id ?? '','options'=>$users,'col'=>4,'required'=>false])
  @include('admin.partials._input', ['name'=>'parent_code','label'=>"Parent Code",'value'=>$model->parent_code ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name_en','label'=>"Name (EN)",'value'=>$model->name_en ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name_kh','label'=>"Name (KH)",'value'=>$model->name_kh ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._select', ['name'=>'gender','label'=>"Gender",'value'=>$model->gender ?? '','options'=>[['id'=>'male','display'=>'Male'], ['id'=>'female','display'=>'Female'], ['id'=>'other','display'=>'Other']],'col'=>4,'required'=>false])
  @include('admin.partials._input', ['name'=>'phone','label'=>"Phone",'value'=>$model->phone ?? '','col'=>4,'required'=>false,'type'=>'tel'])
  @include('admin.partials._input', ['name'=>'secondary_phone','label'=>"Secondary Phone",'value'=>$model->secondary_phone ?? '','col'=>4,'required'=>false,'type'=>'tel'])
  @include('admin.partials._input', ['name'=>'email','label'=>"Email",'value'=>$model->email ?? '','col'=>4,'required'=>false,'type'=>'email'])
  @include('admin.partials._input', ['name'=>'telegram_chat_id','label'=>"Telegram Chat ID",'value'=>$model->telegram_chat_id ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._textarea', ['name'=>'address','label'=>"Address",'value'=>$model->address ?? '','rows'=>3,'required'=>false])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'active','display'=>'Active'], ['id'=>'inactive','display'=>'Inactive']],'col'=>4,'required'=>true])
</div>
