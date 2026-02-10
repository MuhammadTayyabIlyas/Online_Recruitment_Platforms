@extends('layouts.app')
@section('title', 'Appointment Cancelled')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            @if(isset($error))
                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Cannot Cancel</h1>
                <p class="text-gray-600 mb-6">{{ $error }}</p>
            @else
                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Appointment Cancelled</h1>
                <p class="text-gray-600 mb-6">Your appointment <strong>{{ $appointment->booking_reference }}</strong> has been cancelled. A confirmation email has been sent.</p>
            @endif

            <a href="{{ route('appointments.index') }}" class="inline-flex px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium transition">
                Book Another Consultation
            </a>
        </div>
    </div>
</div>
@endsection
