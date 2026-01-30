@extends('layouts.app')

@section('title', 'Upload Payment Receipt - UK Police Character Certificate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-6">
                <h1 class="text-2xl font-bold text-white">Upload Payment Receipt</h1>
                <p class="text-blue-100 mt-1">Application: <span class="font-mono">{{ $application->application_reference }}</span></p>
            </div>

            <div class="p-6 md:p-8">
                <!-- Application Summary -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Application Summary</h2>
                    <div class="grid md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Service:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $application->service_type_label }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Amount Due:</span>
                            <span class="font-bold text-blue-700 ml-2">{{ $application->payment_amount_display }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Applicant:</span>
                            <span class="font-medium text-gray-900 ml-2">{{ $application->full_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                Payment Pending
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Bank Account Details -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="text-md font-semibold text-blue-900 mb-3">Payment Instructions</h3>
                    <p class="text-sm text-blue-700 mb-4">
                        Please transfer <strong>{{ $application->payment_amount_display }}</strong> to one of the following accounts:
                    </p>
                    
                    <div class="space-y-3">
                        <div class="bg-white rounded p-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase">UK Bank</span>
                            <p class="font-mono text-sm mt-1">Sort Code: 12-34-56 | Account: 12345678</p>
                            <p class="font-mono text-sm">IBAN: GB29NWBK60161331926819</p>
                        </div>
                        <div class="bg-white rounded p-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Spanish Bank</span>
                            <p class="font-mono text-sm mt-1">IBAN: ES9121000418450200051332</p>
                        </div>
                        <div class="bg-white rounded p-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Bizum</span>
                            <p class="font-mono text-sm mt-1">+34 666 123 456</p>
                        </div>
                    </div>
                    <p class="text-xs text-blue-600 mt-3">
                        <strong>Important:</strong> Include your name "{{ $application->full_name }}" in the payment reference.
                    </p>
                </div>

                <!-- Upload Form -->
                <form action="{{ route('police-certificate.receipt.upload', ['reference' => $application->application_reference]) }}" 
                      method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
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

                    <!-- Transaction Reference -->
                    <div>
                        <label for="transaction_reference" class="block text-sm font-medium text-gray-700 mb-1">
                            Transaction Reference <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="transaction_reference" id="transaction_reference" 
                               value="{{ old('transaction_reference') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('transaction_reference') border-red-500 @enderror"
                               placeholder="e.g., TRX123456789 or Bizum reference" required>
                        @error('transaction_reference')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transaction Date -->
                    <div>
                        <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Transaction Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="transaction_date" id="transaction_date" 
                               value="{{ old('transaction_date') }}"
                               class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('transaction_date') border-red-500 @enderror"
                               required>
                        @error('transaction_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transaction Amount -->
                    <div>
                        <label for="transaction_amount" class="block text-sm font-medium text-gray-700 mb-1">
                            Amount Transferred <span class="text-red-500">*</span>
                        </label>
                        <div class="relative w-full md:w-1/2">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                {{ $application->payment_currency === 'gbp' ? '£' : '€' }}
                            </span>
                            <input type="number" name="transaction_amount" id="transaction_amount" 
                                   value="{{ old('transaction_amount', $application->payment_amount) }}"
                                   step="0.01"
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('transaction_amount') border-red-500 @enderror"
                                   required>
                        </div>
                        @error('transaction_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Receipt Upload -->
                    <div>
                        <label for="receipt" class="block text-sm font-medium text-gray-700 mb-1">
                            Upload Receipt <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 transition-colors @error('receipt') border-red-500 @enderror">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="receipt" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Select a file</span>
                                        <input id="receipt" name="receipt" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB</p>
                            </div>
                        </div>
                        @error('receipt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg">
                            Upload Receipt
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Need Help -->
                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-gray-600 mb-2">Having trouble with payment?</p>
                    <a href="mailto:support@placemenet.com" class="text-blue-600 hover:text-blue-500 font-medium">
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection