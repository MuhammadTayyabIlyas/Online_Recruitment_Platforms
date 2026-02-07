@extends('police-certificate.layout')

@section('form-content')
<!-- Step 4: UK Address History -->
@php
    $existingAddresses = is_array($application->uk_address_history) ? $application->uk_address_history : [];
    $defaultAddresses = count($existingAddresses) > 0 ? $existingAddresses : [['address_line1' => '', 'address_line2' => '', 'city' => '', 'postcode' => '', 'from_date' => '', 'to_date' => '']];
    $addressDatesApprox = $application->address_dates_approximate ?? false;
@endphp
<div class="space-y-6" x-data="{
    addresses: {{ json_encode(old('uk_address_history', $defaultAddresses)) }},
    addressDatesApproximate: {{ old('address_dates_approximate', $addressDatesApprox) ? 'true' : 'false' }}
}">
    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    List <strong>all addresses</strong> where you lived in the UK. You must include at least one address.
                </p>
            </div>
        </div>
    </div>

    <!-- Tips for Recalling Past Addresses -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 mb-6">
        <h4 class="font-medium text-blue-900 mb-2 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            Tips for Recalling Past Addresses
        </h4>
        <ul class="text-sm text-blue-700 space-y-1">
            <li class="flex items-start">
                <span class="mr-2">-</span>
                <span>Check old bank statements or utility bills for previous addresses</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">-</span>
                <span>Review your credit report (free from Experian, Equifax, TransUnion)</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">-</span>
                <span>Search emails for "new address" or moving confirmations</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">-</span>
                <span>Check old tenancy agreements or council tax letters</span>
            </li>
        </ul>
    </div>

    <template x-for="(address, index) in addresses" :key="index">
        <div class="bg-gray-50 rounded-lg p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">UK Address <span x-text="index + 1"></span></h3>
                <button type="button" @click="addresses.splice(index, 1)" x-show="addresses.length > 1" 
                        class="text-red-600 hover:text-red-800 text-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Remove
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Address Line 1 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" :name="`uk_address_history[${index}][address_line1]`" 
                           x-model="address.address_line1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="House number and street" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Address Line 2
                    </label>
                    <input type="text" :name="`uk_address_history[${index}][address_line2]`" 
                           x-model="address.address_line2"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Apartment, suite, unit, etc. (optional)">
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            City <span class="text-red-500">*</span>
                        </label>
                        <input type="text" :name="`uk_address_history[${index}][city]`" 
                               x-model="address.city"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="e.g., London" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Postcode <span class="text-red-500">*</span>
                        </label>
                        <input type="text" :name="`uk_address_history[${index}][postcode]`" 
                               x-model="address.postcode"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="e.g., SW1A 1AA" required>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            From Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" :name="`uk_address_history[${index}][from_date]`" 
                               x-model="address.from_date"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            To Date (leave blank if current)
                        </label>
                        <input type="date" :name="`uk_address_history[${index}][to_date]`" 
                               x-model="address.to_date"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>
    </template>

    <button type="button" @click="addresses.push({address_line1: '', address_line2: '', city: '', postcode: '', from_date: '', to_date: ''})"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 min-h-[44px]">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Another Address
    </button>

    <!-- Approximate Dates Checkbox -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <label class="flex items-start cursor-pointer">
            <input type="checkbox" name="address_dates_approximate" value="1"
                   x-model="addressDatesApproximate"
                   class="mt-1 h-4 w-4 text-yellow-600 border-gray-300 rounded mr-3 cursor-pointer">
            <span class="text-sm text-yellow-800">
                <strong>I can only provide approximate dates</strong>
                <p class="mt-1 text-yellow-700">Check this if you cannot recall exact move-in/move-out dates. We will proceed with the dates you provide.</p>
            </span>
        </label>
    </div>

    <!-- Notes for approximate dates -->
    <div x-show="addressDatesApproximate" x-transition class="mt-4">
        <label for="address_dates_notes" class="block text-sm font-medium text-gray-700 mb-1">
            Additional notes about dates (optional)
        </label>
        <textarea name="address_dates_notes" id="address_dates_notes"
                  rows="2"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  placeholder="e.g., I lived at Address 1 for approximately 2 years, but I'm not sure of exact dates">{{ old('address_dates_notes', $application->address_dates_notes ?? '') }}</textarea>
    </div>
</div>
@endsection