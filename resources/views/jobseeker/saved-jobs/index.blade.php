@extends('layouts.app')

@section('title', 'Saved Jobs')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Saved Jobs</h1>
            <p class="text-gray-600">Jobs you've saved for later</p>
        </div>
        <a href="{{ route('jobs.index') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Browse More Jobs
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    @if($savedJobs->count() > 0)
        <div class="space-y-4">
            @foreach($savedJobs as $savedJob)
                @if($savedJob->job)
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    @if($savedJob->job->company && $savedJob->job->company->logo)
                                        <img src="{{ $savedJob->job->company->logo_url }}" alt="{{ $savedJob->job->company->company_name }}"
                                             class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <a href="{{ route('jobs.show', $savedJob->job) }}" class="hover:text-indigo-600">
                                                {{ $savedJob->job->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600">{{ $savedJob->job->company->company_name ?? 'Company' }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2 text-sm text-gray-500">
                                    <span class="inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        {{ $savedJob->job->location }}
                                    </span>
                                    @if($savedJob->job->jobType)
                                        <span class="inline-flex items-center px-2 py-1 rounded bg-blue-50 text-blue-700">
                                            {{ $savedJob->job->jobType->name }}
                                        </span>
                                    @endif
                                    @if(!$savedJob->job->hide_salary && ($savedJob->job->min_salary || $savedJob->job->max_salary))
                                        <span class="inline-flex items-center px-2 py-1 rounded bg-green-50 text-green-700">
                                            @if($savedJob->job->min_salary && $savedJob->job->max_salary)
                                                ${{ number_format($savedJob->job->min_salary) }} - ${{ number_format($savedJob->job->max_salary) }}
                                            @elseif($savedJob->job->min_salary)
                                                From ${{ number_format($savedJob->job->min_salary) }}
                                            @else
                                                Up to ${{ number_format($savedJob->job->max_salary) }}
                                            @endif
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-2 text-sm text-gray-500">
                                    Saved {{ $savedJob->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <div class="flex items-center space-x-2 ml-4">
                                @if($savedJob->job->status === 'published')
                                    <a href="{{ route('jobseeker.applications.create', $savedJob->job) }}"
                                       class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                                        Apply Now
                                    </a>
                                @else
                                    <span class="px-4 py-2 bg-gray-100 text-gray-500 text-sm rounded-md">
                                        No longer available
                                    </span>
                                @endif

                                <form action="{{ route('jobseeker.saved.destroy', $savedJob->job) }}" method="POST"
                                      onsubmit="return confirm('Remove this job from saved?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        @if($savedJobs->hasPages())
            <div class="mt-6">
                {{ $savedJobs->links() }}
            </div>
        @endif
    @else
        <div class="bg-white shadow rounded-lg p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No saved jobs yet</h3>
            <p class="text-gray-500 mb-6">Start browsing jobs and save the ones you're interested in.</p>
            <a href="{{ route('jobs.index') }}"
               class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                Browse Jobs
            </a>
        </div>
    @endif
</div>
@endsection
