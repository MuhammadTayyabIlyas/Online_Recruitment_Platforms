@extends('greece-certificate.layout')

@section('form-content')
<!-- Step 4: Current Address -->
<div class="space-y-6">
    <div class="bg-amber-50 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Current Address</h3>
        <p class="text-sm text-gray-600">Enter your current address where you can receive correspondence about your application.</p>
    </div>

    <div>
        <label for="current_address_line1" class="block text-sm font-medium text-gray-700 mb-1">
            Address Line 1 <span class="text-red-500">*</span>
        </label>
        <input type="text" name="current_address_line1" id="current_address_line1"
               value="{{ old('current_address_line1', $application->current_address_line1 ?? '') }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('current_address_line1') border-red-500 @enderror"
               placeholder="Street address, building number"
               required>
        @error('current_address_line1')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="current_address_line2" class="block text-sm font-medium text-gray-700 mb-1">
            Address Line 2
        </label>
        <input type="text" name="current_address_line2" id="current_address_line2"
               value="{{ old('current_address_line2', $application->current_address_line2 ?? '') }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
               placeholder="Apartment, suite, floor (optional)">
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="current_city" class="block text-sm font-medium text-gray-700 mb-1">
                City <span class="text-red-500">*</span>
            </label>
            <input type="text" name="current_city" id="current_city"
                   value="{{ old('current_city', $application->current_city ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('current_city') border-red-500 @enderror"
                   required>
            @error('current_city')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="current_postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                Postal Code <span class="text-red-500">*</span>
            </label>
            <input type="text" name="current_postal_code" id="current_postal_code"
                   value="{{ old('current_postal_code', $application->current_postal_code ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('current_postal_code') border-red-500 @enderror"
                   placeholder="e.g., 10557"
                   required>
            @error('current_postal_code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="current_country" class="block text-sm font-medium text-gray-700 mb-1">
            Country <span class="text-red-500">*</span>
        </label>
        <div class="w-full md:w-1/2">
            <x-country-select
                name="current_country"
                :value="old('current_country', $application->current_country ?? 'Greece')"
                :required="true"
                placeholder="Select country"
            />
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg mt-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    <strong>Note:</strong> This address will be used for all correspondence regarding your application. Make sure it is accurate and you can receive mail at this address.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
