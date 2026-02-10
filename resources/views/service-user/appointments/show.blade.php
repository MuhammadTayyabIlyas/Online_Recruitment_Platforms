@extends('layouts.app')
@section('title', 'Appointment ' . $appointment->booking_reference)

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <a href="{{ route('service_user.appointments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to My Appointments
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-bold text-gray-900">{{ $appointment->booking_reference }}</h1>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                {{ $appointment->status_label }}
            </span>
        </div>

        <dl class="space-y-4">
            <div class="flex justify-between py-2 border-b border-gray-100">
                <dt class="text-sm text-gray-500">Consultation</dt>
                <dd class="text-sm font-medium text-gray-900">{{ $appointment->consultationType->name }}</dd>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-100">
                <dt class="text-sm text-gray-500">Date</dt>
                <dd class="text-sm font-medium text-gray-900">{{ $appointment->appointment_date->format('l, F j, Y') }}</dd>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-100">
                <dt class="text-sm text-gray-500">Time</dt>
                <dd class="text-sm font-medium text-gray-900">{{ $appointment->formatted_time }} ({{ $appointment->duration_minutes }} min)</dd>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-100">
                <dt class="text-sm text-gray-500">Format</dt>
                <dd class="text-sm font-medium text-gray-900">{{ $appointment->meeting_format === 'online' ? 'Online Meeting' : 'In-Person' }}</dd>
            </div>
            @if($appointment->office)
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Location</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $appointment->office['label'] }} - {{ $appointment->office['address'] }}</dd>
                </div>
            @endif
            @if($appointment->meeting_link)
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Meeting Link</dt>
                    <dd class="text-sm font-medium">
                        <a href="{{ $appointment->meeting_link }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">Join Meeting</a>
                    </dd>
                </div>
            @endif
            @if(!$appointment->is_free)
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Payment</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ number_format($appointment->price, 2) }} {{ $appointment->currency }} ({{ $appointment->payment_status_label }})</dd>
                </div>
            @endif
            @if($appointment->notes)
                <div class="py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500 mb-1">Your Notes</dt>
                    <dd class="text-sm text-gray-700 bg-gray-50 rounded p-3">{{ $appointment->notes }}</dd>
                </div>
            @endif
        </dl>

        @if($appointment->canCancel())
            <div class="mt-6 pt-6 border-t border-gray-200">
                <form action="{{ route('service_user.appointments.cancel', $appointment) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm font-medium">Cancel Appointment</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
