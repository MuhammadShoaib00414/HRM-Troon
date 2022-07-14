
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Provident Report')); ?>

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
                            columns: [0,1,2,3,4,5],
                            targets: 1,
                            className: 'italic'
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<a  class="view-btn blue-bg">Excel</a>',
                        title: filename,
                        exportOptions: {
                            columns: [0,1,2,3,4,5],
                            targets: 1,
                            className: 'italic'
                        }
                    }, {
                        extend: 'csv',
                        text: '<a  class="view-btn blue-bg">CSV</a>',
                        title: filename,
                        exportOptions: {
                            columns: [0,1,2,3,4,5],
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













































        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_leave').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(url('report-provident-fund')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>

        </div>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-4 col-md-4">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-1">Total Company Provident Fund</h6>
                            <span class="h3 font-weight-bold mb-0 "> <?php echo e($grandTotalBalance); ?></span> <br>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-1">Total Company Withdraw Request</h6>
                            <span class="h3 font-weight-bold mb-0 "><?php echo e($grandTotalRequest); ?></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-1">Total Company Balance</h6>
                            <span class="h3 font-weight-bold mb-0 "><?php echo e($grandTotalBalance-$grandTotalRequest); ?></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                <th><?php echo e(__('Subscription amount')); ?></th>
                                <th><?php echo e(__('Contribution  amount')); ?></th>
                                <th><?php echo e(__('Withdraw PF')); ?></th>
                                <th><?php echo e(__('Total Provident fund')); ?></th>

                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $providentFound; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(\Auth::user()->employeeIdFormat($provident['found_id'])); ?></td>
                                    <td><?php echo e($provident['employee_name']); ?></td>
                                    <td><?php echo e($provident['subscriptionAmount']); ?></td>
                                    <td><?php echo e($provident['contributionAmount']); ?></td>
                                     <?php if($provident['request_id'] == $provident['found_id'] ): ?>
                                         <td><?php echo e($provident['request_amount']); ?></td>
                                     <?php else: ?>
                                         <td>----</td>
                                    <?php endif; ?>
                                    <?php if($provident['request_id'] == $provident['found_id']): ?>
                                    <td><?php echo e($provident['subscription_pf'] - $provident['request_amount']); ?></td>

                                     <?php else: ?>

                                    <td> <?php echo e($provident['subscription_pf']); ?></td>
                                    <?php endif; ?>

                                    <td>
                                        <a href=" <?php echo e(route('report.provident.fund',$provident['found_id'])); ?>" data-size="lg" data-ajax-popup="true" data-title="Edit Allowance" class="edit-icon" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>
                                    </td>


                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                            <?php if($grandTotal): ?>
                                <tbody>
                                <tr>
                                    <th><strong><?php echo e(__('Grand Total')); ?> </strong></th>
                                    <td></td>
                                    <td> <strong> <?php echo e($grandTotal); ?></strong></td>
                                    <td> <strong> <?php echo e($grandTotal); ?></strong></td>
                                    <td></td>

                                    <td> <strong>  <?php echo e($grandTotalBalance-$grandTotalRequest); ?></strong></td>

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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRM\resources\views/providentfund/provident.blade.php ENDPATH**/ ?>