@extends('layouts.app')

@section('title', 'Application Submitted - UK Police Character Certificate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Success Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-12 text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-white/20 mb-4">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Application Submitted!</h1>
                <p class="text-green-100">Your UK Police Character Certificate application has been received.</p>
            </div>

            <!-- Application Details -->
            <div class="p-6 md:p-8">
                <!-- Reference Number -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 mb-6 text-center">
                    <p class="text-sm text-blue-600 mb-1">Your Application Reference</p>
                    <p class="text-3xl font-bold text-blue-700 font-mono tracking-wider">{{ $application->application_reference }}</p>
                    <p class="text-xs text-blue-500 mt-1">Save this number for your records</p>
                </div>

                <!-- What Happens Next -->
                <h2 class="text-xl font-bold text-gray-900 mb-4">What Happens Next?</h2>
                
                <div class="space-y-4 mb-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">1</div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">Make Your Payment</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Transfer <strong>{{ $application->payment_amount_display }}</strong> to one of the bank accounts provided.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">2</div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">Upload Payment Receipt</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Log into your portal and upload your transaction receipt for verification.
                            </p>
                            @auth
                                <a href="{{ route('police-certificate.receipt.show', ['reference' => $application->application_reference]) }}" 
                                   class="inline-flex items-center mt-2 text-sm font-medium text-blue-600 hover:text-blue-500">
                                    Upload Receipt Now
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <p class="text-sm text-gray-500 mt-1">
                                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a> to upload your receipt.
                                </p>
                            @endauth
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">3</div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">We Process Your Application</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Once payment is verified, we'll process your application within 
                                <strong>{{ $application->service_type == 'urgent' ? '7' : '14' }} working days</strong>.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">4</div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">Receive Your Certificate</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                We'll notify you when your Police Character Certificate is ready.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Important</h3>
                            <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside space-y-1">
                                <li>Save your reference number: <strong>{{ $application->application_reference }}</strong></li>
                                <li>A confirmation email has been sent to: <strong>{{ $application->email }}</strong></li>
                                <li>Please upload your payment receipt within 48 hours</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Download Payment PDF -->
                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-5 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-indigo-900 mb-1">Payment Details Document</h3>
                            <p class="text-sm text-indigo-700">Download your payment instructions as a PDF for your records.</p>
                        </div>
                        <a href="{{ route('police-certificate.download-payment-pdf', $application->application_reference) }}"
                           class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download PDF
                        </a>
                    </div>
                </div>

                <!-- Bank Account Details -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Bank Transfer Details
                    </h3>

                    <!-- GBP Account -->
                    <div class="bg-white rounded-lg p-4 border border-gray-100 mb-3">
                        <h4 class="font-medium text-gray-900 mb-2 text-sm">GBP Account (Wise)</h4>
                        <div class="grid grid-cols-2 gap-1 text-sm">
                            <span class="text-gray-500">Account Name:</span>
                            <span class="font-medium">PLACEMENET I.K.E.</span>
                            <span class="text-gray-500">Account Number:</span>
                            <span class="font-medium font-mono">21126413</span>
                            <span class="text-gray-500">Sort Code:</span>
                            <span class="font-medium font-mono">23-08-01</span>
                            <span class="text-gray-500">IBAN:</span>
                            <span class="font-medium font-mono text-xs">GB52 TRWI 2308 0121 1264 13</span>
                            <span class="text-gray-500">SWIFT/BIC:</span>
                            <span class="font-medium font-mono">TRWIGB2LXXX</span>
                        </div>
                    </div>

                    <!-- EUR Account -->
                    <div class="bg-white rounded-lg p-4 border border-gray-100">
                        <h4 class="font-medium text-gray-900 mb-2 text-sm">EUR Account (Wise)</h4>
                        <div class="grid grid-cols-2 gap-1 text-sm">
                            <span class="text-gray-500">Account Name:</span>
                            <span class="font-medium">PLACEMENET I.K.E.</span>
                            <span class="text-gray-500">IBAN:</span>
                            <span class="font-medium font-mono">BE10 9677 3176 2104</span>
                            <span class="text-gray-500">SWIFT/BIC:</span>
                            <span class="font-medium font-mono">TRWIBEB1XXX</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="text-center">
                    <p class="text-gray-600 mb-4">Questions? We're here to help.</p>
                    <div class="flex justify-center gap-4">
                        <a href="mailto:info@placemenet.com" class="inline-flex items-center text-blue-600 hover:text-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            info@placemenet.com
                        </a>
                        <a href="https://wa.me/3464867464" target="_blank" class="inline-flex items-center text-green-600 hover:text-green-500">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-8">
            <a href="{{ url('/') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Return to Home
            </a>
        </div>
    </div>
</div>
@endsection