<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url' => 'custom-field'))); ?>

    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('name',__('Custom Field Name'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('name',null,array('class'=>'form-control','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-12">
            <div class="input-group">
                <?php echo e(Form::label('type', __('Type'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('type',$types,null, array('class' => 'form-control select2 ','required'=>'required'))); ?>

            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="input-group">
                <?php echo e(Form::label('module', __('Module'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('module',$modules,null, array('class' => 'form-control select2 ','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\xampp\htdocs\HRM\resources\views/customFields/create.blade.php ENDPATH**/ ?>