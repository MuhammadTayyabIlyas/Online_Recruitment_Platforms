@extends('greece-certificate.layout')

@section('form-content')
<!-- Step 7: Service & Payment -->
<div class="space-y-6">

    <!-- Review Your Information -->
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden" x-data="{ expanded: false }">
        <button type="button" @click="expanded = !expanded"
                class="w-full flex items-center justify-between px-6 py-4 bg-gradient-to-r from-amber-50 to-yellow-50 hover:from-amber-100 hover:to-yellow-100 transition min-h-[48px]">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span class="text-lg font-semibold text-gray-900">Review Your Information</span>
            </div>
            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="expanded" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="px-6 pb-6">
            <!-- Step 1: Personal Information -->
            <div class="py-4 border-b border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Personal Information</h4>
                    <a href="{{ route('greece-certificate.step', ['step' => 1]) }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium min-h-[44px] flex items-center">Edit</a>
                </div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                    <div>
                        <span class="text-gray-500">Name:</span>
                        <span class="text-gray-900 font-medium">{{ $application->first_name }} {{ $application->middle_name }} {{ $application->last_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Gender:</span>
                        <span class="text-gray-900 font-medium">{{ ucfirst($application->gender ?? '') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Date of Birth:</span>
                        <span class="text-gray-900 font-medium">{{ $application->date_of_birth?->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Nationality:</span>
                        <span class="text-gray-900 font-medium">{{ $application->nationality }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Place of Birth:</span>
                        <span class="text-gray-900 font-medium">{{ $application->place_of_birth_city }}, {{ $application->place_of_birth_country }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Father's Name:</span>
                        <span class="text-gray-900 font-medium">{{ $application->father_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Mother's Name:</span>
                        <span class="text-gray-900 font-medium">{{ $application->mother_name }}</span>
                    </div>
                </div>
            </div>

            <!-- Step 2: Passport -->
            <div class="py-4 border-b border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Identification Documents</h4>
                    <a href="{{ route('greece-certificate.step', ['step' => 2]) }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium min-h-[44px] flex items-center">Edit</a>
                </div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                    <div>
                        <span class="text-gray-500">Passport No:</span>
                        <span class="text-gray-900 font-medium font-mono">{{ $application->passport_number }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Place of Issue:</span>
                        <span class="text-gray-900 font-medium">{{ $application->passport_place_of_issue }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Issue Date:</span>
                        <span class="text-gray-900 font-medium">{{ $application->passport_issue_date?->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Expiry Date:</span>
                        <span class="text-gray-900 font-medium">{{ $application->passport_expiry_date?->format('d/m/Y') }}</span>
                    </div>
                    @if($application->greece_afm)
                    <div>
                        <span class="text-gray-500">AFM:</span>
                        <span class="text-gray-900 font-medium font-mono">{{ $application->greece_afm }}</span>
                    </div>
                    @endif
                    @if($application->greece_amka)
                    <div>
                        <span class="text-gray-500">AMKA:</span>
                        <span class="text-gray-900 font-medium font-mono">{{ $application->greece_amka }}</span>
                    </div>
                    @endif
                    @php
                        $docCount = $application->documents()->whereIn('document_type', ['passport_front', 'passport_back', 'passport', 'residence_permit'])->count();
                    @endphp
                    <div>
                        <span class="text-gray-500">Documents:</span>
                        <span class="text-green-700 font-medium">{{ $docCount }} uploaded</span>
                    </div>
                </div>
            </div>

            <!-- Step 3: Residence History -->
            <div class="py-4 border-b border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Greece Residence History</h4>
                    <a href="{{ route('greece-certificate.step', ['step' => 3]) }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium min-h-[44px] flex items-center">Edit</a>
                </div>
                @if(is_array($application->greece_residence_history))
                <div class="space-y-2 text-sm">
                    @foreach($application->greece_residence_history as $residence)
                    <div class="bg-gray-50 rounded p-2">
                        <span class="text-gray-900 font-medium">{{ $residence['address'] ?? '' }}, {{ $residence['city'] ?? '' }}</span>
                        <span class="text-gray-500 text-xs block">{{ $residence['from_date'] ?? '' }} - {{ $residence['to_date'] ?? 'Present' }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Step 4: Address -->
            <div class="py-4 border-b border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Current Address</h4>
                    <a href="{{ route('greece-certificate.step', ['step' => 4]) }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium min-h-[44px] flex items-center">Edit</a>
                </div>
                <p class="text-sm text-gray-900">
                    {{ $application->current_address_line1 }}
                    @if($application->current_address_line2), {{ $application->current_address_line2 }}@endif<br>
                    {{ $application->current_city }}, {{ $application->current_postal_code }}, {{ $application->current_country }}
                </p>
            </div>

            <!-- Step 5: Contact -->
            <div class="py-4 border-b border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Contact Information</h4>
                    <a href="{{ route('greece-certificate.step', ['step' => 5]) }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium min-h-[44px] flex items-center">Edit</a>
                </div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                    <div>
                        <span class="text-gray-500">Email:</span>
                        <span class="text-gray-900 font-medium">{{ $application->email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Phone:</span>
                        <span class="text-gray-900 font-medium">{{ $application->phone_number }}</span>
                    </div>
                    @if($application->whatsapp_number)
                    <div>
                        <span class="text-gray-500">WhatsApp:</span>
                        <span class="text-gray-900 font-medium">{{ $application->whatsapp_number }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Step 6: Authorization -->
            <div class="py-4">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Authorization Letter</h4>
                    <a href="{{ route('greece-certificate.step', ['step' => 6]) }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium min-h-[44px] flex items-center">Edit</a>
                </div>
                <div class="text-sm">
                    @if($application->signature_method === 'drawn')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Digitally Signed
                        </span>
                        @if($application->signature_place)
                            <span class="text-gray-500 ml-2">at {{ $application->signature_place }}</span>
                        @endif
                    @elseif($application->authorization_letter_uploaded)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Uploaded
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Certificate Purpose -->
    <div class="bg-amber-50 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Certificate Purpose</h3>
        <p class="text-sm text-gray-600">Please indicate why you need this certificate.</p>
    </div>

    <div>
        <label for="certificate_purpose" class="block text-sm font-medium text-gray-700 mb-1">
            Purpose of Certificate <span class="text-red-500">*</span>
        </label>
        <select name="certificate_purpose" id="certificate_purpose"
                class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('certificate_purpose') border-red-500 @enderror"
                required>
            <option value="">Select purpose</option>
            <option value="employment" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'employment' ? 'selected' : '' }}>Employment</option>
            <option value="immigration" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'immigration' ? 'selected' : '' }}>Immigration</option>
            <option value="visa" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'visa' ? 'selected' : '' }}>Visa Application</option>
            <option value="residency" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'residency' ? 'selected' : '' }}>Residency Permit</option>
            <option value="education" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'education' ? 'selected' : '' }}>Education/Study</option>
            <option value="adoption" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'adoption' ? 'selected' : '' }}>Adoption</option>
            <option value="other" {{ old('certificate_purpose', $application->certificate_purpose ?? '') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('certificate_purpose')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="purpose_details" class="block text-sm font-medium text-gray-700 mb-1">
            Additional Details
        </label>
        <textarea name="purpose_details" id="purpose_details" rows="2"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                  placeholder="Any additional information about why you need this certificate">{{ old('purpose_details', $application->purpose_details ?? '') }}</textarea>
    </div>

    <!-- Service Type Selection -->
    <div class="bg-amber-50 rounded-lg p-4 mt-8 mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Select Service Type</h3>
        <p class="text-sm text-gray-600">Choose the processing speed that suits your needs.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-4" x-data="{ serviceType: '{{ old('service_type', $application->service_type ?? '') }}' }">
        <!-- Normal Service -->
        <label class="relative cursor-pointer">
            <input type="radio" name="service_type" value="normal" x-model="serviceType" class="sr-only peer" required>
            <div class="p-6 border-2 rounded-xl transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-amber-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Normal Service</h4>
                        <p class="text-sm text-gray-600">Up to 30 days</p>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-gray-900">250</span>
                        <span class="text-sm text-gray-600">EUR</span>
                    </div>
                </div>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Full application handling
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Email support
                    </li>
                </ul>
            </div>
        </label>

        <!-- Urgent Service -->
        <label class="relative cursor-pointer">
            <input type="radio" name="service_type" value="urgent" x-model="serviceType" class="sr-only peer">
            <div class="p-6 border-2 rounded-xl transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-amber-300 relative overflow-hidden">
                <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded-full">
                    FASTER
                </div>
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Urgent Service</h4>
                        <p class="text-sm text-gray-600">15-20 days</p>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-gray-900">350</span>
                        <span class="text-sm text-gray-600">EUR</span>
                    </div>
                </div>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Priority processing
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Dedicated case handler
                    </li>
                </ul>
            </div>
        </label>
    </div>
    @error('service_type')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror

    <!-- Payment Information -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Payment Instructions
        </h3>
        <p class="text-sm text-gray-700 mb-4">After submitting your application, you will need to make a bank transfer to complete the process.</p>
        <div class="bg-white rounded-lg p-4 text-sm">
            <p class="mb-2"><strong>Bank:</strong> Wise</p>
            <p class="mb-2"><strong>Account Name:</strong> PLACEMENET I.K.E.</p>
            <p class="mb-2"><strong>IBAN:</strong> BE10 9677 3176 2104</p>
            <p class="mb-2"><strong>BIC/SWIFT:</strong> TRWIBEB1XXX</p>
            <p><strong>Reference:</strong> Your application reference will be shown after submission</p>
        </div>
    </div>

    <!-- Terms & Conditions -->
    <div class="space-y-4 mt-8">
        <label class="flex items-start cursor-pointer">
            <input type="checkbox" name="terms_accepted" value="1"
                   class="mt-1 h-4 w-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500 @error('terms_accepted') border-red-500 @enderror"
                   required>
            <span class="ml-2 text-sm text-gray-700">
                I accept the <a href="{{ route('privacy') }}" target="_blank" class="text-amber-600 hover:underline">Terms and Conditions</a> and confirm that all information provided is accurate. <span class="text-red-500">*</span>
            </span>
        </label>
        @error('terms_accepted')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        <label class="flex items-start cursor-pointer">
            <input type="checkbox" name="privacy_accepted" value="1"
                   class="mt-1 h-4 w-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500 @error('privacy_accepted') border-red-500 @enderror"
                   required>
            <span class="ml-2 text-sm text-gray-700">
                I consent to the processing of my personal data as described in the <a href="{{ route('privacy') }}" target="_blank" class="text-amber-600 hover:underline">Privacy Policy</a>. <span class="text-red-500">*</span>
            </span>
        </label>
        @error('privacy_accepted')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <input type="hidden" name="payment_currency" value="eur">
</div>
@endsection
