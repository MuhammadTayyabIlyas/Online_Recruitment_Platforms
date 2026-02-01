@extends('greece-certificate.layout')

@section('form-content')
<!-- Step 5: Contact Information -->
<div class="space-y-6">
    <div class="bg-amber-50 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Contact Information</h3>
        <p class="text-sm text-gray-600">Please provide your contact details so we can reach you about your application.</p>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
            Email Address <span class="text-red-500">*</span>
        </label>
        <input type="email" name="email" id="email"
               value="{{ old('email', $application->email ?? auth()->user()->email ?? '') }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('email') border-red-500 @enderror"
               placeholder="your.email@example.com"
               required>
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-xs text-gray-500">We'll send application updates to this email</p>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">
                Phone Number <span class="text-red-500">*</span>
            </label>
            <input type="tel" name="phone_number" id="phone_number"
                   value="{{ old('phone_number', $application->phone_number ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('phone_number') border-red-500 @enderror"
                   placeholder="+30 XXX XXX XXXX"
                   required>
            @error('phone_number')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-1">
                WhatsApp Number
            </label>
            <input type="tel" name="whatsapp_number" id="whatsapp_number"
                   value="{{ old('whatsapp_number', $application->whatsapp_number ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                   placeholder="+30 XXX XXX XXXX">
            <p class="mt-1 text-xs text-gray-500">Optional - for faster communication</p>
        </div>
    </div>

    <!-- Communication Preferences -->
    <div class="bg-gray-50 rounded-lg p-4 mt-6">
        <h4 class="font-medium text-gray-900 mb-3">How We'll Contact You</h4>
        <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-amber-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span><strong>Email:</strong> Application confirmations, status updates, and certificate delivery</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-amber-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span><strong>Phone/WhatsApp:</strong> Urgent matters or clarifications needed</span>
            </li>
        </ul>
    </div>
</div>
@endsection
