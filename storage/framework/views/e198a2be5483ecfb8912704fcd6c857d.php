<?php $__env->startSection('title', $program->title . ' at ' . $program->university->name); ?>
<?php $__env->startSection('meta_description', $metaDescription ?? ($program->title . ' - ' . $program->university->name)); ?>

<?php $__env->startPush('head'); ?>
<!-- Structured Data for SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": "<?php echo e($program->title); ?>",
  "description": "<?php echo e(strip_tags($program->description ?? $program->title)); ?>",
  "provider": {
    "@type": "EducationalOrganization",
    "name": "<?php echo e($program->university->name); ?>",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "<?php echo e($program->country->name); ?>"
    }
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->university->website): ?>
    ,"url": "<?php echo e($program->university->website); ?>"
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  },
  "educationalCredentialAwarded": "<?php echo e($program->degree->name); ?>",
  "hasCourseInstance": {
    "@type": "CourseInstance",
    "courseMode": "<?php echo e($program->study_mode); ?>",
    "inLanguage": "<?php echo e($program->language); ?>"
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->tuition_fee): ?>
    ,"offers": {
      "@type": "Offer",
      "price": "<?php echo e($program->tuition_fee); ?>",
      "priceCurrency": "<?php echo e($program->currency ?? 'EUR'); ?>"
    }
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if($program->intake): ?>
    ,"startDate": "<?php echo e($program->intake); ?>"
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  }
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->program_url): ?>
  ,"url": "<?php echo e($program->program_url); ?>"
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-10 text-white">
                <div class="flex items-center space-x-2 text-blue-100 text-sm mb-4">
                    <span><?php echo e($program->country->name); ?></span>
                    <span>&bull;</span>
                    <span><?php echo e($program->degree->name); ?></span>
                    <span>&bull;</span>
                    <span><?php echo e($program->subject->name); ?></span>
                </div>
                <h1 class="text-4xl font-bold mb-2"><?php echo e($program->title); ?></h1>
                <h2 class="text-2xl font-light text-blue-100"><?php echo e($program->university->name); ?></h2>
            </div>

            <div class="flex flex-col md:flex-row">
                <!-- Main Content -->
                <div class="w-full md:w-2/3 p-8 border-r border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">About the Program</h3>
                    <div class="prose max-w-none text-gray-600">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->description): ?>
                            <?php echo nl2br(e($program->description)); ?>

                        <?php else: ?>
                            <p>No description available for this program.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mt-8 mb-4">Key Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Duration</p>
                                <p class="text-sm text-gray-500"><?php echo e($program->duration); ?></p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Study Mode</p>
                                <p class="text-sm text-gray-500"><?php echo e($program->study_mode); ?></p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Next Intake</p>
                                <p class="text-sm text-gray-500"><?php echo e($program->intake ?? 'Contact University'); ?></p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Language</p>
                                <p class="text-sm text-gray-500"><?php echo e($program->language); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="w-full md:w-1/3 p-8 bg-gray-50">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <p class="text-sm text-gray-500 mb-1">Tuition Fee</p>
                        <p class="text-3xl font-bold text-gray-900 mb-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->tuition_fee): ?>
                                €<?php echo e(number_format($program->tuition_fee, 0)); ?> <span class="text-sm font-normal text-gray-500">/ year</span>
                            <?php else: ?>
                                Contact for Fee
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
                            <div class="mb-3 text-sm text-green-700 bg-green-50 border border-green-100 rounded px-3 py-2">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasAnyRole(['student','job_seeker'])): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existingApplication): ?>
                                    <div class="text-sm text-gray-700 mb-3">
                                        You already applied to this program.
                                        <span class="font-semibold capitalize"><?php echo e($existingApplication->status); ?></span>
                                    </div>
                                <?php else: ?>
                                    <form action="<?php echo e(route('study-programs.apply', [Str::slug($program->country->name), $program->slug])); ?>" method="POST" class="space-y-3">
                                        <?php echo csrf_field(); ?>
                                        <label class="block text-sm font-medium text-gray-700">Application Message (optional)</label>
                                        <textarea name="message" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tell the institution why you are interested"></textarea>
                                        <button type="submit" class="block w-full text-center bg-blue-600 text-white font-bold py-3 px-4 rounded hover:bg-blue-700 transition duration-150">
                                            Apply via PlaceMeNet
                                        </button>
                                    </form>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="block w-full text-center bg-blue-600 text-white font-bold py-3 px-4 rounded hover:bg-blue-700 transition duration-150">
                                Login to Apply
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->program_url): ?>
                            <a href="<?php echo e($program->program_url); ?>" target="_blank" rel="noopener noreferrer" class="mt-3 block w-full text-center bg-white border border-blue-600 text-blue-700 font-bold py-3 px-4 rounded hover:bg-blue-50 transition duration-150">
                                Apply on University Site
                            </a>
                            <p class="text-xs text-center text-gray-500 mt-2">External application link</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="font-bold text-gray-900 mb-3">University Location</h4>
                        <div class="flex items-center text-gray-600">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <?php echo e($program->university->name); ?><br>
                            <?php echo e($program->country->name); ?>

                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($program->university->website): ?>
                            <a href="<?php echo e($program->university->website); ?>" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm mt-3 block">
                                Visit University Website &rarr;
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/study-programs/show.blade.php ENDPATH**/ ?>