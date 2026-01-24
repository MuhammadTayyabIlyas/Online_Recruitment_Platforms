@extends('layouts.app')

@section('title', __('Welcome to PlaceMeNet - Find Your Dream Job'))

@section('content')

{{-- ═══════════════════════════════════════════════════════════════════════════ --}}
{{-- HERO SECTION (Module 5)                                                     --}}
{{-- Full-width hero with gradient background, search form, and CTA buttons      --}}
{{-- ═══════════════════════════════════════════════════════════════════════════ --}}

{{-- Remove the default padding from the content area --}}
<div class="-my-6">

{{-- Floating cookies icon and toast on the left --}}
<div class="fixed left-4 top-1/2 -translate-y-1/2 z-50 drop-shadow-lg space-y-3" aria-live="polite">
    <div id="cookie-icon" class="w-12 h-12 rounded-full bg-white/90 border border-gray-200 flex items-center justify-center shadow-lg opacity-0 scale-90 translate-y-2 transition-all duration-500 ease-out pointer-events-auto">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-amber-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M21 11.5a8.5 8.5 0 01-8.5-8.5A1 1 0 0011.5 2 9.5 9.5 0 1021 12.5a1 1 0 00-1-1zM9 7a1 1 0 110 2 1 1 0 010-2zm3 8a1 1 0 110 2 1 1 0 010-2zm4-5a1 1 0 110 2 1 1 0 010-2zM8 12a1 1 0 110 2 1 1 0 010-2z"/>
        </svg>
    </div>
    <div id="cookie-message" class="max-w-[240px] bg-white/95 border border-gray-200 rounded-xl px-4 py-3 text-xs text-gray-700 shadow-xl opacity-0 translate-y-2 transition-all duration-500 ease-out relative pr-10 pointer-events-auto">
        <button type="button" id="cookie-close" aria-label="{{ __('Close cookie message') }}" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
            &times;
        </button>
        {{ __('By using this website, you agree to our Cookies Policy.') }}
        <a href="{{ route('privacy') }}#cookies-policy" class="underline text-blue-600 font-semibold">{{ __('View Policy') }}</a>
    </div>
</div>

