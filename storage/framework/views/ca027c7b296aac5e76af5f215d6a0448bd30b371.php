<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'eobi','method'=>'POST'))); ?>

    <?php echo csrf_field(); ?>
    <?php echo e(Form::hidden('employee_id',$employee->id, array())); ?>

    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('title', __('Title'),['class'=>'form-control-label'])); ?><span class="text-danger">*</span>
            <?php echo e(Form::text('title',null, array('class' => 'form-control ','required'=>'required'))); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('employee_amount', __('Employee Amount'),['class'=>'form-control-label'])); ?><span class="text-danger">*</span>
            <?php echo e(Form::number('employee_amount',null, array('class' => 'form-control ','required'=>'required'))); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('employer_amount', __('Employer Amount'),['class'=>'form-control-label'])); ?><span class="text-danger">*</span>
            <?php echo e(Form::number('employer_amount',null, array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('eobi_date', __('EOBI Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::date('eobi_date',null, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
       
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\xampp\htdocs\HRM\resources\views/eobi/create.blade.php ENDPATH**/ ?>