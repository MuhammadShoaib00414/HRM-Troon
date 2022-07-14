

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Allocated Amount')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="row d-flex justify-content-end">
    <div class="col-xl-4 col-lg-2">
            <?php echo e(Form::open(array('url' => array('allocated-amount'),'method'=>'get','id'=>'report_leave'))); ?>

            <div class="all-select-box">
                <div class="btn-box">
                  
                    <div class="d-flex radio-check">
                       
                        <div class="custom-control custom-radio custom-control-inline">
                            <input style="display:none" type="radio" id="yearly" value="yearly" name="type" class="custom-control-input yearly" <?php echo e(isset($_GET['type']) && $_GET['type']=='yearly' ?'checked':'checked'); ?>>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        <div class="col-xl-5 col-lg-3">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('year', __('Year'),['class'=>'text-type'])); ?>

                    <select class="form-control select2" id="year" name="year" tabindex="-1" aria-hidden="true">
                      <?php $__currentLoopData = $filterYear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                        <?php $year =  date('Y', strtotime($data['year']));?>                  
                        <option <?php echo e(($year) == date("Y") ? 'selected' : ''); ?> value="<?php echo e($year); ?>">
                            <?php echo e($year); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    </select>
                </div>
            </div>
        </div>

        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_leave').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(url('allocated-amount')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>

            <a href="#" data-url="<?php echo e(url('create-allocated-amount')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"
               data-ajax-popup="true" data-title="<?php echo e(__('Create Allocated Amount')); ?>">
                <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

            </a>
        </div>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>

    <script type="text/javascript" src="<?php echo e(asset('js/jszip.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/pdfmake.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/vfs_fonts.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/dataTables.buttons.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/buttons.html5.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script>
        var filename = $('#filename').val();

        

        $(document).ready(function () {
            var filename = $('#filename').val();
            $('#report-dataTable').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'pdf',
                        text: '<a  class="view-btn blue-bg">PDF</a>',
                        title: filename,
                        exportOptions: {
                            columns: [0,1,2,3],
                            targets: 1,
                            className: 'italic'
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<a  class="view-btn blue-bg">Excel</a>',
                        title: filename,
                        exportOptions: {
                            columns: [0,1,2,3],
                            targets: 1,
                            className: 'italic'
                        }
                    }, {
                        extend: 'csv',
                        text: '<a  class="view-btn blue-bg">CSV</a>',
                        title: filename,
                        exportOptions: {
                            columns: [0,1,2,3],
                            targets: 1,
                            className: 'italic'
                        }
                    }
                ]
            });
        });
    </script>
    <script>
        $('input[name="type"]:radio').on('change', function (e) {
            var type = $(this).val();
            if (type == 'monthly') {
                $('.month').addClass('d-block');
                $('.month').removeClass('d-none');
                $('.year').addClass('d-none');
                $('.year').removeClass('d-block');
            } else {
                $('.year').addClass('d-block');
                $('.year').removeClass('d-none');
                $('.month').addClass('d-none');
                $('.month').removeClass('d-block');
            }
        });

        $('input[name="type"]:radio:checked').trigger('change');

    </script>
<?php $__env->stopPush(); ?>

 

<?php $__env->startSection('content'); ?>

<div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-4">
                    <table class="table table-striped mb-0" id="report-dataTable">
                            <thead>
                            <tr>
                                <th><?php echo e(__('ID')); ?></th>
                                <th><?php echo e(__('Set Range')); ?></th>
                                <th><?php echo e(__('Set Employee Range')); ?></th>
                                <th><?php echo e(__('Year')); ?></th>
                                <th><?php echo e(__('Acction')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $allocatedAmounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allocatedAmount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            <tr>
                                    <td><?php echo e(\Auth::user()->employeeIdFormat($allocatedAmount['id'])); ?></td>
                                    <td><?php echo e(!empty($allocatedAmount['set_total_opd']) ? \Auth::user()->priceFormat($allocatedAmount['set_total_opd']) : '-'); ?></td>
                                    <td><?php echo e(!empty($allocatedAmount['set_total_employee_opd']) ? \Auth::user()->priceFormat($allocatedAmount['set_total_employee_opd']) : '-'); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($allocatedAmount['year'])); ?></td>
                                    <td>
                                  
                                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" 
                                      data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>"
                                       data-confirm-yes="document.getElementById('delete-form-<?php echo e($allocatedAmount['id']); ?>').submit();"><i class="fas fa-trash"></i></a>
                                      <?php echo Form::open(['method' => 'DELETE', 'url' => ['allocated-amount/destroyAllocatedAmount', $allocatedAmount['id']],'id'=>'delete-form-'.$allocatedAmount['id']]); ?>

                                      <?php echo Form::close(); ?>                                
                                    </td>
                                 </tr>                              
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            </tbody>
                        <?php if($grandTotalAmount): ?>
                            <tbody>

                            <tr>
                                <th><strong><?php echo e(__('Grand Total')); ?> </strong></th>
                                <td> <strong> <?php echo e($grandTotalAmount); ?></strong></td>
                                <td> <strong> <?php echo e($setTotalEmployeeOpd); ?></strong></td>
                            </tr>
                            </tbody>
                        <?php endif; ?>
                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRM\resources\views/opdPayment/allocated-amount.blade.php ENDPATH**/ ?>