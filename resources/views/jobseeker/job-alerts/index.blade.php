@extends('layouts.app')

@section('title', 'Job Alerts')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Job Alerts</h1>
            <p class="text-gray-600">Get notified when new jobs match your criteria</p>
        </div>
        <a href="{{ route('jobseeker.alerts.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Alert
        </a>
    </div>

    @if($alerts->count() > 0)
        <div class="space-y-4">
            @foreach($alerts as $alert)
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <h3 class="text-lg font-medium text-gray-900">{{ $alert->name }}</h3>
                                @if($alert->is_active)
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Paused
                                    </span>
                                @endif
                            </div>

                            <div class="mt-2 flex flex-wrap gap-2 text-sm text-gray-500">
                                @if($alert->keywords)
                                    <span class="inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        {{ $alert->keywords }}
                                    </span>
                                @endif
                                @if($alert->location)
                                    <span class="inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        {{ $alert->location }}
                                    </span>
                                @endif
                                @if($alert->category)
                                    <span class="inline-flex items-center px-2 py-1 rounded bg-blue-50 text-blue-700">
                                        {{ $alert->category->name }}
                                    </span>
                                @endif
                                @if($alert->jobType)
                                    <span class="inline-flex items-center px-2 py-1 rounded bg-purple-50 text-purple-700">
                                        {{ $alert->jobType->name }}
                                    </span>
                                @endif
                            </div>

                            <p class="mt-2 text-sm text-gray-500">
                                Frequency: <span class="font-medium">{{ ucfirst($alert->frequency) }}</span>
                            </p>
                        </div>

                        <div class="flex items-center space-x-2">
                            <a href="{{ route('jobseeker.alerts.edit', $alert) }}" class="p-2 text-gray-400 hover:text-indigo-600" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <!-- Toggle Active -->
                            <form action="{{ route('jobseeker.alerts.update', $alert) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_active" value="{{ $alert->is_active ? '0' : '1' }}">
                                <button type="submit" class="p-2 text-gray-400 hover:text-gray-600" title="{{ $alert->is_active ? 'Pause' : 'Activate' }}">
                                    @if($alert->is_active)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </button>
                            </form>

                            <!-- Delete -->
                            <form action="{{ route('jobseeker.alerts.destroy', $alert) }}" method="POST"
                                  onsubmit="return confirm('Delete this job alert?');">
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
            @endforeach
        </div>
    @else
        <div class="bg-white shadow rounded-lg p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No job alerts yet</h3>
            <p class="text-gray-500 mb-6">Create job alerts to get notified when new positions match your criteria.</p>
            <a href="{{ route('jobseeker.alerts.create') }}"
               class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                Create Your First Alert
            </a>
        </div>
    @endif
</div>
@endsection
