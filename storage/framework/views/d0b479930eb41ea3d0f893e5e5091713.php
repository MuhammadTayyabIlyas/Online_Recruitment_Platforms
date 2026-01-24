<?php $__env->startSection('title', __('About PlaceMeNet')); ?>

<?php $__env->startSection('content'); ?>
<?php
    $workingHours = config('placemenet.working_hours');
    $supportEmail = config('placemenet.support_email');
    $legalEmail = config('placemenet.legal_email');
    $whatsappLink = config('placemenet.whatsapp_link');
?>
<div class="py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="bg-white/90 rounded-3xl shadow-2xl p-8 md:p-12 backdrop-blur-md">
            <p class="uppercase text-sm tracking-[0.3em] text-blue-500 mb-3"><?php echo e(__('Our Story')); ?></p>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                <?php echo e(__('Connecting brilliant talent with ambitious employers across Europe.')); ?>

            </h1>
            <p class="text-gray-600 text-lg mb-6">
                <?php echo e(__('PlaceMeNet was founded with a simple promise: simplify recruitment for fast-growing teams and remove the friction job seekers face when chasing their next career milestone. From curated roles to real-time coaching, we fuse technology with a human touch to build careers that matter.')); ?>

            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-500 transition">
                    <?php echo e(__('Contact Us')); ?>

                </a>
                <a href="<?php echo e($whatsappLink); ?>" target="<?php echo e($whatsappLink ? '_blank' : '_self'); ?>" rel="noopener" class="inline-flex items-center justify-center px-6 py-3 rounded-full border border-blue-600 text-blue-700 font-semibold hover:bg-blue-50 transition">
                    <?php echo e(__('Chat on WhatsApp')); ?>

                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 space-y-8">
            <div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4"><?php echo e(__('Working Hours')); ?></h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-600">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $workingHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><span class="font-semibold text-gray-900"><?php echo e($slot['day']); ?>:</span> <?php echo e($slot['hours']); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="border border-gray-100 rounded-2xl p-6 bg-blue-50/60">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4"><?php echo e(__('Stay Safe from Job Scams')); ?></h3>
                <p class="text-gray-600 mb-4"><?php echo e(__('PlacemeNet is committed to worker protection. Follow these rules and share them with your friends and family applying overseas.')); ?></p>
                <div class="space-y-3 text-gray-700">
                    <div>
                        <h4 class="font-semibold text-gray-900"><?php echo e(__('PlacemeNet is 100% free')); ?></h4>
                        <p><?php echo e(__('We never charge registration fees, sell visas, or take worker commission. Anyone asking for money in our name is a scam.')); ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900"><?php echo e(__('Never pay for a job')); ?></h4>
                        <p><?php echo e(__('Do not send money via cash, bank, Easypaisa, JazzCash, WhatsApp, or crypto. Genuine employers handle costs legally.')); ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900"><?php echo e(__('Verify the employer')); ?></h4>
                        <p><?php echo e(__('Collect a written offer, company license, visa document, and detailed contract before you travel. Contact us if anything looks suspicious.')); ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900"><?php echo e(__('Official communication only')); ?></h4>
                        <p><?php echo e(__('PlacemeNet does not operate via TikTok, Telegram, or random WhatsApp agents. Trust only @placemenet.net emails or the website chat.')); ?></p>
                    </div>
                </div>
                <p class="mt-4 text-sm text-gray-600"><?php echo __('Feel unsafe? Email :support or :legal. We block offenders and report them to authorities.', [
                    'support' => '<a href="mailto:'.$supportEmail.'" class="text-blue-600 font-semibold">'.$supportEmail.'</a>',
                    'legal' => '<a href="mailto:'.$legalEmail.'" class="text-blue-600 font-semibold">'.$legalEmail.'</a>',
                ]); ?></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e(__('Worker Dashboard Highlights')); ?></h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>✅ <?php echo e(__('Apply for overseas jobs and track every application.')); ?></li>
                        <li>✅ <?php echo e(__('Complete your profile with experience, skills, passport, and preferred countries.')); ?></li>
                        <li>✅ <?php echo e(__('Receive interview calls, employer messages, and safety alerts reminding you PlacemeNet is always free.')); ?></li>
                        <li>✅ <?php echo e(__('Manage account settings—update phone/email or delete your account anytime.')); ?></li>
                    </ul>
                </div>
                <div class="rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e(__('Employer Dashboard Promise')); ?></h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>✅ <?php echo e(__('Post jobs for free in Greece or Albania and get unlimited applications.')); ?></li>
                        <li>✅ <?php echo e(__('Review skills, shortlist candidates, and message workers directly.')); ?></li>
                        <li>✅ <?php echo e(__('Keep hiring transparent—no fake jobs, no illegal recruitment fees, and full compliance with labor laws.')); ?></li>
                        <li>✅ <?php echo e(__('Violations lead to permanent bans because we protect both workers and reputable employers.')); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<?php
    $orgSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => config('app.name'),
        'url' => config('app.url'),
        'email' => $supportEmail,
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'contactType' => 'customer support',
            'email' => $supportEmail,
            'availableLanguage' => ['en', 'es', 'el', 'pt', 'sq'],
        ],
        'sameAs' => array_filter([
            $whatsappLink,
        ]),
        'logo' => asset('assets/images/logo.jpg'),
    ];

    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => [
            [
                '@type' => 'Question',
                'name' => 'Is PlaceMeNet free for job seekers?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes. PlaceMeNet is 100% free for job seekers; we never charge registration fees or commission.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'How do I stay safe from job scams?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Never pay for a job, verify the employer, use official communication only, and contact support if anything looks suspicious.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Can employers post jobs in Greece or Albania for free?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes. Employers can post jobs for free, review applicants, and message candidates directly.',
                ],
            ],
        ],
    ];
?>
<script type="application/ld+json">
<?php echo json_encode($orgSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT); ?>

</script>
<script type="application/ld+json">
<?php echo json_encode($faqSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT); ?>

</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/about.blade.php ENDPATH**/ ?>