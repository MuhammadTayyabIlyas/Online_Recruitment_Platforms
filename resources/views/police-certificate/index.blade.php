@extends('layouts.app')

@section('title', 'UK Police Character Certificate')
@section('meta_description', 'Apply for UK Police Character Certificate for Spanish immigration. Fast processing for Pakistani nationals.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6 backdrop-blur-sm">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                    UK Police Character Certificate
                </h1>
                
                <p class="text-xl text-blue-100 max-w-3xl mx-auto mb-8">
                    For Pakistani nationals residing in Spain applying for Spanish immigration. 
                    Get your UK criminal record check processed efficiently.
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

    <!-- Pricing Section -->
    <div id="pricing" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Service Pricing</h2>
            <p class="text-lg text-gray-600">Transparent pricing with no hidden fees</p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Normal Service -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-100 hover:border-blue-300 transition-colors">
                <div class="p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Normal Service</h3>
                    <p class="text-gray-500 mb-6">14 working days processing</p>
                    
                    <div class="space-y-3 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">GBP</span>
                            <span class="text-3xl font-bold text-gray-900">£100</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">EUR</span>
                            <span class="text-3xl font-bold text-gray-900">€120</span>
                        </div>
                    </div>
                    
                    <ul class="space-y-3 text-gray-600">
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
                    </ul>
                </div>
                <div class="p-6 bg-gray-50">
                    @auth
                        <a href="{{ route('police-certificate.step', ['step' => 1]) }}"
                           class="block w-full py-3 px-4 text-center font-semibold text-blue-700 bg-white border-2 border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white transition-colors">
                            Select Normal
                        </a>
                    @else
                        <a href="{{ route('register') }}?user_type=service_user&redirect={{ urlencode(route('police-certificate.step', ['step' => 1])) }}"
                           class="block w-full py-3 px-4 text-center font-semibold text-blue-700 bg-white border-2 border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white transition-colors">
                            Select Normal
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Urgent Service -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-blue-500 relative">
                <div class="absolute top-0 right-0 bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                    POPULAR
                </div>
                <div class="p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Urgent Service</h3>
                    <p class="text-gray-500 mb-6">7 working days processing</p>

                    <div class="space-y-3 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">GBP</span>
                            <span class="text-3xl font-bold text-blue-600">£150</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">EUR</span>
                            <span class="text-3xl font-bold text-blue-600">€180</span>
                        </div>
                    </div>

                    <ul class="space-y-3 text-gray-600">
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
                            Faster delivery
                        </li>
                    </ul>
                </div>
                <div class="p-6 bg-blue-50">
                    @auth
                        <a href="{{ route('police-certificate.step', ['step' => 1]) }}"
                           class="block w-full py-3 px-4 text-center font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            Select Urgent
                        </a>
                    @else
                        <a href="{{ route('register') }}?user_type=service_user&redirect={{ urlencode(route('police-certificate.step', ['step' => 1])) }}"
                           class="block w-full py-3 px-4 text-center font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            Select Urgent
                        </a>
                    @endauth
                </div>
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