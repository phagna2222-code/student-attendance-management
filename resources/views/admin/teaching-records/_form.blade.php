<div class="row">
  @include('admin.partials._select', ['name'=>'class_id','label'=>__('admin.class'),'value'=>$model->class_id ?? '','options'=>$classes->map(fn($c)=>['id'=>$c->id,'display'=>$c->name])->all(),'col'=>4,'required'=>true])
  @include('admin.partials._select', ['name'=>'subject_id','label'=>__('admin.subject'),'value'=>$model->subject_id ?? '','options'=>$subjects->map(fn($s)=>['id'=>$s->id,'display'=>$s->name_en])->all(),'col'=>4,'required'=>false])
  @include('admin.partials._select', ['name'=>'teacher_id','label'=>__('admin.teacher'),'value'=>$model->teacher_id ?? '','options'=>$teachers->map(fn($t)=>['id'=>$t->id,'display'=>$t->name_en])->all(),'col'=>4,'required'=>false])
  @include('admin.partials._input', ['name'=>'teaching_date','label'=>__('admin.teaching_date'),'value'=>$model->teaching_date?->format('Y-m-d') ?? '','col'=>4,'required'=>true,'type'=>'date'])
  @include('admin.partials._select', ['name'=>'attendance_session_id','label'=>__('admin.attendance_session'),'value'=>$model->attendance_session_id ?? '','options'=>$sessions->map(fn($s)=>['id'=>$s->id,'display'=>$s->attendance_date?->format('Y-m-d').' #'.$s->id])->all(),'col'=>4,'required'=>false])
  @include('admin.partials._input', ['name'=>'lesson_title','label'=>__('admin.lesson_title'),'value'=>$model->lesson_title ?? '','col'=>12,'type'=>'text'])
  @include('admin.partials._textarea', ['name'=>'lesson_content','label'=>__('admin.lesson_content'),'value'=>$model->lesson_content ?? '','rows'=>3])
  @include('admin.partials._textarea', ['name'=>'homework','label'=>__('admin.homework'),'value'=>$model->homework ?? '','rows'=>2])
  @include('admin.partials._textarea', ['name'=>'notes','label'=>__('admin.notes'),'value'=>$model->notes ?? '','rows'=>2])
</div>
