@php
$stepTitles = [
    1 => 'Personal Information',
    2 => 'Identification Documents',
    3 => 'Portugal Residence History',
    4 => 'Current Address',
    5 => 'Contact Information',
    6 => 'Service & Payment',
];

$stepDescriptions = [
    1 => 'Enter your personal details as they appear on your passport',
    2 => 'Upload your passport and residence permit documents',
    3 => 'Provide details of your residence history in Portugal',
    4 => 'Enter your current address for certificate delivery',
    5 => 'How we can contact you during the application process',
    6 => 'Select your service type and view payment instructions',
];

$currentTitle = $stepTitles[$step] ?? '';
$currentDescription = $stepDescriptions[$step] ?? '';
@endphp

@extends('layouts.app')

@section('title', 'Step ' . $step . ' - Portugal Criminal Record Certificate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                @for($i = 1; $i <= 6; $i++)
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm
                            {{ $i < $step ? 'bg-green-500 text-white' : ($i == $step ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-500') }}">
                            @if($i < $step)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                {{ $i }}
                            @endif
                        </div>
                        @if($i < 6)
                            <div class="w-12 h-1 {{ $i < $step ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                        @endif
                    </div>
                @endfor
            </div>
            <div class="text-center">
                <span class="text-sm font-medium text-gray-600">Step {{ $step }} of 6</span>
                <span class="mx-2 text-gray-300">|</span>
                <span class="text-sm text-gray-500">{{ $currentTitle }}</span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-4">
                <div class="flex items-center">
                    <img src="{{ asset('assets/images/flags/portugal.png') }}" alt="Portugal" class="h-6 w-auto mr-3" onerror="this.style.display='none'">
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $currentTitle }}</h2>
                        <p class="text-green-100 text-sm mt-1">{{ $currentDescription }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('portugal-certificate.process-step', ['step' => $step]) }}" method="POST" enctype="multipart/form-data" class="p-6">
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
                        <a href="{{ route('portugal-certificate.step', ['step' => $step - 1]) }}"
                           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </a>
                    @else
                        <a href="{{ route('portugal-certificate.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                    @endif

                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-700 hover:to-emerald-700 transition shadow-lg">
                        @if($step === 6)
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
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Need help? Contact us via
                <a href="{{ config('placemenet.whatsapp_link') }}" target="_blank" class="text-green-600 hover:text-green-700 font-medium">WhatsApp</a>
                or email
                <a href="mailto:{{ config('placemenet.support_email', 'support@placemenet.net') }}" class="text-green-600 hover:text-green-700 font-medium">support@placemenet.net</a>
            </p>
        </div>
    </div>
</div>
@endsection
