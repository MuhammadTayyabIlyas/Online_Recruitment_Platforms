@extends('greece-certificate.layout')

@section('form-content')
<!-- Disclaimer Modal -->
<div x-data="{
    showDisclaimer: {{ session('greece_disclaimer_accepted') ? 'false' : 'true' }},
    accepted: false
}" x-cloak>
    <!-- Modal Backdrop -->
    <div x-show="showDisclaimer"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="disclaimer-title"
         role="dialog"
         aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-900/75 transition-opacity"></div>

            <!-- Modal Content -->
            <div x-show="showDisclaimer"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative w-full max-w-2xl transform rounded-2xl bg-white shadow-2xl transition-all">

                <!-- Header -->
                <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-5 rounded-t-2xl">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-2 bg-white/20 rounded-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-xl font-bold text-white" id="disclaimer-title">
                            Penal Record Certificate Disclaimer
                        </h3>
                    </div>
                </div>

                <!-- Body -->
                <div class="px-6 py-6 max-h-[60vh] overflow-y-auto">
                    <div class="prose prose-sm text-gray-700 space-y-4">
                        <p>
                            <strong>Placemenet</strong> acts solely as an administrative service provider assisting applicants with the submission and follow-up of Police / Criminal Record Certificate applications, including but not limited to certificates issued by authorities in the <strong>United Kingdom</strong> (Police Certificate - ACRO), <strong>Greece</strong> (Penal Record Certificate for General Use), and <strong>Portugal</strong> (Criminal Record Certificate).
                        </p>

                        <p>
                            Placemenet <strong>does not issue, verify, alter, influence, or guarantee</strong> the content, findings, format, processing time, or outcome of any certificate. The applicant acknowledges that all certificates are issued exclusively by the relevant police or judicial authorities and that Placemenet has no control over the information disclosed.
                        </p>

                        <p>
                            Placemenet <strong>shall not be held responsible or liable</strong> if the issued certificate contains information that is unfavorable, incomplete, delayed, refused, or not accepted by immigration authorities, employers, embassies, or any third party. Service fees paid to Placemenet are administrative fees only and do not guarantee issuance, clearance, or acceptance of the certificate.
                        </p>

                        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-lg mt-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <p class="ml-3 text-sm text-amber-700">
                                    <strong>By proceeding with the application</strong>, the applicant confirms acceptance of this disclaimer and full responsibility for the accuracy of the information provided.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <!-- Checkbox -->
                        <label class="flex items-start cursor-pointer flex-1">
                            <input type="checkbox" x-model="accepted" class="mt-1 h-4 w-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                            <span class="ml-2 text-sm text-gray-700">
                                I have read, understood, and accept this disclaimer
                            </span>
                        </label>

                        <!-- Buttons -->
                        <div class="flex gap-3">
                            <a href="{{ route('greece-certificate.index') }}"
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="button"
                                    @click="if(accepted) {
                                        fetch('{{ route('greece-certificate.accept-disclaimer') }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json'
                                            }
                                        }).then(() => showDisclaimer = false);
                                    }"
                                    :disabled="!accepted"
                                    :class="accepted ? 'bg-amber-600 hover:bg-amber-700 cursor-pointer' : 'bg-gray-300 cursor-not-allowed'"
                                    class="px-6 py-2 text-sm font-medium text-white rounded-lg transition shadow-sm">
                                I Accept & Continue
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Existing Draft Applications Notice -->
@if(isset($existingDrafts) && $existingDrafts->count() > 0)
<div class="mb-8 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-xl p-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div class="ml-4 flex-1">
            <h3 class="text-lg font-semibold text-amber-800">You have incomplete applications</h3>
            <p class="mt-1 text-sm text-amber-700">Would you like to continue where you left off?</p>

            <div class="mt-4 space-y-3">
                @foreach($existingDrafts as $draft)
                    <div class="flex items-center justify-between bg-white rounded-lg p-4 border border-amber-200 shadow-sm">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $draft->application_reference }}</p>
                            <p class="text-xs text-gray-500">
                                Started {{ $draft->created_at->diffForHumans() }}
                                @if($draft->first_name)
                                    - {{ $draft->first_name }} {{ $draft->last_name }}
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('greece-certificate.resume', $draft->application_reference) }}"
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Continue
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-t border-amber-200">
                <p class="text-sm text-amber-700">Or start a new application below:</p>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Step 1: Personal Information -->
