<?php echo e(Form::open(array('url'=>'attendanceemployee','method'=>'post'))); ?>

<div class="card-body p-0">
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('employee_id',__('Employee'))); ?>

            <?php echo e(Form::select('employee_id',$employees,null,array('class'=>'form-control select2'))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('date',__('Date'))); ?>

            <?php echo e(Form::text('date',null,array('class'=>'form-control datepicker'))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('clock_in',__('Clock In'))); ?>

            <?php echo e(Form::text('clock_in',null,array('class'=>'form-control timepicker'))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('clock_out',__('Clock Out'))); ?>

            <?php echo e(Form::text('clock_out',null,array('class'=>'form-control timepicker'))); ?>

        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <?php echo e(Form::submit(__('Create'),array('class'=>'btn btn-primary'))); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\HRM\resources\views/attendance/create.blade.php ENDPATH**/ ?>