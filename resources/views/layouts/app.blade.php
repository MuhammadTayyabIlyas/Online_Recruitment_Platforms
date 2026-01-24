<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="gu18dCDnQPyvs82m2d1PmlD7V1Ex9yeykt0ZIsEV5sQ">
    <meta name="description" content="@yield('meta_description', 'PlaceMeNet helps job seekers discover verified roles and connect with top employers, while companies find qualified talent quickly. Browse jobs, apply, and manage applications in one secure platform.')">

    <title>{{ config('app.name', 'PlaceMeNet') }} - @yield('title', 'Job Placement Platform')</title>

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

    <!-- Custom Styles for Interactive Elements -->
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            50% { box-shadow: 0 0 30px rgba(59, 130, 246, 0.8); }
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(to right, #3b82f6, #6366f1);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        @keyframes logo-sequence {
            0% { transform: rotate(0deg); }
            24% { transform: rotate(360deg); }
            25% { transform: translateX(0); }
            30% { transform: translateX(6px); }
            35% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            45% { transform: translateX(-6px); }
            50% { transform: translateX(0); }
            55% { transform: translateY(-6px); }
            60% { transform: translateY(6px); }
            65% { transform: translateY(-6px); }
            70% { transform: translateY(6px); }
            75% { transform: translateY(0); }
            76% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .logo-sequence {
            animation: logo-sequence 12s ease-in-out infinite;
        }

        #locale-select,
        #locale-select option {
            font-family: 'Segoe UI Emoji','Apple Color Emoji','Noto Color Emoji','Figtree',sans-serif;
        }

        .whatsapp-fab {
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.35);
        }
    </style>
    @include('layouts.partials.brand-styles')
