<div class="card bg-none card-box">
<?php echo e(Form::open(array('url'=>'opd-payment','method'=>'post', 'enctype' => 'multipart/form-data'))); ?>

    <div class="row">
        <div class="form-group col-md-6">
        <label for="religion" class="form-control-label"><?php echo e(__('Employee')); ?></label><span class="text-danger pl-1">*</span>
        <select class="form-control select2 select2-hidden-accessible"  name="employee_id" id="employee_id">
          
           <?php $__currentLoopData = $employee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      
             <option value="<?php echo e($data->id); ?>"><?php echo e($data->name); ?> </option>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        
        </select>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('amount', __('Amount'),['class'=>'form-control-label'])); ?><span class="text-danger pl-1">*</span>
            <?php echo e(Form::number('amount',null, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('date',__('Date'),['class'=>'form-control-label'])); ?><span class="text-danger pl-1">*</span>
            <?php echo e(Form::date('date',null,array('class'=>'form-control'))); ?>

        </div>
        <div class="form-group col-md-6">
        <?php echo e(Form::label('attachment',__('Attachment'),['class'=>'form-control-label'])); ?>


        <div class="choose-file form-group">
            
            <label for="attachment">
               <div><?php echo e(__('Choose File')); ?></div>
               <input class="form-control border-0"  type="file" id="attachment" name="attachment" data-filename="attachment_filename">
               <p class="attachment_filename"></p>
           </label>
            

                </div>
        </div>
        </div>
        
        <div class="form-group col-md-12">
            <?php echo e(Form::label('description',__('Description'))); ?>

            <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Note')))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

    </div>
<?php /**PATH C:\xampp\htdocs\HRM\resources\views/opdPayment/create.blade.php ENDPATH**/ ?>