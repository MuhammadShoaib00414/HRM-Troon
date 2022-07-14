<?php
    $logo=asset(url('/public/storage/uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
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
                    <a title="Mail Send" href="<?php echo e(route('payslip.send',[$employee->id,$payslip->salary_month])); ?>"
                       class="btn btn-xs rounded-pill btn-primary"><span class="fa fa-paper-plane"></span></a>
                </div>
            </div>
        </div>
        <div class="invoice-print">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6 class="mb-3"><?php echo e(__('Salary Slip')); ?></h6>

                    <address>
                        <strong><?php echo e(__('Employee Name')); ?> :</strong> <?php echo e($employee->fname); ?> <?php echo e($employee->lname); ?><br>
                        <strong><?php echo e(__('Desigantion')); ?> :</strong> <?php echo e(__('Employee')); ?><br>
                        <strong><?php echo e(__('Salary Date')); ?> :</strong> <?php echo e(\Auth::user()->dateFormat( $payslip->created_at)); ?>

                        <br>

                    </address>

                </div>

            </div>
        </div>


        <div class="row">

            <div class="table-responsive" id="full_width">
                <table class="table table-striped table-bordered table-hover table-md">
                    <tbody>
                    <tr>
                        <td colspan="2"><strong>Earning</strong></td>
                        <td colspan="2"><strong>Deduction</strong></td>
                    </tr>
                    <tr>
                        <td><?php echo e(__('Basic Salary')); ?></td>
                        <td><?php echo e(\Auth::user()->priceFormat( $payslip->basic_salary)); ?></td>
                        <?php $__currentLoopData = $payslipDetail['deduction']['loan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td><?php echo e($loan->title); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat( $loan->amount)); ?></td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php $__currentLoopData = $payslipDetail['earning']['allowance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($allowance->title); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat( $allowance->amount)); ?></td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $payslipDetail['deduction']['deduction']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                            <td><?php echo e($deduction->title); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat( $deduction->amount)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $payslipDetail['earning']['commission']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td><?php echo e($commission->title); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat( $commission->amount)); ?></td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $payslipDetail['deduction']['provident']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                            <td><?php echo e($loan->title); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat( $loan->employee_amount)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $payslipDetail['earning']['otherPayment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td><?php echo e($otherPayment->title); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat( $otherPayment->amount)); ?></td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php $__currentLoopData = $payslipDetail['deduction']['taxDeduction']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                            <td><?php echo e($tax->title); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat( $tax->tax_amount)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $payslipDetail['earning']['overTime']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overTime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td><?php echo e($overTime->title); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat( $overTime->amount)); ?></td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $payslipDetail['deduction']['eobis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eobi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                           <td><?php echo e($eobi->title); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat($eobi->employee_amount)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    </tbody>


                </table>

            </div>

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
<?php /**PATH C:\xampp\htdocs\HRM\resources\views/payslip/pdf.blade.php ENDPATH**/ ?>