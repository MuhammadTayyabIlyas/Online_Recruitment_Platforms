@extends('layouts.employer')

@section('title', 'CV Search')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Find Candidates</h1>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form action="{{ route('employer.cv.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="q" class="block text-sm font-medium text-gray-700">Keywords</label>
                    <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Job title, skills, etc." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location" value="{{ request('location') }}" placeholder="City or Country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="experience_level" class="block text-sm font-medium text-gray-700">Experience Level</label>
                    <select name="experience_level" id="experience_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Any Experience</option>
                        <option value="entry" {{ request('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level (0+ yrs)</option>
                        <option value="mid" {{ request('experience_level') == 'mid' ? 'selected' : '' }}>Mid Level (2+ yrs)</option>
                        <option value="senior" {{ request('experience_level') == 'senior' ? 'selected' : '' }}>Senior Level (5+ yrs)</option>
                        <option value="executive" {{ request('experience_level') == 'executive' ? 'selected' : '' }}>Executive Level (10+ yrs)</option>
                    </select>
                </div>
            </div>

            @if($skills->isNotEmpty())
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Popular Skills</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($skills as $skill)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="skills[]" value="{{ $skill->id }}" {{ in_array($skill->id, request('skills', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">{{ $skill->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Search Candidates
                </button>
            </div>
        </form>
    </div>

    <!-- Candidates List -->
    <div class="space-y-4">
        @forelse($candidates as $candidate)
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl font-bold overflow-hidden">
                            @if($candidate->avatar)
                                <img src="{{ asset('storage/' . $candidate->avatar) }}" alt="{{ $candidate->name }}" class="h-full w-full object-cover">
                            @else
                                {{ substr($candidate->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <a href="{{ route('employer.cv.candidate', $candidate) }}" class="hover:underline">{{ $candidate->name }}</a>
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ $candidate->profile->current_job_title ?? 'Job Seeker' }}
                                @if($candidate->profile->city)
                                    &bull; {{ $candidate->profile->city }}, {{ $candidate->profile->country }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('employer.cv.candidate', $candidate) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View Profile</a>
                </div>
                
                @if($candidate->profile->bio)
                    <p class="mt-3 text-sm text-gray-600 line-clamp-2">{{ $candidate->profile->bio }}</p>
                @endif

                @if($candidate->skills->isNotEmpty())
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($candidate->skills->take(5) as $skill)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $skill->name }}
                            </span>
                        @endforeach
                        @if($candidate->skills->count() > 5)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                +{{ $candidate->skills->count() - 5 }} more
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="mt-2 text-lg font-medium text-gray-900">No candidates found</p>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $candidates->links() }}
    </div>
</div>
@endsection
