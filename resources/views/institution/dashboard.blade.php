@extends('layouts.employer')

@section('title', 'Institution Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="mt-2 text-gray-600">Manage your programs and engage with prospective students.</p>
    </div>

    <!-- Onboarding Checklist (if not completed) -->
    @if(!$onboardingComplete)
        <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6 shadow-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Complete Your Setup</h3>
                    <p class="text-sm text-gray-700 mb-4">Just a few more steps to start attracting students!</p>

                    <div class="space-y-3">
                        <!-- Institution Profile -->
                        <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-gray-200">
                            <div class="flex items-center space-x-3">
                                @if($hasUniversity)
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <div class="h-5 w-5 rounded-full border-2 border-gray-300"></div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Set up institution profile</p>
                                    <p class="text-xs text-gray-500">Add logo, description, and contact info</p>
                                </div>
                            </div>
                            @if(!$hasUniversity)
                                <a href="{{ route('employer.company.create') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                    Complete →
                                </a>
                            @else
                                <span class="text-sm font-medium text-green-600">Done ✓</span>
                            @endif
                        </div>

                        <!-- First Program -->
                        <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-gray-200">
                            <div class="flex items-center space-x-3">
                                @if($programsCount > 0)
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <div class="h-5 w-5 rounded-full border-2 border-gray-300"></div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Publish your first program</p>
                                    <p class="text-xs text-gray-500">Make it visible to students worldwide</p>
                                </div>
                            </div>
                            @if($programsCount == 0)
                                <a href="{{ route('institution.programs.create') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                    Add Program →
                                </a>
                            @else
                                <span class="text-sm font-medium text-green-600">Done ✓</span>
                            @endif
                        </div>

                        <!-- Review Applications -->
                        <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-gray-200">
                            <div class="flex items-center space-x-3">
                                @if($applicationsCount > 0)
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <div class="h-5 w-5 rounded-full border-2 border-gray-300"></div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Receive your first application</p>
                                    <p class="text-xs text-gray-500">Students will start applying soon</p>
                                </div>
                            </div>
                            @if($applicationsCount > 0)
                                <span class="text-sm font-medium text-green-600">Done ✓</span>
                            @endif
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-gray-700 font-medium">Setup Progress</span>
                            <span class="text-gray-600">{{ $completionPercentage }}% complete</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $completionPercentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Programs -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Programs</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $programsCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        <span class="text-green-600">{{ $featuredCount }} featured</span>
                    </p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Applications -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Applications</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $applicationsCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        @if($newApplicationsCount > 0)
                            <span class="text-orange-600">{{ $newApplicationsCount }} new</span>
                        @else
                            <span class="text-gray-500">All reviewed</span>
                        @endif
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Views This Month -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Program Views</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalViews ?? 0) }}</p>
                    <p class="text-xs text-gray-500 mt-1">This month</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Programs -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Programs</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">Accepting applications</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('institution.programs.create') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white hover:from-blue-600 hover:to-blue-700 transition-all transform hover:scale-105">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Add New Program</h3>
                    <p class="text-sm text-blue-100">Quick program wizard</p>
                </div>
            </div>
        </a>

        <a href="{{ route('institution.applications.index') }}" class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white hover:from-green-600 hover:to-green-700 transition-all transform hover:scale-105">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">View Applications</h3>
                    <p class="text-sm text-green-100">
                        @if($newApplicationsCount > 0)
                            {{ $newApplicationsCount }} new applications
                        @else
                            All caught up
                        @endif
                    </p>
                </div>
            </div>
        </a>

        <a href="{{ route('institution.programs.index') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white hover:from-purple-600 hover:to-purple-700 transition-all transform hover:scale-105">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Manage Programs</h3>
                    <p class="text-sm text-purple-100">Edit & update programs</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Recent Programs & Applications -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Programs -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Programs</h3>
                <a href="{{ route('institution.programs.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all →</a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentPrograms as $program)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $program->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $program->degree->name }} • {{ $program->study_mode }}
                                    @if($program->tuition_fee)
                                        • €{{ number_format($program->tuition_fee, 0) }}/year
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('institution.programs.edit', $program) }}" class="ml-4 text-sm text-blue-600 hover:text-blue-800">Edit</a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <p class="mt-2 text-sm">No programs yet</p>
                        <a href="{{ route('institution.programs.create') }}" class="mt-2 inline-block text-sm font-medium text-blue-600 hover:text-blue-800">
                            Create your first program
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Applications</h3>
                <a href="{{ route('institution.applications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all →</a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentApplications as $application)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $application->user->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Applied to: {{ $application->program->title }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $application->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('institution.applications.show', $application) }}" class="ml-4 text-sm text-blue-600 hover:text-blue-800">View</a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="mt-2 text-sm">No applications yet</p>
                        <p class="mt-1 text-xs text-gray-400">Applications will appear here once students start applying</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Helpful Tips -->
    <div class="mt-8 bg-gradient-to-r from-indigo-50 to-blue-50 border border-indigo-200 rounded-lg p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-semibold text-gray-900">💡 Tips to Attract More Students</h3>
                <ul class="mt-2 text-sm text-gray-700 space-y-1 list-disc list-inside">
                    <li>Add detailed program descriptions with career outcomes</li>
                    <li>Upload your institution logo for better visibility</li>
                    <li>Keep tuition fees and deadlines updated</li>
                    <li>Respond to applications within 48 hours</li>
                    <li>Mark popular programs as "Featured" to highlight them</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
