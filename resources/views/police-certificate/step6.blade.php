@extends('police-certificate.layout')

@section('form-content')
<!-- Step 6: Contact Information -->
<div class="space-y-6">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    We'll use these details to contact you about your application. Please ensure they are accurate.
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
                    Mobile Phone (Spain) <span class="text-red-500">*</span>
                </label>
                <input type="tel" name="phone_spain" id="phone_spain" 
                       value="{{ old('phone_spain', $application->phone_spain ?? '') }}"
                       class="w-full md:w-2/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone_spain') border-red-500 @enderror"
                       placeholder="+34 612 345 678" required>
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
                       placeholder="+34 612 345 678">
                @error('whatsapp_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Optional, but recommended for quick updates.</p>
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

    <!-- Communication Preferences -->
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Preferred Contact Method</h3>
        <div class="space-y-3">
            <label class="flex items-center">
                <input type="radio" name="preferred_contact" value="email" checked
                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <span class="ml-3 text-gray-700">Email</span>
            </label>
            <label class="flex items-center">
                <input type="radio" name="preferred_contact" value="whatsapp"
                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <span class="ml-3 text-gray-700">WhatsApp</span>
            </label>
            <label class="flex items-center">
                <input type="radio" name="preferred_contact" value="phone"
                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <span class="ml-3 text-gray-700">Phone Call</span>
            </label>
        </div>
    </div>
</div>
@endsection