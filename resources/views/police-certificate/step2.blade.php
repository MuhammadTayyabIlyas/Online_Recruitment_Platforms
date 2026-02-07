@extends('police-certificate.layout')

@section('form-content')
<!-- Step 2: Identification Details -->
<div class="space-y-6">
    <!-- Passport-Style Photo -->
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
            <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Passport-Style Photo
        </h3>
        <p class="text-sm text-gray-600 mb-4">Take or upload a passport-style photo with a plain white background. Face should be clearly visible, no glasses or head covering (unless for religious reasons).</p>

        <x-document-upload
            name="photo_file"
            label="Passport-Style Photo"
            :required="!$hasPhoto"
            :existingFile="$hasPhoto"
            accept=".jpg,.jpeg,.png"
            helpText="JPG or PNG, white background, max 5MB"
            :showCamera="true"
            captureMode="user"
        />
    </div>

    <!-- Selfie Holding Passport -->
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
            <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Selfie While Holding Passport
        </h3>
        <p class="text-sm text-gray-600 mb-4">Take a selfie while holding your open passport next to your face. Both your face and the passport photo page must be clearly visible.</p>

        <x-document-upload
            name="selfie_passport_file"
            label="Selfie While Holding Passport"
            :required="!$hasSelfie"
            :existingFile="$hasSelfie"
            accept=".jpg,.jpeg,.png"
            helpText="JPG or PNG, hold open passport next to face, max 5MB"
            :showCamera="true"
            captureMode="user"
        />
    </div>

    <!-- Passport Information -->
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            Pakistani Passport
        </h3>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label for="passport_number" class="block text-sm font-medium text-gray-700 mb-1">
                    Passport Number <span class="text-red-500">*</span>
                </label>
                <input type="text" name="passport_number" id="passport_number"
                       value="{{ old('passport_number', $application->passport_number ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('passport_number') border-red-500 @enderror"
                       placeholder="e.g., AB1234567" required>
                @error('passport_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="passport_place_of_issue" class="block text-sm font-medium text-gray-700 mb-1">
                    Place of Issue <span class="text-red-500">*</span>
                </label>
                <input type="text" name="passport_place_of_issue" id="passport_place_of_issue"
                       value="{{ old('passport_place_of_issue', $application->passport_place_of_issue ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('passport_place_of_issue') border-red-500 @enderror"
                       placeholder="e.g., Islamabad" required>
                @error('passport_place_of_issue')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4 mt-4">
            <div>
                <label for="passport_issue_date" class="block text-sm font-medium text-gray-700 mb-1">
                    Date of Issue <span class="text-red-500">*</span>
                </label>
                @php
                    $issueValue = old('passport_issue_date');
                    if (!$issueValue && isset($application) && $application->passport_issue_date) {
                        $issueValue = $application->passport_issue_date instanceof \Carbon\Carbon
                            ? $application->passport_issue_date->format('Y-m-d')
                            : $application->passport_issue_date;
                    }
                @endphp
                <input type="date" name="passport_issue_date" id="passport_issue_date"
                       value="{{ $issueValue ?? '' }}"
                       max="{{ date('Y-m-d') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('passport_issue_date') border-red-500 @enderror"
                       required>
                @error('passport_issue_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="passport_expiry_date" class="block text-sm font-medium text-gray-700 mb-1">
                    Date of Expiry <span class="text-red-500">*</span>
                </label>
                @php
                    $expiryValue = old('passport_expiry_date');
                    if (!$expiryValue && isset($application) && $application->passport_expiry_date) {
                        $expiryValue = $application->passport_expiry_date instanceof \Carbon\Carbon
                            ? $application->passport_expiry_date->format('Y-m-d')
                            : $application->passport_expiry_date;
                    }
                @endphp
                <input type="date" name="passport_expiry_date" id="passport_expiry_date"
                       value="{{ $expiryValue ?? '' }}"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('passport_expiry_date') border-red-500 @enderror"
                       required>
                @error('passport_expiry_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Passport Upload -->
        <div class="mt-4">
            <x-document-upload
                name="passport_file"
                label="Upload Passport (Front & Back)"
                :required="!$hasPassport"
                :existingFile="$hasPassport"
                accept=".pdf,.jpg,.jpeg,.png"
                helpText="PDF, JPG, PNG up to 5MB"
                :showCamera="true"
                captureMode="environment"
            />
        </div>
    </div>

    <!-- CNIC/NICOP -->
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
            </svg>
            CNIC / NICOP
        </h3>

        <div>
            <label for="cnic_nicop_number" class="block text-sm font-medium text-gray-700 mb-1">
                CNIC/NICOP Number <span class="text-red-500">*</span>
            </label>
            <input type="text" name="cnic_nicop_number" id="cnic_nicop_number"
                   value="{{ old('cnic_nicop_number', $application->cnic_nicop_number ?? '') }}"
                   class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('cnic_nicop_number') border-red-500 @enderror"
                   placeholder="xxxxx-xxxxxxx-x" required>
            @error('cnic_nicop_number')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- CNIC Upload -->
        <div class="mt-4">
            <x-document-upload
                name="cnic_file"
                label="Upload CNIC/NICOP (Front & Back)"
                :required="!$hasCnic"
                :existingFile="$hasCnic"
                accept=".pdf,.jpg,.jpeg,.png"
                helpText="PDF, JPG, PNG up to 5MB"
                :showCamera="true"
                captureMode="environment"
            />
        </div>
    </div>

    <!-- UK Immigration Details -->
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            UK Immigration Reference (Optional)
        </h3>

        <!-- Helper text for UK documents -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
            <p class="text-sm text-blue-700">
                <strong>Note:</strong> UK documents are optional if you don't have them. Check the boxes below if you don't have access to this information.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-4" x-data="{ noHomeOfficeRef: {{ old('no_uk_home_office_ref', $application->no_uk_home_office_ref ?? false) ? 'true' : 'false' }}, noBrpNumber: {{ old('no_uk_brp_number', $application->no_uk_brp_number ?? false) ? 'true' : 'false' }} }">
            <div>
                <label for="uk_home_office_ref" class="block text-sm font-medium text-gray-700 mb-1">
                    Home Office Reference
                </label>
                <input type="text" name="uk_home_office_ref" id="uk_home_office_ref"
                       value="{{ old('uk_home_office_ref', $application->uk_home_office_ref ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       :class="{ 'bg-gray-100': noHomeOfficeRef }"
                       :disabled="noHomeOfficeRef"
                       placeholder="e.g., 1234-5678-9012-3456">
                <p class="mt-1 text-xs text-gray-500">Found on visa correspondence or BRP letter</p>
                @error('uk_home_office_ref')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <!-- I don't have this checkbox -->
                <div class="mt-2">
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-gray-800 min-h-[44px]">
                        <input type="checkbox" name="no_uk_home_office_ref" value="1"
                               x-model="noHomeOfficeRef"
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded mr-2 cursor-pointer">
                        I don't have this information
                    </label>
                </div>
            </div>

            <div>
                <label for="uk_brp_number" class="block text-sm font-medium text-gray-700 mb-1">
                    BRP Number
                </label>
                <input type="text" name="uk_brp_number" id="uk_brp_number"
                       value="{{ old('uk_brp_number', $application->uk_brp_number ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       :class="{ 'bg-gray-100': noBrpNumber }"
                       :disabled="noBrpNumber"
                       placeholder="e.g., ZU1234567">
                <p class="mt-1 text-xs text-gray-500">Found on your Biometric Residence Permit card</p>
                @error('uk_brp_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <!-- I don't have this checkbox -->
                <div class="mt-2">
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-gray-800 min-h-[44px]">
                        <input type="checkbox" name="no_uk_brp_number" value="1"
                               x-model="noBrpNumber"
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded mr-2 cursor-pointer">
                        I don't have this information
                    </label>
                </div>
            </div>
        </div>

        <!-- BRP Upload (Optional) -->
        <div class="mt-4">
            <x-document-upload
                name="brp_file"
                label="Upload BRP/Visa (Optional)"
                :required="false"
                :existingFile="$hasBrp"
                accept=".pdf,.jpg,.jpeg,.png"
                helpText="PDF, JPG, PNG up to 5MB"
                :showCamera="true"
                captureMode="environment"
            />
        </div>
    </div>

    <!-- File Size Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="ml-3">
                <h4 class="text-sm font-medium text-blue-800">Document Tips</h4>
                <ul class="mt-1 text-sm text-blue-700 list-disc list-inside space-y-1">
                    <li>Ensure all documents are clear and readable</li>
                    <li>Passport photo: plain white background, face clearly visible</li>
                    <li>Selfie: hold open passport next to your face</li>
                    <li>Passport: Upload all information pages</li>
                    <li>CNIC/NICOP: Include both front and back sides</li>
                    <li>Maximum file size: 5MB per document</li>
                    <li>Accepted formats: PDF, JPG, PNG</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
