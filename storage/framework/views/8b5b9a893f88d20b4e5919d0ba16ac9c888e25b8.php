

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Provident Fund withdrawal')); ?>

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

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A4'}
            };
            html2pdf().set(opt).from(element).save();

        }

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
<?php $__env->startSection('action-button'); ?>
    <div class="row d-flex justify-content-end">
        <div class="col-xl-4 col-lg-2">
            <?php echo e(Form::open(array('url' => array('request-provident'),'method'=>'get','id'=>'report_leave'))); ?>

            <div class="all-select-box">
                <div class="btn-box">
                    <label class="text-type"><?php echo e(__('Type')); ?></label> <br>
                    <div class="d-flex radio-check">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="monthly" value="monthly" name="type" class="custom-control-input monthly" <?php echo e(isset($_GET['type']) && $_GET['type']=='monthly' ?'checked':'checked'); ?>>
                            <label class="custom-control-label" for="monthly"><?php echo e(__('Monthly')); ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="yearly" value="yearly" name="type" class="custom-control-input yearly" <?php echo e(isset($_GET['type']) && $_GET['type']=='yearly' ?'checked':''); ?>>
                            <label class="custom-control-label" for="yearly"><?php echo e(__('Yearly')); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-3 month d-block">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('month',__('Month'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::month('month',isset($_GET['month'])?$_GET['month']:date('Y-m'),array('class'=>'month-btn form-control'))); ?>

                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-3 year d-none">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('year', __('Year'),['class'=>'text-type'])); ?>

                    <select class="form-control select2" id="year" name="year" tabindex="-1" aria-hidden="true">
                        <?php for($filterYear['starting_year']; $filterYear['starting_year'] <= $filterYear['ending_year']; $filterYear['starting_year']++): ?>
                            <option <?php echo e((isset($_GET['year']) && $_GET['year'] == $filterYear['starting_year'] ?'selected':'')); ?> <?php echo e((!isset($_GET['year']) && date('Y') == $filterYear['starting_year'] ?'selected':'')); ?> value="<?php echo e($filterYear['starting_year']); ?>"><?php echo e($filterYear['starting_year']); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_leave').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(url('report-provident-found')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>
        
            <a href="#" data-url="<?php echo e(route('request-provident.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" 
            data-ajax-popup="true" data-title="<?php echo e(__('Create New Request')); ?>">
             <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

         </a>
        </div>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

 

<?php $__env->startSection('content'); ?>
<div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <table class="table table-striped mb-0" id="report-dataTable">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Employee ID')); ?></th>
                                <th><?php echo e(__('Employee')); ?></th>
                                <th><?php echo e(__('Employee amount')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                              
                                <th><?php echo e(__('Acction')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $providetStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $providentFound): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td><?php echo e(\Auth::user()->employeeIdFormat($providentFound['employee_id'])); ?></td>
                                    <td><?php echo e($providentFound['name']); ?></td>
                                    <td><?php echo e($providentFound['amount']); ?></td>
                                    <td><?php echo e($providentFound['date']); ?></td>
                                  
                                    <td>
                                 

                                      <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" 
                                      data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>"
                                       data-confirm-yes="document.getElementById('delete-form-<?php echo e($providentFound['id']); ?>').submit();"><i class="fas fa-trash"></i></a>
                                      <?php echo Form::open(['method' => 'DELETE', 'route' => ['request-provident.destroy', $providentFound['id']],'id'=>'delete-form-'.$providentFound['id']]); ?>

                                                <?php echo Form::close(); ?>                                
                                    </td>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            </tbody>
                            <?php if($grandTotal): ?>
                                <tbody>
                                <tr>
                                    <th><strong><?php echo e(__('Grand Total')); ?> </strong></th>
                                    <td></td>
                                    <td> <strong> <?php echo e($grandTotal); ?></strong></td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRM\resources\views/providentfund/index.blade.php ENDPATH**/ ?>