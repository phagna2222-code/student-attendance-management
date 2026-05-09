<div class="row">
  @include('admin.partials._input', ['name'=>'code','label'=>"Code",'value'=>$model->code ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name','label'=>"Name",'value'=>$model->name ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._select', ['name'=>'channel','label'=>"Channel",'value'=>$model->channel ?? '','options'=>[['id'=>'sms','display'=>'SMS'], ['id'=>'email','display'=>'Email'], ['id'=>'telegram','display'=>'Telegram'], ['id'=>'portal','display'=>'Portal'], ['id'=>'push','display'=>'Push']],'col'=>4,'required'=>true])
  @include('admin.partials._input', ['name'=>'subject','label'=>"Subject",'value'=>$model->subject ?? '','col'=>12,'required'=>false,'type'=>'text'])
  @include('admin.partials._textarea', ['name'=>'body','label'=>"Body",'value'=>$model->body ?? '','rows'=>6,'required'=>false])
  @include('admin.partials._input', ['name'=>'variables','label'=>"Variables (comma-separated)",'value'=>$model->variables ?? '','col'=>12,'required'=>false,'type'=>'text'])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'active','display'=>'Active'], ['id'=>'inactive','display'=>'Inactive']],'col'=>4,'required'=>true])
</div>