<section id="hero" class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 min-h-[600px] flex items-center overflow-hidden">

    {{-- Background Interaction: subtle animated blobs --}}
    <div class="absolute inset-0">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 blur-3xl rounded-full animate-pulse"></div>
        <div class="absolute top-20 right-10 w-80 h-80 bg-blue-300/20 blur-3xl rounded-full animate-[pulse_8s_ease-in-out_infinite]"></div>
        <div class="absolute bottom-10 left-1/3 w-72 h-72 bg-indigo-400/20 blur-3xl rounded-full animate-[pulse_10s_ease-in-out_infinite]"></div>
    </div>

    {{-- Main Content Container --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 w-full">

        {{-- Text Content --}}
        <div class="text-center mb-10 md:mb-12">

            {{-- Main Headline --}}
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 md:mb-6 leading-tight animate-fade-in-up">
                {{ __('Find Your') }} <span class="text-yellow-300 inline-block hover:scale-110 transition-transform duration-300 cursor-default">{{ __('Dream Job') }}</span> {{ __('Today') }}
            </h1>

            {{-- Subheadline --}}
            <p class="text-lg sm:text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto mb-2 animate-fade-in-up animation-delay-200">
                {{ __('Connect with thousands of top employers and discover') }}
                <span class="text-white font-semibold">50,000+</span> {{ __('opportunities') }}
            </p>

            {{-- Supporting Text --}}
            <p class="text-blue-200 text-sm md:text-base animate-fade-in-up animation-delay-400">
                {{ __('Your next career move starts here') }}
            </p>
        </div>

        <style>
            @keyframes fade-in-up {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fade-in-up 0.8s ease-out forwards;
            }

            .animation-delay-200 {
                animation-delay: 0.2s;
                opacity: 0;
            }

    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
    }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const icon = document.getElementById('cookie-icon');
                const message = document.getElementById('cookie-message');
                const closeBtn = document.getElementById('cookie-close');
                if (!icon || !message) return;

                const storageKey = 'placemenet_cookie_notice';
                const sessionKey = 'placemenet_cookie_notice_session_shown';

                // If user already dismissed permanently, do nothing
                if (localStorage.getItem(storageKey) === 'dismissed') {
                    return;
                }

                // Only show once per session automatically
                if (sessionStorage.getItem(sessionKey) === 'shown') {
                    return;
                }
                sessionStorage.setItem(sessionKey, 'shown');

                const show = () => {
                    icon.classList.remove('opacity-0', 'translate-y-2', 'scale-90');
                    message.classList.remove('opacity-0', 'translate-y-2', 'pointer-events-none');
                };

                const hide = () => {
                    icon.classList.add('opacity-0', 'translate-y-2', 'scale-90');
                    message.classList.add('opacity-0', 'translate-y-2', 'pointer-events-none');
                };

                // Show shortly after load, then hide after 10 seconds
                const showTimer = setTimeout(show, 200);
                const autoHideTimer = setTimeout(hide, 10200);

                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        hide();
                        localStorage.setItem(storageKey, 'dismissed');
                        clearTimeout(showTimer);
                        clearTimeout(autoHideTimer);
                    });
                }
            });
        </script>

        {{-- Search Form --}}
        <div class="max-w-4xl mx-auto mb-10 md:mb-12">
            <form action="{{ route('jobs.index') }}" method="GET"
                  class="bg-white rounded-xl shadow-2xl p-3 md:p-4">

                <div class="flex flex-col md:flex-row gap-3 md:gap-4">

                    {{-- Keywords Input --}}
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="q"
                            placeholder="{{ __('Job title, keywords, or company') }}"
                            class="w-full pl-12 pr-4 py-3 md:py-4 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-gray-700 placeholder-gray-400 text-base md:text-lg"
                        >
                    </div>

                    {{-- Location Input --}}
                    <div class="md:w-64 relative">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                name="location"
                                placeholder="{{ __('City, state, or remote') }}"
                                class="w-full pl-12 pr-4 py-3 md:py-4 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-gray-700 placeholder-gray-400 text-base md:text-lg"
                                data-geo-city
                            >
                        </div>
                        <p class="mt-1 text-sm text-gray-500" data-geo-status>We'll try to detect your city automatically.</p>
                    </div>

                    {{-- Search Button --}}
                    <button
                        type="submit"
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 md:py-4 rounded-lg transition-all duration-200 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 text-base md:text-lg"
                    >
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span>{{ __('Search Jobs') }}</span>
                    </button>
                </div>

                {{-- Popular Searches --}}
                <div class="mt-4 pt-4 border-t border-gray-100 hidden md:block">
                    <p class="text-sm text-gray-500 inline">
                        <span class="font-medium">{{ __('Popular:') }}</span>
                    </p>
                    <div class="inline-flex flex-wrap gap-2 ml-2">
                        <a href="{{ route('jobs.index', ['q' => 'software engineer']) }}"
                           class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                            {{ __('Software Engineer') }}
                        </a>
                        <span class="text-gray-300">•</span>
                        <a href="{{ route('jobs.index', ['q' => 'marketing']) }}"
                           class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                            {{ __('Marketing') }}
                        </a>
                        <span class="text-gray-300">•</span>
                        <a href="{{ route('jobs.index', ['q' => 'remote']) }}"
                           class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                            {{ __('Remote Jobs') }}
                        </a>
                        <span class="text-gray-300">•</span>
                        <a href="{{ route('jobs.index', ['q' => 'data analyst']) }}"
                           class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                            {{ __('Data Analyst') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row flex-wrap justify-center gap-3 sm:gap-4 mb-10 md:mb-12 px-4">
            <a href="{{ route('register') }}"
               class="group inline-flex items-center justify-center gap-2 bg-white text-blue-700 hover:bg-yellow-300 hover:text-blue-800 px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl hover-lift animate-pulse-glow">
                <svg class="h-5 w-5 group-hover:scale-110 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                {{ __('Upload Resume') }}
            </a>

            <a href="{{ route('jobs.index') }}"
               class="group inline-flex items-center justify-center gap-2 border-2 border-white/30 text-white hover:bg-white hover:text-blue-700 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover-lift">
                <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                {{ __('Browse Jobs') }}
            </a>

            <a href="{{ route('visa.index') }}"
               class="group inline-flex items-center justify-center gap-2 border-2 border-white/30 text-white hover:bg-white hover:text-blue-700 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover-lift">
                <svg class="h-5 w-5 group-hover:scale-110 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                Move to Europe
            </a>
        </div>

        {{-- Stats Row --}}
        <div class="flex flex-wrap justify-center gap-6 md:gap-12 text-white/90">
            @php
                $statsJobs = \App\Models\Job::active()->count();
                $statsCompanies = \App\Models\Company::count();
                $statsSeekers = \App\Models\User::role('job_seeker')->count();
                $totalApplications = \App\Models\JobApplication::count();
                $approvedApplications = \App\Models\JobApplication::where('status', \App\Enums\ApplicationStatus::ACCEPTED->value)->count();
                $approvalRate = $totalApplications > 0 ? round(($approvedApplications / $totalApplications) * 100) : 0;
            @endphp

            {{-- Jobs Stat --}}
            <div class="group flex items-center gap-2 cursor-default hover:scale-110 transition-transform duration-300">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-yellow-300 group-hover:rotate-12 transition-all duration-300">
                    <svg class="h-5 w-5 group-hover:text-blue-700 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl md:text-2xl font-bold group-hover:text-yellow-300 transition-colors duration-300">{{ number_format($statsJobs) }}</p>
                    <p class="text-xs md:text-sm text-blue-200">{{ __('Active Jobs') }}</p>
                </div>
            </div>

            {{-- Companies Stat --}}
            <div class="group flex items-center gap-2 cursor-default hover:scale-110 transition-transform duration-300">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-yellow-300 group-hover:rotate-12 transition-all duration-300">
                    <svg class="h-5 w-5 group-hover:text-blue-700 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl md:text-2xl font-bold group-hover:text-yellow-300 transition-colors duration-300">{{ number_format($statsCompanies) }}</p>
                    <p class="text-xs md:text-sm text-blue-200">{{ __('Companies') }}</p>
                </div>
            </div>

            {{-- Job Seekers Stat --}}
            <div class="group flex items-center gap-2 cursor-default hover:scale-110 transition-transform duration-300">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-yellow-300 group-hover:rotate-12 transition-all duration-300">
                    <svg class="h-5 w-5 group-hover:text-blue-700 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl md:text-2xl font-bold group-hover:text-yellow-300 transition-colors duration-300">{{ number_format($statsSeekers) }}</p>
                    <p class="text-xs md:text-sm text-blue-200">{{ __('Job Seekers') }}</p>
                </div>
            </div>

            {{-- Approval Rate --}}
            <div class="group flex items-center gap-2 cursor-default hover:scale-110 transition-transform duration-300">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-yellow-300 group-hover:rotate-12 transition-all duration-300">
                    <svg class="h-5 w-5 group-hover:text-blue-700 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl md:text-2xl font-bold group-hover:text-yellow-300 transition-colors duration-300">{{ $approvalRate }}%</p>
                    <p class="text-xs md:text-sm text-blue-200">{{ __('Approved Applications') }}</p>
                </div>
            </div>
        </div>

        {{-- Animated airplane path --}}
        <div class="pointer-events-none absolute left-0 right-0 -bottom-8 flex justify-center">
            <svg class="w-full max-w-3xl h-20" viewBox="0 0 800 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path id="hero-plane-path" d="M40 46 C220 -4 360 70 520 18 C640 0 700 66 760 18" stroke="rgba(255,255,255,0.6)" stroke-width="3" stroke-dasharray="6 10" stroke-linecap="round" fill="none"/>
                <g>
                    <path d="M-18 6 L30 14 L-6 20 L-2 12 Z" fill="#facc15">
                        <animateMotion dur="5s" repeatCount="indefinite" rotate="auto">
                            <mpath xlink:href="#hero-plane-path"/>
                        </animateMotion>
                    </path>
                    <path d="M-10 14 Q0 2 16 14 Q0 12 -10 14" fill="#fbbf24">
                        <animateMotion dur="5s" repeatCount="indefinite" rotate="auto">
                            <mpath xlink:href="#hero-plane-path"/>
                        </animateMotion>
                    </path>
                    <circle r="4" cx="0" cy="14" fill="#fde68a">
                        <animateMotion dur="5s" repeatCount="indefinite" rotate="auto">
                            <mpath xlink:href="#hero-plane-path"/>
                        </animateMotion>
                    </circle>
                </g>
            </svg>
        </div>

    </div>

    {{-- Bottom Wave Decoration --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
    </div>

</section>

</div>

{{-- Categories and featured jobs sections removed per request --}}

{{-- ═══════════════════════════════════════════════════════════════════════════ --}}
{{-- MODULE 8: HOW IT WORKS SECTION                                              --}}
{{-- ═══════════════════════════════════════════════════════════════════════════ --}}

<section id="how-it-works" class="py-16 bg-gradient-to-br from-blue-600 to-indigo-700 relative overflow-hidden">
    <div class="absolute inset-0 opacity-30 pointer-events-none">
        <div class="w-64 h-64 bg-white/10 rounded-full blur-3xl absolute -top-10 left-10 animate-pulse"></div>
        <div class="w-80 h-80 bg-blue-300/10 rounded-full blur-3xl absolute bottom-0 right-16 animate-[pulse_8s_ease-in-out_infinite]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">{{ __('How It Works') }}</h2>
            <p class="text-lg text-blue-100 max-w-2xl mx-auto">{{ __('Your journey to the perfect job in three simple steps') }}</p>
        </div>

        <div class="relative max-w-5xl mx-auto">
            <div class="absolute inset-x-8 top-16 hidden md:block">
                <div class="h-1 rounded-full bg-white/20">
                    <div class="h-full rounded-full bg-white/60 animate-progress"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <div class="how-step">
                    <div class="how-icon">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="how-badge">1</div>
                    <h3>{{ __('Create Your Profile') }}</h3>
                    <p>{{ __('Sign up and build your professional profile with skills and experience') }}</p>
                </div>

                <div class="how-step">
                    <div class="how-icon">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div class="how-badge">2</div>
                    <h3>{{ __('Search & Apply') }}</h3>
                    <p>{{ __('Browse thousands of jobs and apply with one click') }}</p>
                </div>

                <div class="how-step">
                    <div class="how-icon">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="how-badge">3</div>
                    <h3>{{ __('Get Hired') }}</h3>
                    <p>{{ __('Connect with employers and land your dream job') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-12 bg-white rounded-2xl p-8 md:p-10 text-center shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <div class="w-32 h-32 bg-blue-100 rounded-full blur-3xl absolute -top-8 -left-6"></div>
                <div class="w-40 h-40 bg-indigo-100 rounded-full blur-3xl absolute bottom-0 right-0"></div>
            </div>
            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 relative">{{ __('Ready to Start Your Career Journey?') }}</h3>
            <p class="text-lg text-gray-600 mb-6 max-w-2xl mx-auto relative">{{ __('Join thousands of job seekers who found their dream jobs') }}</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center relative">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-4 rounded-lg transition-all text-lg hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    {{ __('Create Free Account') }}
                </a>
                <a href="{{ route('jobs.index') }}"
                   class="inline-flex items-center justify-center gap-2 border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold px-8 py-4 rounded-lg transition-all text-lg hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    {{ __('Browse Jobs') }}
                </a>
            </div>
        </div>
    </div>

    <style>
        @keyframes float-soft {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        @keyframes pulse-glow-how {
            0%,100% { box-shadow: 0 12px 35px rgba(255,255,255,0.08); }
            50% { box-shadow: 0 14px 45px rgba(255,255,255,0.16); }
        }
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 65%; }
            100% { width: 100%; }
        }
        .animate-progress { animation: progress 3s ease-in-out infinite; }
        .how-step {
            position: relative;
            padding: 20px;
            border-radius: 18px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            text-align: center;
            color: white;
            backdrop-filter: blur(6px);
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
            animation: float-soft 6s ease-in-out infinite;
        }
        .how-step:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(0,0,0,0.15);
            border-color: rgba(255,255,255,0.35);
        }
        .how-step h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem; }
        .how-step p { color: #cfe2ff; font-size: 0.95rem; margin: 0; }
        .how-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 14px;
            border-radius: 16px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse-glow-how 3.5s ease-in-out infinite;
        }
        .how-badge {
            position: absolute;
            top: -12px;
            left: 14px;
            width: 32px;
            height: 32px;
            border-radius: 9999px;
            background: #2563eb;
            color: white;
            font-weight: 700;
            display: grid;
            place-items: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
    </style>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════ --}}
{{-- NEXT STEPS: OTHER PATHS                                                     --}}
{{-- ═══════════════════════════════════════════════════════════════════════════ --}}

<section id="paths" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Pick the path that fits you</h2>
            <p class="text-lg text-gray-600">Jobs, study abroad, or moving to Europe—we keep the steps clear and conversion-focused.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 shadow-sm flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-blue-700 font-semibold">Find a job</p>
                    <span class="px-3 py-1 rounded-full bg-white text-blue-700 text-xs font-semibold">New roles daily</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Verified employers, faster offers</h3>
                <p class="text-gray-700 text-sm">Search roles, set alerts, and apply with your saved profile.</p>
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 text-blue-700 font-semibold hover:text-blue-900">
                    Browse jobs
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>

            <div class="p-6 rounded-2xl bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 shadow-sm flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-indigo-700 font-semibold">Study abroad</p>
                    <span class="px-3 py-1 rounded-full bg-white text-indigo-700 text-xs font-semibold">92% get offers</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900">European degrees with clear costs</h3>
                <p class="text-gray-700 text-sm">Compare tuition, deadlines, and visa options in one search.</p>
                <a href="{{ route('study-programs.index') }}" class="inline-flex items-center gap-2 text-indigo-700 font-semibold hover:text-indigo-900">
                    Explore programs
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>

            <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-teal-50 border border-teal-100 shadow-sm flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-teal-700 font-semibold">Visa & residency</p>
                    <span class="px-3 py-1 rounded-full bg-white text-teal-700 text-xs font-semibold">Guided plan</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Move to Europe with a clear plan</h3>
                <p class="text-gray-700 text-sm">Golden Visa, Digital Nomad, Passive Income, Startup, or Skilled paths.</p>
                <a href="{{ route('visa.index') }}" class="inline-flex items-center gap-2 text-teal-700 font-semibold hover:text-teal-900">
                    See pathways
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                Talk to a human
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- Employer strip --}}
<section class="py-12 bg-gradient-to-r from-blue-600 to-indigo-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-6 items-center text-white">
            <div class="md:col-span-2">
                <p class="text-sm uppercase tracking-wide text-blue-100 mb-2">For employers</p>
                <h3 class="text-2xl font-bold mb-2">Post a role and reach vetted candidates fast</h3>
                <p class="text-blue-100">Premium placements, applicant tracking, and shortlists from our talent pool.</p>
            </div>
            <div class="flex flex-col sm:flex-row md:flex-col gap-3 justify-center md:justify-end">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-semibold px-6 py-3 rounded-lg hover:bg-blue-50 transition">
                    Post a job
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 border border-white text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition">
                    Talk to sales
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
