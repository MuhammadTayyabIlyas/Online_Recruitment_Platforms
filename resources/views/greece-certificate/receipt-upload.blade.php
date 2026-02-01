@extends('layouts.app')

@section('title', 'Upload Payment Receipt - Greece Penal Record Certificate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Upload Payment Receipt</h1>
            <p class="text-gray-600">Application Reference: <span class="font-semibold text-amber-600">{{ $application->application_reference }}</span></p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Payment Confirmation</h2>
                <p class="text-amber-100 text-sm">Please upload your bank transfer receipt</p>
            </div>

            <form action="{{ route('greece-certificate.receipt.upload', $application->application_reference) }}" method="POST" enctype="multipart/form-data" class="p-6">
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

                <!-- Payment Details -->
                <div class="bg-amber-50 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Expected Payment</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-medium">{{ number_format($application->payment_amount, 2) }} EUR</span>
                        <span class="text-gray-600">Reference:</span>
                        <span class="font-medium">{{ $application->application_reference }}</span>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Transaction Reference -->
                    <div>
                        <label for="transaction_reference" class="block text-sm font-medium text-gray-700 mb-1">
                            Transaction Reference / ID <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="transaction_reference" id="transaction_reference"
                               value="{{ old('transaction_reference') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('transaction_reference') border-red-500 @enderror"
                               placeholder="Bank transaction reference number"
                               required>
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
                               max="{{ date('Y-m-d') }}"
                               class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('transaction_date') border-red-500 @enderror"
                               required>
                        @error('transaction_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount Paid -->
                    <div>
                        <label for="transaction_amount" class="block text-sm font-medium text-gray-700 mb-1">
                            Amount Paid (EUR) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="transaction_amount" id="transaction_amount"
                               value="{{ old('transaction_amount', $application->payment_amount) }}"
                               class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('transaction_amount') border-red-500 @enderror"
                               required>
                        @error('transaction_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Receipt Upload -->
                    <div>
                        <label for="receipt" class="block text-sm font-medium text-gray-700 mb-1">
                            Payment Receipt <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-amber-400 transition @error('receipt') border-red-500 @enderror">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="receipt" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500">
                                        <span>Upload receipt</span>
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
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-amber-500 to-yellow-600 text-white font-semibold rounded-lg hover:from-amber-600 hover:to-yellow-700 transition shadow-lg">
                        Upload Receipt
                    </button>
                </div>
            </form>
        </div>

        <!-- Back Link -->
        <div class="mt-6 text-center">
            <a href="{{ route('service_user.dashboard') }}" class="text-amber-600 hover:text-amber-700 font-medium">
                &larr; Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
