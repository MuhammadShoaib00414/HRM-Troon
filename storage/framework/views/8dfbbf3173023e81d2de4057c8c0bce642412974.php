<div class="card bg-none card-box">
    <?php echo e(Form::model($leave,array('route' => array('leave.update', $leave->id), 'method' => 'PUT'))); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('employee_id',__('Employee'))); ?>

                <?php echo e(Form::select('employee_id',$employees,null,array('class'=>'form-control select2','placeholder'=>__('Select Employee')))); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('leave_type_id',__('Leave Type'))); ?>

                <?php echo e(Form::select('leave_type_id',$leavetypes,null,array('class'=>'form-control select2','placeholder'=>__('Select Leave Type')))); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('start_date',__('Start Date'))); ?>

                <?php echo e(Form::text('start_date',null,array('class'=>'form-control datepicker'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('end_date',__('End Date'))); ?>

                <?php echo e(Form::text('end_date',null,array('class'=>'form-control datepicker'))); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('leave_reason',__('Leave Reason'))); ?>

                <?php echo e(Form::textarea('leave_reason',null,array('class'=>'form-control','placeholder'=>__('Leave Reason')))); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('remark',__('Remark'))); ?>

                <?php echo e(Form::textarea('remark',null,array('class'=>'form-control','placeholder'=>__('Leave Remark')))); ?>

            </div>
        </div>
    </div>
    <?php if(auth()->check() && auth()->user()->hasRole('Company')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('status',__('Status'))); ?>

                <select name="status" id="" class="form-control select2">
                    <option value=""><?php echo e(__('Select Status')); ?></option>
                    <option value="pending" <?php if($leave->status=='Pending'): ?> selected="" <?php endif; ?>><?php echo e(__('Pending')); ?></option>
                    <option value="approval" <?php if($leave->status=='Approval'): ?> selected="" <?php endif; ?>><?php echo e(__('Approval')); ?></option>
                    <option value="reject" <?php if($leave->status=='Reject'): ?> selected="" <?php endif; ?>><?php echo e(__('Reject')); ?></option>
                </select>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\xampp\htdocs\HRM\resources\views/leave/edit.blade.php ENDPATH**/ ?>