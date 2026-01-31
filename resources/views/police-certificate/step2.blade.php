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
                       value="{{ old('passport_issue_date', $application->passport_issue_date?->format('Y-m-d') ?? '') }}"
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
                       value="{{ old('passport_expiry_date', $application->passport_expiry_date?->format('Y-m-d') ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('passport_expiry_date') border-red-500 @enderror"
                       required>
                @error('passport_expiry_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Passport Upload -->
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Upload Passport (Front & Back) <span class="text-red-500">*</span>
            </label>
            <div class="file-upload-zone" data-input="passport_file" data-required="true">
                <input type="file" name="passport_file" id="passport_file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all">
                    <div class="upload-prompt">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="font-semibold text-blue-600">Click to upload</span> or drag and drop
                        </p>
                        <p class="mt-1 text-xs text-gray-500">PDF, JPG, PNG (Max 5MB)</p>
                    </div>
                    <div class="file-preview hidden">
                        <div class="flex items-center justify-center space-x-4">
                            <div class="preview-image-container hidden">
                                <img src="" alt="Preview" class="preview-image h-20 w-20 object-cover rounded-lg border">
                            </div>
                            <div class="preview-icon hidden">
                                <svg class="h-16 w-16 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="file-name text-sm font-medium text-gray-900 truncate max-w-xs"></p>
                                <p class="file-size text-xs text-gray-500"></p>
                            </div>
                            <button type="button" class="remove-file ml-4 p-1 rounded-full hover:bg-red-100 text-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <p class="file-error mt-1 text-sm text-red-600 hidden"></p>
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
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Upload CNIC/NICOP (Front & Back) <span class="text-red-500">*</span>
            </label>
            <div class="file-upload-zone" data-input="cnic_file" data-required="true">
                <input type="file" name="cnic_file" id="cnic_file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all">
                    <div class="upload-prompt">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="font-semibold text-blue-600">Click to upload</span> or drag and drop
                        </p>
                        <p class="mt-1 text-xs text-gray-500">PDF, JPG, PNG (Max 5MB)</p>
                    </div>
                    <div class="file-preview hidden">
                        <div class="flex items-center justify-center space-x-4">
                            <div class="preview-image-container hidden">
                                <img src="" alt="Preview" class="preview-image h-20 w-20 object-cover rounded-lg border">
                            </div>
                            <div class="preview-icon hidden">
                                <svg class="h-16 w-16 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="file-name text-sm font-medium text-gray-900 truncate max-w-xs"></p>
                                <p class="file-size text-xs text-gray-500"></p>
                            </div>
                            <button type="button" class="remove-file ml-4 p-1 rounded-full hover:bg-red-100 text-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <p class="file-error mt-1 text-sm text-red-600 hidden"></p>
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
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Upload BRP/Visa (Optional)
            </label>
            <div class="file-upload-zone" data-input="brp_file" data-required="false">
                <input type="file" name="brp_file" id="brp_file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all">
                    <div class="upload-prompt">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="font-semibold text-blue-600">Click to upload</span> or drag and drop
                        </p>
                        <p class="mt-1 text-xs text-gray-500">PDF, JPG, PNG (Max 5MB)</p>
                    </div>
                    <div class="file-preview hidden">
                        <div class="flex items-center justify-center space-x-4">
                            <div class="preview-image-container hidden">
                                <img src="" alt="Preview" class="preview-image h-20 w-20 object-cover rounded-lg border">
                            </div>
                            <div class="preview-icon hidden">
                                <svg class="h-16 w-16 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="file-name text-sm font-medium text-gray-900 truncate max-w-xs"></p>
                                <p class="file-size text-xs text-gray-500"></p>
                            </div>
                            <button type="button" class="remove-file ml-4 p-1 rounded-full hover:bg-red-100 text-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <p class="file-error mt-1 text-sm text-red-600 hidden"></p>
            </div>
            @error('brp_file')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
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
                    <li>Passport: Upload all information pages</li>
                    <li>CNIC/NICOP: Include both front and back sides</li>
                    <li>Maximum file size: 5MB per document</li>
                    <li>Accepted formats: PDF, JPG, PNG</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB in bytes
    const ALLOWED_TYPES = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

    document.querySelectorAll('.file-upload-zone').forEach(zone => {
        const inputId = zone.dataset.input;
        const input = document.getElementById(inputId);
        const uploadArea = zone.querySelector('.upload-area');
        const uploadPrompt = zone.querySelector('.upload-prompt');
        const filePreview = zone.querySelector('.file-preview');
        const fileName = zone.querySelector('.file-name');
        const fileSize = zone.querySelector('.file-size');
        const previewImage = zone.querySelector('.preview-image');
        const previewImageContainer = zone.querySelector('.preview-image-container');
        const previewIcon = zone.querySelector('.preview-icon');
        const removeBtn = zone.querySelector('.remove-file');
        const errorEl = zone.querySelector('.file-error');

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showError(message) {
            errorEl.textContent = message;
            errorEl.classList.remove('hidden');
            uploadArea.classList.add('border-red-500', 'bg-red-50');
            uploadArea.classList.remove('border-gray-300', 'border-blue-500');
        }

        function clearError() {
            errorEl.classList.add('hidden');
            uploadArea.classList.remove('border-red-500', 'bg-red-50');
            uploadArea.classList.add('border-gray-300');
        }

        function validateFile(file) {
            clearError();

            if (!file) return false;

            // Check file type
            if (!ALLOWED_TYPES.includes(file.type)) {
                showError('Invalid file type. Please upload PDF, JPG, or PNG files only.');
                return false;
            }

            // Check file size
            if (file.size > MAX_FILE_SIZE) {
                showError('File size exceeds 5MB limit. Please choose a smaller file.');
                return false;
            }

            return true;
        }

        function handleFile(file) {
            if (!validateFile(file)) {
                input.value = '';
                return;
            }

            // Show preview
            uploadPrompt.classList.add('hidden');
            filePreview.classList.remove('hidden');
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);

            // Show image preview or PDF icon
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImageContainer.classList.remove('hidden');
                    previewIcon.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewImageContainer.classList.add('hidden');
                previewIcon.classList.remove('hidden');
            }

            // Update border color to success
            uploadArea.classList.remove('border-gray-300', 'border-red-500', 'bg-red-50');
            uploadArea.classList.add('border-green-500', 'bg-green-50');
        }

        function resetUpload() {
            input.value = '';
            uploadPrompt.classList.remove('hidden');
            filePreview.classList.add('hidden');
            previewImageContainer.classList.add('hidden');
            previewIcon.classList.add('hidden');
            uploadArea.classList.remove('border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50');
            uploadArea.classList.add('border-gray-300');
            clearError();
        }

        // Click to upload
        uploadArea.addEventListener('click', function(e) {
            if (!e.target.closest('.remove-file')) {
                input.click();
            }
        });

        // File input change
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                handleFile(this.files[0]);
            }
        });

        // Remove file
        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            resetUpload();
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-blue-500', 'bg-blue-50');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            if (!input.files || !input.files[0]) {
                this.classList.remove('border-blue-500', 'bg-blue-50');
                this.classList.add('border-gray-300');
            }
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-500', 'bg-blue-50');

            const files = e.dataTransfer.files;
            if (files && files[0]) {
                // Create a new DataTransfer to set the input files
                const dt = new DataTransfer();
                dt.items.add(files[0]);
                input.files = dt.files;
                handleFile(files[0]);
            }
        });
    });

    // Form submission validation
    document.querySelector('form').addEventListener('submit', function(e) {
        let hasError = false;

        document.querySelectorAll('.file-upload-zone').forEach(zone => {
            const inputId = zone.dataset.input;
            const isRequired = zone.dataset.required === 'true';
            const input = document.getElementById(inputId);
            const errorEl = zone.querySelector('.file-error');
            const uploadArea = zone.querySelector('.upload-area');

            if (isRequired && (!input.files || !input.files[0])) {
                errorEl.textContent = 'This document is required.';
                errorEl.classList.remove('hidden');
                uploadArea.classList.add('border-red-500', 'bg-red-50');
                uploadArea.classList.remove('border-gray-300', 'border-green-500', 'bg-green-50');
                hasError = true;
            }
        });

        if (hasError) {
            e.preventDefault();
            // Scroll to first error
            const firstError = document.querySelector('.file-error:not(.hidden)');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});
</script>
@endsection
