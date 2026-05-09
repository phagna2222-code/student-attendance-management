<div class="row">
  @include('admin.partials._select', ['name'=>'branch_id','label'=>"Branch",'value'=>$model->branch_id ?? '','options'=>$branches,'labelKey'=>'name_en','col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'user_id','label'=>"User Account",'value'=>$model->user_id ?? '','options'=>$users,'col'=>4,'required'=>false])
  @include('admin.partials._input', ['name'=>'teacher_code','label'=>"Teacher Code",'value'=>$model->teacher_code ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name_en','label'=>"Name (EN)",'value'=>$model->name_en ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name_kh','label'=>"Name (KH)",'value'=>$model->name_kh ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._select', ['name'=>'gender','label'=>"Gender",'value'=>$model->gender ?? '','options'=>[['id'=>'male','display'=>'Male'], ['id'=>'female','display'=>'Female'], ['id'=>'other','display'=>'Other']],'col'=>4,'required'=>false])
  @include('admin.partials._input', ['name'=>'date_of_birth','label'=>"Date of Birth",'value'=>$model->date_of_birth ?? '','col'=>4,'required'=>false,'type'=>'date'])
  @include('admin.partials._input', ['name'=>'phone','label'=>"Phone",'value'=>$model->phone ?? '','col'=>4,'required'=>false,'type'=>'tel'])
  @include('admin.partials._input', ['name'=>'email','label'=>"Email",'value'=>$model->email ?? '','col'=>4,'required'=>false,'type'=>'email'])
  @include('admin.partials._textarea', ['name'=>'address','label'=>"Address",'value'=>$model->address ?? '','rows'=>3,'required'=>false])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'active','display'=>'Active'], ['id'=>'inactive','display'=>'Inactive'], ['id'=>'resigned','display'=>'Resigned'], ['id'=>'suspended','display'=>'Suspended']],'col'=>4,'required'=>true])
</div>
