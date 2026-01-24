<?php $__env->startSection('title', 'Application Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="<?php echo e(route('jobseeker.applications.index')); ?>" class="hover:text-indigo-600">My Applications</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900"><?php echo e($application->job->title); ?></li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->job->company && $application->job->company->logo): ?>
                                <img src="<?php echo e($application->job->company->logo_url); ?>" alt="<?php echo e($application->job->company->company_name); ?>"
                                     class="w-16 h-16 rounded-lg object-cover">
                            <?php else: ?>
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div>
                                <h1 class="text-xl font-bold text-gray-900">
                                    <a href="<?php echo e(route('jobs.show', $application->job)); ?>" class="hover:text-indigo-600">
                                        <?php echo e($application->job->title); ?>

                                    </a>
                                </h1>
                                <p class="text-gray-600"><?php echo e($application->job->company->company_name ?? 'Company'); ?></p>
                            </div>
                        </div>
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
                    </div>
                </div>

                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Cover Letter</h2>
                    <div class="prose max-w-none text-gray-600 bg-gray-50 rounded-lg p-4">
                        <?php echo nl2br(e($application->cover_letter)); ?>

                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->answers): ?>
                        <h2 class="text-lg font-semibold text-gray-900 mt-6 mb-4">Screening Questions</h2>
                        <?php $answers = json_decode($application->answers, true); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($answers && $application->job->questions): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $application->job->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                    <p class="font-medium text-gray-900"><?php echo e($question->question); ?></p>
                                    <p class="text-gray-600 mt-2"><?php echo e($answers[$index] ?? 'No answer provided'); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3">
            <!-- Application Details -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Application Details</h3>

                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Applied On</dt>
                        <dd class="text-gray-900"><?php echo e($application->created_at->format('M d, Y \a\t h:i A')); ?></dd>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->resume_path): ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Resume</dt>
                            <dd>
                                <a href="<?php echo e(route('jobseeker.applications.resume', $application)); ?>"
                                   class="text-indigo-600 hover:text-indigo-900">
                                    Download Resume
                                </a>
                            </dd>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->withdrawn_at): ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Withdrawn On</dt>
                            <dd class="text-gray-900"><?php echo e($application->withdrawn_at->format('M d, Y')); ?></dd>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </dl>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($application->status, ['pending', 'under_review'])): ?>
                    <form action="<?php echo e(route('jobseeker.applications.withdraw', $application)); ?>" method="POST"
                          onsubmit="return confirm('Are you sure you want to withdraw this application?');">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Withdraw Application
                        </button>
                    </form>
                <?php else: ?>
                    <p class="text-gray-500 text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->status === 'withdrawn'): ?>
                            This application has been withdrawn.
                        <?php else: ?>
                            This application cannot be withdrawn at this stage.
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <a href="<?php echo e(route('jobs.show', $application->job)); ?>"
                   class="block w-full text-center px-4 py-2 mt-3 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                    View Job Posting
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/jobseeker/applications/show.blade.php ENDPATH**/ ?>