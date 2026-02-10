@extends('layouts.app')

@section('title', 'Service Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="mt-2 text-gray-600">Manage your service applications and track their progress.</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 border-l-4 border-green-500">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Partner Program Section -->
    @if($partner)
        <div class="mb-8">
            @switch($partner->status)
                @case('pending_profile')
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 border-l-4 border-purple-500 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                            <svg class="h-5 w-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Partner Program
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">You've been selected as a partner candidate! Complete your business profile to proceed.</p>
                        <a href="{{ route('partner.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition shadow-sm">
                            Complete Partner Profile
                        </a>
                    </div>
                    @break
                @case('pending_review')
                    <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-500 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                            <svg class="h-5 w-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Partner Program - Under Review
                        </h3>
                        <p class="text-sm text-gray-600">Your partner profile is being reviewed. We'll notify you once a decision has been made.</p>
                    </div>
                    @break
                @case('active')
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1 flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Authorized Partner
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Ref: <span class="font-mono font-semibold">{{ $partner->reference_number }}</span> |
                                    Valid until: {{ $partner->expires_at?->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="flex gap-2">
                                @if($partner->certificate_path)
                                    <a href="{{ route('partner.certificate.download') }}" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Certificate
                                    </a>
                                @endif
                                <a href="{{ route('partner.profile.edit') }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                                    Profile
                                </a>
                            </div>
                        </div>
                    </div>
                    @break
                @case('suspended')
                    <div class="bg-gradient-to-r from-orange-50 to-red-50 border-l-4 border-orange-500 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 mr-2">Suspended</span>
                            Partner Program
                        </h3>
                        <p class="text-sm text-gray-600">Your partner account has been suspended. Please contact us for more information.</p>
                    </div>
                    @break
                @case('revoked')
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">Revoked</span>
                            Partner Program
                        </h3>
                        <p class="text-sm text-gray-600">Your partner account has been revoked.</p>
                    </div>
                    @break
            @endswitch
        </div>
    @endif

    <!-- Refer & Earn Section -->
    <div class="mb-8 bg-gradient-to-r from-purple-50 to-indigo-50 border-l-4 border-purple-500 rounded-lg p-6">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1 flex items-center">
                    <svg class="h-5 w-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                    </svg>
                    Refer & Earn
                </h3>
                @if($referralCode)
                    <p class="text-sm text-gray-600">
                        Your code: <span class="font-mono font-bold text-purple-700">{{ $referralCode->code }}</span>
                        <span class="text-gray-400 ml-2">{{ $referralCode->times_used }}/{{ $referralCode->max_uses }} uses</span>
                    </p>
                    @if($walletBalance > 0)
                        <p class="text-sm text-gray-600 mt-1">Wallet: <span class="font-semibold text-purple-700">&euro;{{ number_format($walletBalance, 2) }}</span></p>
                    @endif
                @else
                    <p class="text-sm text-gray-600">Complete a payment to get your referral code and start earning!</p>
                @endif
            </div>
            <a href="{{ route('service_user.wallet') }}" class="inline-flex items-center px-3 py-1.5 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">
                View Wallet
            </a>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    @if($upcomingAppointments->count() > 0)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Upcoming Appointments
                </h3>
                <a href="{{ route('service_user.appointments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All</a>
            </div>
            <div class="space-y-3">
                @foreach($upcomingAppointments as $appt)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 bg-indigo-100 rounded-lg">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $appt->consultationType->name }}</p>
                                <p class="text-xs text-gray-500">{{ $appt->appointment_date->format('M j, Y') }} &middot; {{ $appt->formatted_time }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $appt->status_color }}-100 text-{{ $appt->status_color }}-800">
                                {{ $appt->status_label }}
                            </span>
                            <a href="{{ route('service_user.appointments.show', $appt) }}" class="text-sm text-indigo-600 hover:text-indigo-800">View</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Draft Applications - Continue Where You Left Off -->
    @if($draftApplications->count() > 0)
        <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Continue Your Application
            </h3>
            <p class="text-sm text-gray-600 mb-4">You have incomplete applications. Pick up where you left off:</p>
            <div class="space-y-3">
                @foreach($draftApplications as $draft)
                    <div class="flex items-center justify-between bg-white rounded-lg p-4 border border-blue-200 shadow-sm">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 {{ $draft->certificate_type === 'greece' ? 'bg-amber-100' : ($draft->certificate_type === 'portugal' ? 'bg-green-100' : 'bg-blue-100') }} rounded-lg">
                                <svg class="h-5 w-5 {{ $draft->certificate_type === 'greece' ? 'text-amber-600' : ($draft->certificate_type === 'portugal' ? 'text-green-600' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $draft->application_reference }}</p>
                                <p class="text-xs text-gray-500">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium {{ $draft->certificate_type === 'greece' ? 'bg-amber-100 text-amber-700' : ($draft->certificate_type === 'portugal' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700') }} mr-1">
                                        {{ $draft->certificate_type === 'greece' ? 'Greece' : ($draft->certificate_type === 'portugal' ? 'Portugal' : 'UK') }}
                                    </span>
                                    @if($draft->first_name)
                                        {{ $draft->first_name }} {{ $draft->last_name }} ·
                                    @endif
                                    Step {{ $draft->next_step }} of {{ $draft->certificate_type === 'portugal' ? '6' : '7' }} · Started {{ $draft->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ $draft->certificate_type === 'greece' ? route('greece-certificate.resume', $draft->application_reference) : ($draft->certificate_type === 'portugal' ? route('portugal-certificate.resume', $draft->application_reference) : route('police-certificate.resume', $draft->application_reference)) }}"
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white {{ $draft->certificate_type === 'greece' ? 'bg-amber-600 hover:bg-amber-700' : ($draft->certificate_type === 'portugal' ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-700') }} rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Continue
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Quick Actions Needed -->
    @if($needsAction->count() > 0)
        <div class="mb-8 bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="h-5 w-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                Action Required
            </h3>
            <div class="space-y-3">
                @foreach($needsAction as $app)
                    <div class="flex items-center justify-between bg-white rounded-lg p-4 border border-yellow-200">
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $app->application_reference }}
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium {{ $app->certificate_type === 'greece' ? 'bg-amber-100 text-amber-700' : ($app->certificate_type === 'portugal' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700') }} ml-1">
                                    {{ $app->certificate_type === 'greece' ? 'Greece' : ($app->certificate_type === 'portugal' ? 'Portugal' : 'UK') }}
                                </span>
                            </p>
                            <p class="text-xs text-gray-500">Please upload payment receipt to proceed</p>
                        </div>
                        <a href="{{ $app->certificate_type === 'greece' ? route('greece-certificate.receipt.show', $app->application_reference) : ($app->certificate_type === 'portugal' ? route('portugal-certificate.receipt.show', $app->application_reference) : route('police-certificate.receipt.show', $app->application_reference)) }}"
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 transition">
                            Upload Receipt
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Applications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Applications</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalApplications }}</p>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingApplications }}</p>
                </div>
            </div>
        </div>

        <!-- Processing -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Processing</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $processingApplications }}</p>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $completedApplications }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- UK Police Certificate -->
            <a href="{{ route('police-certificate.step', ['step' => 1]) }}"
               class="flex items-center p-4 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl text-white hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                <div class="p-3 bg-white/20 rounded-lg mr-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">UK Police Certificate</p>
                    <p class="text-sm text-blue-100">Apply for UK PCC</p>
                </div>
            </a>

            <!-- Portugal Criminal Record -->
            <a href="{{ route('portugal-certificate.step', ['step' => 1]) }}"
               class="flex items-center p-4 bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl text-white hover:from-green-700 hover:to-emerald-700 transition shadow-lg">
                <div class="p-3 bg-white/20 rounded-lg mr-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Portugal Certificate</p>
                    <p class="text-sm text-green-100">Criminal Record</p>
                </div>
            </a>

            <!-- Greece Penal Record -->
            <a href="{{ route('greece-certificate.step', ['step' => 1]) }}"
               class="flex items-center p-4 bg-gradient-to-r from-amber-500 to-yellow-600 rounded-xl text-white hover:from-amber-600 hover:to-yellow-700 transition shadow-lg">
                <div class="p-3 bg-white/20 rounded-lg mr-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Greece Certificate</p>
                    <p class="text-sm text-amber-100">Penal Record</p>
                </div>
            </a>

            <!-- UK Info -->
            <a href="{{ route('police-certificate.index') }}"
               class="flex items-center p-4 bg-white border border-gray-200 rounded-xl text-gray-900 hover:bg-gray-50 transition shadow-sm">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">UK Info</p>
                    <p class="text-sm text-gray-500">Learn more</p>
                </div>
            </a>

            <!-- Portugal Info -->
            <a href="{{ route('portugal-certificate.index') }}"
               class="flex items-center p-4 bg-white border border-gray-200 rounded-xl text-gray-900 hover:bg-gray-50 transition shadow-sm">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Portugal Info</p>
                    <p class="text-sm text-gray-500">Learn more</p>
                </div>
            </a>

            <!-- Greece Info -->
            <a href="{{ route('greece-certificate.index') }}"
               class="flex items-center p-4 bg-white border border-gray-200 rounded-xl text-gray-900 hover:bg-gray-50 transition shadow-sm">
                <div class="p-3 bg-amber-100 rounded-lg mr-4">
                    <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Greece Info</p>
                    <p class="text-sm text-gray-500">Learn more</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Applications</h2>
        </div>

        @if($recentApplications->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($recentApplications as $application)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 {{ $application->certificate_type === 'greece' ? 'bg-amber-100' : ($application->certificate_type === 'portugal' ? 'bg-green-100' : 'bg-blue-100') }} rounded-lg">
                                <svg class="h-5 w-5 {{ $application->certificate_type === 'greece' ? 'text-amber-600' : ($application->certificate_type === 'portugal' ? 'text-green-600' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $application->application_reference }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $application->certificate_label }} - {{ $application->service_type_label }}
                                    @if($application->submitted_at)
                                        <span class="mx-1">|</span> Submitted {{ $application->submitted_at->format('M d, Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($application->status)
                                    @case('draft') bg-gray-100 text-gray-800 @break
                                    @case('submitted') bg-blue-100 text-blue-800 @break
                                    @case('payment_pending') bg-yellow-100 text-yellow-800 @break
                                    @case('payment_verified') bg-green-100 text-green-800 @break
                                    @case('processing') bg-indigo-100 text-indigo-800 @break
                                    @case('completed') bg-emerald-100 text-emerald-800 @break
                                    @case('rejected') bg-red-100 text-red-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch
                            ">
                                {{ $application->status_label }}
                            </span>
                            @if($application->status === 'submitted')
                                <a href="{{ $application->certificate_type === 'greece' ? route('greece-certificate.receipt.show', $application->application_reference) : ($application->certificate_type === 'portugal' ? route('portugal-certificate.receipt.show', $application->application_reference) : route('police-certificate.receipt.show', $application->application_reference)) }}"
                                   class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    Upload Receipt
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating your first application.</p>
                <div class="mt-6 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('police-certificate.step', ['step' => 1]) }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        UK Certificate
                    </a>
                    <a href="{{ route('portugal-certificate.step', ['step' => 1]) }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Portugal Certificate
                    </a>
                    <a href="{{ route('greece-certificate.step', ['step' => 1]) }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Greece Certificate
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
