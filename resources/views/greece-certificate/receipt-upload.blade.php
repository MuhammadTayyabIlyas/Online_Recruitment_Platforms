@extends('layouts.app')

@section('title', 'Upload Payment Receipt - Greece Penal Record Certificate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-6">
                <h1 class="text-2xl font-bold text-white">Upload Payment Receipt</h1>
                <p class="text-amber-100 mt-1">Application: {{ $application->application_reference }}</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Payment Details Reminder -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Payment Details</h3>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><strong>Amount Due:</strong> {{ number_format($application->payment_amount, 2) }} EUR</p>
                        <p><strong>Service:</strong> {{ $application->service_type === 'urgent' ? 'Urgent (15-20 days)' : 'Normal (Up to 30 days)' }}</p>
                    </div>
                </div>

                <!-- Uploaded Receipts -->
                @if($receipts->count() > 0)
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-amber-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Uploaded Receipts
                        </h3>
                        <div class="space-y-3">
                            @foreach($receipts as $receipt)
                                <div class="bg-white rounded-lg p-3 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                            @if(str_contains($receipt->mime_type, 'pdf'))
                                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $receipt->original_filename }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $receipt->description ?? '' }}
                                                <span class="ml-2">Uploaded {{ $receipt->created_at->diffForHumans() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <form action="{{ route('greece-certificate.receipt.delete', [$application->application_reference, $receipt->id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this receipt?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-2" title="Delete receipt">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Upload Form -->
                <form action="{{ route('greece-certificate.receipt.upload', $application->application_reference) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    @if($receipts->count() > 0)
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="font-semibold text-gray-900 mb-4">Upload Another Receipt</h3>
                        </div>
                    @endif

                    <div>
                        <label for="transaction_reference" class="block text-sm font-medium text-gray-700 mb-1">
                            Transaction Reference <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="transaction_reference" id="transaction_reference"
                               value="{{ old('transaction_reference') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('transaction_reference') border-red-500 @enderror"
                               placeholder="Bank transaction reference"
                               required>
                        @error('transaction_reference')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Transaction Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="transaction_date" id="transaction_date"
                                   value="{{ old('transaction_date') }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('transaction_date') border-red-500 @enderror"
                                   required>
                            @error('transaction_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="transaction_amount" class="block text-sm font-medium text-gray-700 mb-1">
                                Amount Paid (EUR) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="transaction_amount" id="transaction_amount"
                                   value="{{ old('transaction_amount', $application->payment_amount) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('transaction_amount') border-red-500 @enderror"
                                   required>
                            @error('transaction_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="receipt" class="block text-sm font-medium text-gray-700 mb-1">
                            Receipt/Proof of Payment <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-amber-400 transition @error('receipt') border-red-500 @enderror">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="receipt" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none">
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

                    <div class="flex gap-4 pt-4">
                        <a href="{{ route('service_user.dashboard') }}"
                           class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Back to Dashboard
                        </a>
                        <button type="submit"
                                class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload Receipt
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
