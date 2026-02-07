@extends('portugal-certificate.layout')

@section('form-content')
<!-- Step 6: Authorization Letter -->
<div class="space-y-6" x-data="{
    activeTab: 'sign-online',
    signatureMethod: 'drawn'
}">
    <!-- Important Notice -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-green-900 mb-2">Authorization Letter</h3>
                <p class="text-green-700">
                    This letter authorizes us to apply for a Portugal Criminal Record Certificate on your behalf. You can <strong>sign directly on your screen</strong> (fastest!) or download the letter, print, sign by hand, and upload it.
                </p>
            </div>
        </div>
    </div>

    <!-- Tab Selector -->
    <div class="flex rounded-lg border border-gray-200 overflow-hidden">
        <button type="button"
                @click="activeTab = 'sign-online'; signatureMethod = 'drawn'"
                :class="activeTab === 'sign-online' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm font-medium transition min-h-[48px] flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Sign Online (Recommended)
        </button>
        <button type="button"
                @click="activeTab = 'upload'; signatureMethod = 'uploaded'"
                :class="activeTab === 'upload' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm font-medium transition min-h-[48px] flex items-center justify-center border-l border-gray-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Download, Print & Sign
        </button>
    </div>

    <input type="hidden" name="signature_method" :value="signatureMethod">

    <!-- TAB A: Sign Online -->
    <div x-show="activeTab === 'sign-online'" x-cloak class="space-y-6">
        <!-- Letter Preview -->
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Letter Preview</h4>
            <div class="bg-white border border-gray-300 rounded-lg p-6 text-sm text-gray-700 leading-relaxed">
                <p class="mb-4">
                    I, <strong>{{ $application->full_name ?? '___' }}</strong>, holder of passport number
                    <strong>{{ $application->passport_number ?? '___' }}</strong>,
                    nationality <strong>{{ $application->nationality ?? '___' }}</strong>,
                    hereby authorize <strong>_______________</strong>
                    to act on my behalf for the purpose of applying for and obtaining my
                    Portugal Criminal Record Certificate (Certificado do Registo Criminal)
                    from the competent authorities in Portugal.
                </p>
                <p>
                    I confirm that all information provided in this application is true and correct to the best of my knowledge.
                </p>
            </div>
        </div>

        <div class="bg-white border-2 border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sign Your Authorization Letter</h3>
            <p class="text-sm text-gray-600 mb-6">Your letter will be automatically generated with your details and this signature.</p>

            <!-- Signing Place -->
            <div class="mb-4">
                <label for="signature_place" class="block text-sm font-medium text-gray-700 mb-1">
                    Signing Place <span class="text-red-500">*</span>
                </label>
                <input type="text" name="signature_place" id="signature_place"
                       value="{{ old('signature_place', $application->signature_place ?? ($application->current_city ? $application->current_city . ', ' . ($application->current_country ?? '') : '')) }}"
                       class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('signature_place') border-red-500 @enderror"
                       placeholder="e.g., Lisbon, Portugal">
                @error('signature_place')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date (auto-filled, read-only display) -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Date
                </label>
                <div class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 w-full md:w-1/2">
                    {{ now()->format('d/m/Y') }}
                </div>
                <input type="hidden" name="signature_date" value="{{ now()->format('Y-m-d') }}">
            </div>

            <!-- Signature Canvas -->
            <div x-data="signaturePadComponent()" x-init="initSignaturePad()">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Your Signature <span class="text-red-500">*</span>
                </label>
                <div class="border-2 border-gray-300 rounded-lg bg-white overflow-hidden" :class="isEmpty ? '' : 'border-green-400'">
                    <canvas x-ref="signatureCanvas" class="w-full touch-none" style="height: 200px;"></canvas>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-xs text-gray-500">Use your finger or mouse to sign above</p>
                    <button type="button" @click="clearSignature()"
                            class="inline-flex items-center px-3 py-1.5 text-sm text-red-600 hover:text-red-800 border border-red-200 rounded-lg hover:bg-red-50 transition min-h-[44px]">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Clear Signature
                    </button>
                </div>

                <input type="hidden" name="signature_data" x-ref="signatureData">

                @error('signature_data')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- What will be generated info -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-sm text-green-800">
                <strong>What happens next:</strong> We'll generate your authorization letter with all your pre-filled details (name, passport, address) plus your signature, date, and signing place. The completed PDF is stored with your application.
            </p>
        </div>
    </div>

    <!-- TAB B: Download, Print & Sign -->
    <div x-show="activeTab === 'upload'" x-cloak class="space-y-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Complete in 3 Simple Steps</h3>

            <div class="space-y-6">
                <!-- Step 1: Download -->
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg">
                        1
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-semibold text-gray-900 text-lg">Download Your Pre-filled Letter</h4>
                        <p class="text-gray-600 mt-1 mb-3">Your authorization letter is ready with all your details pre-filled. Just download it!</p>
                        <a href="{{ route('portugal-certificate.download-authorization-letter') }}"
                           class="inline-flex items-center px-5 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition shadow-sm min-h-[48px]">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Pre-filled Authorization Letter
                        </a>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-l-2 border-green-200 ml-5 h-4"></div>

                <!-- Step 2: Sign -->
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg">
                        2
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-semibold text-gray-900 text-lg">Print & Sign</h4>
                        <p class="text-gray-600 mt-1">Print the letter and <strong>sign it by hand</strong> in the signature box. Then scan or take a clear photo.</p>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-l-2 border-green-200 ml-5 h-4"></div>

                <!-- Step 3: Upload -->
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg">
                        3
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-semibold text-gray-900 text-lg">Upload Below</h4>
                        <p class="text-gray-600 mt-1 mb-4">Upload your signed authorization letter.</p>

                        <x-document-upload
                            name="authorization_letter"
                            label="Signed Authorization Letter"
                            :required="false"
                            help-text="PDF, JPG, PNG up to 5MB"
                        />
                    </div>
                </div>
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

<script src="https://cdn.jsdelivr.net/npm/signature_pad@5.0.4/dist/signature_pad.umd.min.js"></script>
<script>
function signaturePadComponent() {
    return {
        signaturePad: null,
        isEmpty: true,

        initSignaturePad() {
            const canvas = this.$refs.signatureCanvas;
            this.resizeCanvas(canvas);
            this.signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
            });

            this.signaturePad.addEventListener('endStroke', () => {
                this.isEmpty = this.signaturePad.isEmpty();
                this.$refs.signatureData.value = this.signaturePad.toDataURL('image/png');
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                const data = this.signaturePad.toData();
                this.resizeCanvas(canvas);
                this.signaturePad.fromData(data);
            });
        },

        resizeCanvas(canvas) {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width * ratio;
            canvas.height = rect.height * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
        },

        clearSignature() {
            this.signaturePad.clear();
            this.isEmpty = true;
            this.$refs.signatureData.value = '';
        }
    }
}

// Intercept form submission to populate signature data
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const methodInput = form.querySelector('input[name="signature_method"]');
            if (methodInput && methodInput.value === 'drawn') {
                const sigData = form.querySelector('input[name="signature_data"]');
                if (!sigData || !sigData.value) {
                    e.preventDefault();
                    alert('Please sign the authorization letter before continuing.');
                    return false;
                }
            }
        });
    }
});
</script>
@endsection
