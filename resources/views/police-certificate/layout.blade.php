@extends('layouts.app')

@section('title', 'Step ' . $step . ' - UK Police Character Certificate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                @for($i = 1; $i <= 7; $i++)
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm
                            {{ $i < $step ? 'bg-green-500 text-white' : ($i == $step ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500') }}">
                            @if($i < $step)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                {{ $i }}
                            @endif
                        </div>
                        @if($i < 7)
                            <div class="w-8 h-1 {{ $i < $step ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                        @endif
                    </div>
                @endfor
            </div>
            <div class="text-center">
                <span class="text-sm font-medium text-gray-600">Step {{ $step }} of 7</span>
                <span class="mx-2 text-gray-300">|</span>
                <span class="text-sm text-gray-500">{{ $this->getStepTitle($step) }}</span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                <h2 class="text-xl font-bold text-white">{{ $this->getStepTitle($step) }}</h2>
                <p class="text-blue-100 text-sm mt-1">{{ $this->getStepDescription($step) }}</p>
            </div>

            <form action="{{ route('police-certificate.process-step', ['step' => $step]) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">Please correct the errors below.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('form-content')

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                    @if($step > 1)
                        <a href="{{ route('police-certificate.step', ['step' => $step - 1]) }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </a>
                    @else
                        <div></div>
                    @endif

                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg transform hover:scale-105 transition-all">
                        {{ $step == 7 ? 'Submit Application' : 'Next Step' }}
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Your progress is automatically saved. You can return anytime to complete your application.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@php
function getStepTitle($step) {
    $titles = [
        1 => 'Personal Information',
        2 => 'Identification Details',
        3 => 'UK Residence History',
        4 => 'UK Address History',
        5 => 'Spain Address',
        6 => 'Contact Information',
        7 => 'Review & Payment',
    ];
    return $titles[$step] ?? '';
}

function getStepDescription($step) {
    $descriptions = [
        1 => 'Enter your personal details as they appear on your passport',
        2 => 'Upload your passport, CNIC/NICOP, and UK visa documents',
        3 => 'Provide details of your stay in the United Kingdom',
        4 => 'List all addresses where you lived in the UK',
        5 => 'Enter your current address in Spain',
        6 => 'How we can contact you during the application process',
        7 => 'Select your service type and view payment instructions',
    ];
    return $descriptions[$step] ?? '';
}
@endphp