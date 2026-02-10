@extends('layouts.admin')
@section('title', 'Appointment ' . $appointment->booking_reference)
@section('page-title', 'Appointment Details')

@section('content')
<div class="max-w-5xl mx-auto">
    <a href="{{ route('admin.appointments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Appointments
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Booking Details --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $appointment->booking_reference }}</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                        {{ $appointment->status_label }}
                    </span>
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Consultation Type</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $appointment->consultationType->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Date</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $appointment->appointment_date->format('l, F j, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Time</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $appointment->formatted_time }} ({{ $appointment->duration_minutes }} min)</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Meeting Format</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $appointment->meeting_format === 'online' ? 'Online Meeting' : 'In-Person' }}</dd>
                    </div>
                    @if($appointment->office)
                        <div>
                            <dt class="text-sm text-gray-500">Office</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $appointment->office['label'] }} - {{ $appointment->office['address'] }}</dd>
                        </div>
                    @endif
                    @if($appointment->meeting_link)
                        <div class="sm:col-span-2">
                            <dt class="text-sm text-gray-500">Meeting Link</dt>
                            <dd class="text-sm font-medium text-indigo-600"><a href="{{ $appointment->meeting_link }}" target="_blank">{{ $appointment->meeting_link }}</a></dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Client Info --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Client Information</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Name</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $appointment->booker_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Email</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $appointment->booker_email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Phone</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $appointment->booker_phone ?? 'Not provided' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Registered User</dt>
                        <dd class="text-sm font-medium text-gray-900">
                            @if($appointment->user)
                                <a href="{{ route('admin.users.show', $appointment->user) }}" class="text-indigo-600 hover:text-indigo-800">{{ $appointment->user->name }}</a>
                            @else
                                Guest
                            @endif
                        </dd>
                    </div>
                </dl>
                @if($appointment->notes)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <dt class="text-sm text-gray-500 mb-1">Client Notes</dt>
                        <dd class="text-sm text-gray-700 bg-gray-50 rounded p-3">{{ $appointment->notes }}</dd>
                    </div>
                @endif
            </div>

            {{-- Payment Info --}}
            @if(!$appointment->is_free)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Amount</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ number_format($appointment->price, 2) }} {{ $appointment->currency }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Payment Status</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $appointment->payment_status_label }}</dd>
                    </div>
                    @if($appointment->stripe_payment_intent_id)
                        <div>
                            <dt class="text-sm text-gray-500">Stripe ID</dt>
                            <dd class="text-sm font-mono text-gray-700">{{ $appointment->stripe_payment_intent_id }}</dd>
                        </div>
                    @endif
                    @if($appointment->paid_at)
                        <div>
                            <dt class="text-sm text-gray-500">Paid At</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $appointment->paid_at->format('M j, Y H:i') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
            @endif
        </div>

        {{-- Sidebar Actions --}}
        <div class="space-y-6">
            {{-- Update Status --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Update Status</h3>
                <form action="{{ route('admin.appointments.update-status', $appointment) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="space-y-3">
                        <div>
                            <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @foreach(['pending', 'confirmed', 'completed', 'cancelled', 'no_show', 'rescheduled'] as $s)
                                    <option value="{{ $s }}" {{ $appointment->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <textarea name="admin_notes" rows="3" placeholder="Admin notes..."
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $appointment->admin_notes }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">Update Status</button>
                    </div>
                </form>
            </div>

            {{-- Meeting Link --}}
            @if($appointment->meeting_format === 'online')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Meeting Link</h3>
                <form action="{{ route('admin.appointments.update-meeting-link', $appointment) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="space-y-3">
                        <input type="url" name="meeting_link" value="{{ $appointment->meeting_link }}" placeholder="https://meet.google.com/..."
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium">Save & Notify Client</button>
                    </div>
                </form>
            </div>
            @endif

            {{-- Cancellation Info --}}
            @if($appointment->cancelled_at)
            <div class="bg-red-50 rounded-lg border border-red-200 p-6">
                <h3 class="text-sm font-semibold text-red-900 mb-2">Cancellation Info</h3>
                <p class="text-sm text-red-700">Cancelled {{ $appointment->cancelled_at->format('M j, Y H:i') }} by {{ $appointment->cancelled_by ?? 'unknown' }}</p>
                @if($appointment->cancellation_reason)
                    <p class="text-sm text-red-600 mt-2">Reason: {{ $appointment->cancellation_reason }}</p>
                @endif
            </div>
            @endif

            {{-- Timestamps --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Timeline</h3>
                <div class="space-y-2 text-sm text-gray-500">
                    <p>Created: {{ $appointment->created_at->format('M j, Y H:i') }}</p>
                    @if($appointment->paid_at)
                        <p>Paid: {{ $appointment->paid_at->format('M j, Y H:i') }}</p>
                    @endif
                    @if($appointment->reminder_24h_sent_at)
                        <p>24h Reminder: {{ $appointment->reminder_24h_sent_at->format('M j, Y H:i') }}</p>
                    @endif
                    @if($appointment->reminder_1h_sent_at)
                        <p>1h Reminder: {{ $appointment->reminder_1h_sent_at->format('M j, Y H:i') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
