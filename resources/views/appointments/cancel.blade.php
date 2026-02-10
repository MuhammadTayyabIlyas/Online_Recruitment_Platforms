@extends('layouts.app')
@section('title', 'Cancel Appointment')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="text-center mb-6">
                <div class="mx-auto w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Cancel Appointment?</h1>
                <p class="text-gray-600">Are you sure you want to cancel this appointment?</p>
            </div>

            {{-- Appointment Summary --}}
            <div class="bg-gray-50 rounded-lg p-4 mb-6 space-y-2">
                <p class="text-sm"><span class="text-gray-500">Reference:</span> <strong>{{ $appointment->booking_reference }}</strong></p>
                <p class="text-sm"><span class="text-gray-500">Service:</span> {{ $appointment->consultationType->name }}</p>
                <p class="text-sm"><span class="text-gray-500">Date:</span> {{ $appointment->appointment_date->format('l, F j, Y') }} at {{ $appointment->formatted_time }}</p>
            </div>

            <form action="{{ route('appointments.cancel', $appointment->booking_reference) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for cancellation (optional)</label>
                    <textarea name="cancellation_reason" id="cancellation_reason" rows="3"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                              placeholder="Let us know why you're cancelling..."></textarea>
                </div>

                <div class="flex gap-3 justify-end">
                    <a href="{{ route('appointments.confirmation', $appointment->booking_reference) }}"
                       class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition">
                        Keep Appointment
                    </a>
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium transition">
                        Cancel Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
