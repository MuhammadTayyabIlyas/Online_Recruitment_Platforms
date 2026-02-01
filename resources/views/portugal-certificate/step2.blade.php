@extends('portugal-certificate.layout')

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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('passport_number') border-red-500 @enderror"
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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('passport_place_of_issue') border-red-500 @enderror"
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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('passport_issue_date') border-red-500 @enderror"
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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('passport_expiry_date') border-red-500 @enderror"
                   required>
            @error('passport_expiry_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Portugal Documents -->
    <div class="bg-green-50 rounded-lg p-4 mt-8 mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Portugal Documents</h3>
        <p class="text-sm text-gray-600">If you have Portuguese documents, please provide them below.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="portugal_nif" class="block text-sm font-medium text-gray-700 mb-1">
                Portuguese NIF (Tax ID)
            </label>
            <input type="text" name="portugal_nif" id="portugal_nif"
                   value="{{ old('portugal_nif', $application->portugal_nif ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   placeholder="9 digits">
            <p class="mt-1 text-xs text-gray-500">Optional but recommended if you have one</p>
        </div>

        <div>
            <label for="portugal_residence_permit" class="block text-sm font-medium text-gray-700 mb-1">
                Residence Permit Number
            </label>
            <input type="text" name="portugal_residence_permit" id="portugal_residence_permit"
                   value="{{ old('portugal_residence_permit', $application->portugal_residence_permit ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   placeholder="Autorização de Residência">
        </div>
    </div>

    <div class="md:w-1/2">
        <label for="portugal_residence_permit_expiry" class="block text-sm font-medium text-gray-700 mb-1">
            Residence Permit Expiry Date
        </label>
        @php
            $permitExpiry = old('portugal_residence_permit_expiry');
            if (!$permitExpiry && isset($application) && $application->portugal_residence_permit_expiry) {
                $permitExpiry = $application->portugal_residence_permit_expiry instanceof \Carbon\Carbon
                    ? $application->portugal_residence_permit_expiry->format('Y-m-d')
                    : $application->portugal_residence_permit_expiry;
            }
        @endphp
        <input type="date" name="portugal_residence_permit_expiry" id="portugal_residence_permit_expiry"
               value="{{ $permitExpiry ?? '' }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
    </div>

    <!-- File Uploads -->
    <div class="bg-gray-50 rounded-lg p-4 mt-8 mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Document Uploads</h3>
        <p class="text-sm text-gray-600">Upload clear scans or photos of your documents. Accepted formats: PDF, JPG, PNG (max 5MB each).</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label for="passport_file" class="block text-sm font-medium text-gray-700 mb-1">
                Passport Copy <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-green-400 transition @error('passport_file') border-red-500 @enderror">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="passport_file" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500">
                            <span>Upload passport</span>
                            <input id="passport_file" name="passport_file" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB</p>
                </div>
            </div>
            @error('passport_file')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="residence_permit_file" class="block text-sm font-medium text-gray-700 mb-1">
                Residence Permit Copy
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-green-400 transition">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="residence_permit_file" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500">
                            <span>Upload permit</span>
                            <input id="residence_permit_file" name="residence_permit_file" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">Optional - if applicable</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
