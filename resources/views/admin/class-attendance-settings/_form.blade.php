<div class="row">
  @include('admin.partials._select', ['name'=>'class_id','label'=>"Class",'value'=>$model->class_id ?? '','options'=>$classes,'col'=>4,'required'=>true])
  @include('admin.partials._input', ['name'=>'check_in_start_time','label'=>"Check-in Start",'value'=>$model->check_in_start_time ?? '','col'=>4,'required'=>false,'type'=>'time'])
  @include('admin.partials._input', ['name'=>'check_in_end_time','label'=>"Check-in End",'value'=>$model->check_in_end_time ?? '','col'=>4,'required'=>false,'type'=>'time'])
  @include('admin.partials._input', ['name'=>'check_out_time','label'=>"Check-out",'value'=>$model->check_out_time ?? '','col'=>4,'required'=>false,'type'=>'time'])
  @include('admin.partials._input', ['name'=>'late_grace_minutes','label'=>"Late Grace (min)",'value'=>$model->late_grace_minutes ?? '','col'=>4,'required'=>false,'type'=>'number'])
  @include('admin.partials._checkbox', ['name'=>'allow_manual_attendance','label'=>"Allow Manual",'value'=>$model->allow_manual_attendance ?? false,'col'=>3])
  @include('admin.partials._checkbox', ['name'=>'allow_qr_attendance','label'=>"Allow QR",'value'=>$model->allow_qr_attendance ?? false,'col'=>3])
  @include('admin.partials._checkbox', ['name'=>'allow_barcode_attendance','label'=>"Allow Barcode",'value'=>$model->allow_barcode_attendance ?? false,'col'=>3])
  @include('admin.partials._checkbox', ['name'=>'allow_rfid_attendance','label'=>"Allow RFID",'value'=>$model->allow_rfid_attendance ?? false,'col'=>3])
  @include('admin.partials._checkbox', ['name'=>'auto_mark_absent','label'=>"Auto Mark Absent",'value'=>$model->auto_mark_absent ?? false,'col'=>4])
</div>
