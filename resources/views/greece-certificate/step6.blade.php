@extends('greece-certificate.layout')

@section('form-content')
<!-- Step 6: Authorization Letter -->
<div class="space-y-6">
    <!-- Important Notice -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-blue-900 mb-2">Authorization Letter Required</h3>
                <p class="text-blue-700">
                    To apply for a Greece Penal Record Certificate on your behalf, we require a signed authorization letter.
                    Please follow the steps below to complete this requirement.
                </p>
            </div>
        </div>
    </div>

    <!-- Step-by-Step Instructions -->
    <div class="bg-amber-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">How to Complete the Authorization Letter</h3>

        <div class="space-y-4">
            <!-- Step 1: Download -->
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-amber-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                    1
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="font-medium text-gray-900">Download the Authorization Letter Template</h4>
                    <p class="text-sm text-gray-600 mb-3">Click the button below to download our official authorization letter template.</p>
                    <a href="{{ asset('assets/documents/greece-authorization-letter.pdf') }}"
                       target="_blank"
                       download="greece-authorization-letter.pdf"
                       class="inline-flex items-center px-4 py-2 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 transition shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Authorization Letter
                    </a>
                </div>
            </div>

            <!-- Step 2: Fill -->
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-amber-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                    2
                </div>
                <div class="ml-4">
                    <h4 class="font-medium text-gray-900">Fill in Your Details</h4>
                    <p class="text-sm text-gray-600">Complete all required fields in the authorization letter with your personal information.</p>
                    <ul class="mt-2 text-sm text-gray-600 list-disc list-inside space-y-1">
                        <li>Full name (as per passport)</li>
                        <li>Date of birth</li>
                        <li>Passport number</li>
                        <li>Current address</li>
                    </ul>
                </div>
            </div>

            <!-- Step 3: Sign -->
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-amber-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                    3
                </div>
                <div class="ml-4">
                    <h4 class="font-medium text-gray-900">Sign the Letter</h4>
                    <p class="text-sm text-gray-600">Sign and date the authorization letter. You can:</p>
                    <ul class="mt-2 text-sm text-gray-600 list-disc list-inside space-y-1">
                        <li>Print, sign by hand, and scan/photograph</li>
                        <li>Use a digital signature if available</li>
                    </ul>
                </div>
            </div>

            <!-- Step 4: Upload -->
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-amber-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                    4
                </div>
                <div class="ml-4">
                    <h4 class="font-medium text-gray-900">Upload the Completed Letter</h4>
                    <p class="text-sm text-gray-600">Upload the signed authorization letter using the form below.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Section -->
    <div class="bg-white border-2 border-gray-200 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Signed Authorization Letter</h3>

        <div>
            <label for="authorization_letter" class="block text-sm font-medium text-gray-700 mb-1">
                Authorization Letter <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-amber-400 transition @error('authorization_letter') border-red-500 @enderror">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="authorization_letter" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500">
                            <span>Upload signed letter</span>
                            <input id="authorization_letter" name="authorization_letter" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required>
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB</p>
                </div>
            </div>
            @error('authorization_letter')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- File Preview -->
        <div id="file-preview" class="mt-4 hidden">
            <div class="flex items-center p-3 bg-amber-50 rounded-lg">
                <svg class="w-8 h-8 text-amber-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <div class="flex-1">
                    <p id="file-name" class="text-sm font-medium text-gray-900"></p>
                    <p id="file-size" class="text-xs text-gray-500"></p>
                </div>
                <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong>Important:</strong> The authorization letter must be clearly legible and include your signature. Incomplete or illegible documents may delay your application.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('authorization_letter');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFile = document.getElementById('remove-file');

    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            filePreview.classList.remove('hidden');
        }
    });

    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.add('hidden');
    });

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
@endsection
