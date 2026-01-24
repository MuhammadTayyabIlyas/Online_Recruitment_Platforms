@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('jobseeker.applications.index') }}" class="hover:text-indigo-600">My Applications</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900">{{ $application->job->title }}</li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            @if($application->job->company && $application->job->company->logo)
                                <img src="{{ $application->job->company->logo_url }}" alt="{{ $application->job->company->company_name }}"
                                     class="w-16 h-16 rounded-lg object-cover">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h1 class="text-xl font-bold text-gray-900">
                                    <a href="{{ route('jobs.show', $application->job) }}" class="hover:text-indigo-600">
                                        {{ $application->job->title }}
                                    </a>
                                </h1>
                                <p class="text-gray-600">{{ $application->job->company->company_name ?? 'Company' }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($application->status === 'pending') bg-gray-100 text-gray-800
                            @elseif($application->status === 'under_review') bg-blue-100 text-blue-800
                            @elseif($application->status === 'shortlisted') bg-indigo-100 text-indigo-800
                            @elseif($application->status === 'interviewed') bg-purple-100 text-purple-800
                            @elseif($application->status === 'offered') bg-yellow-100 text-yellow-800
                            @elseif($application->status === 'accepted') bg-green-100 text-green-800
                            @elseif($application->status === 'rejected') bg-red-100 text-red-800
                            @elseif($application->status === 'withdrawn') bg-gray-100 text-gray-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Cover Letter</h2>
                    <div class="prose max-w-none text-gray-600 bg-gray-50 rounded-lg p-4">
                        {!! nl2br(e($application->cover_letter)) !!}
                    </div>

                    @if($application->answers)
                        <h2 class="text-lg font-semibold text-gray-900 mt-6 mb-4">Screening Questions</h2>
                        @php $answers = json_decode($application->answers, true); @endphp
                        @if($answers && $application->job->questions)
                            @foreach($application->job->questions as $index => $question)
                                <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                    <p class="font-medium text-gray-900">{{ $question->question }}</p>
                                    <p class="text-gray-600 mt-2">{{ $answers[$index] ?? 'No answer provided' }}</p>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3">
            <!-- Application Details -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Application Details</h3>

                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Applied On</dt>
                        <dd class="text-gray-900">{{ $application->created_at->format('M d, Y \a\t h:i A') }}</dd>
                    </div>

                    @if($application->resume_path)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Resume</dt>
                            <dd>
                                <a href="{{ route('jobseeker.applications.resume', $application) }}"
                                   class="text-indigo-600 hover:text-indigo-900">
                                    Download Resume
                                </a>
                            </dd>
                        </div>
                    @endif

                    @if($application->withdrawn_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Withdrawn On</dt>
                            <dd class="text-gray-900">{{ $application->withdrawn_at->format('M d, Y') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>

                @if(in_array($application->status, ['pending', 'under_review']))
                    <form action="{{ route('jobseeker.applications.withdraw', $application) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to withdraw this application?');">
                        @csrf
                        <button type="submit"
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Withdraw Application
                        </button>
                    </form>
                @else
                    <p class="text-gray-500 text-sm">
                        @if($application->status === 'withdrawn')
                            This application has been withdrawn.
                        @else
                            This application cannot be withdrawn at this stage.
                        @endif
                    </p>
                @endif

                <a href="{{ route('jobs.show', $application->job) }}"
                   class="block w-full text-center px-4 py-2 mt-3 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                    View Job Posting
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
