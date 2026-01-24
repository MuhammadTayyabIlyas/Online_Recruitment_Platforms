@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">My Profile</h1>
        <a href="{{ route('jobseeker.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Edit Profile
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Profile Card -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Header with Photo -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}"
                                     class="w-24 h-24 rounded-full object-cover">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-3xl font-bold text-gray-400">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                            <p class="text-gray-600">{{ auth()->user()->profile->headline ?? 'Job Seeker' }}</p>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- About -->
                @if(auth()->user()->profile && auth()->user()->profile->bio)
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">About</h3>
                        <p class="text-gray-600">{{ auth()->user()->profile->bio }}</p>
                    </div>
                @endif

                <!-- Experience -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Experience</h3>
                    @forelse(auth()->user()->experience ?? [] as $experience)
                        <div class="mb-4 last:mb-0">
                            <h4 class="font-medium text-gray-900">{{ $experience->job_title }}</h4>
                            <p class="text-gray-600">{{ $experience->company_name }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $experience->start_date->format('M Y') }} -
                                {{ $experience->is_current ? 'Present' : ($experience->end_date ? $experience->end_date->format('M Y') : 'Present') }}
                            </p>
                            @if($experience->description)
                                <p class="text-gray-600 mt-2">{{ $experience->description }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">No experience added yet.</p>
                    @endforelse
                </div>

                <!-- Education -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Education</h3>
                    @forelse(auth()->user()->education ?? [] as $education)
                        <div class="mb-4 last:mb-0">
                            <h4 class="font-medium text-gray-900">{{ $education->degree }}</h4>
                            <p class="text-gray-600">{{ $education->institution }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $education->start_date }} -
                                {{ $education->is_current ? 'Present' : ($education->end_date ?? 'Present') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-500">No education added yet.</p>
                    @endforelse
                </div>

                <!-- Skills -->
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Skills</h3>
                    @if(auth()->user()->skills && auth()->user()->skills->count())
                        <div class="flex flex-wrap gap-2">
                            @foreach(auth()->user()->skills as $skill)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ $skill->skill->name ?? $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No skills added yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Profile Completion -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Strength</h3>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $profileCompletion ?? 0 }}%"></div>
                </div>
                <p class="text-sm text-gray-500">{{ $profileCompletion ?? 0 }}% Complete</p>
            </div>

            <!-- Resumes -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumes</h3>
                @forelse(auth()->user()->resumes ?? [] as $resume)
                    <div class="flex items-center justify-between mb-3 last:mb-0">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-gray-900">{{ $resume->title ?? 'Resume' }}</span>
                            @if($resume->is_primary)
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    Primary
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No resumes uploaded.</p>
                @endforelse
                <a href="{{ route('jobseeker.profile.resumes') }}" class="block mt-4 text-indigo-600 hover:text-indigo-900 text-sm">
                    Manage Resumes
                </a>
            </div>

            <!-- Contact Info -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-gray-900">{{ auth()->user()->email }}</dd>
                    </div>
                    @if(auth()->user()->phone)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="text-gray-900">{{ auth()->user()->phone }}</dd>
                        </div>
                    @endif
                    @if(auth()->user()->profile && auth()->user()->profile->location)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="text-gray-900">{{ auth()->user()->profile->location }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
