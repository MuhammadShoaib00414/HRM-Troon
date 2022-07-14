

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Employee')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit employee')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="<?php echo e(route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>"
                   class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fa fa-edit"></i> <?php echo e(__('Edit')); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><?php echo e(__('Personal Detail')); ?></h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('EmployeeId')); ?></strong>
                                    <span><?php echo e($employeesId); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Username')); ?></strong>
                                    <span><?php echo e($employee->name); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('First Name')); ?></strong>
                                    <span><?php echo e($employee->fname); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Last Name')); ?></strong>
                                    <span><?php echo e($employee->lname); ?></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('CNIC Number')); ?></strong>
                                    <span><?php echo e($employee->cnic); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Status')); ?></strong>
                                    <span><?php echo e($employee->status); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Gender')); ?></strong>
                                    <span><?php echo e($employee->gender); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Date of Birth')); ?></strong>
                                    <span><?php echo e(\Auth::user()->dateFormat($employee->dob)); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Email')); ?></strong>
                                    <span><?php echo e($employee->email); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Religion')); ?></strong>
                                    <span><?php echo e($employee->religion); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Department')); ?></strong>
                                    <?php if($employee->department): ?>
                                        <span><?php echo e($employee->department->name); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Designation')); ?></strong>
                                    <span><?php echo e($employee->nationality_id); ?></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Phone')); ?></strong>
                                    <span><?php echo e($employee->phone); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Date Of Joining')); ?></strong>
                                    <span><?php echo e($employee->company_doj); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><?php echo e(__('Profile Image')); ?></h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">

                                <?php if($employee->profile_image): ?>
                                    <img src="<?php echo e('/public/uploads/profile/'.$employee->profile_image); ?>" width="140"
                                         alt="">
                                <?php else: ?>
                                    <img src="/public/uploads/avatar/avatar.png" width="140" alt="" download title="">
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><?php echo e(__('Professional Information')); ?></h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Employer Name')); ?></strong>
                                        <span><?php echo e($employee->employer_name); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Designation')); ?></strong>
                                        <span><?php echo e($employee->pro_designation); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Start Date')); ?></strong>
                                        <span><?php echo e($employee->professional_start_date); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('End Date')); ?></strong>
                                        <span><?php echo e($employee->professional_end_date); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Experience Letter')); ?></strong>
                                        <?php if($employee->experience_letter): ?>

                                            <a href="<?php echo e('/public/uploads/experienceLetter/'.$employee->experience_letter); ?>"
                                               download><i class="fa fa-download"> <?php echo e($employee->experience_letter); ?></i></a>
                                        <?php else: ?>
                                            <div class="text-centers">
                                                No Document Type Added.!
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Reference Name')); ?></strong>
                                        <span><?php echo e($employee->reference_name); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Reference Number')); ?></strong>
                                        <span><?php echo e($employee->refeance_number); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Reference Email')); ?></strong>
                                        <span><?php echo e($employee->refeance_number); ?></span>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><?php echo e(__('Education Information')); ?></h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Insititution Name')); ?></strong>
                                        <span><?php echo e($employee->insititution_name); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm font-style">
                                        <strong><?php echo e(__('Start Date')); ?></strong>
                                        <span><?php echo e($employee->educational_start_date); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('End Date')); ?></strong>
                                        <span><?php echo e($employee->educational_start_date); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Name of Degree')); ?></strong>
                                        <span><?php echo e($employee->name_degree); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Specialization')); ?></strong>
                                        <span><?php echo e($employee->specialization); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Degree Level')); ?></strong>
                                        <span><?php echo e($employee->degree_level); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Degree Copy')); ?></strong>
                                        <?php if($employee->degree_copy): ?>

                                            <a href="<?php echo e('/public/uploads/degree/'.$employee->degree_copy); ?>" download><i
                                                        class="fa fa-download">  <?php echo e($employee->degree_copy); ?></i></a>
                                        <?php else: ?>
                                            <div class="text-centers">
                                                No Document Type Added.!
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><?php echo e(__('Document Detail')); ?></h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <?php
                                    $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                                ?>
                                <?php if(!$documents->isEmpty()): ?>
                                    <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-12">
                                            <div class="info text-sm">
                                                <strong><?php echo e($document->name); ?></strong>
                                                <span><a href="<?php echo e((!empty($employeedoc[$document->id])?asset(url('/public/uploads/document')).'/'.$employeedoc[$document->id]:'')); ?>"
                                                         target=""
                                                         download><?php echo e((!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'')); ?></a></span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="text-centers">
                                        No Document Type Added.!
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><?php echo e(__('Contract Information')); ?></h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Basic Salary')); ?></strong>
                                        <span><?php echo e($employee->basic_salary); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Hourly Rate')); ?></strong>
                                        <span><?php echo e($employee->hourly_rate); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Payslip Type')); ?></strong>
                                        <span><?php echo e($employee->salaries_type); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Leave Categories')); ?></strong>
                                        <span><?php echo e($employee->leave_type); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Contract Start Date')); ?></strong>
                                        <span><?php echo e($employee->contract_start_date); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Contract End Date')); ?></strong>
                                        <span><?php echo e($employee->contract_end_date); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Reporting To')); ?></strong>
                                        <span><?php echo e($employee->reporting_to); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Office Timing')); ?></strong>
                                        <span><?php echo e($employee->office_time); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Note')); ?></strong>
                                        <span><?php echo e($employee->benefits_details); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Employment Status')); ?></strong>
                                        <span><?php echo e($employee->employment_status); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Department')); ?></strong>
                                        <span><?php echo e($employee->contract_department); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Designation')); ?></strong>
                                        <span><?php echo e($employee->contract_designation); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Contract Copy')); ?></strong>
                                        <?php if($employee->contract_copy): ?>
                                            <a download=""
                                               href="<?php echo e('/public/uploads/contract/'.$employee->contract_copy); ?>"
                                               download><i class="fa fa-download"> <?php echo e($employee->contract_copy); ?></i></a>
                                        <?php else: ?>
                                            <div class="text-centers">
                                                No Document Type Added.!
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><?php echo e(__('Family Details')); ?></h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Fathers Name')); ?></strong>
                                        <span><?php echo e($employee->father_name); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Mothers Name')); ?></strong>
                                        <span><?php echo e($employee->mother_name); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Marital Status')); ?></strong>
                                        <span><?php echo e($employee->marital_status); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Wife Name')); ?></strong>
                                        <span><?php echo e($employee->wife_name); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Wife Cnic')); ?></strong>
                                        <span><?php echo e($employee->wife_cnic); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Wife Date Of Birth')); ?></strong>
                                        <span><?php echo e($employee->wife_dob); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="info text-sm">
                                        <table class="table table-bordered" id="dynamicTable">
                                            <?php if($resultfamily): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?php echo e(__('Children Name')); ?></strong>
                                                    </td>
                                                    <td><strong><?php echo e(__('Children DOB')); ?></strong></td>
                                                    <td><strong><?php echo e(__('Children Gender')); ?></strong></td>
                                                </tr>

                                                <?php $__currentLoopData = $resultfamily; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $family): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <div class="info text-sm">
                                                                <span><?php echo e($family['name']); ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info text-sm">
                                                                <span><?php echo e($family['dob']); ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info text-sm">

                                                                <?php if($family['gender'] == 'f'): ?>
                                                                    <span>  Female  </span>
                                                                <?php else: ?>
                                                                    <span> Male </span>
                                                                <?php endif; ?>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>

                                        </table>
                                    </div>
                                </div>


                            <!-- <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Branch')); ?></strong>
                                    <span><?php echo e(!empty($employee->branch)?$employee->branch->name:''); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Department')); ?></strong>
                                    <span><?php echo e(!empty($employee->department)?$employee->department->name:''); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Designation')); ?></strong>
                                    <span><?php echo e(!empty($employee->designation)?$employee->designation->name:''); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Date Of Joining')); ?></strong>
                                    <span><?php echo e(\Auth::user()->dateFormat($employee->company_doj)); ?></span>
                                </div>
                            </div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><?php echo e(__('Emergency Contact')); ?></h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Full Name')); ?></strong>
                                        <span><?php echo e($employee->emergency_name); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Relationship')); ?></strong>
                                        <span><?php echo e($employee->emergency_relation); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Emergency Number')); ?></strong>
                                        <span><?php echo e($employee->emergency_number); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Blood Group')); ?></strong>
                                        <span><?php echo e($employee->blood_group); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="info text-sm">
                                        <strong><?php echo e(__('Emergency Address')); ?></strong>
                                        <span><?php echo e($employee->emergency_address); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><?php echo e(__('Social Profile')); ?></h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Facebook')); ?></strong>
                                    <span><?php echo e($employee->facebook); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Twitter')); ?></strong>
                                    <span><?php echo e($employee->twitter); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Google Plus')); ?></strong>
                                    <span><?php echo e($employee->google); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Linkedin In')); ?></strong>
                                    <span><?php echo e($employee->linkedin); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><?php echo e(__('Assets')); ?></h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="info text-sm">
                                    <table class="table table-bordered" id="dynamicTable">
                                        <?php if($resultArrayAssets ): ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo e(__('Device Name')); ?></strong>
                                                </td>
                                                <td><strong><?php echo e(__('Device Details')); ?></strong></td>

                                            </tr>

                                            <?php $__currentLoopData = $resultArrayAssets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assets): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <div class="info text-sm">
                                                            <span><?php echo e($assets['name']); ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info text-sm">
                                                            <span><?php echo e($assets['details']); ?></span>
                                                        </div>
                                                    </td>

                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><?php echo e(__('Bank Account Detail')); ?></h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Account Holder Name')); ?></strong>
                                    <span><?php echo e($employee->account_holder_name); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Account Number')); ?></strong>
                                    <span><?php echo e($employee->account_number); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong><?php echo e(__('Bank Name')); ?></strong>
                                    <span><?php echo e($employee->bank_name); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Bank Identifier Code')); ?></strong>
                                    <span><?php echo e($employee->bank_identifier_code); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Branch Location')); ?></strong>
                                    <span><?php echo e($employee->branch_location); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Tax Payer Id')); ?></strong>
                                    <span><?php echo e($employee->tax_payer_id); ?></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><?php echo e(__('Address')); ?></h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('State / Province')); ?></strong>
                                    <span><?php echo e($employee->province); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('City')); ?></strong>
                                    <span><?php echo e($employee->city); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong><?php echo e(__(' Postal Code')); ?></strong>
                                    <span><?php echo e($employee->zip_code); ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Present Address')); ?></strong>
                                    <span><?php echo e($employee->present_address); ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="info text-sm">
                                    <strong><?php echo e(__('Permanent Address')); ?></strong>
                                    <span><?php echo e($employee->permanent_address); ?></span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRM\resources\views/employee/show.blade.php ENDPATH**/ ?>