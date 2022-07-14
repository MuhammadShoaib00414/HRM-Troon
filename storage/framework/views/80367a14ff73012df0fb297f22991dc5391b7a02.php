
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Provident Report Details Page ')); ?>

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
                            columns: [0,1,2,3,4],
                            targets: 1,
                            className: 'italic'
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<a  class="view-btn blue-bg">Excel</a>',
                        title: filename,
                        exportOptions: {
                            columns: [0,1,2,3,4],
                            targets: 1,
                            className: 'italic'
                        }
                    }, {
                        extend: 'csv',
                        text: '<a  class="view-btn blue-bg">CSV</a>',
                        title: filename,
                        exportOptions: {
                            columns: [0,1,2,3,4],
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
        <div class="col-xl-5 col-lg-2">
            <?php echo e(Form::open(array('route' => array('report.provident.fund',request()->route('id')),'method'=>'get','id'=>'report_leave'))); ?>

            <div class="all-select-box">
                <div class="btn-box">
                    <label class="text-type"><?php echo e(__('Type')); ?></label> <br>
                    <div class="d-flex radio-check">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="monthly" value="monthly" name="type"
                                   class="custom-control-input monthly" <?php echo e(isset($_GET['type']) && $_GET['type']=='monthly' ?'checked':'checked'); ?>>
                            <label class="custom-control-label" for="monthly"><?php echo e(__('Monthly')); ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="yearly" value="yearly" name="type"
                                   class="custom-control-input yearly" <?php echo e(isset($_GET['type']) && $_GET['type']=='yearly' ?'checked':''); ?>>
                            <label class="custom-control-label" for="yearly"><?php echo e(__('Yearly')); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-3 month">
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
                      
                    <?php $__currentLoopData = $get_year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                        <?php $year =  date('Y', strtotime($data['employee_date']));?>                  
                        <option <?php echo e(($year) == date("Y") ? 'selected' : ''); ?> value="<?php echo e($year); ?>">
                            <?php echo e($year); ?>

                                </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_leave').submit(); return false;"
               data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(url('report-provident-fund',request()->route('id'))); ?>" class="reset-btn" data-toggle="tooltip"
               data-original-title="<?php echo e(__('Reset')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>

        </div>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="printableArea" class="mt-4">

    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-4">
                        
                        <?php if(request('type') == 'yearly' || request('type') == 'monthly'): ?>
                    <strong><?php echo e(__('Opening Balance')); ?> : <?php echo e($total_previous_balance); ?> </strong>
                    <?php endif; ?>
                        <table class="table table-striped mb-0" id="report-dataTable">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Month')); ?></th>
                                <th><?php echo e(__('Employee')); ?></th>
                                <th><?php echo e(__('Subscription amount')); ?></th>
                                <th><?php echo e(__('Contribution  amount')); ?></th>
                                <th><?php echo e(__('Withdraw PF')); ?></th>
                                <th><?php echo e(__('Balance PF')); ?></th>
                            <!-- <th><?php echo e(__('Date')); ?></th>
                            <!-- <th><?php echo e(__('Acction')); ?></th> -->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $PFValue = [];
                                $employPlusEmployer = 0;
                            ?>
                            
                            <?php $__currentLoopData = $providentFunds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $providentFund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
                                <tr>
                                    <td><strong><?php echo e($providentFund['month_name']); ?></strong></td>
                                    <td><?php echo e($providentFund['employee_name']); ?></td>
                                    <td><?php echo e($providentFund['employee_amount']); ?></td>
                                    <td><?php echo e($providentFund['employer_amout']); ?></td>
                                    <?php if($providentFund['request_month_name'] == $providentFund['month_name'] && $providentFund['fund_id'] == $providentFund['employee_id'] ): ?>
                                        <td><?php echo e($providentFund['amount']); ?></td>
                                    <?php else: ?>
                                        <td>----</td>
                                    <?php endif; ?>

                                    <?php if($providentFund['request_month_name'] == $providentFund['month_name'] && $providentFund['fund_id'] == $providentFund['employee_id']): ?>
                                       <td><?php echo e($providentFund['pf_balance']- $providentFund['amount']); ?></td>
                                   <?php else: ?>
                                        <td><?php echo e($providentFund['total_pf_balance']); ?></td>
                              <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <?php if($grandTotal): ?>
                            <tr>
                                    <td><strong><?php echo e(__('Grand Total')); ?> </strong></td>
                                    <td></td>
                                    <td> <strong> <?php echo e($grandEmployeeAmount); ?></strong></td>
                                    <td> <strong> <?php echo e($grandEmployerAmount); ?></strong></td>
                                    <td></td>
                                    <td> <strong> <?php echo e($grandTotal); ?></strong></td>
                            <?php endif; ?>
                            </tr>
                             <tr>


                                    <td><strong><?php echo e(__('Closing Balance')); ?> </strong></td>
                                    <td></td>
                                    <td></td>

                                    <td></td>

                                    <td></td>
                                    <td><strong> <?php echo e($grandTotal); ?> + <?php echo e($total_previous_balance); ?> = <?php echo e($grandTotal + $total_previous_balance); ?></strong></td>


                            </tr>
                           
                         
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRM\resources\views/providentfund/providentDetails.blade.php ENDPATH**/ ?>