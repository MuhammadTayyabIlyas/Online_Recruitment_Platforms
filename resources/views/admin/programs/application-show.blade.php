@extends('layouts.admin')

@section('title', 'Application Details')

@section('page-title', 'Application Details')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

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
        <a href="{{ route('admin.programs.show', $program) }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Program
        </a>
    </div>

    <!-- Application Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Application for {{ $program->title }}</h2>
                <p class="text-sm text-gray-600 mt-1">
                    Submitted {{ $application->created_at->format('M d, Y') }} ({{ $application->created_at->diffForHumans() }})
                </p>
            </div>
            <div>
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'under_review' => 'bg-blue-100 text-blue-800',
                        'accepted' => 'bg-green-100 text-green-800',
                        'rejected' => 'bg-red-100 text-red-800',
                    ];
                    $statusColor = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                    {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column - Applicant Information -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Applicant Details Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Applicant Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-blue-600">
                                {{ strtoupper(substr($application->user->name ?? 'N', 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-900">{{ $application->user->name ?? 'N/A' }}</h4>
                            <p class="text-sm text-gray-600">{{ $application->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">User ID</label>
                            <p class="text-sm font-semibold text-gray-900">#{{ $application->user->id }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Member Since</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $application->user->created_at->format('M d, Y') }}</p>
                        </div>

                        @if($application->user->phone)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Phone</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $application->user->phone }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Application Message -->
            @if($application->message)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Application Message</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $application->message }}</p>
                </div>
            </div>
            @endif

            <!-- Admin Notes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Admin Notes</h3>
                </div>
                <div class="p-6">
                    @if($application->admin_notes)
                        <p class="text-sm text-gray-700 whitespace-pre-wrap mb-4">{{ $application->admin_notes }}</p>
                    @else
                        <p class="text-sm text-gray-500 italic">No admin notes yet.</p>
                    @endif

                    <form method="POST" action="{{ route('admin.programs.application.update-notes', [$program, $application]) }}" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <textarea
                            name="admin_notes"
                            rows="4"
                            placeholder="Add notes about this application..."
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                        >{{ old('admin_notes', $application->admin_notes) }}</textarea>
                        <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Update Notes
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Right Column - Program & Status -->
        <div class="space-y-6">

            <!-- Program Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Program Details</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Program</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $program->title }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Institution</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $program->university->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Degree Level</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $program->degree->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Subject</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $program->subject->name ?? 'N/A' }}</p>
                    </div>

                    @if($program->tuition_fee)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tuition Fee</label>
                        <p class="text-sm font-semibold text-gray-900">€{{ number_format($program->tuition_fee) }}/year</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Update Status</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.programs.application.update-status', [$program, $application]) }}">
                        @csrf
                        @method('PATCH')

                        <label class="block text-sm font-medium text-gray-700 mb-2">Application Status</label>
                        <select
                            name="status"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 mb-4"
                        >
                            <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under_review" {{ $application->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>

                        <button type="submit" class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Update Status
                        </button>
                    </form>

                    @if($application->reviewed_at)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-500">
                            Last reviewed: {{ $application->reviewed_at->format('M d, Y H:i') }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Application Timeline -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Application Submitted</p>
                                <p class="text-xs text-gray-500">{{ $application->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>

                        @if($application->reviewed_at)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Reviewed</p>
                                <p class="text-xs text-gray-500">{{ $application->reviewed_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
