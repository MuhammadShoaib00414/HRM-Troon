<div class="card bg-none card-box">
    <?php echo e(Form::model($resignation,array('route' => array('resignation.update', $resignation->id), 'method' => 'PUT','enctype' => 'multipart/form-data'))); ?>

    <div class="row">
        <?php if(\Auth::user()->type!='employee'): ?>
            <div class="form-group col-lg-12">
                <?php echo e(Form::label('employee_id', __('Employee'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('employee_id', $employees,null, array('class' => 'form-control select2','required'=>'required'))); ?>

              
            </div>
        <?php endif; ?>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('notice_date',__('Notice Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('notice_date',null,array('class'=>'form-control datepicker'))); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('resignation_date',__('Resignation Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('resignation_date',null,array('class'=>'form-control datepicker'))); ?>

        </div>
        
        
        
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('notice_date',__('Exit Interview'),['class'=>'form-control-label'])); ?>

            <select class="form-control select2 select2-hidden-accessible" name="exit_interview" id="exit_interview">
                <option value="" selected="" disabled="" >Select One</option>
                <option value="yes"  <?php echo e(($resignation['exit_interview']) == 'yes' ? 'selected' : ''); ?>> Yes  </option>
                <option value="no"  <?php echo e(($resignation['exit_interview']) == 'no' ? 'selected' : ''); ?>> No  </option>
               
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('notice_date',__('Disable Account'),['class'=>'form-control-label'])); ?>

            <select class="form-control select2 select2-hidden-accessible" name="disabledAccount" id="disabledAccount">
            <option value="" selected="" disabled="">Select One</option>
                <option value="yes"  <?php echo e(($resignation['disabledAccount']) == 'yes' ? 'selected' : ''); ?>> Yes  </option>
                <option value="no"  <?php echo e(($resignation['disabledAccount']) == 'no' ? 'selected' : ''); ?>> No </option>
               
            </select>
        </div>
        

        <div class="form-group col-lg-12">
            <?php
                $resignation = json_decode($resignation['resignationDocument']);
                
                ?>
            <table class="table table-bordered" id="dynamicDevice">
                <td>
                    <button type="button" name="device_add" id="add_device" class="btn-create btn-xs badge-blue radius-10px">Add More</button>
                </td>
                <?php $__currentLoopData = $resignation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="form-group">
                        <div class="choose-file form-group">
                        <label for="document">
                            <div><?php echo e(__('Choose File')); ?></div>
                            <input class="form-control border-0" type="file" id="resignationDocument" value="<?php echo e($file); ?>" name="resignationDocument[]" data-filename="profile_filenames">   
                            <input class="form-control" type="hidden" value="<?php echo e($file); ?>" name="resignation_old[]">   
                            <p class="profile_filenames"></p>
                        </label>
                        </div>
                    </td>
                    <td>
                     <?php if($file): ?>
                        <a href="/public/uploads/resignation/<?php echo e($file); ?>" download><i class="fa fa-download"></i></a>
                     <?php endif; ?>
                    </td>
                    <td><button type="button" class="btn-create btn-xs badge-danger radius-10px float-right remove-tr">Remove</button></td>
                </tr>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </table>
         </div>
        
        <div class="form-group col-lg-12">
            <?php echo e(Form::label('description',__('Description'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<script>

var i = 0;
$("#add_device").click(function() {
		++i;
		$("#dynamicDevice").append('<tr> <td class="form-group"> <div class="choose-file form-group"> <label for="document"> <div><?php echo e(__('Choose File')); ?></div><input class="form-control border-0" type="file" id="resignationDocument" name="resignationDocument[]"> </label> </div></td><td></td><td><button type="button" class="btn-create btn-xs badge-danger radius-10px float-right remove-tr">Remove</button></td></tr></tr>');
	});
    $(document).on('click', '.remove-tr', function() {
		$(this).parents('tr').remove();
	});


</script><?php /**PATH C:\xampp\htdocs\HRM\resources\views/resignation/edit.blade.php ENDPATH**/ ?>