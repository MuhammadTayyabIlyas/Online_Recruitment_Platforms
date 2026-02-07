@php
$stepTitles = [
    1 => 'Personal Information',
    2 => 'Identification Documents',
    3 => 'Greece Residence History',
    4 => 'Current Address',
    5 => 'Contact Information',
    6 => 'Authorization Letter',
    7 => 'Service & Payment',
];

$stepDescriptions = [
    1 => 'Enter your personal details as they appear on your passport',
    2 => 'Upload your passport and Greek residence documents',
    3 => 'Provide details of your residence history in Greece',
    4 => 'Enter your current address for certificate delivery',
    5 => 'How we can contact you during the application process',
    6 => 'Download, fill, and upload the authorization letter',
    7 => 'Select your service type and view payment instructions',
];

$currentTitle = $stepTitles[$step] ?? '';
$currentDescription = $stepDescriptions[$step] ?? '';
$totalSteps = 7;
$percentage = round(($step / $totalSteps) * 100);
@endphp

@extends('layouts.app')

@section('title', 'Step ' . $step . ' - Greece Penal Record Certificate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Enhanced Progress Bar -->
        <div class="mb-8">
            <!-- Mobile: Simple progress bar -->
            <div class="md:hidden mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Step {{ $step }} of {{ $totalSteps }}</span>
                    <span class="text-sm font-bold text-amber-600">{{ $percentage }}% Complete</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 bg-gradient-to-r from-amber-500 to-yellow-600"
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
                                {{ $i < $step ? 'bg-amber-500 text-white' : ($i == $step ? 'bg-amber-600 text-white ring-4 ring-amber-200' : 'bg-gray-200 text-gray-500') }}">
                                @if($i < $step)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    {{ $i }}
                                @endif
                            </div>
                            @if($i < $totalSteps)
                                <div class="w-8 h-1 transition-all duration-300 {{ $i < $step ? 'bg-amber-500' : 'bg-gray-200' }}"></div>
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
                    <span class="text-sm font-bold text-amber-600">{{ $percentage }}% Complete</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                <div class="flex items-center">
                    <img src="{{ asset('assets/images/flags/greece.png') }}" alt="Greece" class="h-6 w-auto mr-3" onerror="this.style.display='none'">
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $currentTitle }}</h2>
                        <p class="text-amber-100 text-sm mt-1">{{ $currentDescription }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('greece-certificate.process-step', ['step' => $step]) }}" method="POST" enctype="multipart/form-data" class="p-6">
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
                            <a href="{{ route('greece-certificate.step', ['step' => $step - 1]) }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition min-h-[48px]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Previous
                            </a>
                        @else
                            <a href="{{ route('greece-certificate.index') }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition min-h-[48px]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
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
                                class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-yellow-600 text-white font-semibold rounded-lg hover:from-amber-600 hover:to-yellow-700 transition shadow-lg min-h-[48px]">
                            @if($step === 7)
                                Submit Application
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                Next Step
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-amber-700">
                        Your progress is automatically saved. Need help? Contact us via
                        <a href="{{ config('placemenet.whatsapp_link') }}" target="_blank" class="text-amber-600 hover:text-amber-700 font-medium">WhatsApp</a>
                        or email
                        <a href="mailto:{{ config('placemenet.support_email', 'support@placemenet.net') }}" class="text-amber-600 hover:text-amber-700 font-medium">support@placemenet.net</a>
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
