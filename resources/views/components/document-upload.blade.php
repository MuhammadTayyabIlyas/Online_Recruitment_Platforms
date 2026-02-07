@props([
    'name',
    'label' => 'Document',
    'required' => false,
    'existingFile' => null,
    'accept' => '.pdf,.jpg,.jpeg,.png',
    'helpText' => 'PDF, JPG, PNG up to 5MB',
    'showCamera' => true,
    'captureMode' => 'environment',
])

<div x-data="documentUpload('{{ $name }}', {{ json_encode($existingFile) }})" class="w-full">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    {{-- Existing file indicator --}}
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
                    <button type="button" @click="replaceExisting()" class="text-blue-600 hover:text-blue-800 text-sm underline min-h-[44px] flex items-center">Replace</button>
                </div>
            </div>
        </div>
    </template>

    {{-- Upload area --}}
    <div x-show="!existingFile" class="space-y-2">
        {{-- Preview --}}
        <template x-if="previewUrl">
            <div class="relative rounded-lg overflow-hidden border-2 border-green-400 bg-green-50">
                <img :src="previewUrl" class="w-full max-h-48 object-contain bg-gray-100" alt="Preview">
                <div class="p-3">
                    <p class="text-sm font-medium text-green-700 truncate" x-text="fileName"></p>
                    <p class="text-xs text-green-600" x-text="fileSize"></p>
                </div>
                <div class="absolute top-2 right-2 flex gap-2">
                    <button type="button" @click="openFileSelector()" class="bg-white rounded-full p-1.5 shadow-md hover:bg-gray-100 min-h-[36px] min-w-[36px] flex items-center justify-center" title="Replace">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                    <button type="button" @click="clearFile()" class="bg-white rounded-full p-1.5 shadow-md hover:bg-gray-100 min-h-[36px] min-w-[36px] flex items-center justify-center" title="Remove">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </template>

        {{-- Non-image file preview --}}
        <template x-if="fileName && !previewUrl">
            <div class="flex items-center p-3 bg-green-50 border-2 border-green-400 rounded-lg">
                <svg class="w-8 h-8 text-green-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-green-700 truncate" x-text="fileName"></p>
                    <p class="text-xs text-green-600" x-text="fileSize"></p>
                </div>
                <div class="flex gap-2 ml-3">
                    <button type="button" @click="openFileSelector()" class="text-blue-600 hover:text-blue-800 min-h-[44px] min-w-[44px] flex items-center justify-center" title="Replace">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                    <button type="button" @click="clearFile()" class="text-red-600 hover:text-red-800 min-h-[44px] min-w-[44px] flex items-center justify-center" title="Remove">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </template>

        {{-- Drop zone (shown when no file selected) --}}
        <div x-show="!fileName"
             class="flex flex-col items-center justify-center px-4 pt-5 pb-6 border-2 border-dashed rounded-lg transition cursor-pointer min-h-[120px]"
             :class="dragover ? 'border-amber-500 bg-amber-50' : 'border-gray-300 hover:border-amber-400'"
             @click="openFileSelector()"
             @dragover.prevent="dragover = true"
             @dragleave.prevent="dragover = false"
             @drop.prevent="handleDrop($event)">
            <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <p class="mt-2 text-sm text-gray-600"><span class="font-medium text-amber-600">Click to upload</span> or drag and drop</p>
            <p class="text-xs text-gray-500">{{ $helpText }}</p>
        </div>

        {{-- Camera / file buttons --}}
        <div x-show="!fileName" class="flex gap-2">
            @if($showCamera)
            <button type="button" @click="openCamera()" class="flex-1 inline-flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition min-h-[48px]">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Take Photo
            </button>
            @endif
            <button type="button" @click="openFileSelector()" class="flex-1 inline-flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition min-h-[48px]">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Browse Files
            </button>
        </div>
    </div>

    {{-- Hidden file inputs --}}
    <input x-ref="fileInput" type="file" name="{{ $name }}" class="sr-only" accept="{{ $accept }}" @change="handleFileSelect($event)" {{ $required && !$existingFile ? 'required' : '' }}>
    @if($showCamera)
    <input x-ref="cameraInput" type="file" accept="image/*" capture="{{ $captureMode }}" class="sr-only" @change="handleCameraCapture($event)">
    @endif
    <input type="hidden" name="remove_{{ $name }}" :value="removeExisting ? '1' : '0'">

    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

@once
<script>
function documentUpload(inputName, existingFilePath) {
    return {
        fileName: null,
        fileSize: null,
        previewUrl: null,
        existingFile: existingFilePath,
        dragover: false,
        removeExisting: false,

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) this.setFile(file);
        },

        handleCameraCapture(event) {
            const file = event.target.files[0];
            if (file) {
                // Transfer captured file to the main file input
                const dt = new DataTransfer();
                dt.items.add(file);
                this.$refs.fileInput.files = dt.files;
                this.setFile(file);
            }
        },

        handleDrop(event) {
            this.dragover = false;
            const file = event.dataTransfer.files[0];
            if (file) {
                const dt = new DataTransfer();
                dt.items.add(file);
                this.$refs.fileInput.files = dt.files;
                this.setFile(file);
            }
        },

        setFile(file) {
            this.fileName = file.name;
            this.fileSize = this.formatSize(file.size);
            this.existingFile = null;

            if (file.type.startsWith('image/')) {
                this.previewUrl = URL.createObjectURL(file);
            } else {
                this.previewUrl = null;
            }
        },

        clearFile() {
            if (this.previewUrl) {
                URL.revokeObjectURL(this.previewUrl);
            }
            this.fileName = null;
            this.fileSize = null;
            this.previewUrl = null;
            this.$refs.fileInput.value = '';
        },

        replaceExisting() {
            this.existingFile = null;
            this.removeExisting = true;
        },

        openFileSelector() {
            this.$refs.fileInput.click();
        },

        openCamera() {
            this.$refs.cameraInput.click();
        },

        formatSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    }
}
</script>
@endonce