<div class="space-y-6">
    <!-- Name Fields -->
    <div class="grid md:grid-cols-3 gap-4">
        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                First Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="first_name" id="first_name"
                   value="{{ old('first_name', $application->first_name ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('first_name') border-red-500 @enderror"
                   placeholder="As per passport" required>
            @error('first_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-1">
                Middle Name
            </label>
            <input type="text" name="middle_name" id="middle_name"
                   value="{{ old('middle_name', $application->middle_name ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                   placeholder="If any">
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                Last Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="last_name" id="last_name"
                   value="{{ old('last_name', $application->last_name ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('last_name') border-red-500 @enderror"
                   placeholder="As per passport" required>
            @error('last_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Parents' Names -->
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="father_name" class="block text-sm font-medium text-gray-700 mb-1">
                Father's Full Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="father_name" id="father_name"
                   value="{{ old('father_name', $application->father_name ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('father_name') border-red-500 @enderror"
                   placeholder="Full name as per official documents" required>
            @error('father_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="mother_name" class="block text-sm font-medium text-gray-700 mb-1">
                Mother's Full Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="mother_name" id="mother_name"
                   value="{{ old('mother_name', $application->mother_name ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('mother_name') border-red-500 @enderror"
                   placeholder="Full name as per official documents" required>
            @error('mother_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Gender -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Gender <span class="text-red-500">*</span>
        </label>
        <div class="flex gap-4">
            <label class="inline-flex items-center">
                <input type="radio" name="gender" value="male"
                       {{ old('gender', $application->gender ?? '') == 'male' ? 'checked' : '' }}
                       class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500" required>
                <span class="ml-2 text-gray-700">Male</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="gender" value="female"
                       {{ old('gender', $application->gender ?? '') == 'female' ? 'checked' : '' }}
                       class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500">
                <span class="ml-2 text-gray-700">Female</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="gender" value="other"
                       {{ old('gender', $application->gender ?? '') == 'other' ? 'checked' : '' }}
                       class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500">
                <span class="ml-2 text-gray-700">Other</span>
            </label>
        </div>
        @error('gender')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Date of Birth -->
    <div>
        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">
            Date of Birth <span class="text-red-500">*</span>
        </label>
        @php
            $dobValue = old('date_of_birth');
            if (!$dobValue && isset($application) && $application->date_of_birth) {
                $dobValue = $application->date_of_birth instanceof \Carbon\Carbon
                    ? $application->date_of_birth->format('Y-m-d')
                    : $application->date_of_birth;
            }
        @endphp
        <input type="date" name="date_of_birth" id="date_of_birth"
               value="{{ $dobValue ?? '' }}"
               max="{{ date('Y-m-d') }}"
               class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('date_of_birth') border-red-500 @enderror"
               required>
        @error('date_of_birth')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Place of Birth -->
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="place_of_birth_city" class="block text-sm font-medium text-gray-700 mb-1">
                City of Birth <span class="text-red-500">*</span>
            </label>
            <input type="text" name="place_of_birth_city" id="place_of_birth_city"
                   value="{{ old('place_of_birth_city', $application->place_of_birth_city ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('place_of_birth_city') border-red-500 @enderror"
                   required>
            @error('place_of_birth_city')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="place_of_birth_country" class="block text-sm font-medium text-gray-700 mb-1">
                Country of Birth <span class="text-red-500">*</span>
            </label>
            <input type="text" name="place_of_birth_country" id="place_of_birth_country"
                   value="{{ old('place_of_birth_country', $application->place_of_birth_country ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('place_of_birth_country') border-red-500 @enderror"
                   required>
            @error('place_of_birth_country')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Nationality -->
    <div>
        <label for="nationality" class="block text-sm font-medium text-gray-700 mb-1">
            Nationality <span class="text-red-500">*</span>
        </label>
        <input type="text" name="nationality" id="nationality"
               value="{{ old('nationality', $application->nationality ?? '') }}"
               class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('nationality') border-red-500 @enderror"
               required>
        @error('nationality')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
@endsection