</head>
@php($whatsappLink = config('placemenet.whatsapp_link'))
@php($whatsappNumber = config('placemenet.whatsapp_number'))
<body class="font-sans antialiased bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="group flex items-center gap-4">
                                <div class="relative">
                                    <span class="absolute -inset-1 rounded-2xl bg-white/10 blur-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                    <div class="relative flex items-center justify-center h-12 w-12 rounded-2xl border border-white/30 bg-white/15 backdrop-blur-md shadow-lg transition-all duration-300 group-hover:border-white/70 group-hover:bg-white/25 group-hover:-translate-y-0.5">
                                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="PlaceMeNet logo" class="logo-sequence h-8 w-auto object-contain drop-shadow-lg">
                                    </div>
                                </div>
                                <div class="hidden sm:block leading-tight">
                                    <p class="text-white font-semibold tracking-wide">PlaceMeNet</p>
                                    <p class="text-xs text-white/70 uppercase tracking-[0.25em]">Career Network</p>
                                </div>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="{{ route('jobs.index') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                            {{ __('Jobs') }}
                        </a>
                        <a href="{{ route('study-programs.index') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                            {{ __('Study Programs') }}
                        </a>
                        <a href="{{ route('visa.index') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                            {{ __('Visa & Residency') }}
                        </a>
                        <a href="{{ route('blogs.index') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                            {{ __('Blog') }}
                        </a>
                        @auth
                            @if(auth()->user()->hasRole('educational_institution'))
                                <a href="{{ route('institution.programs.index') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                                    {{ __('My Programs') }}
                                </a>
                            @endif
                        @endauth
                            <a href="{{ route('about') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                                {{ __('About') }}
                            </a>
                            <a href="{{ route('contact') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                                {{ __('Contact') }}
                            </a>
                            @auth
                                @if(auth()->user()->hasRole('employer') || auth()->user()->hasRole('educational_institution'))
                                    <a href="{{ route('employer.dashboard') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                                        {{ __('Dashboard') }}
                                    </a>
                                    <a href="{{ route('employer.jobs.index') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                                        {{ __('My Openings') }}
                                    </a>
                                    <a href="{{ route('content-creator.blogs.index') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                                        {{ __('My Blogs') }}
                                    </a>
                                @elseif(auth()->user()->hasRole('job_seeker'))
                                    <a href="{{ route('jobseeker.dashboard') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                                        {{ __('Dashboard') }}
                                    </a>
                                    <a href="{{ route('jobseeker.applications.index') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                                        {{ __('My Applications') }}
                                    </a>
                        @elseif(auth()->user()->hasRole('student'))
                            <a href="{{ route('study-programs.index') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                                {{ __('Study Programs') }}
                            </a>
                        @elseif(auth()->user()->hasRole('educational_institution'))
                            <a href="{{ route('institution.programs.index') }}" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-white/90 hover:text-white">
                                {{ __('My Programs') }}
                            </a>
                        @endif
                    @endauth
                </div>
                    </div>

                    <!-- Right Navigation -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-3">
                        @php($localeLabels = [
                            'en' => 'English',
                            'es' => 'Español',
                            'el' => 'Ελληνικά',
                            'pt' => 'Português',
                            'sq' => 'Shqip',
                        ])
                        @php($flagSvgs = [
                            'en' => '<svg width="18" height="12" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg"><rect width="18" height="12" fill="#012169"/><path d="M0 0l18 12M18 0L0 12" stroke="#FFF" stroke-width="2"/><path d="M0 0l18 12M18 0L0 12" stroke="#C8102E" stroke-width="1"/><rect x="7" width="4" height="12" fill="#FFF"/><rect y="4" width="18" height="4" fill="#FFF"/><rect x="7.5" width="3" height="12" fill="#C8102E"/><rect y="4.5" width="18" height="3" fill="#C8102E"/></svg>',
                            'es' => '<svg width="18" height="12" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg"><rect width="18" height="12" fill="#AA151B"/><rect y="3" width="18" height="6" fill="#F1BF00"/></svg>',
                            'el' => '<svg width="18" height="12" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg"><rect width="18" height="12" fill="#0D5EAF"/><path d="M0 1.5h18M0 4.5h18M0 7.5h18M0 10.5h18" stroke="#FFF" stroke-width="1.2"/><rect width="7.2" height="7.2" fill="#0D5EAF"/><path d="M3.6 0v7.2M0 3.6h7.2" stroke="#FFF" stroke-width="1.2"/></svg>',
                            'pt' => '<svg width="18" height="12" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg"><rect width="7" height="12" fill="#006600"/><rect x="7" width="11" height="12" fill="#FF0000"/><circle cx="7.5" cy="6" r="2.4" fill="#FFD700"/><circle cx="7.5" cy="6" r="1.4" fill="#006600"/></svg>',
                            'sq' => '<svg width="18" height="12" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg"><rect width="18" height="12" fill="#E41E20"/><path d="M7 3.5h4v5H7z" fill="#111"/></svg>',
                        ])
                        @php($currentLocale = app()->getLocale())
                        <div class="relative" x-data="{ open: false, selected: '{{ $currentLocale }}' }" @keydown.escape.window="open = false">
                            <form method="POST" action="{{ route('locale.switch') }}" x-ref="localeForm">
                                @csrf
                                <input type="hidden" name="locale" :value="selected">
                            </form>
                            <button type="button"
                                    @click="open = !open"
                                    class="inline-flex items-center justify-center gap-1.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-xs font-semibold rounded-full border border-white/30 px-3 py-1.5 shadow-md hover:shadow-lg hover:-translate-y-px transition focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-yellow-300"
                                    style="font-family: 'Segoe UI Emoji','Apple Color Emoji','Noto Color Emoji','Figtree',sans-serif; min-width: 110px;">
                                <span class="inline-flex items-center gap-1.5 mx-auto">
                                    <span class="inline-block w-4 h-3 align-middle" x-html="@js($flagSvgs)[selected] ?? ''"></span>
                                    <span class="text-center" x-text="@js($localeLabels)[selected] ?? selected.toUpperCase()"></span>
                                </span>
                                <svg class="h-3 w-3 text-white/80 transition-transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute top-full right-0 mt-2 w-36 bg-white/60 backdrop-blur-md rounded-lg shadow-md border border-white/40 py-1 z-50 transform translate-x-2">
                                @foreach(config('app.available_locales', ['en']) as $locale)
                                    <button type="button"
                                            class="w-full text-left px-3 py-2 text-xs font-semibold text-gray-800 hover:bg-blue-50/80 flex items-center gap-2"
                                            style="font-family: 'Segoe UI Emoji','Apple Color Emoji','Noto Color Emoji','Figtree',sans-serif;"
                                            @click="selected = '{{ $locale }}'; open = false; $refs.localeForm.submit();">
                                        <span class="inline-block w-5 h-3 align-middle">{!! $flagSvgs[$locale] ?? '' !!}</span>
                                        <span>{{ $localeLabels[$locale] ?? strtoupper($locale) }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        @guest
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-yellow-300 text-blue-900 text-sm font-semibold rounded-full px-4 py-2 mr-2 shadow-md hover:shadow-lg hover:bg-yellow-200 transition">
                                {{ __('Login') }}
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-blue-900 uppercase tracking-widest hover:bg-yellow-300 transition-all duration-300 hover-lift">
                                {{ __('Register') }}
                            </a>
                        @else
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-sm font-medium text-white/90 hover:text-white focus:outline-none transition-colors duration-300">
                                    {{ Auth::user()->name }}
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    @if(auth()->user()->hasRole('job_seeker'))
                                        <a href="{{ route('jobseeker.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Profile') }}</a>
                                    @elseif(auth()->user()->hasRole('student'))
                                        <a href="{{ route('study-programs.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Browse Study Programs</a>
                                    @elseif(auth()->user()->hasRole('employer') || auth()->user()->hasRole('educational_institution'))
                                        <a href="{{ route('employer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ __('Logout') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Floating WhatsApp Button -->
        <a href="{{ $whatsappLink }}" target="_blank" rel="noopener"
           class="whatsapp-fab fixed bottom-5 right-4 sm:bottom-6 sm:right-6 w-14 h-14 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-green-300"
           aria-label="Chat on WhatsApp">
            <svg class="w-8 h-8" viewBox="0 0 512 512" aria-hidden="true" focusable="false">
                <path fill="currentColor" d="M256.05 32C132.44 32 32 131.87 32 255.17c0 49.22 14.53 95.16 39.48 134L32 480l92-39.24c37.44 20.5 80.05 32.14 125.86 32.14h.19c123.61 0 224.05-99.87 224.05-223.17C474.1 131.89 379.66 32 256.05 32ZM380.74 354.93c-5.89 16.55-29.33 30.35-47.94 34.34-12.77 2.72-29 4.89-84.38-18.12C188.55 342.75 147 284.81 143.77 280c-3.19-4.76-28.04-37.32-28.04-71.25s17.33-50.32 24.17-57.35c5.89-6.09 15.68-8.86 25.05-8.86 3 0 5.7.15 8.13.28 7.11.3 10.66.73 15.35 11.94 5.89 14.22 20.18 49.17 21.93 52.77 1.76 3.55 3.52 8.42 1.06 13.18-2.35 4.9-4.4 7.08-8.08 11.27-3.68 4.19-7.16 7.4-10.79 11.89-3.35 4.17-7.13 8.66-2.9 16.2s16.78 27.72 35.94 44.73c24.69 22 45.52 28.89 52.02 32.13 6.5 3.24 14.24 2.47 18.93-1.49 6-5 13.44-14.59 21-24.94 5.35-7.4 12.07-8.3 19.05-5.67 7.95 2.79 50.14 23.61 58.77 27.89 8.64 4.28 14.35 6.34 16.48 10 .22 2.7-.71 15.72-6.6 32.26Z"/>
            </svg>
        </a>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms>
                <div class="flex items-center justify-between bg-green-50 border-l-4 border-green-400 p-4 shadow-md rounded-lg" role="alert">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-800 focus:outline-none focus:ring-2 focus:ring-green-400 p-1 rounded-full">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('warning') }}
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('info') }}
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main class="py-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 border-t border-blue-500/30 mt-auto">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-white font-semibold text-lg mb-2">PlaceMeNet</p>
                    <p class="text-blue-100 text-sm mb-4">Your Gateway to Dream Jobs</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-3 mb-5">
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-2 rounded-full bg-white/10 text-white text-sm font-semibold hover:bg-white/20 transition">
                            Contact Us
                        </a>
                        <a href="{{ $whatsappLink }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-6 py-2 rounded-full border border-white/30 text-white/90 text-sm font-semibold hover:text-white hover:border-white transition">
                            WhatsApp: {{ $whatsappNumber }}
                        </a>
                    </div>
                        <div class="flex justify-center space-x-6 mb-4">
                            <a href="{{ route('jobs.index') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Browse Jobs</a>
                            <span class="text-blue-300">•</span>
                            <a href="{{ route('visa.index') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Visa & Residency</a>
                            <span class="text-blue-300">•</span>
                            <a href="{{ route('blogs.index') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Blog</a>
                            <span class="text-blue-300">•</span>
                            <a href="{{ route('about') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">About Us</a>
                            <span class="text-blue-300">•</span>
                            <a href="{{ route('login') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">For Employers</a>
                            <span class="text-blue-300">•</span>
                            <a href="{{ route('register') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Job Seekers</a>
                        <span class="text-blue-300">•</span>
                        <a href="{{ route('privacy') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Data Privacy & GDPR</a>
                    </div>
                    <p class="text-blue-200 text-xs">
                        &copy; 2026 PlaceMeNet. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    @include('layouts.partials.geo-autofill')
    @stack('scripts')
</body>
</html>
