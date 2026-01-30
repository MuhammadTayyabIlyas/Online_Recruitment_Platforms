@extends('police-certificate.layout')

@section('form-content')
<!-- Step 5: Spain Current Address -->
<div class="space-y-6">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    Enter your current address in Spain where we can contact you and send your certificate.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 rounded-lg p-6">
        <div class="space-y-4">
            <div>
                <label for="spain_address_line1" class="block text-sm font-medium text-gray-700 mb-1">
                    Street Address <span class="text-red-500">*</span>
                </label>
                <input type="text" name="spain_address_line1" id="spain_address_line1" 
                       value="{{ old('spain_address_line1', $application->spain_address_line1 ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('spain_address_line1') border-red-500 @enderror"
                       placeholder="Calle, número, piso, puerta" required>
                @error('spain_address_line1')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="spain_address_line2" class="block text-sm font-medium text-gray-700 mb-1">
                    Apartment / Floor / Door (Optional)
                </label>
                <input type="text" name="spain_address_line2" id="spain_address_line2" 
                       value="{{ old('spain_address_line2', $application->spain_address_line2 ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('spain_address_line2') border-red-500 @enderror"
                       placeholder="Escalera, piso, puerta">
                @error('spain_address_line2')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label for="spain_city" class="block text-sm font-medium text-gray-700 mb-1">
                        City <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="spain_city" id="spain_city" 
                           value="{{ old('spain_city', $application->spain_city ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('spain_city') border-red-500 @enderror"
                           placeholder="e.g., Barcelona" required>
                    @error('spain_city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="spain_province" class="block text-sm font-medium text-gray-700 mb-1">
                        Province <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="spain_province" id="spain_province" 
                           value="{{ old('spain_province', $application->spain_province ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('spain_province') border-red-500 @enderror"
                           placeholder="e.g., Barcelona" required>
                    @error('spain_province')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="spain_postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                        Postal Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="spain_postal_code" id="spain_postal_code" 
                           value="{{ old('spain_postal_code', $application->spain_postal_code ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('spain_postal_code') border-red-500 @enderror"
                           placeholder="e.g., 08001" required>
                    @error('spain_postal_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Country
                </label>
                <input type="text" value="Spain" disabled
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                <input type="hidden" name="spain_country" value="Spain">
            </div>
        </div>
    </div>
</div>
@endsection