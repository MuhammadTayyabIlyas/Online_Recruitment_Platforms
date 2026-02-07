@extends('greece-certificate.layout')

@section('form-content')
<!-- Step 2: Identification Documents -->
<div class="space-y-6">
    <!-- Passport Information -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Passport Information</h3>
        <p class="text-sm text-gray-600">Enter your passport details exactly as they appear on your passport.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="passport_number" class="block text-sm font-medium text-gray-700 mb-1">
                Passport Number <span class="text-red-500">*</span>
            </label>
            <input type="text" name="passport_number" id="passport_number"
                   value="{{ old('passport_number', $application->passport_number ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('passport_number') border-red-500 @enderror"
                   required>
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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('passport_place_of_issue') border-red-500 @enderror"
                   required>
            @error('passport_place_of_issue')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="passport_issue_date" class="block text-sm font-medium text-gray-700 mb-1">
                Issue Date <span class="text-red-500">*</span>
            </label>
            @php
                $issueDate = old('passport_issue_date');
                if (!$issueDate && isset($application) && $application->passport_issue_date) {
                    $issueDate = $application->passport_issue_date instanceof \Carbon\Carbon
                        ? $application->passport_issue_date->format('Y-m-d')
                        : $application->passport_issue_date;
                }
            @endphp
            <input type="date" name="passport_issue_date" id="passport_issue_date"
                   value="{{ $issueDate ?? '' }}"
                   max="{{ date('Y-m-d') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('passport_issue_date') border-red-500 @enderror"
                   required>
            @error('passport_issue_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="passport_expiry_date" class="block text-sm font-medium text-gray-700 mb-1">
                Expiry Date <span class="text-red-500">*</span>
            </label>
            @php
                $expiryDate = old('passport_expiry_date');
                if (!$expiryDate && isset($application) && $application->passport_expiry_date) {
                    $expiryDate = $application->passport_expiry_date instanceof \Carbon\Carbon
                        ? $application->passport_expiry_date->format('Y-m-d')
                        : $application->passport_expiry_date;
                }
            @endphp
            <input type="date" name="passport_expiry_date" id="passport_expiry_date"
                   value="{{ $expiryDate ?? '' }}"
                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('passport_expiry_date') border-red-500 @enderror"
                   required>
            @error('passport_expiry_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Greece Documents -->
    <div class="bg-amber-50 rounded-lg p-4 mt-8 mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Greek Documents</h3>
        <p class="text-sm text-gray-600">If you have Greek documents, please provide them below. Check the boxes if you don't have this information.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-4" x-data="{
        noGreeceAfm: {{ old('no_greece_afm', $application->no_greece_afm ?? false) ? 'true' : 'false' }},
        noGreeceAmka: {{ old('no_greece_amka', $application->no_greece_amka ?? false) ? 'true' : 'false' }}
    }">
        <div>
            <label for="greece_afm" class="block text-sm font-medium text-gray-700 mb-1">
                Greek AFM (Tax ID)
            </label>
            <input type="text" name="greece_afm" id="greece_afm"
                   value="{{ old('greece_afm', $application->greece_afm ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                   :class="{ 'bg-gray-100': noGreeceAfm }"
                   :disabled="noGreeceAfm"
                   placeholder="e.g., 123456789">
            <p class="mt-1 text-xs text-gray-500">9-digit tax identification number (&#913;&#934;&#924;)</p>
            <!-- I don't have this checkbox -->
            <div class="mt-2">
                <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-gray-800 min-h-[44px]">
                    <input type="checkbox" name="no_greece_afm" value="1"
                           x-model="noGreeceAfm"
                           class="h-4 w-4 text-amber-600 border-gray-300 rounded mr-2 cursor-pointer">
                    I don't have this information
                </label>
            </div>
        </div>

        <div>
            <label for="greece_amka" class="block text-sm font-medium text-gray-700 mb-1">
                AMKA (Social Security Number)
            </label>
            <input type="text" name="greece_amka" id="greece_amka"
                   value="{{ old('greece_amka', $application->greece_amka ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                   :class="{ 'bg-gray-100': noGreeceAmka }"
                   :disabled="noGreeceAmka"
                   placeholder="e.g., 12345678901">
            <p class="mt-1 text-xs text-gray-500">11-digit social security number (&#913;&#924;&#922;&#913;)</p>
            <!-- I don't have this checkbox -->
            <div class="mt-2">
                <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-gray-800 min-h-[44px]">
                    <input type="checkbox" name="no_greece_amka" value="1"
                           x-model="noGreeceAmka"
                           class="h-4 w-4 text-amber-600 border-gray-300 rounded mr-2 cursor-pointer">
                    I don't have this information
                </label>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="greece_residence_permit" class="block text-sm font-medium text-gray-700 mb-1">
                Residence Permit Number
            </label>
            <input type="text" name="greece_residence_permit" id="greece_residence_permit"
                   value="{{ old('greece_residence_permit', $application->greece_residence_permit ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                   placeholder="Permit number">
        </div>

        <div>
            <label for="greece_residence_permit_expiry" class="block text-sm font-medium text-gray-700 mb-1">
                Residence Permit Expiry Date
            </label>
            @php
                $permitExpiry = old('greece_residence_permit_expiry');
                if (!$permitExpiry && isset($application) && $application->greece_residence_permit_expiry) {
                    $permitExpiry = $application->greece_residence_permit_expiry instanceof \Carbon\Carbon
                        ? $application->greece_residence_permit_expiry->format('Y-m-d')
                        : $application->greece_residence_permit_expiry;
                }
            @endphp
            <input type="date" name="greece_residence_permit_expiry" id="greece_residence_permit_expiry"
                   value="{{ $permitExpiry ?? '' }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
        </div>
    </div>

    <!-- File Uploads -->
    <div class="bg-gray-50 rounded-lg p-4 mt-8 mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Document Uploads</h3>
        <p class="text-sm text-gray-600">Upload clear scans or photos of your documents. You can also take photos directly with your phone camera.</p>
    </div>

    @php
        $hasPassportFront = $application ? $application->documents()->where('document_type', 'passport_front')->exists() : false;
        $hasPassportBack = $application ? $application->documents()->where('document_type', 'passport_back')->exists() : false;
        $hasPassportLegacy = $application ? $application->documents()->where('document_type', 'passport')->exists() : false;
        $hasResidencePermit = $application ? $application->documents()->where('document_type', 'residence_permit')->exists() : false;
    @endphp

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Passport Front Upload -->
        <x-document-upload
            name="passport_front_file"
            label="Passport / ID - Front Side"
            :required="!$hasPassportFront && !$hasPassportLegacy"
            :existing-file="$hasPassportFront || $hasPassportLegacy ? true : null"
            help-text="Upload the page with your photo. PDF, JPG, PNG up to 5MB"
        />

        <!-- Passport Back Upload -->
        <x-document-upload
            name="passport_back_file"
            label="Passport / ID - Back Side (if applicable)"
            :required="false"
            :existing-file="$hasPassportBack ? true : null"
            help-text="Not needed for passport booklets. PDF, JPG, PNG up to 5MB"
        />
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Residence Permit Upload -->
        <x-document-upload
            name="residence_permit_file"
            label="Residence Permit Copy"
            :required="false"
            :existing-file="$hasResidencePermit ? true : null"
            help-text="Optional - PDF, JPG, PNG up to 5MB"
        />
    </div>
</div>
@endsection
