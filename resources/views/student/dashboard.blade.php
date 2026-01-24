@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="mt-2 text-gray-600">Track your applications and manage your study abroad journey.</p>
    </div>

    <!-- Onboarding Checklist -->
    @if(!$onboardingComplete)
        <div class="mb-8 bg-gradient-to-r from-indigo-50 to-blue-50 border-l-4 border-indigo-500 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Complete Your Setup</h3>

            <div class="space-y-3">
                <!-- Profile -->
                <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        @if($hasProfile)
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <div class="h-5 w-5 rounded-full border-2 border-gray-300"></div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900">Complete your profile</p>
                            <p class="text-xs text-gray-500">{{ $profile->profile_completion }}% complete</p>
                        </div>
                    </div>
                    @if(!$hasProfile)
                        <a href="{{ route('student.profile.edit') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Complete →
                        </a>
                    @else
                        <span class="text-sm font-medium text-green-600">Done ✓</span>
                    @endif
                </div>

                <!-- Documents -->
                <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        @if($hasDocuments)
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <div class="h-5 w-5 rounded-full border-2 border-gray-300"></div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900">Upload required documents</p>
                            <p class="text-xs text-gray-500">{{ $documentsCount }} / 3 minimum</p>
                        </div>
                    </div>
                    @if(!$hasDocuments)
                        <a href="{{ route('student.documents.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Upload →
                        </a>
                    @else
                        <span class="text-sm font-medium text-green-600">Done ✓</span>
                    @endif
                </div>

                <!-- Applications -->
                <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        @if($hasApplied)
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <div class="h-5 w-5 rounded-full border-2 border-gray-300"></div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900">Apply to programs</p>
                            <p class="text-xs text-gray-500">Start your study abroad journey</p>
                        </div>
                    </div>
                    @if(!$hasApplied)
                        <a href="{{ route('study-programs.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Browse →
                        </a>
                    @else
                        <span class="text-sm font-medium text-green-600">Done ✓</span>
                    @endif
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-4">
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="text-gray-700 font-medium">Setup Progress</span>
                    <span class="text-gray-600">{{ $onboardingPercentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full transition-all" style="width: {{ $onboardingPercentage }}%"></div>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Applications</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $applicationsCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        @if($pendingApplications > 0)
                            <span class="text-orange-600">{{ $pendingApplications }} pending</span>
                        @else
                            All reviewed
                        @endif
                    </p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Documents</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $documentsCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ 15 - $documentsCount }} slots remaining</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Profile</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $profile->profile_completion }}%</p>
                    <p class="text-xs text-gray-500 mt-1">
                        @if($profile->is_complete)
                            <span class="text-green-600">Complete</span>
                        @else
                            {{ 100 - $profile->profile_completion }}% remaining
                        @endif
                    </p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Saved Programs</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
                    <p class="text-xs text-gray-500 mt-1">Browse programs</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('study-programs.index') }}" class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg p-6 text-white hover:from-indigo-600 hover:to-indigo-700 transition-all transform hover:scale-105">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Browse Programs</h3>
                    <p class="text-sm text-indigo-100">Find your perfect match</p>
                </div>
            </div>
        </a>

        <a href="{{ route('student.profile.edit') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white hover:from-purple-600 hover:to-purple-700 transition-all transform hover:scale-105">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Update Profile</h3>
                    <p class="text-sm text-purple-100">{{ $profile->profile_completion }}% complete</p>
                </div>
            </div>
        </a>

        <a href="{{ route('student.documents.index') }}" class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white hover:from-green-600 hover:to-green-700 transition-all transform hover:scale-105">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Manage Documents</h3>
                    <p class="text-sm text-green-100">{{ $documentsCount }} uploaded</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Recent Applications & Documents -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Applications -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Applications</h3>
                <a href="{{ route('study-programs.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All →</a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentApplications as $application)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $application->program->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $application->program->university->name }} • {{ $application->program->country->name }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">Applied {{ $application->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($application->status === 'pending') bg-gray-100 text-gray-800
                                @elseif($application->status === 'accepted') bg-green-100 text-green-800
                                @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="mt-2 text-sm">No applications yet</p>
                        <a href="{{ route('study-programs.index') }}" class="mt-2 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Browse programs →
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Documents -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Documents</h3>
                <a href="{{ route('student.documents.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All →</a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentDocuments as $document)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-1">
                                <svg class="w-8 h-8 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ $document->document_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $document->file_size_formatted }} • {{ $document->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if($document->is_verified)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Verified
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="mt-2 text-sm">No documents uploaded</p>
                        <a href="{{ route('student.documents.index') }}" class="mt-2 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Upload documents →
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Tips -->
    <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="h-6 w-6 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-blue-900">
                <p class="font-semibold mb-2">Tips for Success:</p>
                <ul class="list-disc list-inside space-y-1 text-blue-800">
                    <li>Complete your profile to increase your chances of admission</li>
                    <li>Upload all required documents in PDF format (transcripts, certificates, passport)</li>
                    <li>Apply to multiple programs that match your interests and qualifications</li>
                    <li>Keep your contact information up-to-date</li>
                    <li>Check application statuses regularly</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
