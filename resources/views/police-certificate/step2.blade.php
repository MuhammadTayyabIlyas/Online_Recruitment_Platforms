@extends('police-certificate.layout')

@section('form-content')
<!-- Step 2: Identification Details -->
<div class="space-y-6">
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
                <input type="date" name="passport_issue_date" id="passport_issue_date" 
                       value="{{ old('passport_issue_date', $application->passport_issue_date ?? '') }}"
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
                <input type="date" name="passport_expiry_date" id="passport_expiry_date" 
                       value="{{ old('passport_expiry_date', $application->passport_expiry_date ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('passport_expiry_date') border-red-500 @enderror"
                       required>
                @error('passport_expiry_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Passport Upload -->
        <div class="mt-4">
            <label for="passport_file" class="block text-sm font-medium text-gray-700 mb-1">
                Upload Passport <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 transition-colors">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600 justify-center">
                        <label for="passport_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                            <span>Upload a file</span>
                            <input id="passport_file" name="passport_file" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB</p>
                </div>
            </div>
            @error('passport_file')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
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
            <label for="cnic_file" class="block text-sm font-medium text-gray-700 mb-1">
                Upload CNIC/NICOP <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 transition-colors">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600 justify-center">
                        <label for="cnic_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                            <span>Upload a file</span>
                            <input id="cnic_file" name="cnic_file" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB</p>
                </div>
            </div>
            @error('cnic_file')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
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
        
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label for="uk_home_office_ref" class="block text-sm font-medium text-gray-700 mb-1">
                    Home Office Reference
                </label>
                <input type="text" name="uk_home_office_ref" id="uk_home_office_ref" 
                       value="{{ old('uk_home_office_ref', $application->uk_home_office_ref ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="If available">
                @error('uk_home_office_ref')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="uk_brp_number" class="block text-sm font-medium text-gray-700 mb-1">
                    BRP Number
                </label>
                <input type="text" name="uk_brp_number" id="uk_brp_number" 
                       value="{{ old('uk_brp_number', $application->uk_brp_number ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="If available">
                @error('uk_brp_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- BRP Upload (Optional) -->
        <div class="mt-4">
            <label for="brp_file" class="block text-sm font-medium text-gray-700 mb-1">
                Upload BRP/Visa (Optional)
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 transition-colors">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600 justify-center">
                        <label for="brp_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                            <span>Upload a file</span>
                            <input id="brp_file" name="brp_file" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB</p>
                </div>
            </div>
            @error('brp_file')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
@endsection