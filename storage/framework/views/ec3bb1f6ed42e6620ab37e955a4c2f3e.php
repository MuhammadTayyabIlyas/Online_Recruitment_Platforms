<?php $__env->startSection('title', 'User Details'); ?>
<?php $__env->startSection('page-title', 'User Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-indigo-600">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="<?php echo e(route('admin.users.index')); ?>" class="hover:text-indigo-600">Users</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900"><?php echo e($user->name); ?></li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Info Card -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->avatar): ?>
                        <img class="h-24 w-24 rounded-full mx-auto object-cover" src="<?php echo e(asset('storage/' . $user->avatar)); ?>" alt="">
                    <?php else: ?>
                        <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center mx-auto">
                            <span class="text-3xl font-medium text-gray-500"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <h2 class="mt-4 text-xl font-semibold text-gray-900"><?php echo e($user->name); ?></h2>
                    <p class="text-gray-500"><?php echo e($user->email); ?></p>
                    <span class="mt-2 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        <?php echo e($user->user_type === 'admin' ? 'bg-red-100 text-red-800' : ''); ?>

                        <?php echo e($user->user_type === 'employer' ? 'bg-blue-100 text-blue-800' : ''); ?>

                        <?php echo e($user->user_type === 'job_seeker' ? 'bg-green-100 text-green-800' : ''); ?>">
                        <?php echo e(ucfirst(str_replace('_', ' ', $user->user_type))); ?>

                    </span>
                </div>

                <div class="mt-6 border-t pt-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->is_active): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->phone ?? 'Not provided'); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Joined</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->created_at->format('M d, Y \a\t h:i A')); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never'); ?></dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-6 flex space-x-3">
                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>"
                       class="flex-1 text-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Edit User
                    </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->id !== auth()->id()): ?>
                        <form action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" method="POST" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit"
                                    class="w-full px-4 py-2 <?php echo e($user->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700'); ?> text-white rounded-md">
                                <?php echo e($user->is_active ? 'Deactivate' : 'Activate'); ?>

                            </button>
                        </form>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Details Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Info -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->profile): ?>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Information</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->profile->headline): ?>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Headline</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->profile->headline); ?></dd>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->profile->location): ?>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->profile->location); ?></dd>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->profile->bio): ?>
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Bio</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->profile->bio); ?></dd>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </dl>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Company (for employers) -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->user_type === 'employer' && $user->company): ?>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Information</h3>
                <div class="flex items-center mb-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->company->logo): ?>
                        <img src="<?php echo e(asset('storage/' . $user->company->logo)); ?>" alt="<?php echo e($user->company->company_name); ?>"
                             class="w-16 h-16 rounded-lg object-cover mr-4">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div>
                        <h4 class="font-medium text-gray-900"><?php echo e($user->company->company_name); ?></h4>
                        <p class="text-sm text-gray-500"><?php echo e($user->company->industry ?? 'Industry not specified'); ?></p>
                    </div>
                </div>
                <dl class="grid grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <dt class="font-medium text-gray-500">Jobs Posted</dt>
                        <dd class="text-gray-900"><?php echo e($user->jobs->count()); ?></dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Company Size</dt>
                        <dd class="text-gray-900"><?php echo e($user->company->company_size ?? 'Not specified'); ?></dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="font-medium text-gray-500">CV/Profile Access</dt>
                        <dd class="mt-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->company->is_cv_access_approved): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Approved
                                </span>
                            <?php else: ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                    Not Approved
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </dd>
                    </div>
                </dl>

                <!-- CV Access Toggle Button -->
                <form action="<?php echo e(route('admin.users.toggle-cv-access', $user)); ?>" method="POST" class="mt-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <button type="submit"
                            class="w-full px-4 py-2 <?php echo e($user->company->is_cv_access_approved ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'); ?> text-white rounded-md transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->company->is_cv_access_approved): ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            <?php else: ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </svg>
                        <?php echo e($user->company->is_cv_access_approved ? 'Revoke CV Access' : 'Grant CV Access'); ?>

                    </button>
                </form>

                <!-- Package Assignment Section -->
                <div class="mt-6 border-t pt-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-4">Package Management</h4>
                    
                    <?php
                        $currentSubscription = $user->activeSubscription;
                        $allPackages = App\Models\Package::where('is_active', true)->orderBy('price')->get();
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentSubscription): ?>
                        <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm font-medium text-blue-900">Current Package</p>
                            <p class="text-xs text-blue-700 mt-1">
                                <?php echo e($currentSubscription->package->name); ?> - 
                                Expires: <?php echo e($currentSubscription->expires_at->format('M d, Y')); ?>

                            </p>
                        </div>
                    <?php else: ?>
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-900">No Active Package</p>
                            <p class="text-xs text-gray-600 mt-1">User is on free tier</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <form action="<?php echo e(route('admin.users.assign-package', $user)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-gray-700">Assign New Package</label>
                            <select name="package_id" class="w-full border-gray-300 rounded-md text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Select Package --</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $allPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($package->id); ?>">
                                        <?php echo e($package->name); ?> - €<?php echo e(number_format($package->price, 0)); ?>/month
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        <button type="submit" 
                                class="w-full mt-3 px-4 py-2 bg-purple-600 text-white text-sm rounded-md hover:bg-purple-700 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Assign Package
                        </button>
                    </form>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Job Applications (for job seekers) -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->user_type === 'job_seeker' && $user->jobApplications->count() > 0): ?>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Applications</h3>
                <div class="space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $user->jobApplications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-center border-b pb-4 last:border-b-0 last:pb-0">
                        <div>
                            <p class="font-medium text-gray-900"><?php echo e($application->job->title ?? 'Job Deleted'); ?></p>
                            <p class="text-sm text-gray-500">Applied <?php echo e($application->created_at->diffForHumans()); ?></p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            <?php echo e($application->status === 'pending' ? 'bg-gray-100 text-gray-800' : ''); ?>

                            <?php echo e($application->status === 'accepted' ? 'bg-green-100 text-green-800' : ''); ?>

                            <?php echo e($application->status === 'rejected' ? 'bg-red-100 text-red-800' : ''); ?>">
                            <?php echo e(ucfirst($application->status)); ?>

                        </span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Activity Stats -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Activity Summary</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->user_type === 'employer'): ?>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-indigo-600"><?php echo e($user->jobs->count()); ?></p>
                        <p class="text-sm text-gray-500">Jobs Posted</p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->user_type === 'job_seeker'): ?>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-indigo-600"><?php echo e($user->jobApplications->count()); ?></p>
                        <p class="text-sm text-gray-500">Applications</p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/placemenet/resources/views/admin/users/show.blade.php ENDPATH**/ ?>