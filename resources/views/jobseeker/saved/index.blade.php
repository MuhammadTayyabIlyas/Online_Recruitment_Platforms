@extends('layouts.app')

@section('title', 'Saved Jobs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Saved Jobs</h1>
        <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Browse More Jobs
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        @forelse($savedJobs ?? [] as $savedJob)
            <div class="border-b border-gray-200 last:border-b-0 p-6 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        @if($savedJob->job->company && $savedJob->job->company->logo)
                            <img src="{{ $savedJob->job->company->logo_url }}" alt="{{ $savedJob->job->company->name }}"
                                 class="w-12 h-12 rounded-lg object-cover">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h3 class="font-semibold text-gray-900">
                                <a href="{{ route('jobs.show', $savedJob->job) }}" class="hover:text-indigo-600">
                                    {{ $savedJob->job->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600">{{ $savedJob->job->company->name ?? 'Company' }}</p>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-sm text-gray-500">{{ $savedJob->job->location }}</span>
                                @if($savedJob->job->jobType)
                                    <span class="text-sm text-gray-500">{{ $savedJob->job->jobType->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('jobseeker.applications.create', $savedJob->job) }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">
                            Apply Now
                        </a>
                        <form action="{{ route('jobseeker.saved.destroy', $savedJob->job) }}" method="POST"
                              onsubmit="return confirm('Remove from saved jobs?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No saved jobs</h3>
                <p class="mt-1 text-sm text-gray-500">Save jobs you're interested in to review later.</p>
                <div class="mt-6">
                    <a href="{{ route('jobs.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Browse Jobs
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if(isset($savedJobs) && $savedJobs->hasPages())
        <div class="mt-6">
            {{ $savedJobs->links() }}
        </div>
    @endif
</div>
@endsection
