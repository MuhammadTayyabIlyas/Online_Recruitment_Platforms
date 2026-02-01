@extends('layouts.app')

@section('title', 'Application Submitted - Greece Penal Record Certificate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-8 py-10 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Application Submitted!</h1>
                <p class="text-amber-100">Your Greece Penal Record Certificate application has been received.</p>
            </div>

            <!-- Content -->
            <div class="px-8 py-8">
                <!-- Reference Number -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8 text-center">
                    <p class="text-sm text-gray-600 mb-2">Your Application Reference</p>
                    <p class="text-3xl font-bold text-amber-700 tracking-wider">{{ $application->application_reference }}</p>
                    <p class="text-xs text-gray-500 mt-2">Please save this reference for future enquiries</p>
                </div>

                <!-- Application Details -->
                <div class="space-y-4 mb-8">
                    <h3 class="font-semibold text-gray-900">Application Details</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Applicant:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $application->first_name }} {{ $application->last_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Service Type:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $application->service_type === 'urgent' ? 'Urgent (2-3 days)' : 'Normal (5-7 days)' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Purpose:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $application->purpose_label }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Amount Due:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ number_format($application->payment_amount, 2) }} EUR</span>
                        </div>
                    </div>
                </div>

                <!-- Download Payment PDF -->
                <div class="bg-yellow-50 border border-yellow-300 rounded-xl p-6 mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-900 mb-1">Payment Details Document</h3>
                            <p class="text-sm text-yellow-700">Download your payment instructions as a PDF for your records.</p>
                        </div>
                        <a href="{{ route('greece-certificate.download-payment-pdf', $application->application_reference) }}"
                           class="inline-flex items-center px-5 py-2.5 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download PDF
                        </a>
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-amber-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Next Step: Complete Payment
                    </h3>
                    <p class="text-sm text-amber-700 mb-4">Please make a bank transfer to complete your application:</p>

                    <div class="bg-white rounded-lg p-4 text-sm space-y-2">
                        <p><strong>Bank:</strong> National Bank of Greece</p>
                        <p><strong>IBAN:</strong> GR00 0000 0000 0000 0000 0000 000</p>
                        <p><strong>BIC/SWIFT:</strong> ETHNGRAA</p>
                        <p><strong>Amount:</strong> {{ number_format($application->payment_amount, 2) }} EUR</p>
                        <p><strong>Reference:</strong> {{ $application->application_reference }}</p>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('greece-certificate.receipt.show', $application->application_reference) }}"
                           class="inline-flex items-center px-6 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload Payment Receipt
                        </a>
                    </div>
                </div>

                <!-- What's Next -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="font-semibold text-gray-900 mb-4">What Happens Next?</h3>
                    <ol class="space-y-4">
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center font-bold text-sm mr-3">1</span>
                            <div>
                                <p class="font-medium text-gray-900">Complete Payment</p>
                                <p class="text-sm text-gray-600">Transfer the fee and upload your receipt</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center font-bold text-sm mr-3">2</span>
                            <div>
                                <p class="font-medium text-gray-900">Payment Verification</p>
                                <p class="text-sm text-gray-600">We'll verify your payment within 24 hours</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center font-bold text-sm mr-3">3</span>
                            <div>
                                <p class="font-medium text-gray-900">Application Processing</p>
                                <p class="text-sm text-gray-600">We submit your application to Greek authorities</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center font-bold text-sm mr-3">4</span>
                            <div>
                                <p class="font-medium text-gray-900">Certificate Delivery</p>
                                <p class="text-sm text-gray-600">Receive your certificate via email</p>
                            </div>
                        </li>
                    </ol>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('service_user.dashboard') }}"
                       class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Go to Dashboard
                    </a>
                    <a href="{{ route('greece-certificate.index') }}"
                       class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Application
                    </a>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Need help? Contact us via
                <a href="{{ config('placemenet.whatsapp_link') }}" target="_blank" class="text-amber-600 hover:text-amber-700 font-medium">WhatsApp</a>
                or email
                <a href="mailto:{{ config('placemenet.support_email', 'support@placemenet.net') }}" class="text-amber-600 hover:text-amber-700 font-medium">support@placemenet.net</a>
            </p>
        </div>
    </div>
</div>
@endsection
