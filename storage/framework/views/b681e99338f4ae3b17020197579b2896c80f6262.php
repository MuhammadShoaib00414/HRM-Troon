
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Payslip')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="row d-flex justify-content-end">
        <div class="col-xl-2 col-lg-6">
            <?php echo e(Form::open(array('route'=>array('payslip.store'),'method'=>'POST','class'=>'w-50 float-left','id'=>'payslip_form'))); ?>


        </div>
        <div class="col-xl-6 col-lg-3 month">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::month('month',isset($_GET['month'])?$_GET['month']:date('Y-m'),array('class'=>'month-btn form-control'))); ?>

                </div>
            </div>
        </div>

            <a href="#" class="btn btn-xs btn-white btn-icon-only width-auto" onclick="document.getElementById('payslip_form').submit(); return false;">
                <?php echo e(__('Generate Payslip')); ?>

            </a>

    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form>
                        <div class="d-flex justify-content-between w-100 align-items-center">
                            <h6><?php echo e(__('Find Employee Payslip')); ?></h6>
                            <div class="float-right col-4">
                                <select class="form-control month_date select2" name="year" tabindex="-1" aria-hidden="true">
                                    <option value="--">--</option>
                                    <?php $__currentLoopData = $month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$mon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($k); ?>"><?php echo e($mon); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="float-right col-4">
                            <div class="btn-box">
                   
                    <select class="form-control year_date select2" id="year" name="year" tabindex="-1" aria-hidden="true">
                      
                            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                           
                                               
                                <option <?php echo e(($data) == date("Y") ? 'selected' : ''); ?> value="<?php echo e($data); ?>">
                                    <?php echo e($data); ?>

                                        </option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                            </div>
                              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create pay slip')): ?>
                                  <input type="button" value="<?php echo e(__('Bulk Payment')); ?>" class="btn-create badge-blue float-right search" id="bulk_payment">
                              <?php endif; ?>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <table class="table table-striped mb-0" id="dataTable1">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Id')); ?></th>
                                <th><?php echo e(__('ACCOUNTNUMBER')); ?></th>
                                <th><?php echo e(__('BENEFICIARY NAME')); ?></th>
                                <th><?php echo e(__('CONSUMERNUMBERREFERENCE')); ?></th>
                                <th><?php echo e(__('Basic Salary')); ?></th>
                                <th><?php echo e(__('Allowance')); ?></th>
                                <th><?php echo e(__('Commission')); ?></th>
                                <th><?php echo e(__('Other Payment')); ?></th>
                                <th><?php echo e(__('Over Time')); ?></th>
                                <th><?php echo e(__('Net Salary')); ?></th>
                                <th><?php echo e(__('Saturation  Deduction')); ?></th>
                                <th><?php echo e(__('Loan')); ?></th>
                                <th><?php echo e(__('Provident Funds')); ?></th>
                                <th><?php echo e(__('Tax Dedutcion')); ?></th>
                                <th><?php echo e(__('EOBI Amount')); ?></th>
                                <th><?php echo e(__('TRANSAMOUNT')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            
            var filename = 'Download  (IFT)';
            var sammry = 'Summary of Salary';
            
            var table = $('#dataTable1').DataTable({
                dom: 'lBfrtip',
                fixedColumns: true,
                
                buttons: [
                    {
                        extend: 'excel',
                        title: filename,
                        text: '<a  class="view-btn green-bg">Download (IFT)</a>',
                        exportOptions: {
                                columns: [1,2,3,15],
                                targets: 1,
                            className: 'italic'
                        }
                    },
                    {
                        extend: 'excel',
                        title: sammry,
                        text: '<a class="view-btn green-bg">Sammary of Salary</a>',
                        
                        exportOptions: {
                            columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
                            targets: 1,
                            className: 'italic'
                        }
                    },
                ],
                
                select: true,
                
                "aoColumnDefs": [
                    {
                        "aTargets": [16],
                        "mData": null,
                        "mRender": function (data, type, full) {
                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var datePicker = year + '-' + month;
                            var id = data[0];

                            if (data[16] == 'Paid')
                                return '<div class="badge badge-pill badge-success" id="paid"><a href="#" class="text-white">' + data[16] + '</a></div>';
                            else
                                return '<div class="badge badge-pill badge-danger" id="paid"><a href="#" class="text-white">' + data[16] + '</a></div>';
                        }
                    },
                    {
                        "aTargets": [17],
                        "mData": null,
                        "mRender": function (data, type, full) {

                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var datePicker = year + '-' + month;

                            var id = data[0];
                            var payslip_id = data[17];

                            var clickToPaid = '';
                            var payslip = '';
                            var view = '';
                            var edit = '';
                            var deleted = '';
                            var form = '';

                            if (data[17] != 0) {
                                var payslip = '<a href="#" data-url="<?php echo e(url('payslip/pdf/')); ?>/' + id + '/' + datePicker + '" data-size="md-pdf"  data-ajax-popup="true" class="view-btn yellow-bg" data-title="<?php echo e(__('Employee Payslip')); ?>">' + '<?php echo e(__('Payslip')); ?>' + '</a> ';
                            }

                            if (data[16] == "UnPaid" && data[17] != 0) {
                                clickToPaid = '<a  data_i="'+ id +'" data_id="<?php echo e(url('payslip/paysalary/')); ?>/' + id + '/' + datePicker + '"  class="view-btn clickToPaid green-bg">' + '<?php echo e(__('Click To Paid')); ?>' + '</a>  ';
                            }

                            if (data[17] != 0) {
                                view = '<a href="#" data-url="<?php echo e(url('payslip/showemployee/')); ?>/' + payslip_id + '"  data-ajax-popup="true" class="view-btn gray-bg" data-title="<?php echo e(__('View Employee Detail')); ?>">' + '<?php echo e(__('View')); ?>' + '</a>';
                            }

                            if (data[17] != 0 && data[16] == "UnPaid") {
                                edit = '<a href="#" data-url="<?php echo e(url('payslip/editemployee/')); ?>/' + payslip_id + '"  data-ajax-popup="true" class="view-btn blue-bg" data-title="<?php echo e(__('Edit Employee salary')); ?>">' + '<?php echo e(__('Edit')); ?>' + '</a>';
                            }

                            var url = '<?php echo e(route("payslip.delete", ":id")); ?>';
                            url = url.replace(':id', payslip_id);

                            if (data[17] != 0) {
                                deleted = '<a href="#"  data-url="' + url + '" class="payslip_delete view-btn red-bg" >' + '<?php echo e(__('Delete')); ?>' + '</a>';

                            }


                            return view + payslip + clickToPaid + edit + deleted + form;
                        }
                    },
                ]
            });

            function callback() {
                var month = $(".month_date").val();
                var year = $(".year_date").val();

                var datePicker = year + '-' + month;

                $.ajax({
                    url: '<?php echo e(route('payslip.search_json')); ?>',
                    type: 'POST',
                    data: {
                        "datePicker": datePicker, "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function (data) {

                        table.rows().remove().draw();
                        table.rows.add(data).draw();
                        table.column(0).visible(false);
                        $('[data-toggle="tooltip"]').tooltip();

                        // if (!(data)) {
                        //     show_toastr('error', 'Payslip Not Found!', 'error');
                        // }
                    },
                    error: function (data) {

                    }
                });
            }

            $(document).on("click", ".clickToPaid", function () {

                var some_var = $(this).attr( 'data_id' );
                var id = $(this).attr('data_i');

                
                $.ajax({
                    url: some_var,
                    type: 'GET',
                    data: {
                        "some_var": some_var, "id": id, "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function (data,id) {
                       
                        callback();

                        show_toastr('Success', 'Payslip Payment successfully', 'success');


                        if (!(data)) {
                            show_toastr('error', 'Payslip Not Found!', 'error');
                        }
                    },
                    error: function (data) {

                    }
                });
            });

            $(document).on("change", ".month_date,.year_date", function () {
                callback();
            });
            // $(document).on("click", ".clickToPaid", function () {
            //     callbackPayslip();
            // });

            //bulkpayment Click
            $(document).on("click", "#bulk_payment", function () {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '_' + month;

            });
            $(document).on('click', '#bulk_payment', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '-' + month;

                var title = 'Bulk Payment';
                var size = 'md';
                var url = 'payslip/bulk_pay_create/' + datePicker;


                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $.ajax({
                    url: url,
                    success: function (data) {
                        if (data.length) {
                            $('#commonModal .modal-body').html(data);
                            $("#commonModal").modal('show');
                        } else {
                            show_toastr('Error', 'Permission denied.');
                            $("#commonModal").modal('hide');
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('Error', data.error);
                    }
                });
            });

            $(document).on("click", ".payslip_delete", function () {
                var confirmation = confirm("are you sure you want to delete this payslip?");
                var url = $(this).data('url');
                if (confirmation) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (data) {

                            show_toastr('Success', 'Payslip successfully deleted', 'success');

                            setTimeout(function () {
                                callback()
                            }, 800)


                        },

                    });

                }
            });

        });


    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>

    <script type="text/javascript" src="<?php echo e(asset('js/jszip.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/pdfmake.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/vfs_fonts.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/dataTables.buttons.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/buttons.html5.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>

    <script type="text/javascript" src="<?php echo e(asset('js/multiselect/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/multiselect/dataTables.buttons.min.js')); ?>"></script>


    <script type="text/javascript" src="<?php echo e(asset('js/multiselect/buttons.html5.min.js')); ?>"></script>

    <script type="text/javascript" src="<?php echo e(asset('js/multiselect/dataTables.select.min.js')); ?>"></script>
  


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

    
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRM\resources\views/payslip/index.blade.php ENDPATH**/ ?>