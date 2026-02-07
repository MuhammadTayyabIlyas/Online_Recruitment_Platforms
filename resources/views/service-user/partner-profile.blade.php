@extends('layouts.app')

@section('title', 'Partner Profile')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('service_user.dashboard') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium mb-4">
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Authorized Partner Profile</h1>
        <p class="mt-2 text-gray-600">Manage your partner business information.</p>
    </div>

    <!-- Success / Error Messages -->
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 border-l-4 border-green-500">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 p-4 border-l-4 border-red-500">
            <span class="text-red-700">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Status Banner -->
    <div class="mb-6">
        @switch($partner->status)
            @case('pending_profile')
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-blue-700 font-medium">Please complete your business profile below to proceed with the partner application.</p>
                    </div>
                </div>
                @break
            @case('pending_review')
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-yellow-700 font-medium">Your profile is under review. We will notify you once it has been reviewed.</p>
                    </div>
                </div>
                @break
            @case('active')
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-green-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-green-700 font-medium">You are an approved Authorized Partner!</p>
                            <p class="text-green-600 text-sm mt-1">
                                Reference: <span class="font-mono font-semibold">{{ $partner->reference_number }}</span> |
                                Valid until: <span class="font-semibold">{{ $partner->expires_at?->format('M d, Y') }}</span>
                            </p>
                            @if($partner->authorized_countries)
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @foreach($partner->authorized_country_labels as $label)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-200 text-green-800">{{ $label }}</span>
                                    @endforeach
                                </div>
                            @endif
                            @if($partner->certificate_path)
                                <a href="{{ route('partner.certificate.download') }}" class="inline-flex items-center mt-3 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download Certificate
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @break
            @case('suspended')
                <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg">
                    <p class="text-orange-700 font-medium">Your partner account has been suspended. Please contact us for more information.</p>
                </div>
                @break
            @case('revoked')
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <p class="text-red-700 font-medium">Your partner account has been revoked. Please contact us if you believe this is an error.</p>
                </div>
                @break
        @endswitch
    </div>

    <!-- Profile Form -->
    @if(!in_array($partner->status, ['revoked']))
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Business Information
            </h2>
        </div>

        <form action="{{ route('partner.profile.update') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Business Name -->
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name <span class="text-red-500">*</span></label>
                    <input type="text" name="business_name" id="business_name" value="{{ old('business_name', $partner->business_name) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('business_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Tax ID -->
                <div>
                    <label for="tax_id" class="block text-sm font-medium text-gray-700">Tax ID (CIF/NIF) <span class="text-red-500">*</span></label>
                    <input type="text" name="tax_id" id="tax_id" value="{{ old('tax_id', $partner->tax_id) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('tax_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Address Line 1 -->
                <div class="md:col-span-2">
                    <label for="address_line1" class="block text-sm font-medium text-gray-700">Address Line 1 <span class="text-red-500">*</span></label>
                    <input type="text" name="address_line1" id="address_line1" value="{{ old('address_line1', $partner->address_line1) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('address_line1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Address Line 2 -->
                <div class="md:col-span-2">
                    <label for="address_line2" class="block text-sm font-medium text-gray-700">Address Line 2</label>
                    <input type="text" name="address_line2" id="address_line2" value="{{ old('address_line2', $partner->address_line2) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('address_line2') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City <span class="text-red-500">*</span></label>
                    <input type="text" name="city" id="city" value="{{ old('city', $partner->city) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Postal Code -->
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code <span class="text-red-500">*</span></label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $partner->postal_code) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('postal_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Country -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700">Country <span class="text-red-500">*</span></label>
                    <x-country-select name="country" :value="old('country', $partner->country)" required />
                    @error('country') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $partner->phone) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Contact Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $partner->email) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 shadow-sm transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ $partner->status === 'pending_profile' ? 'Submit for Review' : 'Update Profile' }}
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
