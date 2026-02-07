@php
$stepTitles = [
    1 => 'Personal Information',
    2 => 'Identification Details',
    3 => 'UK Residence History',
    4 => 'UK Address History',
    5 => 'Delivery Address (Spain)',
    6 => 'Authorization Letter',
    7 => 'Review & Payment',
];

$stepDescriptions = [
    1 => 'Enter your personal details as they appear on your passport',
    2 => 'Upload your passport, CNIC/NICOP, and UK visa documents',
    3 => 'Provide details of your stay in the United Kingdom',
    4 => 'List all addresses where you lived in the UK',
    5 => 'Enter your Spanish postal address where we will send your certificate',
    6 => 'Sign the authorization letter for PLACEMENT UK LIMITED',
    7 => 'Select your service type and view payment instructions',
];

$currentTitle = $stepTitles[$step] ?? '';
$currentDescription = $stepDescriptions[$step] ?? '';
$totalSteps = 7;
$percentage = round(($step / $totalSteps) * 100);
@endphp

@extends('layouts.app')

@section('title', 'Step ' . $step . ' - UK Police Character Certificate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Enhanced Progress Bar -->
        <div class="mb-8">
            <!-- Mobile: Simple progress bar -->
            <div class="md:hidden mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Step {{ $step }} of {{ $totalSteps }}</span>
                    <span class="text-sm font-bold text-blue-600">{{ $percentage }}% Complete</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 bg-gradient-to-r from-blue-500 to-indigo-600"
                         style="width: {{ $percentage }}%">
                    </div>
                </div>
            </div>

            <!-- Desktop: Step circles with progress -->
            <div class="hidden md:block">
                <div class="flex items-center justify-between mb-2">
                    @for($i = 1; $i <= $totalSteps; $i++)
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300
                                {{ $i < $step ? 'bg-green-500 text-white' : ($i == $step ? 'bg-blue-600 text-white ring-4 ring-blue-200' : 'bg-gray-200 text-gray-500') }}">
                                @if($i < $step)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    {{ $i }}
                                @endif
                            </div>
                            @if($i < $totalSteps)
                                <div class="w-8 h-1 transition-all duration-300 {{ $i < $step ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                    @endfor
                </div>
                <div class="flex justify-between items-center">
                    <div class="text-center">
                        <span class="text-sm font-medium text-gray-600">Step {{ $step }} of {{ $totalSteps }}</span>
                        <span class="mx-2 text-gray-300">|</span>
                        <span class="text-sm text-gray-500">{{ $currentTitle }}</span>
                    </div>
                    <span class="text-sm font-bold text-blue-600">{{ $percentage }}% Complete</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                <h2 class="text-xl font-bold text-white">{{ $currentTitle }}</h2>
                <p class="text-blue-100 text-sm mt-1">{{ $currentDescription }}</p>
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
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-gray-200">
                    <div class="w-full sm:w-auto order-2 sm:order-1">
                        @if($step > 1)
                            <a href="{{ route('police-certificate.step', ['step' => $step - 1]) }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 min-h-[48px]">
                                <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Previous
                            </a>
                        @else
                            <div></div>
                        @endif
                    </div>

                    <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-3 order-1 sm:order-2">
                        <!-- Save & Continue Later Button -->
                        @if($step < 7)
                            <button type="submit" name="save_for_later" value="1"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition min-h-[48px]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Save & Continue Later
                            </button>
                        @endif

                        <!-- Next/Submit Button -->
                        <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg transform hover:scale-105 transition-all min-h-[48px]">
                            {{ $step == 7 ? 'Submit Application' : 'Next Step' }}
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
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
                        Need help? Contact us via
                        <a href="{{ config('placemenet.whatsapp_link') }}" target="_blank" class="font-medium underline">WhatsApp</a>
                        or email
                        <a href="mailto:{{ config('placemenet.support_email', 'support@placemenet.net') }}" class="font-medium underline">support@placemenet.net</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto-save indicator (shown after saving) -->
@if(session('progress_saved'))
    <x-auto-save-indicator :show="true" message="Progress saved! Reference: {{ session('application_reference') }}" />
@endif
@endsection
