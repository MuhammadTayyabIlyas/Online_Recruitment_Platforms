@extends('layouts.app')
@section('title', 'Booking Confirmed')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            {{-- Success Icon --}}
            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">Appointment Booked!</h1>
            <p class="text-gray-600 mb-6">Your consultation has been {{ $appointment->status === 'confirmed' ? 'confirmed' : 'submitted' }}. A confirmation email has been sent to <strong>{{ $appointment->booker_email }}</strong>.</p>

            {{-- Booking Details --}}
            <div class="bg-gray-50 rounded-lg p-6 text-left space-y-3 mb-6">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Reference</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $appointment->booking_reference }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Service</span>
                    <span class="text-sm font-medium text-gray-900">{{ $appointment->consultationType->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Date</span>
                    <span class="text-sm font-medium text-gray-900">{{ $appointment->appointment_date->format('l, F j, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Time</span>
                    <span class="text-sm font-medium text-gray-900">{{ $appointment->formatted_time }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Duration</span>
                    <span class="text-sm font-medium text-gray-900">{{ $appointment->duration_minutes }} minutes</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Format</span>
                    <span class="text-sm font-medium text-gray-900">{{ $appointment->meeting_format === 'online' ? 'Online Meeting' : 'In-Person' }}</span>
                </div>
                @if($appointment->meeting_format === 'in_person' && $appointment->office)
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Location</span>
                        <span class="text-sm font-medium text-gray-900">{{ $appointment->office['label'] }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Status</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                        {{ $appointment->status_label }}
                    </span>
                </div>
                @if(!$appointment->is_free)
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Payment</span>
                        <span class="text-sm font-medium text-gray-900">{{ number_format($appointment->price, 2) }} {{ $appointment->currency }} ({{ $appointment->payment_status_label }})</span>
                    </div>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                @if($appointment->canCancel())
                    <a href="{{ route('appointments.show-cancel', $appointment->booking_reference) }}"
                       class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition">
                        Cancel Appointment
                    </a>
                @endif
                <a href="{{ route('appointments.index') }}"
                   class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium transition">
                    Book Another
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
