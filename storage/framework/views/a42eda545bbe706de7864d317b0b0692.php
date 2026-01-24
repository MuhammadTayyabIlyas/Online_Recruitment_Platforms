<?php $__env->startSection('title', 'Add Study Program'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Add Study Program</h1>
    <p class="text-sm text-gray-600 mb-6">Publish a new program for students.</p>

    <form method="POST" action="<?php echo e(route('institution.programs.store')); ?>" class="space-y-4 bg-white shadow-sm rounded-lg p-6">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('institution.programs.partials.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="flex justify-end gap-3">
            <a href="<?php echo e(route('institution.programs.index')); ?>" class="px-4 py-2 rounded-md bg-gray-100 text-gray-700">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">Save Program</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.employer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/institution/programs/create.blade.php ENDPATH**/ ?>