<?php $__env->startSection('title', 'My Applications'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">My Applications</h1>
        <a href="<?php echo e(route('jobs.index')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Browse Jobs
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $applications ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="border-b border-gray-200 last:border-b-0 p-6 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->job->company && $application->job->company->logo): ?>
                            <img src="<?php echo e($application->job->company->logo_url); ?>" alt="<?php echo e($application->job->company->company_name); ?>"
                                 class="w-12 h-12 rounded-lg object-cover">
                        <?php else: ?>
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div>
                            <h3 class="font-semibold text-gray-900">
                                <a href="<?php echo e(route('jobs.show', $application->job)); ?>" class="hover:text-indigo-600">
                                    <?php echo e($application->job->title); ?>

                                </a>
                            </h3>
                            <p class="text-gray-600"><?php echo e($application->job->company->company_name ?? 'Company'); ?></p>
                            <p class="text-sm text-gray-500">Applied <?php echo e($application->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            <?php if($application->status === 'pending'): ?> bg-gray-100 text-gray-800
                            <?php elseif($application->status === 'under_review'): ?> bg-blue-100 text-blue-800
                            <?php elseif($application->status === 'shortlisted'): ?> bg-indigo-100 text-indigo-800
                            <?php elseif($application->status === 'interviewed'): ?> bg-purple-100 text-purple-800
                            <?php elseif($application->status === 'offered'): ?> bg-yellow-100 text-yellow-800
                            <?php elseif($application->status === 'accepted'): ?> bg-green-100 text-green-800
                            <?php elseif($application->status === 'rejected'): ?> bg-red-100 text-red-800
                            <?php elseif($application->status === 'withdrawn'): ?> bg-gray-100 text-gray-800
                            <?php else: ?> bg-gray-100 text-gray-800
                            <?php endif; ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $application->status))); ?>

                        </span>
                        <a href="<?php echo e(route('jobseeker.applications.show', $application)); ?>"
                           class="text-indigo-600 hover:text-indigo-900 font-medium">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
                <p class="mt-1 text-sm text-gray-500">Start applying for jobs to see them here.</p>
                <div class="mt-6">
                    <a href="<?php echo e(route('jobs.index')); ?>"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Browse Jobs
                    </a>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($applications) && $applications->hasPages()): ?>
        <div class="mt-6">
            <?php echo e($applications->links()); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/jobseeker/applications/index.blade.php ENDPATH**/ ?>