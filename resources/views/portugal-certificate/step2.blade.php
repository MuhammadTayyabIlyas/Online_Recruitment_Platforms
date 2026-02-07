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
        <p class="text-sm text-gray-600">If you have Portuguese documents, please provide them below. Check the boxes if you don't have this information.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-4" x-data="{
        noPortugalNif: {{ old('no_portugal_nif', $application->no_portugal_nif ?? false) ? 'true' : 'false' }},
        noPortugalPermit: {{ old('no_portugal_residence_permit', $application->no_portugal_residence_permit ?? false) ? 'true' : 'false' }}
    }">
        <div>
            <label for="portugal_nif" class="block text-sm font-medium text-gray-700 mb-1">
                Portuguese NIF (Tax ID)
            </label>
            <input type="text" name="portugal_nif" id="portugal_nif"
                   value="{{ old('portugal_nif', $application->portugal_nif ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   :class="{ 'bg-gray-100': noPortugalNif }"
                   :disabled="noPortugalNif"
                   placeholder="e.g., 123456789">
            <p class="mt-1 text-xs text-gray-500">9-digit tax identification number</p>
            <!-- I don't have this checkbox -->
            <div class="mt-2">
                <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-gray-800 min-h-[44px]">
                    <input type="checkbox" name="no_portugal_nif" value="1"
                           x-model="noPortugalNif"
                           class="h-4 w-4 text-green-600 border-gray-300 rounded mr-2 cursor-pointer">
                    I don't have this information
                </label>
            </div>
        </div>

        <div>
            <label for="portugal_residence_permit" class="block text-sm font-medium text-gray-700 mb-1">
                Residence Permit Number
            </label>
            <input type="text" name="portugal_residence_permit" id="portugal_residence_permit"
                   value="{{ old('portugal_residence_permit', $application->portugal_residence_permit ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   :class="{ 'bg-gray-100': noPortugalPermit }"
                   :disabled="noPortugalPermit"
                   placeholder="Autorização de Residência number">
            <p class="mt-1 text-xs text-gray-500">Found on your residence card</p>
            <!-- I don't have this checkbox -->
            <div class="mt-2">
                <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-gray-800 min-h-[44px]">
                    <input type="checkbox" name="no_portugal_residence_permit" value="1"
                           x-model="noPortugalPermit"
                           class="h-4 w-4 text-green-600 border-gray-300 rounded mr-2 cursor-pointer">
                    I don't have this information
                </label>
            </div>
        </div>
    </div>

    <div class="md:w-1/2 mt-4">
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
        <!-- Passport Upload -->
        <div x-data="fileUpload('passport_file', {{ json_encode($application->passport_file ?? null) }})">
            <label for="passport_file" class="block text-sm font-medium text-gray-700 mb-1">
                Passport Copy <span class="text-red-500">*</span>
            </label>

            <!-- Show existing file if already uploaded -->
            <template x-if="existingFile">
                <div class="mb-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm text-green-800">Document already uploaded</span>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" @click="existingFile = null" class="text-blue-600 hover:text-blue-800 text-sm underline">Replace</button>
                            <button type="button" @click="removeExistingFile()" class="text-red-600 hover:text-red-800 text-sm underline">Delete</button>
                        </div>
                    </div>
                </div>
            </template>
            <input type="hidden" name="remove_passport_file" :value="removeExisting ? '1' : '0'" x-show="false">

            <!-- Upload area -->
            <div x-show="!existingFile"
                 class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg transition cursor-pointer"
                 :class="fileName ? 'border-green-400 bg-green-50' : 'border-gray-300 hover:border-green-400 @error('passport_file') border-red-500 @enderror'"
                 @click="$refs.passportInput.click()"
                 @dragover.prevent="dragover = true"
                 @dragleave.prevent="dragover = false"
                 @drop.prevent="handleDrop($event)">
                <div class="space-y-1 text-center">
                    <!-- Success state -->
                    <template x-if="fileName">
                        <div>
                            <svg class="mx-auto h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mt-2 text-sm font-medium text-green-700" x-text="fileName"></p>
                            <div class="mt-2 flex justify-center gap-3">
                                <span class="text-xs text-green-600">Click to change</span>
                                <button type="button" @click.stop="clearFile()" class="text-xs text-red-600 hover:text-red-800 underline">Remove</button>
                            </div>
                        </div>
                    </template>
                    <!-- Default state -->
                    <template x-if="!fileName">
                        <div>
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600"><span class="font-medium text-green-600">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB</p>
                        </div>
                    </template>
                </div>
                <input x-ref="passportInput" id="passport_file" name="passport_file" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" @change="handleFileSelect($event)" :required="!existingFile">
            </div>
            @error('passport_file')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Residence Permit Upload -->
        <div x-data="fileUpload('residence_permit_file', {{ json_encode($application->residence_permit_file ?? null) }})">
            <label for="residence_permit_file" class="block text-sm font-medium text-gray-700 mb-1">
                Residence Permit Copy
            </label>

            <!-- Show existing file if already uploaded -->
            <template x-if="existingFile">
                <div class="mb-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm text-green-800">Document already uploaded</span>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" @click="existingFile = null" class="text-blue-600 hover:text-blue-800 text-sm underline">Replace</button>
                            <button type="button" @click="removeExistingFile()" class="text-red-600 hover:text-red-800 text-sm underline">Delete</button>
                        </div>
                    </div>
                </div>
            </template>
            <input type="hidden" name="remove_residence_permit_file" :value="removeExisting ? '1' : '0'" x-show="false">

            <!-- Upload area -->
            <div x-show="!existingFile"
                 class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg transition cursor-pointer"
                 :class="fileName ? 'border-green-400 bg-green-50' : 'border-gray-300 hover:border-green-400'"
                 @click="$refs.permitInput.click()"
                 @dragover.prevent="dragover = true"
                 @dragleave.prevent="dragover = false"
                 @drop.prevent="handleDrop($event)">
                <div class="space-y-1 text-center">
                    <!-- Success state -->
                    <template x-if="fileName">
                        <div>
                            <svg class="mx-auto h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mt-2 text-sm font-medium text-green-700" x-text="fileName"></p>
                            <div class="mt-2 flex justify-center gap-3">
                                <span class="text-xs text-green-600">Click to change</span>
                                <button type="button" @click.stop="clearFile()" class="text-xs text-red-600 hover:text-red-800 underline">Remove</button>
                            </div>
                        </div>
                    </template>
                    <!-- Default state -->
                    <template x-if="!fileName">
                        <div>
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600"><span class="font-medium text-green-600">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">Optional - PDF, JPG, PNG up to 5MB</p>
                        </div>
                    </template>
                </div>
                <input x-ref="permitInput" id="residence_permit_file" name="residence_permit_file" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" @change="handleFileSelect($event)">
            </div>
        </div>
    </div>
</div>

<script>
function fileUpload(inputName, existingFilePath) {
    return {
        fileName: null,
        existingFile: existingFilePath,
        dragover: false,
        removeExisting: false,
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.fileName = file.name;
                this.existingFile = null;
            }
        },
        handleDrop(event) {
            this.dragover = false;
            const file = event.dataTransfer.files[0];
            if (file) {
                const input = this.$refs.passportInput || this.$refs.permitInput;
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
                this.fileName = file.name;
                this.existingFile = null;
            }
        },
        clearFile() {
            this.fileName = null;
            const input = this.$refs.passportInput || this.$refs.permitInput;
            if (input) {
                input.value = '';
            }
        },
        removeExistingFile() {
            this.existingFile = null;
            this.removeExisting = true;
        }
    }
}
</script>
@endsection
