<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'tax','method'=>'POST'))); ?>

    <?php echo csrf_field(); ?>
    <?php echo e(Form::hidden('employee_id',$employee->id, array())); ?>

    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('title', __('Title'),['class'=>'form-control-label'])); ?> <span class="text-danger">*</span>
            <?php echo e(Form::text('title',null, array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('tax_amount', __('Tax Amount'),['class'=>'form-control-label'])); ?><span class="text-danger">*</span>
            <?php echo e(Form::number('tax_amount',null, array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('tax_date', __('Tax Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::date('tax_date',null, array('class' => 'form-control','required'=>'required'))); ?>

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
            var regex = new RegExp("^[a-zA-Z ]+$");
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
</script><?php /**PATH C:\xampp\htdocs\HRM\resources\views/tax/create.blade.php ENDPATH**/ ?>