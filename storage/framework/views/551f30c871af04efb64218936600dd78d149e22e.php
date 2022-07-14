
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Attendance List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $('input[name="type"]:radio').on('change', function (e) {
            var type = $(this).val();

            if (type == 'monthly') {
                $('.month').addClass('d-block');
                $('.month').removeClass('d-none');
                $('.date').addClass('d-none');
                $('.date').removeClass('d-block');
                $('.year').addClass('d-none');
                $('.year').removeClass('d-block');
            } else if(type == 'daily') {
                $('.date').addClass('d-block');
                $('.date').removeClass('d-none');
                $('.month').addClass('d-none');
                $('.month').removeClass('d-block');
                $('.year').addClass('d-none');
                $('.year').removeClass('d-block');
            }else{

                $('.year').addClass('d-block');
                $('.year').removeClass('d-none');
                $('.date').addClass('d-none');
                $('.date').removeClass('d-block');
                $('.month').addClass('d-none');
                $('.month').removeClass('d-block');
            }
        });

        $('input[name="type"]:radio:checked').trigger('change');

    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="row d-flex justify-content-end">
      <div class="col-auto">
          <?php echo e(Form::open(array('route' => array('attendanceemployee.index'),'method'=>'get','id'=>'attendanceemployee_filter'))); ?>

      </div>
      <div class="col-4">
        <div class="all-select-box">
            <div class="btn-box">
                <label class="text-type"><?php echo e(__('Type')); ?></label> <br>
                <div class="d-flex radio-check">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="monthly" value="monthly" name="type" class="custom-control-input" <?php echo e(isset($_GET['type']) && $_GET['type']=='monthly' ?'checked':'checked'); ?>>
                        <label class="custom-control-label" for="monthly"><?php echo e(__('Monthly')); ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="daily" value="daily" name="type" class="custom-control-input" <?php echo e(isset($_GET['type']) && $_GET['type']=='daily' ?'checked':''); ?>>
                        <label class="custom-control-label" for="daily"><?php echo e(__('Daily')); ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="year" value="year" name="type" class="custom-control-input" <?php echo e(isset($_GET['type']) && $_GET['type']=='year' ?'checked':''); ?>>
                        <label class="custom-control-label" for="year"><?php echo e(__('Year')); ?></label>
                    </div>
                </div>
            </div>
          </div>
      </div>
      <div class="col-auto month">
        <div class="all-select-box">
            <div class="btn-box">
                <?php echo e(Form::label('month',__('Month'),['class'=>'text-type'])); ?>

                <?php echo e(Form::month('month',isset($_GET['month'])?$_GET['month']:date('Y-m'),array('class'=>'month-btn form-control month-btn'))); ?>

            </div>
        </div>
      </div>
      <div class="col-4 date">
        <div class="all-select-box">
            <div class="btn-box">
                <?php echo e(Form::label('date', __('Date'),['class'=>'text-type'])); ?>

                <?php echo e(Form::text('date',isset($_GET['date'])?$_GET['date']:'', array('class' => 'form-control datepicker month-btn'))); ?>

            </div>
        </div>
      </div>

        <div class="col-4 year">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('year', __('Year'),['class'=>'text-type'])); ?>

                    <select class="form-control select2" id="year" name="year" tabindex="-1" aria-hidden="true">
                        <?php $__currentLoopData = $filterYear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $year =  date('Y', strtotime($data['date']));?>
                            <option <?php echo e(($year) == date("Y") ? 'selected' : ''); ?> value="<?php echo e($year); ?>">
                                <?php echo e($year); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>


















      <div class="col-auto  my-custom">
          <a href="#" class="apply-btn" onclick="document.getElementById('attendanceemployee_filter').submit(); return false;">
              <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
          </a>
          <a href="<?php echo e(route('attendanceemployee.index')); ?>" class="reset-btn">
              <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
          </a>
      </div>
    <?php echo e(Form::close()); ?>

  </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
               
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Employee ID')); ?></th>

                            <?php if(\Auth::user()->type!='employee'): ?>
                                    <th><?php echo e(__('Employee')); ?></th>
                                <?php endif; ?>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Time')); ?></th>
                                <!-- <th><?php echo e(__('Clock Out')); ?></th> -->
                                <th><?php echo e(__('Type')); ?></th>
                                <th><?php echo e(__('Late')); ?></th>


                                <?php if(Gate::check('edit attendance') || Gate::check('delete attendance')): ?>
                                    <th><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $getAllemployeeAttandanceData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                   <?php
                                   $time1 = strtotime('11:15');  // 2012-12-06 23:56
                                   $time2 = strtotime($att['clock_in']);  // 2012-12-06 00:21
                                   $late =  ($time1 - $time2)/60;


                                   $minutes =  $late;
                                   $zero    = new DateTime('@0');
                                   $offset  = new DateTime('@' . $minutes * 60);
                                   $diff    = $zero->diff($offset);
                                   $total_late = $diff->format('%h Hours, %i Minutes');

                                 ?>  
                                 <tr>
                                     <td><?php echo e($att['employee_id']); ?></td>
                                     <td><?php echo(isset($getUser[$att['employee_id']]) ? $getUser[$att['employee_id']]['name'] : $att['employee_id']); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($att['date'])); ?></td>
                                    <td><?php echo e($att['status']); ?></td>
                                    <td><?php echo e(($att['clock_in'] !='00:00:00') ?\Auth::user()->timeFormat($att['clock_in']):'00:00'); ?> </td>
                                     <!-- <?php if($att['type'] == 0): ?>
                                         <td><?php echo e(($att['clock_in'] !='00:00:00') ?\Auth::user()->timeFormat($att['clock_in']):'00:00'); ?> </td>

                                     <?php else: ?>
                                        <td> ----------</td>
                                     <?php endif; ?> -->
                                     <td>
                                         <?php if($att['type'] == 1): ?>
                                             <?php echo e('Check Out'); ?>

                                         <?php else: ?>
                                             <?php echo e('Check In'); ?>

                                         <?php endif; ?>
                                     </td>
                                     <td>
                                         <?php if($att['type'] == 0): ?>
                                             <?php echo e($total_late); ?>

                                         <?php else: ?>
                                           ----------
                                         <?php endif; ?>


                                         </td>









                                    <?php if(Gate::check('edit attendance') || Gate::check('delete attendance')): ?>
                                        <td>



                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete attendance')): ?>
                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($att['id']); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['attendanceemployee.destroy', $att['id']],'id'=>'delete-form-'.$att['id']]); ?>

                                                <?php echo Form::close(); ?>

                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>

                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).ready(function () {
            $('.daterangepicker').daterangepicker({
                format: 'yyyy-mm-dd',
                locale: {format: 'YYYY-MM-DD'},
            });
        });
        function postDataAttandance() {
            $.ajax({
                url: '<?php echo e(route('attendanceemployee.addAttandanceFromMachine')); ?>',
                type: 'POST',
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    // console.log(data);
                },
                error: function (data) {

                }
            });
        }
        setInterval(function(){
            postDataAttandance();
        }, 60 * 1000);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRM\resources\views/attendance/index.blade.php ENDPATH**/ ?>