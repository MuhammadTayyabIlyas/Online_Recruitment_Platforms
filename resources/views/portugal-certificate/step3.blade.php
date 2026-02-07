@extends('portugal-certificate.layout')

@section('form-content')
<!-- Step 3: Portugal Residence History -->
@php
    $existingResidences = is_array($application->portugal_residence_history) ? $application->portugal_residence_history : [];
    $defaultResidences = count($existingResidences) > 0 ? $existingResidences : [['from_date' => '', 'to_date' => '', 'address' => '', 'city' => '']];
@endphp
<div class="space-y-6" x-data="{
    residences: {{ json_encode(old('portugal_residence_history', $defaultResidences)) }},
    addResidence() {
        this.residences.push({ from_date: '', to_date: '', address: '', city: '' });
    },
    removeResidence(index) {
        if (this.residences.length > 1) {
            this.residences.splice(index, 1);
        }
    }
}">
    <div class="bg-green-50 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Portugal Residence History</h3>
        <p class="text-sm text-gray-600">List all addresses where you have lived in Portugal. Start with the most recent.</p>
    </div>

    <!-- Residence Entries -->
    <template x-for="(residence, index) in residences" :key="index">
        <div class="bg-white border border-gray-200 rounded-xl p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-semibold text-gray-900" x-text="'Residence ' + (index + 1)"></h4>
                <button type="button"
                        x-show="residences.length > 1"
                        @click="removeResidence(index)"
                        class="text-red-500 hover:text-red-700 text-sm font-medium">
                    Remove
                </button>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label :for="'from_date_' + index" class="block text-sm font-medium text-gray-700 mb-1">
                        From Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           :name="'portugal_residence_history[' + index + '][from_date]'"
                           :id="'from_date_' + index"
                           x-model="residence.from_date"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           required>
                </div>

                <div>
                    <label :for="'to_date_' + index" class="block text-sm font-medium text-gray-700 mb-1">
                        To Date <span class="text-gray-400">(leave empty if current)</span>
                    </label>
                    <input type="date"
                           :name="'portugal_residence_history[' + index + '][to_date]'"
                           :id="'to_date_' + index"
                           x-model="residence.to_date"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <div class="mb-4">
                <label :for="'address_' + index" class="block text-sm font-medium text-gray-700 mb-1">
                    Full Address <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       :name="'portugal_residence_history[' + index + '][address]'"
                       :id="'address_' + index"
                       x-model="residence.address"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="Street address, building, apartment"
                       required>
            </div>

            <div>
                <label :for="'city_' + index" class="block text-sm font-medium text-gray-700 mb-1">
                    City <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       :name="'portugal_residence_history[' + index + '][city]'"
                       :id="'city_' + index"
                       x-model="residence.city"
                       class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="e.g., Lisboa, Porto, Faro"
                       required>
            </div>
        </div>
    </template>

    <!-- Add More Button -->
    <button type="button"
            @click="addResidence()"
            class="w-full py-3 border-2 border-dashed border-gray-300 rounded-xl text-gray-600 hover:border-green-500 hover:text-green-600 transition flex items-center justify-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Another Residence
    </button>

    <!-- Social Security Number -->
    <div class="mt-8" x-data="{ noNiss: {{ old('no_portugal_social_security_number', $application->no_portugal_social_security_number ?? false) ? 'true' : 'false' }} }">
        <div class="bg-gray-50 rounded-lg p-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Social Security (Optional)</h3>
            <p class="text-sm text-gray-600">If you have a Portuguese social security number (NISS), please provide it.</p>
        </div>

        <div class="md:w-1/2">
            <label for="portugal_social_security_number" class="block text-sm font-medium text-gray-700 mb-1">
                NISS (Social Security Number)
            </label>
            <input type="text" name="portugal_social_security_number" id="portugal_social_security_number"
                   value="{{ old('portugal_social_security_number', $application->portugal_social_security_number ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   :class="{ 'bg-gray-100': noNiss }"
                   :disabled="noNiss"
                   placeholder="e.g., 12345678901">
            <p class="mt-1 text-xs text-gray-500">11-digit social security number issued by Segurança Social</p>

            <!-- I don't have this checkbox -->
            <div class="mt-2">
                <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-gray-800 min-h-[44px]">
                    <input type="checkbox" name="no_portugal_social_security_number" value="1"
                           x-model="noNiss"
                           class="h-4 w-4 text-green-600 border-gray-300 rounded mr-2 cursor-pointer">
                    I don't have this information
                </label>
            </div>
        </div>
    </div>
</div>
@endsection
