@extends('layouts.admin')

@section('title', 'Program Details')

@section('page-title', 'Program Details')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- Success Message -->
    @if(session('status'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-start">
                <svg class="h-5 w-5 text-green-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                </div>
                <button @click="show = false" class="ml-4 text-green-500 hover:text-green-700">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Programs
        </a>
    </div>

    <!-- Program Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $program->title }}</h2>
                    <p class="text-sm text-gray-600 mt-1">Created {{ $program->created_at->diffForHumans() }} by {{ $program->creator->name ?? 'N/A' }}</p>
                </div>
                <a href="{{ route('admin.programs.edit', $program) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Edit Program
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Institution -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Institution</label>
                    <p class="text-sm font-semibold text-gray-900">{{ $program->university->name ?? 'N/A' }}</p>
                </div>

                <!-- Country -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Country</label>
                    <p class="text-sm font-semibold text-gray-900">{{ $program->country->name ?? 'N/A' }}</p>
                </div>

                <!-- Degree Level -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Degree Level</label>
                    <p class="text-sm font-semibold text-gray-900">{{ $program->degree->name ?? 'N/A' }}</p>
                </div>

                <!-- Subject -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Subject/Field</label>
                    <p class="text-sm font-semibold text-gray-900">{{ $program->subject->name ?? 'N/A' }}</p>
                </div>

                <!-- Study Mode -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Study Mode</label>
                    <p class="text-sm font-semibold text-gray-900">{{ $program->study_mode }}</p>
                </div>

                <!-- Language -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Language</label>
                    <p class="text-sm font-semibold text-gray-900">{{ $program->language }}</p>
                </div>

                <!-- Tuition Fee -->
                @if($program->tuition_fee)
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tuition Fee</label>
                    <p class="text-sm font-semibold text-gray-900">€{{ number_format($program->tuition_fee) }}/year</p>
                </div>
                @endif

                <!-- Duration -->
                @if($program->duration)
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Duration</label>
                    <p class="text-sm font-semibold text-gray-900">{{ $program->duration }}</p>
                </div>
                @endif

                <!-- Intake -->
                @if($program->intake)
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Next Intake</label>
                    <p class="text-sm font-semibold text-gray-900">{{ $program->intake }}</p>
                </div>
                @endif

                <!-- Application Deadline -->
                @if($program->application_deadline)
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Application Deadline</label>
                    <p class="text-sm font-semibold text-gray-900">{{ $program->application_deadline->format('M d, Y') }}</p>
                </div>
                @endif

                <!-- Program URL -->
                @if($program->program_url)
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">External URL</label>
                    <a href="{{ $program->program_url }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-800 break-all">
                        {{ $program->program_url }}
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Applications Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Applications</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $program->applications->count() }} total applications</p>
                </div>
            </div>
        </div>

        @if($program->applications->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Applicant</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Applied</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($program->applications as $application)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold text-blue-600">
                                                {{ strtoupper(substr($application->user->name ?? 'N', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-semibold text-gray-900">{{ $application->user->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600">{{ $application->user->email ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.programs.application.update-status', [$program, $application]) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select
                                            name="status"
                                            onchange="if(confirm('Are you sure you want to change the application status?')) this.form.submit()"
                                            class="text-xs font-medium rounded-full border-0 focus:ring-2 focus:ring-offset-0 cursor-pointer
                                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800 focus:ring-yellow-500' : '' }}
                                            {{ $application->status === 'under_review' ? 'bg-blue-100 text-blue-800 focus:ring-blue-500' : '' }}
                                            {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800 focus:ring-green-500' : '' }}
                                            {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800 focus:ring-red-500' : '' }}"
                                        >
                                            <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="under_review" {{ $application->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                                            <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                            <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600">{{ $application->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <a
                                        href="{{ route('admin.programs.application.show', [$program, $application]) }}"
                                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800"
                                    >
                                        View Details
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No applications yet</h3>
                <p class="mt-2 text-sm text-gray-600">
                    This program hasn't received any applications yet.
                </p>
            </div>
        @endif
    </div>

</div>
@endsection
