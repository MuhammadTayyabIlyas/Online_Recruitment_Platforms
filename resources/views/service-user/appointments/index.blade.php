@extends('layouts.app')
@section('title', 'My Appointments')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Appointments</h1>
            <p class="text-sm text-gray-500 mt-1">View and manage your consultation bookings</p>
        </div>
        <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Book New
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">{{ session('success') }}</div>
    @endif

    {{-- Upcoming Appointments --}}
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Upcoming</h2>
        @if($upcoming->isEmpty())
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <p class="text-gray-500">No upcoming appointments.</p>
                <a href="{{ route('appointments.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm mt-2 inline-block">Book a consultation</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($upcoming as $appointment)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-sm font-semibold text-gray-900">{{ $appointment->consultationType->name }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                                        {{ $appointment->status_label }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $appointment->appointment_date->format('M j, Y') }}
                                    </span>
                                    <span>{{ $appointment->formatted_time }}</span>
                                    <span>{{ $appointment->meeting_format === 'online' ? 'Online' : 'In-Person' }}</span>
                                </div>
                                @if($appointment->meeting_link)
                                    <a href="{{ $appointment->meeting_link }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-800 mt-2 inline-flex items-center">
                                        Join Meeting
                                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2 ml-4">
                                <a href="{{ route('service_user.appointments.show', $appointment) }}" class="text-sm text-indigo-600 hover:text-indigo-800">Details</a>
                                @if($appointment->canCancel())
                                    <form action="{{ route('service_user.appointments.cancel', $appointment) }}" method="POST" onsubmit="return confirm('Cancel this appointment?')">
                                        @csrf
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">Cancel</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Past Appointments --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Past</h2>
        @if($past->isEmpty())
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <p class="text-gray-500">No past appointments.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($past as $appointment)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 opacity-75">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center space-x-3 mb-1">
                                    <h3 class="text-sm font-medium text-gray-700">{{ $appointment->consultationType->name }}</h3>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                                        {{ $appointment->status_label }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">{{ $appointment->appointment_date->format('M j, Y') }} &middot; {{ $appointment->formatted_time }}</p>
                            </div>
                            <a href="{{ route('service_user.appointments.show', $appointment) }}" class="text-sm text-indigo-600 hover:text-indigo-800">View</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
