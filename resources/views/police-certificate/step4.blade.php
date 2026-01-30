@extends('police-certificate.layout')

@section('form-content')
<!-- Step 4: UK Address History -->
<div class="space-y-6" x-data="{ addresses: {{ json_encode(old('uk_address_history', $application->uk_address_history ?? [['address_line1' => '', 'address_line2' => '', 'city' => '', 'postcode' => '', 'from_date' => '', 'to_date' => '']])) }} }">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    List all addresses where you lived in the UK. You must include at least one address.
                </p>
            </div>
        </div>
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
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Another Address
    </button>
</div>
@endsection