<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PlaceMeNet') }} - @yield('title', 'Jobseeker Hub')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">

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
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 4px solid var(--brand-accent);
            color: #fff;
            font-weight: 600;
        }
    </style>
    @include('layouts.partials.brand-styles')
</head>
<body class="font-sans antialiased bg-slate-100" x-data="{ sidebarOpen: true }" :data-sidebar-open="sidebarOpen">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-72' : 'w-20'"
               class="brand-gradient text-white shadow-2xl transition-all duration-300 fixed h-full z-30 border-r border-white/10">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-white/10">
                <a href="{{ route('home') }}" class="flex items-center gap-3" x-show="sidebarOpen">
                    <div class="h-12 w-12 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center shadow-lg">
                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="PlaceMeNet" class="h-8 w-auto object-contain drop-shadow">
                    </div>
                    <div class="leading-tight">
                        <p class="font-semibold tracking-wide text-white">PlaceMeNet</p>
                        <p class="text-xs text-white/70 uppercase tracking-[0.25em]">Jobseeker Hub</p>
                    </div>
                </a>
                <a href="{{ route('home') }}" class="block" x-show="!sidebarOpen">
                    <div class="h-10 w-10 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center shadow-lg">
                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="PlaceMeNet" class="h-7 w-auto object-contain drop-shadow">
                    </div>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-white/10 transition md:hidden">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2 text-white">
                <a href="{{ route('jobseeker.dashboard') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('jobseeker.dashboard') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>

                <a href="{{ route('jobseeker.profile.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('jobseeker.profile.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span x-show="sidebarOpen">My Profile</span>
                </a>

                <a href="{{ route('jobseeker.applications.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('jobseeker.applications.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-show="sidebarOpen">My Applications</span>
                </a>

                <a href="{{ route('jobseeker.saved.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('jobseeker.saved.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span x-show="sidebarOpen">Saved Jobs</span>
                </a>

                <a href="{{ route('jobseeker.alerts.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('jobseeker.alerts.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span x-show="sidebarOpen">Job Alerts</span>
                </a>

                <a href="{{ route('jobseeker.documents.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3 {{ request()->routeIs('jobseeker.documents.*') ? 'active' : '' }}"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span x-show="sidebarOpen">My Documents</span>
                </a>

                <div class="border-t border-white/10 my-4" x-show="sidebarOpen"></div>

                <a href="{{ route('jobs.index') }}"
                   class="sidebar-link group flex items-center rounded-lg text-white/80 py-3"
                   :class="sidebarOpen ? 'space-x-3 px-4 justify-start' : 'px-3 justify-center'">
                    <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span x-show="sidebarOpen">Browse Jobs</span>
                </a>
            </nav>

            <!-- User Card -->
            <div class="absolute bottom-0 w-full p-4 border-t border-white/10 bg-white/5 backdrop-blur">
                <div class="flex items-center space-x-3" x-show="sidebarOpen">
                    <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/70 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-500/90 text-white text-sm rounded-lg hover:bg-red-500 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7 m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Content Area -->
        <div :class="sidebarOpen ? 'ml-72' : 'ml-20'" class="flex-1 transition-all duration-300 bg-slate-50 min-h-screen">
            <header class="brand-gradient text-white shadow-lg sticky top-0 z-20">
                <div class="px-6 py-4 flex items-center justify-between">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg bg-white/10 hover:bg-white/20 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-2xl font-semibold">@yield('page-title', 'Jobseeker Dashboard')</h1>
                    <div class="hidden md:flex items-center gap-3">
                        <div class="px-4 py-2 rounded-full bg-white/10 text-white text-sm font-medium backdrop-blur">
                            {{ auth()->user()->name }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            <div class="px-6 pt-4 space-y-3">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                        <p class="font-medium">Success!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                        <p class="font-medium">Error!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded" role="alert">
                        <p class="font-medium">Warning!</p>
                        <p>{{ session('warning') }}</p>
                    </div>
                @endif

                @if(session('info'))
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded" role="alert">
                        <p class="font-medium">Info!</p>
                        <p>{{ session('info') }}</p>
                    </div>
                @endif
            </div>

            <main class="px-6 py-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
