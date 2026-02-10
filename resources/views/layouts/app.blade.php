<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
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

    <!-- Mobile Zoom & Responsive Fixes -->
    <style>
        /* Alpine.js cloak - hide elements until Alpine loads */
        [x-cloak] { display: none !important; }

        /* Prevent horizontal overflow on zoom */
        html, body {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
        }
        html {
            -webkit-text-size-adjust: 100%;
            text-size-adjust: 100%;
        }
        /* Ensure media scales correctly */
        img, video, svg, iframe { max-width: 100%; height: auto; }
        /* Prevent iOS zoom on input focus */
        input, textarea, select, button { font-size: 16px; touch-action: manipulation; }
        /* Safe area for notched devices */
        @supports (padding: max(0px)) {
            body {
                padding-left: env(safe-area-inset-left);
                padding-right: env(safe-area-inset-right);
            }
        }
    </style>

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
    @livewireStyles
</head>
@php($whatsappLink = config('placemenet.whatsapp_link'))
@php($whatsappNumber = config('placemenet.whatsapp_number'))
<body class="font-sans antialiased bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800">
    <div class="min-h-screen flex flex-col">
        <!-- Mega Menu Navigation -->
        @include('layouts.partials.mega-menu')

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
                    <div class="flex flex-wrap justify-center gap-x-4 gap-y-2 mb-4 px-2">
                        <a href="{{ route('jobs.index') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Browse Jobs</a>
                        <span class="text-blue-300 hidden sm:inline">•</span>
                        <a href="{{ route('visa.index') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Visa & Residency</a>
                        <span class="text-blue-300 hidden sm:inline">•</span>
                        <a href="{{ route('blogs.index') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Blog</a>
                        <span class="text-blue-300 hidden sm:inline">•</span>
                        <a href="{{ route('about') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">About Us</a>
                        <span class="text-blue-300 hidden sm:inline">•</span>
                        <a href="{{ route('appointments.index') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Consultations</a>
                        <span class="text-blue-300 hidden sm:inline">•</span>
                        <a href="{{ route('login') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">For Employers</a>
                        <span class="text-blue-300 hidden sm:inline">•</span>
                        <a href="{{ route('register') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Job Seekers</a>
                        <span class="text-blue-300 hidden sm:inline">•</span>
                        <a href="{{ route('privacy') }}" class="text-white/80 hover:text-white text-sm transition-colors duration-300">Data Privacy & GDPR</a>
                    </div>
                    <!-- General Legal Notice -->
                    <div class="mt-6 pt-6 border-t border-blue-500/30 max-w-4xl mx-auto">
                        <p class="text-blue-200/80 text-xs leading-relaxed mb-3">
                            <strong class="text-blue-100">General Legal Notice:</strong> PlaceMeNet is a trade name used by a group of independently registered legal entities operating in different jurisdictions. PlaceMeNet provides independent application support and administrative assistance services. We are not a government authority, law-enforcement body, or issuing authority in any country.
                        </p>
                        <p class="text-blue-200/70 text-xs leading-relaxed mb-3">
                            Official certificates, records, or documents referenced on this website are issued solely by the relevant government or public authorities, in accordance with their own laws, rules, and procedures. PlaceMeNet does not issue official certificates and does not guarantee approval, issuance, processing times, or acceptance by any authority.
                        </p>
                        <p class="text-blue-200/70 text-xs leading-relaxed">
                            The legal entity responsible for providing the service depends on the country-specific service page you are viewing. Jurisdiction, applicable law, and the contracting entity are clearly stated on each individual service page.
                        </p>
                    </div>

                    <p class="text-blue-200 text-xs mt-6">
                        &copy; 2026 PlaceMeNet. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    @include('layouts.partials.geo-autofill')
    @livewireScripts
    @stack('scripts')
</body>
</html>
