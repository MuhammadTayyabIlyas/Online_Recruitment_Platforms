<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PlaceMeNet') }} - Admin - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">

    <style>
        /* Mobile Zoom & Responsive Fixes */
        html, body {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
        }
        html {
            -webkit-text-size-adjust: 100%;
            text-size-adjust: 100%;
        }
        img, video, svg, iframe { max-width: 100%; height: auto; }
        input, textarea, select, button { font-size: 16px; touch-action: manipulation; }
        @supports (padding: max(0px)) {
            body {
                padding-left: env(safe-area-inset-left);
                padding-right: env(safe-area-inset-right);
            }
        }

        .sidebar-link {
            transition: all 0.25s ease;
        }
        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.12);
            border-left: 4px solid var(--brand-accent);
            padding-left: 1.25rem;
        }
        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.18);
            border-left: 4px solid var(--brand-accent);
            color: #fff;
            font-weight: 600;
        }
        /* Custom scrollbar for sidebar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        .overflow-y-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Mobile sidebar as overlay */
        @media (max-width: 767px) {
            .sidebar-mobile {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar-mobile.open {
                transform: translateX(0);
            }
            .content-area {
                margin-left: 0 !important;
                width: 100%;
            }
            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 25;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }
            .sidebar-backdrop.open {
                opacity: 1;
                pointer-events: auto;
            }
        }
    </style>
    @include('layouts.partials.brand-styles')
</head>
<body class="font-sans antialiased bg-slate-100">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: window.innerWidth >= 768 }">
        <!-- Mobile Backdrop -->
        <div class="sidebar-backdrop md:hidden" :class="sidebarOpen ? 'open' : ''" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="[sidebarOpen ? 'w-64' : 'w-20', sidebarOpen ? 'open' : '']" class="sidebar-mobile md:translate-x-0 brand-gradient text-white shadow-2xl transition-all duration-300 fixed h-full z-30 border-r border-white/10 flex flex-col">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center justify-between p-4 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3" x-show="sidebarOpen">
                    <div class="h-12 w-12 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center shadow-lg">
                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="PlaceMeNet Admin" class="h-8 w-auto object-contain drop-shadow">
                    </div>
                    <div class="leading-tight">
                        <p class="font-semibold tracking-wide text-white">PlaceMeNet</p>
                        <p class="text-xs text-white/70 uppercase tracking-[0.25em]">Admin</p>
                    </div>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="block" x-show="!sidebarOpen">
                    <div class="h-10 w-10 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center shadow-lg">
                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="PlaceMeNet" class="h-7 w-auto object-contain drop-shadow">
                    </div>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-white/10 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation (Scrollable) -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-2 text-white">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>

                <!-- Users -->
                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span x-show="sidebarOpen">Manage Users</span>
                </a>

                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span x-show="sidebarOpen">Categories</span>
                </a>

                <!-- Jobs -->
                <a href="{{ route('admin.jobs.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span x-show="sidebarOpen">Manage Jobs</span>
                </a>

                <!-- Programs -->
                <a href="{{ route('admin.programs.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span x-show="sidebarOpen">Manage Programs</span>
                </a>

                <!-- Applications -->
                <a href="{{ route('admin.applications.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span x-show="sidebarOpen">Applications</span>
                </a>

                <!-- Police Certificates -->
                <a href="{{ route('admin.police-certificates.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('admin.police-certificates.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span x-show="sidebarOpen">Police Certificates</span>
                </a>

                <!-- Blogs -->
                <a href="{{ route('admin.blogs.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <span x-show="sidebarOpen">Manage Blogs</span>
                </a>

                <!-- Blog Categories -->
                <a href="{{ route('admin.blog-categories.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span x-show="sidebarOpen">Blog Categories</span>
                </a>

                <!-- Settings -->
                <a href="{{ route('admin.settings.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span x-show="sidebarOpen">Settings</span>
                </a>

                <!-- Divider -->
                <div class="border-t border-white/10 my-4" x-show="sidebarOpen"></div>

                <!-- Back to Site -->
                <a href="{{ route('home') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span x-show="sidebarOpen">View Website</span>
                </a>
            </nav>

            <!-- User Info (Bottom) -->
            <div class="flex-shrink-0 p-4 border-t border-white/10 bg-white/5 backdrop-blur" x-show="sidebarOpen">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center text-white font-semibold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/70 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-500/90 text-white text-sm rounded-lg hover:bg-red-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div :class="{'md:ml-64': sidebarOpen, 'md:ml-20': !sidebarOpen}" class="content-area flex-1 transition-all duration-300 bg-slate-50 min-h-screen w-full">
            <!-- Top Header -->
            <header class="brand-gradient text-white shadow-lg sticky top-0 z-20">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="text-2xl font-semibold">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <!-- Notifications (placeholder) -->
                        <button class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition relative">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            <div class="px-6 py-4">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                        <p class="font-medium">Success!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                        <p class="font-medium">Error!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded" role="alert">
                        <p class="font-medium">Warning!</p>
                        <p>{{ session('warning') }}</p>
                    </div>
                @endif

                @if(session('info'))
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded" role="alert">
                        <p class="font-medium">Info!</p>
                        <p>{{ session('info') }}</p>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <main class="px-6 pb-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
