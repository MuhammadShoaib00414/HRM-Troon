<div class="card bg-none card-box">
    <?php echo e(Form::model($ducumentUpload,array('route' => array('document-upload.update', $ducumentUpload->id), 'method' => 'PUT','enctype' => "multipart/form-data"))); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('name',__('Name'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('name',null,array('class'=>'form-control','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('document',__('Document'),['class'=>'form-control-label'])); ?>

                <div class="choose-file form-group">
                    <label for="document" class="form-control-label">
                        <div><?php echo e(__('Choose file here')); ?></div>
                        <input type="file" class="form-control" name="document" id="document" data-filename="document_update">
                    </label>
                    <p class="document_update"></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('role',__('Role'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('role',$roles,null,array('class'=>'form-control select2'))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('description', __('Description'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::textarea('description',null, array('class' => 'form-control'))); ?>

            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\xampp\htdocs\HRM\resources\views/documentUpload/edit.blade.php ENDPATH**/ ?>