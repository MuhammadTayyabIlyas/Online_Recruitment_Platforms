@extends('police-certificate.layout')

@section('form-content')
<!-- Step 5: Delivery Address in Spain -->
<div class="space-y-6">
    <!-- Important Notice about Delivery Address -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 mb-4">
        <div class="flex">
            <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <div class="ml-3">
                <h4 class="text-sm font-semibold text-blue-900 mb-1">Delivery Address in Spain</h4>
                <p class="text-sm text-blue-700">
                    This is where we'll <strong>send your police certificate</strong> once it's ready. Please provide a valid <strong>Spanish postal address</strong> where you can receive mail.
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
                       placeholder="e.g., Calle Gran Via 28, 3o Izq" required>
                <p class="mt-1 text-xs text-gray-500">Include street name, number, floor, and door if applicable</p>
                @error('spain_address_line1')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="spain_address_line2" class="block text-sm font-medium text-gray-700 mb-1">
                    Additional Address Details (Optional)
                </label>
                <input type="text" name="spain_address_line2" id="spain_address_line2"
                       value="{{ old('spain_address_line2', $application->spain_address_line2 ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('spain_address_line2') border-red-500 @enderror"
                       placeholder="e.g., Escalera B, Oficina 4">
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
                           placeholder="e.g., Madrid, Barcelona, Valencia" required>
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
                           placeholder="e.g., Madrid, Barcelona" required>
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
                           placeholder="e.g., 28013, 08001" required>
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

    <!-- Contact Information Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 mt-6 mb-4">
        <div class="flex">
            <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <div class="ml-3">
                <h4 class="text-sm font-semibold text-blue-900 mb-1">Contact Information</h4>
                <p class="text-sm text-blue-700">
                    We'll use these details to <strong>contact you about your application</strong>. Please ensure they are accurate.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 rounded-lg p-6">
        <div class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email"
                       value="{{ old('email', $application->email ?? '') }}"
                       class="w-full md:w-2/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                       placeholder="your.email@example.com" required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">We'll send confirmation and updates to this address.</p>
            </div>

            <div>
                <label for="phone_spain" class="block text-sm font-medium text-gray-700 mb-1">
                    Mobile Phone Number <span class="text-red-500">*</span>
                </label>
                <input type="tel" name="phone_spain" id="phone_spain"
                       value="{{ old('phone_spain', $application->phone_spain ?? '') }}"
                       class="w-full md:w-2/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone_spain') border-red-500 @enderror"
                       placeholder="+34 6XX XXX XXX" required>
                <p class="mt-1 text-xs text-gray-500">Spanish mobile (+34 6XX XXX XXX) or UK mobile (+44 7XXX XXXXXX)</p>
                @error('phone_spain')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-1">
                    WhatsApp Number
                </label>
                <input type="tel" name="whatsapp_number" id="whatsapp_number"
                       value="{{ old('whatsapp_number', $application->whatsapp_number ?? '') }}"
                       class="w-full md:w-2/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('whatsapp_number') border-red-500 @enderror"
                       placeholder="+34 6XX XXX XXX">
                <p class="mt-1 text-xs text-gray-500">Optional, but recommended for quick updates.</p>
                @error('whatsapp_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-start mt-4">
                <div class="flex items-center h-5">
                    <input type="checkbox" id="same_whatsapp"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                           onchange="document.getElementById('whatsapp_number').value = this.checked ? document.getElementById('phone_spain').value : ''">
                </div>
                <div class="ml-3 text-sm">
                    <label for="same_whatsapp" class="font-medium text-gray-700">
                        Same as mobile phone
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection