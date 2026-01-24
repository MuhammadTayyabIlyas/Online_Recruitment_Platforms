<?php $__env->startSection('title', __('Contact PlaceMeNet')); ?>

<?php $__env->startSection('content'); ?>
<?php ($offices = config('placemenet.offices')); ?>
<?php ($workingHours = config('placemenet.working_hours')); ?>
<?php ($supportEmail = config('placemenet.support_email')); ?>
<?php ($whatsappLink = config('placemenet.whatsapp_link')); ?>
<?php ($whatsappNumber = config('placemenet.whatsapp_number')); ?>
<div class="py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="bg-white/95 rounded-3xl shadow-2xl p-8 md:p-12">
            <p class="uppercase text-sm tracking-[0.3em] text-blue-500 mb-3"><?php echo e(__('Get in touch')); ?></p>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4"><?php echo e(__('We are here to support your next hire or career move.')); ?></h1>
            <p class="text-gray-600 mb-6">
                <?php echo e(__('Reach our talent success team by phone, WhatsApp, or visit one of our offices during opening hours. We’ll route your message to the right specialist right away.')); ?>

            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="mailto:<?php echo e($supportEmail); ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-500 transition">
                    <?php echo e(__('Email Us')); ?>

                </a>
                <a href="<?php echo e($whatsappLink); ?>" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-6 py-3 rounded-full border border-blue-600 text-blue-700 font-semibold hover:bg-blue-50 transition">
                    <?php echo e(__('WhatsApp: :number', ['number' => $whatsappNumber])); ?>

                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $offices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-2xl shadow-xl p-6 flex flex-col">
                    <h2 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($loop->first ? __('Head Office') : $office['label']); ?></h2>
                    <p class="text-gray-600 mb-4"><?php echo e($office['address']); ?></p>
                    <a href="<?php echo e($office['map_url']); ?>" target="_blank" rel="noopener" class="mt-auto inline-flex items-center text-blue-600 hover:text-blue-500 font-semibold">
                        <?php echo e(__('Open in Google Maps')); ?>

                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6m0 0v6m0-6L10 16" />
                        </svg>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            <h3 class="text-2xl font-semibold text-gray-900 mb-4"><?php echo e(__('Working Hours')); ?></h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-600">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $workingHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><span class="font-semibold text-gray-900"><?php echo e($slot['day']); ?>:</span> <?php echo e($slot['hours']); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/contact.blade.php ENDPATH**/ ?>