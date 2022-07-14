<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'resignation','method'=>'post','enctype' => 'multipart/form-data'))); ?>

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
                <option value="yes"> Yes  </option>
                <option value="no"> No  </option>
               
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('notice_date',__('Disable Account'),['class'=>'form-control-label'])); ?>

            <select class="form-control select2 select2-hidden-accessible" name="disabledAccount" id="disabledAccount">
            <option value="" selected="" disabled="">Select One</option>
                <option value="yes"> Yes  </option>
                <option value="no"> No </option>
               
            </select>
        </div>
        

        <div class="form-group col-lg-6"  id="items">
            <div class="choose-file form-group">
                <label for="document">
                    <div><?php echo e(__('Choose File')); ?></div>
                    <input class="form-control border-0" type="file" id="resignationDocument" name="resignationDocument[]"  data-filename="letter_filename"> 

                    <p class="letter_filename"></p>
                </label>
            </div>
        </div>

       <div class="form-group col-md-12">
       
          <a href="#"  id="add" class="btn add-more btn-create badge-blue uppercase" >
                <i class="fa fa-plus"></i> Add
            </a>

            <a class="delete btn btn-create badge-danger uppercase" >
               - Remove
            </a>
     </div>
        
       
        <div class="form-group col-lg-12">
            <?php echo e(Form::label('description',__('Description'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>

<script>
$(document).ready(function() {
  $(".delete").hide();
  //when the Add Field button is clicked
  $("#add").click(function(e) {
    $(".delete").fadeIn("1500");
    //Append a new row of code to the "#items" div
    $("#items").append(
      '<div class="next-referral form-group col-lg-6"><div class="choose-file form-group" ><label for="document"><div><?php echo e(__('Choose File')); ?></div><input class="form-control border-0" type="file" id="degree_copy" name="resignationDocument[]"  data-filename="letter_filenames">    <p class="letter_filenames"></p> </label></div></div');
  });
  $("body").on("click", ".delete", function(e) {
    $(".next-referral").last().remove();
  });
});


</script><?php /**PATH C:\xampp\htdocs\HRM\resources\views/resignation/create.blade.php ENDPATH**/ ?>