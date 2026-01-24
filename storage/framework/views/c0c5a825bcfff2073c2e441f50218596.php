<?php $__env->startSection('title', 'Application Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto py-6 px-4">
    <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-900"><?php echo e($application->user->name); ?></h1>
                <p class="text-sm text-gray-600">Applied to: <?php echo e($application->program->title); ?></p>
            </div>
            <form action="<?php echo e(route('institution.applications.status', $application)); ?>" method="POST" class="flex items-center gap-2">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <select name="status" class="rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['pending','reviewing','accepted','rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status); ?>" <?php if($application->status === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
                <button type="submit" class="px-3 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">Update</button>
            </form>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->message): ?>
            <div>
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Message</h3>
                <p class="text-sm text-gray-700 whitespace-pre-line"><?php echo e($application->message); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="text-xs text-gray-500">
            Submitted <?php echo e($application->created_at->diffForHumans()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.employer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/institution/applications/show.blade.php ENDPATH**/ ?>