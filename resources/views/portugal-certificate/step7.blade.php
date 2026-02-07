@extends('portugal-certificate.layout')

@section('form-content')
<!-- Step 7: Service & Payment -->
<div class="space-y-6">
    <!-- Certificate Purpose -->
    <div class="bg-green-50 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Certificate Purpose</h3>
        <p class="text-sm text-gray-600">Please indicate why you need this certificate.</p>
    </div>

    <div>
        <label for="certificate_purpose" class="block text-sm font-medium text-gray-700 mb-1">
            Purpose of Certificate <span class="text-red-500">*</span>
        </label>
        <select name="certificate_purpose" id="certificate_purpose"
                class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('certificate_purpose') border-red-500 @enderror"
                required>
            <option value="">Select purpose</option>
            <option value="employment" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'employment' ? 'selected' : '' }}>Employment</option>
            <option value="immigration" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'immigration' ? 'selected' : '' }}>Immigration</option>
            <option value="visa" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'visa' ? 'selected' : '' }}>Visa Application</option>
            <option value="residency" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'residency' ? 'selected' : '' }}>Residency Permit</option>
            <option value="education" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'education' ? 'selected' : '' }}>Education/Study</option>
            <option value="adoption" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'adoption' ? 'selected' : '' }}>Adoption</option>
            <option value="other" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('certificate_purpose')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="purpose_details" class="block text-sm font-medium text-gray-700 mb-1">
            Additional Details
        </label>
        <textarea name="purpose_details" id="purpose_details" rows="2"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                  placeholder="Any additional information about why you need this certificate">{{ old('purpose_details', $application->purpose_details ?? '') }}</textarea>
    </div>

    <!-- Service Type Selection -->
    <div class="bg-green-50 rounded-lg p-4 mt-8 mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Select Service Type</h3>
        <p class="text-sm text-gray-600">Choose the processing speed that suits your needs.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-4" x-data="{ serviceType: '{{ old('service_type', $application->service_type ?? '') }}' }">
        <!-- Normal Service -->
        <label class="relative cursor-pointer">
            <input type="radio" name="service_type" value="normal" x-model="serviceType" class="sr-only peer" required>
            <div class="p-6 border-2 rounded-xl transition-all peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Normal Service</h4>
                        <p class="text-sm text-gray-600">Up to 30 days</p>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-gray-900">200</span>
                        <span class="text-sm text-gray-600">EUR</span>
                    </div>
                </div>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Full application handling
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Email support
                    </li>
                </ul>
            </div>
        </label>

        <!-- Urgent Service -->
        <label class="relative cursor-pointer">
            <input type="radio" name="service_type" value="urgent" x-model="serviceType" class="sr-only peer">
            <div class="p-6 border-2 rounded-xl transition-all peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 relative overflow-hidden">
                <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded-full">
                    FASTER
                </div>
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Urgent Service</h4>
                        <p class="text-sm text-gray-600">14 days</p>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-gray-900">250</span>
                        <span class="text-sm text-gray-600">EUR</span>
                    </div>
                </div>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Priority processing
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Dedicated case handler
                    </li>
                </ul>
            </div>
        </label>
    </div>
    @error('service_type')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror

    <!-- Payment Information -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Payment Instructions
        </h3>
        <p class="text-sm text-gray-700 mb-4">After submitting your application, you will need to make a bank transfer to complete the process.</p>
        <div class="bg-white rounded-lg p-4 text-sm">
            <p class="mb-2"><strong>Bank:</strong> Wise</p>
            <p class="mb-2"><strong>Account Name:</strong> PLACEMENET I.K.E.</p>
            <p class="mb-2"><strong>IBAN:</strong> BE10 9677 3176 2104</p>
            <p class="mb-2"><strong>BIC/SWIFT:</strong> TRWIBEB1XXX</p>
            <p><strong>Reference:</strong> Your application reference will be shown after submission</p>
        </div>
    </div>

    <!-- Terms & Conditions -->
    <div class="space-y-4 mt-8">
        <label class="flex items-start cursor-pointer">
            <input type="checkbox" name="terms_accepted" value="1"
                   class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 @error('terms_accepted') border-red-500 @enderror"
                   required>
            <span class="ml-2 text-sm text-gray-700">
                I accept the <a href="{{ route('privacy') }}" target="_blank" class="text-green-600 hover:underline">Terms and Conditions</a> and confirm that all information provided is accurate. <span class="text-red-500">*</span>
            </span>
        </label>
        @error('terms_accepted')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        <label class="flex items-start cursor-pointer">
            <input type="checkbox" name="privacy_accepted" value="1"
                   class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 @error('privacy_accepted') border-red-500 @enderror"
                   required>
            <span class="ml-2 text-sm text-gray-700">
                I consent to the processing of my personal data as described in the <a href="{{ route('privacy') }}" target="_blank" class="text-green-600 hover:underline">Privacy Policy</a>. <span class="text-red-500">*</span>
            </span>
        </label>
        @error('privacy_accepted')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <input type="hidden" name="payment_currency" value="eur">
</div>
@endsection
