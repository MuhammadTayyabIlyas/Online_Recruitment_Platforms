<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'PlaceMeNet')); ?> - <?php echo e(auth()->user()->hasRole('educational_institution') ? 'Institution' : 'Employer'); ?> - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js - Removed duplicate, loaded at bottom -->

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/favicon/favicon.ico')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('assets/favicon/apple-touch-icon.png')); ?>">

    <style>
        .sidebar-link {
            transition: all 0.25s ease;
        }
        [data-sidebar-open="true"] .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.12);
            border-left: 4px solid var(--brand-accent);
            padding-left: 1.25rem;
        }
        [data-sidebar-open="false"] .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.18);
            border-left-width: 0;
        }
        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.18);
            border-left: 4px solid var(--brand-accent);
            color: #fff;
            font-weight: 600;
        }
</style>
    <?php echo $__env->make('layouts.partials.brand-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <script src="//unpkg.com/alpinejs" defer></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased bg-slate-100">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }" :data-sidebar-open="sidebarOpen">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-72' : 'w-20'" class="brand-gradient text-white shadow-2xl transition-all duration-300 fixed h-full z-30 border-r border-white/10">
            <!-- Logo + Toggle -->
            <div class="flex items-center justify-between p-4 border-b border-white/10">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3" x-show="sidebarOpen">
                    <div class="h-12 w-12 rounded-2xl bg-white/10 backdrop-blur-lg flex items-center justify-center shadow-lg">
                        <img src="<?php echo e(asset('assets/images/logo.jpg')); ?>" alt="PlaceMeNet Employer" class="h-8 w-auto object-contain drop-shadow">
                    </div>
                    <div class="leading-tight">
                        <p class="font-semibold tracking-wide text-white">PlaceMeNet</p>
                        <p class="text-xs text-white/70 uppercase tracking-[0.2em]">
                            <?php echo e(auth()->user()->hasRole('educational_institution') ? 'Institution Hub' : 'Employer Hub'); ?>

                        </p>
                    </div>
                </a>
                <a href="<?php echo e(route('home')); ?>" class="block" x-show="!sidebarOpen">
                    <div class="h-10 w-10 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center shadow-lg">
                        <img src="<?php echo e(asset('assets/images/logo.jpg')); ?>" alt="PlaceMeNet" class="h-7 w-auto object-contain drop-shadow">
                    </div>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-white/10 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-160px)] text-white">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('educational_institution')): ?>
                    <!-- Dashboard -->
                    <a href="<?php echo e(route('institution.dashboard')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('institution.dashboard') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span x-show="sidebarOpen">Dashboard</span>
                    </a>

                    <a href="<?php echo e(route('institution.programs.index')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('institution.programs.*') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        <span x-show="sidebarOpen">My Programs</span>
                    </a>
                    <a href="<?php echo e(route('institution.programs.create')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('institution.programs.create') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span x-show="sidebarOpen">Add Program</span>
                    </a>
                    <a href="<?php echo e(route('institution.applications.index')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('institution.applications.*') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10m-8 4h8M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"></path>
                        </svg>
                        <span x-show="sidebarOpen">Applications</span>
                    </a>
                    <?php if(auth()->user()->company): ?>
                        <a href="<?php echo e(route('employer.company.show')); ?>"
                           class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.company.*') ? 'active' : ''); ?>"
                           :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                            <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span x-show="sidebarOpen">Institution Profile</span>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(route('employer.dashboard')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.dashboard') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarOpen">Dashboard Overview</span>
                    </a>

                    <a href="<?php echo e(route('employer.jobs.create')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.jobs.create') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span x-show="sidebarOpen">Post a Job</span>
                    </a>

                    <a href="<?php echo e(route('employer.jobs.index')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.jobs.index') || request()->routeIs('employer.jobs.edit') || request()->routeIs('employer.jobs.show') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span x-show="sidebarOpen">Manage Jobs</span>
                    </a>

                    <a href="<?php echo e(route('employer.applicants.index')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.applicants.*') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span x-show="sidebarOpen">Applications</span>
                    </a>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('employer.cv.index')): ?>
                    <a href="<?php echo e(route('employer.cv.index')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.cv.*') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span x-show="sidebarOpen">Search CVs</span>
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="border-t border-white/10 my-4" x-show="sidebarOpen"></div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->user()->hasRole('educational_institution')): ?>
                    <?php if(auth()->user()->company): ?>
                        <a href="<?php echo e(route('employer.company.show')); ?>"
                           class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.company.show') ? 'active' : ''); ?>"
                           :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                            <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span x-show="sidebarOpen">Company Profile</span>
                        </a>

                        <a href="<?php echo e(route('employer.company.edit')); ?>"
                           class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.company.edit') ? 'active' : ''); ?>"
                           :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                            <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span x-show="sidebarOpen">Edit Profile</span>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('employer.company.create')); ?>"
                           class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.company.create') ? 'active' : ''); ?>"
                           :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                            <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span x-show="sidebarOpen">Create Company</span>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->user()->hasRole('educational_institution')): ?>
                    <a href="<?php echo e(route('employer.subscription')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.subscription') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span x-show="sidebarOpen">My Subscription</span>
                    </a>

                    <a href="<?php echo e(route('employer.packages')); ?>"
                       class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 <?php echo e(request()->routeIs('employer.packages') ? 'active' : ''); ?>"
                       :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                        <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span x-show="sidebarOpen">Upgrade Plan</span>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="border-t border-white/10 my-4" x-show="sidebarOpen"></div>

                <a href="<?php echo e(route('jobs.index')); ?>"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'space-x-0 px-2 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    <span x-show="sidebarOpen">View Public Site</span>
                </a>
            </nav>

            <!-- User Info & Logout -->
            <div class="absolute bottom-0 w-full p-4 border-t border-white/10 bg-white/5 backdrop-blur">
                <div class="flex items-center space-x-3" x-show="sidebarOpen">
                    <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center text-white font-semibold">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-xs text-white/70 truncate"><?php echo e(auth()->user()->email); ?></p>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-3">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-500/90 text-white text-sm rounded-lg hover:bg-red-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'ml-72' : 'ml-20'" class="flex-1 transition-all duration-300 bg-slate-50 min-h-screen">
            <!-- Top Header -->
            <header class="brand-gradient text-white shadow-lg sticky top-0 z-10">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg bg-white/10 hover:bg-white/20 transition">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h1 class="text-2xl font-semibold"><?php echo $__env->yieldContent('page-title', auth()->user()->hasRole('educational_institution') ? 'Institution Dashboard' : 'Employer Dashboard'); ?></h1>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <div class="px-4 py-2 rounded-full bg-white/10 text-white text-sm font-medium backdrop-blur">
                            <?php echo e(auth()->user()->name); ?>

                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            <div class="px-6 pt-4 space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                        <p class="font-medium">Success!</p>
                        <p><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                        <p class="font-medium">Error!</p>
                        <p><?php echo e(session('error')); ?></p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('warning')): ?>
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded" role="alert">
                        <p class="font-medium">Warning!</p>
                        <p><?php echo e(session('warning')); ?></p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('info')): ?>
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded" role="alert">
                        <p class="font-medium">Info!</p>
                        <p><?php echo e(session('info')); ?></p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <main class="px-6 py-6">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <?php echo $__env->make('layouts.partials.geo-autofill', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Livewire Scripts -->
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


    <!-- Manual Livewire Script (Force HTTPS) -->
    <script src="https://www.placemenet.net/livewire/livewire.min.js" data-turbo-eval="false" data-turbolinks-eval="false"></script>

    <!-- Force Livewire Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, checking Livewire...');

            if (typeof Livewire !== 'undefined') {
                console.log('✓ Livewire loaded');

                // Force Livewire to start/rescan
                setTimeout(function() {
                    console.log('Attempting to restart Livewire...');

                    try {
                        // In Livewire v3, try to restart
                        if (Livewire.start) {
                            Livewire.start();
                            console.log('✓ Livewire.start() called');
                        }

                        // Force rescan of components
                        if (Livewire.rescan) {
                            Livewire.rescan();
                            console.log('✓ Livewire.rescan() called');
                        }

                        // Check components after init
                        setTimeout(function() {
                            const component = document.querySelector('[wire\\:id]');
                            if (component && component.__livewire) {
                                console.log('✓✓✓ Component initialized successfully!');
                            } else {
                                console.error('✗ Component still not initialized');
                                console.log('Component element:', component);
                            }
                        }, 500);

                    } catch (e) {
                        console.error('Error initializing Livewire:', e);
                    }
                }, 100);
            } else {
                console.error('✗ Livewire not loaded!');
            }
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/placemenet/resources/views/layouts/employer.blade.php ENDPATH**/ ?>