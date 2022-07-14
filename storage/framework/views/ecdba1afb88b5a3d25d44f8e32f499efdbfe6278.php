<div class="card bg-none card-box">
<?php echo e(Form::open(array('url'=>'request-provident','method'=>'post'))); ?>

    <div class="row">
        <div class="form-group col-md-4">
        <label for="religion" class="form-control-label"><?php echo e(__('Employee')); ?></label>
        <select class="form-control select2 select2-hidden-accessible"  name="employee_id" id="employee_id">
          
           <?php $__currentLoopData = $employee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      
             <option value="<?php echo e($data->id); ?>"><?php echo e($data->name); ?> </option>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        
        </select>
        </div>
        <div class="form-group col-md-4 ">
            <?php echo e(Form::label('amount', __('Amount'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('amount',null, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-4">
            <?php echo e(Form::label('date',__('Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::date('date',null,array('class'=>'form-control'))); ?>

        </div>
       
        <div class="form-group col-md-12">
            <?php echo e(Form::label('note',__('Description'))); ?>

            <?php echo e(Form::textarea('note',null,array('class'=>'form-control','placeholder'=>__('Enter Note')))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

    </div>
    <script>
      $(function () {
        $('input[type="text').keypress(function (e) {
			var regex = new RegExp("^[a-zA-Z]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (regex.test(str)) {
				return true;
			}
			else
			{
			e.preventDefault();
			$('.errmsg').show();

			$('.errmsg').text('Please Enter Alphabate');
            $(".errmsg").show().delay(2000).fadeOut();
			return false;

			}
		});
  });
</script><?php /**PATH C:\xampp\htdocs\HRM\resources\views/providentfund/create.blade.php ENDPATH**/ ?>