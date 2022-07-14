<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center">
                <thead>
                <tr>
                    <th scope="col" class="sort" data-sort="name"><?php echo e(__('Project')); ?></th>
                    <th scope="col" class="sort" data-sort="status"><?php echo e(__('Status')); ?></th>
                    <th scope="col"><?php echo e(__('Users')); ?></th>
                    <th scope="col" class="sort" data-sort="completion"><?php echo e(__('Completion')); ?></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody class="list">
                <?php if(isset($projects) && !empty($projects) && count($projects) > 0): ?>
                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div>
                                        <img <?php echo e($project->img_image); ?> class="avatar rounded-circle">
                                    </div>
                                    <div class="media-body ml-4">
                                        <a href="<?php echo e(route('projects.show',$project)); ?>" class="name mb-0 h6 text-sm"><?php echo e($project->project_name); ?></a>
                                    </div>
                                </div>
                            </th>
                            <td>
                                <span class="badge badge-dot mr-4">
                                      <i class="bg-<?php echo e(\App\Models\Project::$status_color[$project->status]); ?>"></i>
                                      <span class="status"><?php echo e(__(\App\Models\Project::$project_status[$project->status])); ?></span>
                                </span>
                            </td>
                            <td>
                                <div class="avatar-group" id="project_<?php echo e($project->id); ?>">
                                    <?php if(isset($project->users) && !empty($project->users) && count($project->users) > 0): ?>
                                        <?php $__currentLoopData = $project->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($key < 3): ?>
                                                <a href="#" class="avatar rounded-circle">
                                                    <img <?php if($user->avatar): ?> src="<?php echo e(asset('/storage/uploads/avatar/'.$user->avatar)); ?>" <?php else: ?> src="<?php echo e(asset('assets/img/avatar/avatar-1.png')); ?>" <?php endif; ?> title="<?php echo e($user->name); ?>" style="height:36px;width:36px;">
                                                </a>
                                            <?php else: ?>
                                                <?php break; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(count($project->users) > 3): ?>
                                            <a href="#" class="avatar rounded-circle avatar-sm">
                                                <img avatar="+ <?php echo e(count($project->users)-3); ?>" style="height:36px;width:36px;">
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php echo e(__('-')); ?>

                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="completion mr-2"><?php echo e($project->project_progress()['percentage']); ?></span>
                                    <div>
                                        <div class="progress" style="width: 100px;">
                                            <div class="progress-bar bg-<?php echo e($project->project_progress()['color']); ?>" role="progressbar" aria-valuenow="<?php echo e($project->project_progress()['percentage']); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($project->project_progress()['percentage']); ?>;"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right w-15">
                                        <div class="actions">
                                            <a href="#" data-url="<?php echo e(route('invite.project.member.view', $project->id)); ?>" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Invite Member')); ?>" class="action-item" data-toggle="tooltip" data-original-title="<?php echo e(__('Invite Member')); ?>">
                                                <i class="fas fa-paper-plane"></i>
                                            </a>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit project')): ?>
                                                <a href="#" class="action-item"
                                                        data-url="<?php echo e(route('projects.edit', $project->id)); ?>" data-ajax-popup="true"
                                                        data-title="<?php echo e(__('Edit Project')); ?>" data-toggle="tooltip"
                                                        data-original-title="<?php echo e(__('Edit')); ?>" data-size='lg'>
                                                        <span class="btn-inner--icon"><i class="fas fa-pencil-alt"></i></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete project')): ?>
                                                <a href="#" class="action-item text-danger" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?')); ?>|<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-project-<?php echo e($project->id); ?>').submit();">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>

                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['projects.user.destroy', [$project->id,$user->id]],'id'=>'project-user-delete-form-'.$user->id]); ?>

                                <?php echo Form::close(); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <th scope="col" colspan="7"><h6 class="text-center"><?php echo e(__('No Projects Found.')); ?></h6></th>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\HRM\resources\views/projects/list.blade.php ENDPATH**/ ?>