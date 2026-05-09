<div class="row">
  @include('admin.partials._select', ['name'=>'branch_id','label'=>"Branch",'value'=>$model->branch_id ?? '','options'=>$branches,'labelKey'=>'name_en','col'=>4,'required'=>false])
  @include('admin.partials._input', ['name'=>'name','label'=>"Name",'value'=>$model->name ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'username','label'=>"Username",'value'=>$model->username ?? '','col'=>4,'required'=>false,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'email','label'=>"Email",'value'=>$model->email ?? '','col'=>4,'required'=>false,'type'=>'email'])
  @include('admin.partials._input', ['name'=>'phone','label'=>"Phone",'value'=>$model->phone ?? '','col'=>4,'required'=>false,'type'=>'tel'])
  @include('admin.partials._input', ['name'=>'password','label'=>"Password",'value'=>$model->password ?? '','col'=>4,'required'=>false,'type'=>'password','help'=>'Leave empty to keep current'])
  @include('admin.partials._select', ['name'=>'user_type','label'=>"User Type",'value'=>$model->user_type ?? '','options'=>[['id'=>'super_admin','display'=>'Super Admin'], ['id'=>'school_admin','display'=>'School Admin'], ['id'=>'teacher','display'=>'Teacher'], ['id'=>'secretary','display'=>'Secretary'], ['id'=>'parent','display'=>'Parent'], ['id'=>'student','display'=>'Student'], ['id'=>'auditor','display'=>'Auditor']],'col'=>4,'required'=>true])
  @include('admin.partials._select', ['name'=>'status','label'=>"Status",'value'=>$model->status ?? '','options'=>[['id'=>'active','display'=>'Active'], ['id'=>'inactive','display'=>'Inactive'], ['id'=>'blocked','display'=>'Blocked'], ['id'=>'pending','display'=>'Pending']],'col'=>4,'required'=>true])
  <div class="col-md-8 mb-3">
    <label class="form-label">{{ __('admin.roles') }}</label>
    <select name="roles[]" multiple class="form-select tom-select-multi">
      @foreach($roles as $role)
        <option value="{{ $role->id }}" {{ ($model->id && $model->roles->pluck('id')->contains($role->id)) ? 'selected' : '' }}>{{ $role->name }}</option>
      @endforeach
    </select>
  </div>
</div>
