<?php
    $logo=asset(url('/public/storage/uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
      $url = $_SERVER['HTTP_REFERER'];
        parse_str( parse_url( $url, PHP_URL_QUERY), $array );
        $startDate = $array['start_month'];
        $endDate = $array['end_month'];

?>

<div class="card bg-none card-box">
    <div class="invoice" id="printableArea">
        <div class="row">
            <div class="col-md-6">
                <div class="invoice-number">
                    <img src="<?php echo e($logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')); ?>"
                         width="170px;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right mb-2">
                    <a href="#" class="btn btn-xs rounded-pill btn-warning" onclick="saveAsPDF()"><span
                                class="fa fa-download"></span></a>

                </div>
            </div>
        </div>
        <div class="invoice-print">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6 class="mb-3"><?php echo e(__('Salary Slip')); ?></h6>


                    <address>
                        <strong><?php echo e(__('Employee Name')); ?> :</strong> <?php echo e($payslip[0]['employee_user']['fname']); ?> <?php echo e($payslip[0]['employee_user']['lname']); ?><br>
                        <strong><?php echo e(__('Desigantion')); ?> :</strong> <?php echo e(__('Employee')); ?><br>
                        <strong><?php echo e(__('CNIC')); ?> :</strong> <?php echo e($payslip[0]['employee_user']['cnic']); ?><br>
                        <strong><?php echo e(__('Salary Date')); ?> :</strong>
                        <?php echo e(\Auth::user()->dateFormat($startDate)); ?> To <?php echo e(\Auth::user()->dateFormat($endDate)); ?>

                    </address>

                </div>

            </div>
        </div>

        <div class="row">

            <div class="table-responsive" id="full_width">
                <table class="table table-striped table-bordered table-hover table-md">
                    <tbody>
                    <?php $__currentLoopData = $payslipDetail['earning']['allowance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowances): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="font-weight-bold text-center border-none">
                            <th colspan="4"><h2>
                                        <strong> <?php echo e(\Carbon\Carbon::parse($allowances['salary_month'])->format('F,d,Y')); ?> </strong>
                                   </h2>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>Earning</strong></td>
                            <td colspan="2"><strong>Deduction</strong></td>
                        </tr>
                        <tr>
                            <td><?php echo e(__('Basic Salary')); ?></td>
                            <td> <?php echo e(\Auth::user()->priceFormat($payslip[0]['basic_salary'])); ?> </td>
                            <?php $__currentLoopData = json_decode($allowances['loan']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td> <?php echo e($loan->title); ?></td>
                                <td> <?php echo e(\Auth::user()->priceFormat($loan->amount)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tr>
                        <tr>
                            <?php $__currentLoopData = json_decode($allowances['allowance']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td> <?php echo e($allowance->title); ?></td>
                                <td> <?php echo e(\Auth::user()->priceFormat($allowance->amount)); ?></td>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = json_decode($allowances['saturation_deduction']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saturation_deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>------------</td>
                                <td> <?php echo e(\Auth::user()->priceFormat($saturation_deduction->amount)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </tr>
                        <tr>
                            <?php $__currentLoopData = $payslipDetail['earning']['commission']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td> <?php echo e($commission['title']); ?></td>
                                <td> <?php echo e(\Auth::user()->priceFormat($commission['amount'])); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = json_decode($allowances['provident']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <td>------------</td>
                                <td> <?php echo e(\Auth::user()->priceFormat($provident->employer_amout)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <?php $__currentLoopData = $payslipDetail['earning']['otherPayment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other_payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td> <?php echo e($other_payment['title']); ?></td>
                                <td> <?php echo e(\Auth::user()->priceFormat($other_payment['amount'])); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = json_decode($allowances['tax']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxDeduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>------------</td>
                                <td> <?php echo e(\Auth::user()->priceFormat($taxDeduction->tax_amount)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <tr>
                            <?php $__currentLoopData = $payslipDetail['earning']['overTime']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overtime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td> <?php echo e($overtime['title']); ?></td>
                                <td> <?php echo e(\Auth::user()->priceFormat($payslipDetail['earning']['overTime'][0]['amount'])); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = json_decode($allowances['eobi']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eobi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>------------</td>
                                <td> <?php echo e(\Auth::user()->priceFormat($eobi->employee_amount)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <tr>
                                <td> <strong><?php echo e(__('Total Earning')); ?></strong></td>
                                <td><strong> <?php echo e(\Auth::user()->priceFormat($payslipDetail['totalEarning'])); ?> </strong></td>
                                <td><strong><?php echo e(__('Total Deduction')); ?></strong></td>
                                <td> <strong><?php echo e(\Auth::user()->priceFormat($payslipDetail['totalDeduction'])); ?></strong></td>

                        </tr>
                         <tr>
                            <td colspan="2"></td>
                            <td ><strong class="final_style"><?php echo e(__('Final Salary')); ?></strong></td>
                            <td ><strong class="final_style"><?php echo e((\Auth::user()->priceFormat($payslipDetail['totalEarning']-$payslipDetail['totalDeduction']))); ?></strong></td>

                         </tr>
                        <tr>
                            <td colspan="2">Employee Signature ---------------------</td>
                            <td colspan="2"> <?php echo e(__('Paid By')); ?>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <span><img src="/public/upload/signature.png" width="50px;"></span>
                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </tbody>


                </table>

            </div>
        </div>
    </div>


            </tbody>
            </table>


    </div>

</div>

</div>
<script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
<script>

    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,
            filename: '<?php echo e($employee->name); ?>',
            image: {type: 'jpeg', quality: 1},
            html2canvas: {scale: 4, dpi: 72, letterRendering: true},
            jsPDF: {unit: 'in', format: 'A4'}
        };
        html2pdf().set(opt).from(element).save();
    }
</script>
<?php /**PATH C:\xampp\htdocs\HRM\resources\views/payslip/multi-pdf.blade.php ENDPATH**/ ?>