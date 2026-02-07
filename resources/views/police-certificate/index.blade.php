@extends('layouts.app')

@section('title', 'UK Police Character Certificate')
@section('meta_description', 'Apply for UK Police Character Certificate for Spanish immigration. Fast processing for Pakistani nationals.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <!-- Hero Section with UK imagery -->
    <div class="relative overflow-hidden">
        <!-- Background image of London/Big Ben -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=1920&q=80"
                 alt="London, United Kingdom - Big Ben and Westminster"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-indigo-900/85"></div>
        </div>

        <!-- Union Jack pattern overlay -->
        <div class="absolute inset-0 opacity-5">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <pattern id="union" width="50" height="50" patternUnits="userSpaceOnUse">
                    <rect width="50" height="50" fill="none"/>
                    <line x1="0" y1="25" x2="50" y2="25" stroke="white" stroke-width="8"/>
                    <line x1="25" y1="0" x2="25" y2="50" stroke="white" stroke-width="8"/>
                    <line x1="0" y1="0" x2="50" y2="50" stroke="white" stroke-width="3"/>
                    <line x1="50" y1="0" x2="0" y2="50" stroke="white" stroke-width="3"/>
                </pattern>
                <rect width="100" height="100" fill="url(#union)"/>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="text-center">
                <!-- UK flag colors indicator -->
                <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium mb-6">
                    <span class="flex gap-1 mr-2">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        <span class="w-2 h-2 bg-white rounded-full"></span>
                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    </span>
                    Official ACRO Document Assistance Service
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                    UK Police Character Certificate
                </h1>

                <p class="text-xl text-blue-100 max-w-3xl mx-auto mb-8">
                    For Pakistani nationals residing in Spain applying for Spanish immigration.
                    Get your UK criminal record check (ACRO Certificate) processed efficiently.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('police-certificate.step', ['step' => 1]) }}"
                           class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-blue-700 bg-white rounded-lg shadow-lg hover:bg-blue-50 transition-all transform hover:scale-105">
                            Start Application
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}?user_type=service_user&redirect={{ urlencode(route('police-certificate.step', ['step' => 1])) }}"
                           class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-blue-700 bg-white rounded-lg shadow-lg hover:bg-blue-50 transition-all transform hover:scale-105">
                            Create Account & Apply
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}?redirect={{ urlencode(route('police-certificate.step', ['step' => 1])) }}"
                           class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white border-2 border-white rounded-lg hover:bg-white/10 transition-all">
                            Already Have Account? Login
                        </a>
                    @endauth

                    <a href="#pricing"
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white border-2 border-white rounded-lg hover:bg-white/10 transition-all">
                        View Pricing
                    </a>
                    <a href="#legal-notice"
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white/80 hover:text-white transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Legal Notice
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Wave decoration -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="url(#gradient)"/>
                <defs>
                    <linearGradient id="gradient" x1="0" y1="0" x2="1440" y2="0">
                        <stop offset="0%" stop-color="#EFF6FF"/>
                        <stop offset="100%" stop-color="#EEF2FF"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Simple Process</h3>
                <p class="text-gray-600">Complete your application in 7 easy steps. Auto-save feature ensures you never lose progress.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Fast Processing</h3>
                <p class="text-gray-600">Choose Normal (14 days) or Urgent (7 days) service. Track your application status online.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Secure & Confidential</h3>
                <p class="text-gray-600">Your documents and personal information are encrypted and handled with strict confidentiality.</p>
            </div>
        </div>
    </div>

    <!-- Required Documents Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="grid lg:grid-cols-2">
                <div class="p-8 lg:p-12">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Required Documents</h2>
                    </div>
                    <p class="text-gray-600 mb-6">Please have these documents ready before starting your application:</p>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Valid Passport</span>
                                <p class="text-sm text-gray-500">Clear color scan of your Pakistani passport (all pages with stamps)</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">CNIC / NICOP</span>
                                <p class="text-sm text-gray-500">Front and back scan of your National ID card</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Proof of UK Residence</span>
                                <p class="text-sm text-gray-500">Previous UK visa, BRP card, or utility bills showing UK address</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Current Spanish Address</span>
                                <p class="text-sm text-gray-500">Proof of your current residence in Spain (NIE, Empadronamiento)</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Passport Photo</span>
                                <p class="text-sm text-gray-500">Recent passport-sized photo (white background)</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-8 lg:p-12 flex items-center justify-center">
                    <div class="text-center text-white">
                        <svg class="w-20 h-20 mx-auto mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-lg font-semibold mb-2">All Documents Digital</p>
                        <p class="text-blue-200 text-sm">Upload clear scans or photos in JPG, PNG, or PDF format</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Processing Timeline Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-gray-50 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Processing Timeline</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Here's what happens after you submit your application</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Normal Service Timeline -->
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-10 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3 text-xs font-bold">15-20</span>
                        Normal Service (15-20 Working Days)
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-24 flex-shrink-0 text-sm font-semibold text-blue-600">Day 1-2</div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Document Verification</p>
                                <p class="text-sm text-gray-500">We review your documents for accuracy and completeness</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-24 flex-shrink-0 text-sm font-semibold text-blue-600">Day 3-5</div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Application Preparation</p>
                                <p class="text-sm text-gray-500">We prepare and format your ACRO application</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-24 flex-shrink-0 text-sm font-semibold text-blue-600">Day 6-8</div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Submission to ACRO</p>
                                <p class="text-sm text-gray-500">Application submitted to UK authorities</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-24 flex-shrink-0 text-sm font-semibold text-blue-600">Day 9-18</div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">ACRO Processing</p>
                                <p class="text-sm text-gray-500">Official processing by ACRO Criminal Records Office</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-24 flex-shrink-0 text-sm font-semibold text-blue-600">Day 19-20</div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Certificate Delivery</p>
                                <p class="text-sm text-gray-500">Digital certificate sent to your email</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Express Service Timeline -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-8 shadow-lg text-white">
                    <h3 class="text-xl font-bold mb-6 flex items-center">
                        <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 text-sm font-bold">2-5</span>
                        Express Service (2-5 Working Days)
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-24 flex-shrink-0 text-sm font-semibold text-blue-200">Day 1</div>
                            <div class="flex-1">
                                <p class="font-medium">Priority Document Review</p>
                                <p class="text-sm text-blue-200">Same-day verification and preparation</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-24 flex-shrink-0 text-sm font-semibold text-blue-200">Day 1-2</div>
                            <div class="flex-1">
                                <p class="font-medium">Express Submission</p>
                                <p class="text-sm text-blue-200">Priority submission to ACRO</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-24 flex-shrink-0 text-sm font-semibold text-blue-200">Day 2-4</div>
                            <div class="flex-1">
                                <p class="font-medium">Fast-Track Processing</p>
                                <p class="text-sm text-blue-200">Priority queue at ACRO</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-24 flex-shrink-0 text-sm font-semibold text-blue-200">Day 4-5</div>
                            <div class="flex-1">
                                <p class="font-medium">Express Delivery</p>
                                <p class="text-sm text-blue-200">Certificate delivered digitally</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-center text-sm text-gray-500 mt-6">
                * Processing times are estimates based on typical cases. Actual times may vary depending on ACRO workload and document complexity.
            </p>
        </div>
    </div>

    <!-- Who Can Apply Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="grid lg:grid-cols-2">
                <div class="p-8 lg:p-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Who Can Apply?</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Pakistani nationals currently residing in Spain</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Previously lived in the UK under any visa category</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Applying for Spanish immigration or residency</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Have valid Pakistani passport and CNIC/NICOP</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-8 lg:p-12 flex items-center justify-center">
                    <div class="text-center text-white">
                        <svg class="w-24 h-24 mx-auto mb-6 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-lg opacity-90">Serving Pakistani community across Spain</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jurisdiction Notice -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-blue-900 mb-1">Jurisdiction Notice</h3>
                    <p class="text-sm text-blue-800">
                        This service is provided by <strong>PlaceMeNet Ltd</strong>, a company registered in England and Wales. UK law applies to this service.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Options Section -->
    <div id="pricing" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Service Options</h2>
            <p class="text-lg text-gray-600">Choose the service that best fits your timeline</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Normal Service -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-100 hover:border-blue-300 transition-colors">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Normal Service</h3>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-sm font-medium rounded-full">Standard</span>
                    </div>
                    <p class="text-blue-600 font-semibold mb-6">15-20 working days processing</p>

                    <ul class="space-y-3 text-gray-600 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Complete application processing
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Document verification
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Email support
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Status tracking
                        </li>
                    </ul>

                    <div class="bg-blue-50 rounded-xl p-4 mb-6">
                        <p class="text-sm text-blue-800">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pricing details will be provided after you start your application
                        </p>
                    </div>
                </div>
                <div class="p-6 bg-gray-50">
                    @auth
                        <a href="{{ route('police-certificate.step', ['step' => 1]) }}"
                           class="block w-full py-3 px-4 text-center font-semibold text-blue-700 bg-white border-2 border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white transition-colors">
                            Start Application
                        </a>
                    @else
                        <a href="{{ route('register') }}?user_type=service_user&redirect={{ urlencode(route('police-certificate.step', ['step' => 1])) }}"
                           class="block w-full py-3 px-4 text-center font-semibold text-blue-700 bg-white border-2 border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white transition-colors">
                            Start Application
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Express Service -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-blue-500 relative">
                <div class="absolute top-0 right-0 bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                    FASTEST
                </div>
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Express Service</h3>
                        <span class="px-3 py-1 bg-blue-100 text-blue-600 text-sm font-medium rounded-full">Priority</span>
                    </div>
                    <p class="text-blue-600 font-semibold mb-6">2-5 working days processing</p>

                    <ul class="space-y-3 text-gray-600 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Priority processing
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Express document handling
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            WhatsApp support
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Dedicated case handler
                        </li>
                    </ul>

                    <div class="bg-blue-50 rounded-xl p-4 mb-6">
                        <p class="text-sm text-blue-800">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pricing details will be provided after you start your application
                        </p>
                    </div>
                </div>
                <div class="p-6 bg-blue-50">
                    @auth
                        <a href="{{ route('police-certificate.step', ['step' => 1]) }}"
                           class="block w-full py-3 px-4 text-center font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            Start Application
                        </a>
                    @else
                        <a href="{{ route('register') }}?user_type=service_user&redirect={{ urlencode(route('police-certificate.step', ['step' => 1])) }}"
                           class="block w-full py-3 px-4 text-center font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            Start Application
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <p class="text-center text-sm text-gray-500 mt-8">
            Service fees will be communicated during the application process or via email. No payment required to start your application.
        </p>
    </div>

    <!-- Refund & Cancellation Policy -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-amber-900 mb-2">Refund & Cancellation Policy</h3>
                    <div class="text-sm text-amber-800 space-y-2">
                        <p><strong>Full Refund:</strong> Cancel within 24 hours of payment if we haven't started processing your application.</p>
                        <p><strong>Partial Refund (50%):</strong> Cancel after 24 hours but before submission to ACRO.</p>
                        <p><strong>No Refund:</strong> Once your application has been submitted to ACRO, no refund is possible as official fees are non-recoverable.</p>
                        <p class="text-amber-600 text-xs mt-2">* All refund requests must be made in writing to support@placemenet.net</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Need Help Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-gradient-to-r from-blue-700 to-red-600 rounded-3xl p-8 md:p-12 text-white">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">Need Help?</h2>
                    <p class="text-blue-100 mb-6">
                        Have questions about the UK Police Certificate (ACRO) process? Our team is here to help you in English, Urdu, and other languages.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-200 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-blue-100">Mon - Fri: 9:00 AM - 6:00 PM (GMT)</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-200 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-blue-100">support@placemenet.net</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-end">
                    <a href="https://wa.me/447424604646?text={{ urlencode('Hello, I\'m interested in getting a UK Police Certificate (ACRO). Can you please help me with the application process?') }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center px-6 py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition shadow-lg">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WhatsApp UK
                    </a>
                    <a href="tel:+447424604646"
                       class="inline-flex items-center justify-center px-6 py-4 bg-white/20 hover:bg-white/30 text-white font-bold rounded-xl transition">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        +44 7424 604 646
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Legal Notice Section -->
    <div id="legal-notice" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Important Legal Notice</h2>
            </div>

            <p class="text-gray-600 mb-8 text-lg">
                <strong>PlaceMeNet Disclaimer for ACRO Police Certificate Assistance</strong>
            </p>

            <div class="space-y-6 text-gray-700">
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">1. Independent Service Provider</h3>
                    <p>PlaceMeNet ("we", "us", "our") is an independent service provider assisting individuals with document preparation and submission guidance in relation to criminal record certificates that are requested from the ACRO Criminal Records Office ("ACRO Police Certificates"). We are not a government agency, regulator, or part of ACRO or any UK law enforcement body, and our services are not required to obtain an ACRO Police Certificate.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">2. No Guarantee of Outcome</h3>
                    <p>PlaceMeNet does not guarantee that any application for a Police Certificate, International Child Protection Certificate (ICPC), or similar verification will be accepted, approved, processed, issued, or accepted by ACRO Criminal Records Office, any Foreign and Commonwealth & Development Office (FCDO) legalisation authority, UK visas and immigration, or any third-party visa, consulate, or foreign authority. All such decisions are made solely by the relevant issuing authority.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">3. ACRO Terms & Conditions</h3>
                    <p>Users acknowledge that ACRO's own terms and conditions (as published on <a href="https://www.acro.police.uk" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">ACRO's official website</a>) govern the issuance of Police Certificates. These terms include requirements relating to application accuracy, applicant identity, supporting documentation, and ACRO's processing rules. Users must review and accept those terms directly with ACRO.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">4. Applicant Responsibility</h3>
                    <p>You are responsible for providing accurate and complete information, including identity documentation, address history, contact information, and reasons for application. PlaceMeNet will assist with submission support, but you retain responsibility for your application and compliance with all legal requirements.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">5. Data Protection & Confidentiality</h3>
                    <p>Any personal data you provide to PlaceMeNet will be processed in accordance with our <a href="{{ route('privacy') }}" class="text-blue-600 hover:underline">Privacy Policy</a> and applicable data protection laws, including UK GDPR. PlaceMeNet does not share your data with ACRO or other authorities without your consent, except where required to complete an application or where required by law.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">6. No Legal Advice</h3>
                    <p>PlaceMeNet does not provide legal advice. If you require legal interpretation of ACRO's terms, visa rules, international requirements (including apostille/legalisation steps), or immigration law, you should seek qualified legal counsel.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">7. Fees and Payments</h3>
                    <p>PlaceMeNet charges fees for its services separately from ACRO's official fees. You acknowledge that ACRO's official fees and delivery charges (as set by ACRO at the time of your application) are not included in PlaceMeNet's service fees, unless explicitly stated.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">8. Third-Party Services</h3>
                    <p>If PlaceMeNet refers you to any third-party providers (for translations, document legalisation, courier services, etc.), PlaceMeNet is not responsible for the performance, conduct, or pricing of those third parties.</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-gray-900 mb-2">9. Limitation of Liability</h3>
                    <p>To the maximum extent permitted by law, PlaceMeNet's total liability to you for all claims arising out of or relating to our services is limited to the total fees you have paid to PlaceMeNet for those services.</p>
                </div>
            </div>

            <div class="mt-8 p-4 bg-amber-50 rounded-xl border border-amber-200">
                <p class="text-amber-800 text-sm">
                    <strong>By using our services, you acknowledge that you have read, understood, and agree to this disclaimer.</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 md:p-12 text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Begin your UK Police Character Certificate application now. 
                The process takes approximately 20 minutes to complete.
            </p>
            @auth
                <a href="{{ route('police-certificate.step', ['step' => 1]) }}"
                   class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-blue-700 bg-white rounded-lg shadow-lg hover:bg-blue-50 transition-all transform hover:scale-105">
                    Start Application Now
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            @else
                <a href="{{ route('register') }}?user_type=service_user&redirect={{ urlencode(route('police-certificate.step', ['step' => 1])) }}"
                   class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-blue-700 bg-white rounded-lg shadow-lg hover:bg-blue-50 transition-all transform hover:scale-105">
                    Create Account & Apply
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection