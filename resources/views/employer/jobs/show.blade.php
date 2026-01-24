@extends('layouts.employer')

@section('title', $job->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-6">
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('employer.jobs.index') }}" class="hover:text-indigo-600">Jobs</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900">{{ $job->title }}</li>
            </ol>
        </nav>

        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $job->title }}</h1>
                    @switch($job->status)
                        @case('published')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Published
                            </span>
                            @break
                        @case('draft')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Draft
                            </span>
                            @break
                        @case('closed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Closed
                            </span>
                            @break
                        @case('paused')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Paused
                            </span>
                            @break
                    @endswitch
                </div>
                <p class="text-gray-600 mt-1">{{ $job->company->company_name ?? 'Your Company' }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('employer.jobs.edit', $job) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Edit Job
                </a>
                <a href="{{ route('employer.applicants.index', ['job' => $job->id]) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    View Applicants ({{ $job->applications_count ?? 0 }})
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Job Details -->
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Job Details</h2>
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="text-gray-900">{{ $job->location }}</dd>
                        </div>
                        @if($job->category)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="text-gray-900">{{ $job->category->name }}</dd>
                            </div>
                        @endif
                        @if($job->jobType)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Job Type</dt>
                                <dd class="text-gray-900">{{ $job->jobType->name }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Remote</dt>
                            <dd class="text-gray-900">{{ $job->is_remote ? 'Yes' : 'No' }}</dd>
                        </div>
                        @if($job->min_salary || $job->max_salary)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Salary Range</dt>
                                <dd class="text-gray-900">
                                    @if($job->min_salary && $job->max_salary)
                                        ${{ number_format($job->min_salary) }} - ${{ number_format($job->max_salary) }}
                                    @elseif($job->min_salary)
                                        From ${{ number_format($job->min_salary) }}
                                    @else
                                        Up to ${{ number_format($job->max_salary) }}
                                    @endif
                                    <span class="text-sm text-gray-500">({{ $job->hide_salary ? 'Hidden' : 'Visible' }})</span>
                                </dd>
                            </div>
                        @endif
                        @if($job->expires_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Application Deadline</dt>
                                <dd class="{{ $job->expires_at->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $job->expires_at->format('F d, Y') }}
                                    @if($job->expires_at->isPast())
                                        (Expired)
                                    @endif
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Description -->
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Description</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                <!-- Requirements -->
                @if($job->requirements)
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Requirements</h2>
                        <div class="prose max-w-none text-gray-600">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                @endif

                <!-- Benefits -->
                @if($job->benefits)
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Benefits</h2>
                        <div class="prose max-w-none text-gray-600">
                            {!! nl2br(e($job->benefits)) !!}
                        </div>
                    </div>
                @endif

                <!-- Skills -->
                @if($job->skills && $job->skills->count())
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Required Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($job->skills as $skill)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Screening Questions -->
            @if($job->questions && $job->questions->count())
                <div class="bg-white shadow rounded-lg overflow-hidden mt-6">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Screening Questions</h2>
                        <ol class="list-decimal list-inside space-y-3">
                            @foreach($job->questions as $question)
                                <li class="text-gray-700">
                                    {{ $question->question }}
                                    @if($question->is_required)
                                        <span class="text-red-500 text-sm">(Required)</span>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Stats -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h2>
                <dl class="space-y-4">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Total Applications</dt>
                        <dd class="font-semibold text-gray-900">{{ $job->applications_count ?? 0 }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Views</dt>
                        <dd class="font-semibold text-gray-900">{{ $job->views_count ?? 0 }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Posted</dt>
                        <dd class="font-semibold text-gray-900">{{ $job->published_at ? $job->published_at->diffForHumans() : 'Not published' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    @if($job->status === 'published')
                        <form action="{{ route('employer.jobs.status', $job) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="paused">
                            <button type="submit" class="w-full px-4 py-2 border border-yellow-300 text-yellow-700 rounded-md hover:bg-yellow-50">
                                Pause Job
                            </button>
                        </form>
                        <form action="{{ route('employer.jobs.status', $job) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="closed">
                            <button type="submit" class="w-full px-4 py-2 border border-red-300 text-red-700 rounded-md hover:bg-red-50">
                                Close Job
                            </button>
                        </form>
                    @elseif($job->status === 'paused' || $job->status === 'draft')
                        <form action="{{ route('employer.jobs.status', $job) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="published">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Publish Job
                            </button>
                        </form>
                    @elseif($job->status === 'closed')
                        <form action="{{ route('employer.jobs.status', $job) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="published">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Reopen Job
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('employer.jobs.duplicate', $job) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                            Duplicate Job
                        </button>
                    </form>

                    <a href="{{ route('jobs.show', $job) }}" target="_blank"
                       class="block w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-center">
                        View Public Listing
                    </a>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-red-600 mb-4">Danger Zone</h2>
                <form action="{{ route('employer.jobs.destroy', $job) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this job? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Delete Job
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
