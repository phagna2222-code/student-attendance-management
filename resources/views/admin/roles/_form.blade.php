<div class="row">
  @include('admin.partials._input', ['name'=>'slug','label'=>"Slug",'value'=>$model->slug ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._input', ['name'=>'name','label'=>"Name",'value'=>$model->name ?? '','col'=>4,'required'=>true,'type'=>'text'])
  @include('admin.partials._textarea', ['name'=>'description','label'=>"Description",'value'=>$model->description ?? '','rows'=>3,'required'=>false])
  <div class="col-12">
    <hr>
    <h6 class="mb-3">{{ __('admin.permissions') }}</h6>
    @php $rolePerms = $model->id ? $model->permissions->pluck('id')->all() : []; @endphp
    @foreach($permissions as $group => $perms)
      <div class="mb-2">
        <strong>{{ ucfirst(str_replace('_',' ', $group)) }}</strong>
        <div class="row">
          @foreach($perms as $p)
            <div class="col-md-3 col-6">
              <div class="form-check">
                <input type="checkbox" name="permissions[]" value="{{ $p->id }}" id="p_{{ $p->id }}"
                       class="form-check-input" {{ in_array($p->id, $rolePerms) ? 'checked' : '' }}>
                <label class="form-check-label" for="p_{{ $p->id }}">{{ $p->name }}</label>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
</div>
