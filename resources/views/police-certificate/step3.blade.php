@extends('police-certificate.layout')

@section('form-content')
<!-- Step 3: UK Residence History -->
<div class="space-y-6" x-data="{ residences: {{ json_encode(old('uk_residence_history', $application->uk_residence_history ?? [['entry_date' => '', 'exit_date' => '', 'visa_category' => '', 'notes' => '']])) }} }">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    Add each period you stayed in the UK. Include all visa categories you held.
                </p>
            </div>
        </div>
    </div>

    <template x-for="(residence, index) in residences" :key="index">
        <div class="bg-gray-50 rounded-lg p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">UK Stay <span x-text="index + 1"></span></h3>
                <button type="button" @click="residences.splice(index, 1)" x-show="residences.length > 1" 
                        class="text-red-600 hover:text-red-800 text-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Remove
                </button>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Entry Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" :name="`uk_residence_history[${index}][entry_date]`" 
                           x-model="residence.entry_date"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Exit Date (leave blank if current)
                    </label>
                    <input type="date" :name="`uk_residence_history[${index}][exit_date]`" 
                           x-model="residence.exit_date"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Visa Category <span class="text-red-500">*</span>
                </label>
                <select :name="`uk_residence_history[${index}][visa_category]`" 
                        x-model="residence.visa_category"
                        class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <option value="">Select visa type</option>
                    <option value="Student Visa">Student Visa</option>
                    <option value="Work Visa">Work Visa</option>
                    <option value="Skilled Worker Visa">Skilled Worker Visa</option>
                    <option value="Family Visa">Family Visa</option>
                    <option value="Asylum/Humanitarian">Asylum / Humanitarian</option>
                    <option value="Visitor Visa">Visitor Visa</option>
                    <option value="Other">Other (specify in notes)</option>
                </select>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Additional Notes
                </label>
                <textarea :name="`uk_residence_history[${index}][notes]`" 
                          x-model="residence.notes"
                          rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Any additional details about this stay"></textarea>
            </div>
        </div>
    </template>

    <button type="button" @click="residences.push({entry_date: '', exit_date: '', visa_category: '', notes: ''})" 
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Another Stay
    </button>

    <!-- UK National Insurance Number -->
    <div class="mt-6">
        <label for="uk_national_insurance_number" class="block text-sm font-medium text-gray-700 mb-1">
            UK National Insurance Number (if available)
        </label>
        <input type="text" name="uk_national_insurance_number" id="uk_national_insurance_number" 
               value="{{ old('uk_national_insurance_number', $application->uk_national_insurance_number ?? '') }}"
               class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               placeholder="e.g., AB123456C">
        @error('uk_national_insurance_number')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
@endsection