{{-- Mega Menu Component for PlaceMeNet --}}
{{-- Uses Alpine.js for interactivity and Tailwind for styling --}}

<nav class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="group flex items-center gap-3">
                    <div class="relative">
                        <span class="absolute -inset-1 rounded-2xl bg-white/10 blur-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        <div class="relative flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-2xl border border-white/30 bg-white/15 backdrop-blur-md shadow-lg transition-all duration-300 group-hover:border-white/70 group-hover:bg-white/25">
                            <img src="{{ asset('assets/images/logo.jpg') }}" alt="PlaceMeNet" class="logo-sequence h-6 sm:h-8 w-auto object-contain drop-shadow-lg">
                        </div>
                    </div>
                    <div class="hidden sm:block leading-tight">
                        <p class="text-white font-semibold tracking-wide">PlaceMeNet</p>
                        <p class="text-xs text-white/70 uppercase tracking-[0.25em]">Career Network</p>
                    </div>
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex lg:items-center lg:space-x-1">
                {{-- Jobs Dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false" @keydown.escape.window="open = false">
                    <button @click="open = !open" type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white/90 hover:text-white rounded-lg hover:bg-white/10 transition-all" :class="open ? 'bg-white/10 text-white' : ''">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ __('Jobs') }}
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-2 w-80 bg-white/95 backdrop-blur-lg rounded-xl shadow-2xl border border-blue-100 overflow-hidden z-[100]" style="display: none;">
                        <div class="p-4">
                            <div class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-100">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ __('Jobs & Careers') }}</h3>
                                    <p class="text-xs text-gray-500">Find your dream job</p>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <a href="{{ route('jobs.index') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <span class="text-sm text-gray-700">{{ __('Browse Jobs') }}</span>
                                </a>
                                @auth
                                    @if(auth()->user()->hasRole('job_seeker'))
                                        <a href="{{ route('jobseeker.applications.index') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ __('My Applications') }}</span>
                                        </a>
                                        <a href="{{ route('jobseeker.saved.index') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ __('Saved Jobs') }}</span>
                                        </a>
                                        <a href="{{ route('jobseeker.alerts.index') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ __('Job Alerts') }}</span>
                                        </a>
                                    @endif
                                @endauth
                            </div>
                            @guest
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 w-full py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        {{ __('Sign up as Job Seeker') }}
                                    </a>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>

                {{-- Employers Dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false" @keydown.escape.window="open = false">
                    <button @click="open = !open" type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white/90 hover:text-white rounded-lg hover:bg-white/10 transition-all" :class="open ? 'bg-white/10 text-white' : ''">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        {{ __('Employers') }}
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-2 w-80 bg-white/95 backdrop-blur-lg rounded-xl shadow-2xl border border-blue-100 overflow-hidden z-[100]" style="display: none;">
                        <div class="p-4">
                            <div class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-100">
                                <div class="p-2 bg-indigo-100 rounded-lg">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ __('For Employers') }}</h3>
                                    <p class="text-xs text-gray-500">Hire the best talent</p>
                                </div>
                            </div>
                            <div class="space-y-1">
                                @auth
                                    @if(auth()->user()->hasRole('employer'))
                                        <a href="{{ route('employer.dashboard') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-50 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ __('Dashboard') }}</span>
                                        </a>
                                        <a href="{{ route('employer.jobs.create') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-50 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ __('Post a Job') }}</span>
                                        </a>
                                        <a href="{{ route('employer.jobs.index') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-50 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ __('My Jobs') }}</span>
                                        </a>
                                        <a href="{{ route('employer.applicants.index') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-50 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ __('Applications') }}</span>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-50 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ __('Employer Login') }}</span>
                                        </a>
                                    @endif
                                @endauth
                                @guest
                                    <a href="{{ route('login') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-50 transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ __('Employer Login') }}</span>
                                    </a>
                                    <a href="{{ route('register') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-50 transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ __('Register Company') }}</span>
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Education Dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false" @keydown.escape.window="open = false">
                    <button @click="open = !open" type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white/90 hover:text-white rounded-lg hover:bg-white/10 transition-all" :class="open ? 'bg-white/10 text-white' : ''">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        {{ __('Education') }}
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-2 w-96 bg-white/95 backdrop-blur-lg rounded-xl shadow-2xl border border-blue-100 overflow-hidden z-[100]" style="display: none;">
                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-4">
                                {{-- For Students --}}
                                <div>
                                    <div class="flex items-center gap-2 mb-2 pb-2 border-b border-gray-100">
                                        <div class="p-1.5 bg-green-100 rounded-lg">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-900 text-sm">{{ __('For Students') }}</h4>
                                    </div>
                                    <div class="space-y-1">
                                        <a href="{{ route('study-programs.index') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-green-50 transition-colors text-sm text-gray-700">
                                            {{ __('Browse Programs') }}
                                        </a>
                                        @auth
                                            @if(auth()->user()->hasRole('student'))
                                                <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-green-50 transition-colors text-sm text-gray-700">
                                                    {{ __('My Dashboard') }}
                                                </a>
                                            @endif
                                        @endauth
                                    </div>
                                </div>

                                {{-- For Institutions --}}
                                <div>
                                    <div class="flex items-center gap-2 mb-2 pb-2 border-b border-gray-100">
                                        <div class="p-1.5 bg-purple-100 rounded-lg">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-900 text-sm">{{ __('Institutions') }}</h4>
                                    </div>
                                    <div class="space-y-1">
                                        @auth
                                            @if(auth()->user()->hasRole('educational_institution'))
                                                <a href="{{ route('institution.dashboard') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-purple-50 transition-colors text-sm text-gray-700">
                                                    {{ __('Dashboard') }}
                                                </a>
                                                <a href="{{ route('institution.programs.index') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-purple-50 transition-colors text-sm text-gray-700">
                                                    {{ __('My Programs') }}
                                                </a>
                                            @else
                                                <a href="{{ route('register') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-purple-50 transition-colors text-sm text-gray-700">
                                                    {{ __('Register') }}
                                                </a>
                                            @endif
                                        @endauth
                                        @guest
                                            <a href="{{ route('register') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-purple-50 transition-colors text-sm text-gray-700">
                                                {{ __('Register Institution') }}
                                            </a>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Services Dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false" @keydown.escape.window="open = false">
                    <button @click="open = !open" type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white/90 hover:text-white rounded-lg hover:bg-white/10 transition-all" :class="open ? 'bg-white/10 text-white' : ''">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        {{ __('Services') }}
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-2 w-72 bg-white/95 backdrop-blur-lg rounded-xl shadow-2xl border border-blue-100 overflow-hidden z-[100]" style="display: none;">
                        <div class="p-2">
                            @auth
                                @if(auth()->user()->hasRole('service_user'))
                                    <a href="{{ route('service_user.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-indigo-50 transition-colors border-b border-gray-100 mb-2">
                                        <div class="p-2 bg-indigo-100 rounded-lg">
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">{{ __('My Services Dashboard') }}</p>
                                            <p class="text-xs text-gray-500">Track your applications</p>
                                        </div>
                                    </a>
                                @endif
                            @endauth
                            <a href="{{ route('visa.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-amber-50 transition-colors">
                                <div class="p-2 bg-amber-100 rounded-lg">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ __('Visa & Residency') }}</p>
                                    <p class="text-xs text-gray-500">Immigration services</p>
                                </div>
                            </a>
                            <a href="{{ route('police-certificate.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ __('UK Police Certificate') }}</p>
                                    <p class="text-xs text-gray-500">ACRO service</p>
                                </div>
                            </a>
                            <a href="{{ route('portugal-certificate.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ __('Portugal Certificate') }}</p>
                                    <p class="text-xs text-gray-500">Criminal Record</p>
                                </div>
                            </a>
                            <a href="{{ route('greece-certificate.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-amber-50 transition-colors">
                                <div class="p-2 bg-amber-100 rounded-lg">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ __('Greece Certificate') }}</p>
                                    <p class="text-xs text-gray-500">Penal Record</p>
                                </div>
                            </a>
                            <a href="{{ route('blogs.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-rose-50 transition-colors">
                                <div class="p-2 bg-rose-100 rounded-lg">
                                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ __('Blog & Resources') }}</p>
                                    <p class="text-xs text-gray-500">Career tips & news</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- About Link --}}
                <a href="{{ route('about') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white/90 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    {{ __('About') }}
                </a>

                {{-- Contact Link --}}
                <a href="{{ route('contact') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white/90 hover:text-white rounded-lg hover:bg-white/10 transition-all">
                    {{ __('Contact') }}
                </a>
            </div>

            {{-- Right Side: Language + Auth --}}
            <div class="hidden lg:flex lg:items-center lg:space-x-3">
                {{-- Language Switcher --}}
                @php($localeLabels = ['en' => 'EN', 'es' => 'ES', 'el' => 'EL', 'pt' => 'PT', 'sq' => 'SQ'])
                @php($currentLocale = app()->getLocale())
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <form method="POST" action="{{ route('locale.switch') }}" x-ref="localeForm">
                        @csrf
                        <input type="hidden" name="locale" x-ref="localeInput">
                    </form>
                    <button @click="open = !open" type="button" class="inline-flex items-center gap-1 px-3 py-2 bg-white/10 text-white text-sm font-medium rounded-lg hover:bg-white/20 transition">
                        {{ $localeLabels[$currentLocale] ?? strtoupper($currentLocale) }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-24 bg-white/95 backdrop-blur-lg rounded-lg shadow-xl border border-blue-100 py-1 z-[100]" style="display: none;">
                        @foreach(config('app.available_locales', ['en']) as $locale)
                            <button type="button" @click="$refs.localeInput.value = '{{ $locale }}'; $refs.localeForm.submit();" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                {{ $localeLabels[$locale] ?? strtoupper($locale) }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Auth Buttons --}}
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-white/10 text-white text-sm font-medium rounded-lg hover:bg-white/20 transition">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-yellow-400 text-blue-900 text-sm font-semibold rounded-lg hover:bg-yellow-300 transition shadow-lg">
                        {{ __('Get Started') }}
                    </a>
                @else
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" type="button" class="flex items-center gap-2 px-3 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white text-sm font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white/95 backdrop-blur-lg rounded-xl shadow-xl border border-blue-100 py-2 z-[100]" style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Admin Panel') }}</a>
                            @elseif(auth()->user()->hasRole('job_seeker'))
                                <a href="{{ route('jobseeker.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Dashboard') }}</a>
                                <a href="{{ route('jobseeker.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('My Profile') }}</a>
                            @elseif(auth()->user()->hasRole('employer'))
                                <a href="{{ route('employer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Dashboard') }}</a>
                            @elseif(auth()->user()->hasRole('educational_institution'))
                                <a href="{{ route('institution.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Dashboard') }}</a>
                            @elseif(auth()->user()->hasRole('student'))
                                <a href="{{ route('student.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Dashboard') }}</a>
                            @elseif(auth()->user()->hasRole('service_user'))
                                <a href="{{ route('service_user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('My Services') }}</a>
                            @endif
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">{{ __('Logout') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            {{-- Mobile Menu Button --}}
            <div class="flex items-center lg:hidden" x-data="{ mobileOpen: false }">
                <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 rounded-lg text-white hover:bg-white/10 transition">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Mobile Menu Panel --}}
                <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[200] lg:hidden" style="display: none;">
                    {{-- Backdrop --}}
                    <div class="fixed inset-0 bg-black/50" @click="mobileOpen = false"></div>

                    {{-- Panel --}}
                    <div class="fixed top-0 right-0 w-80 max-w-full h-full bg-gradient-to-b from-blue-700 to-indigo-800 shadow-2xl overflow-y-auto">
                        <div class="p-4">
                            {{-- Close Button --}}
                            <div class="flex justify-end mb-4">
                                <button @click="mobileOpen = false" class="p-2 text-white/80 hover:text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Mobile Links --}}
                            <div class="space-y-2">
                                <a href="{{ route('jobs.index') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('Browse Jobs') }}</a>
                                <a href="{{ route('study-programs.index') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('Study Programs') }}</a>
                                <a href="{{ route('visa.index') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('Visa & Residency') }}</a>

                                {{-- Certificate Services --}}
                                <div class="border-t border-white/20 my-2 pt-2">
                                    <p class="px-4 py-1 text-white/60 text-xs font-semibold uppercase tracking-wider">{{ __('Certificate Services') }}</p>
                                    <a href="{{ route('police-certificate.index') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('UK Police Certificate') }}</a>
                                    <a href="{{ route('portugal-certificate.index') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('Portugal Certificate') }}</a>
                                    <a href="{{ route('greece-certificate.index') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('Greece Certificate') }}</a>
                                </div>

                                <a href="{{ route('blogs.index') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('Blog') }}</a>
                                <a href="{{ route('about') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('About') }}</a>
                                <a href="{{ route('contact') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('Contact') }}</a>

                                @auth
                                    <div class="border-t border-white/20 my-4 pt-4">
                                        @if(auth()->user()->hasRole('job_seeker'))
                                            <a href="{{ route('jobseeker.dashboard') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('My Dashboard') }}</a>
                                            <a href="{{ route('jobseeker.applications.index') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('My Applications') }}</a>
                                        @elseif(auth()->user()->hasRole('employer'))
                                            <a href="{{ route('employer.dashboard') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('Employer Dashboard') }}</a>
                                        @elseif(auth()->user()->hasRole('educational_institution'))
                                            <a href="{{ route('institution.dashboard') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('Institution Dashboard') }}</a>
                                        @elseif(auth()->user()->hasRole('admin'))
                                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('Admin Panel') }}</a>
                                        @elseif(auth()->user()->hasRole('service_user'))
                                            <a href="{{ route('service_user.dashboard') }}" class="block px-4 py-3 text-white rounded-lg hover:bg-white/10">{{ __('My Services Dashboard') }}</a>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-3 bg-red-500/20 text-red-200 rounded-lg hover:bg-red-500/30 text-left">{{ __('Logout') }}</button>
                                    </form>
                                @else
                                    <div class="border-t border-white/20 my-4 pt-4 space-y-2">
                                        <a href="{{ route('login') }}" class="block px-4 py-3 text-white bg-white/10 rounded-lg text-center font-medium">{{ __('Login') }}</a>
                                        <a href="{{ route('register') }}" class="block px-4 py-3 bg-yellow-400 text-blue-900 rounded-lg text-center font-semibold">{{ __('Get Started') }}</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
