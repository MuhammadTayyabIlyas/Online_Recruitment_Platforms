@extends('police-certificate.layout')

@section('form-content')
<!-- Step 7: Review & Payment -->
<div class="space-y-6">
    <!-- Service Selection -->
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Service Type</h3>
        
        <div class="grid md:grid-cols-2 gap-4">
            <!-- Normal Service -->
            <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none {{ old('service_type', $application->service_type ?? '') == 'normal' ? 'border-blue-500 ring-2 ring-blue-500' : 'border-gray-300' }}">
                <input type="radio" name="service_type" value="normal" 
                       {{ old('service_type', $application->service_type ?? '') == 'normal' ? 'checked' : '' }}
                       class="sr-only" required onchange="updatePaymentDetails()">
                <span class="flex flex-1">
                    <span class="flex flex-col">
                        <span class="block text-sm font-medium text-gray-900">Normal Service</span>
                        <span class="mt-1 flex items-center text-sm text-gray-500">14 working days</span>
                        <span class="mt-2 text-lg font-bold text-blue-600">£100 / €120</span>
                    </span>
                </span>
                <svg class="h-5 w-5 text-blue-600 {{ old('service_type', $application->service_type ?? '') == 'normal' ? '' : 'invisible' }} check-icon-normal" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </label>

            <!-- Urgent Service -->
            <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none {{ old('service_type', $application->service_type ?? '') == 'urgent' ? 'border-blue-500 ring-2 ring-blue-500' : 'border-gray-300' }}">
                <input type="radio" name="service_type" value="urgent"
                       {{ old('service_type', $application->service_type ?? '') == 'urgent' ? 'checked' : '' }}
                       class="sr-only" onchange="updatePaymentDetails()">
                <span class="flex flex-1">
                    <span class="flex flex-col">
                        <span class="block text-sm font-medium text-gray-900">Urgent Service <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 ml-2">Popular</span></span>
                        <span class="mt-1 flex items-center text-sm text-gray-500">7 working days</span>
                        <span class="mt-2 text-lg font-bold text-blue-600">£150 / €180</span>
                    </span>
                </span>
                <svg class="h-5 w-5 text-blue-600 {{ old('service_type', $application->service_type ?? '') == 'urgent' ? '' : 'invisible' }} check-icon-urgent" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </label>
        </div>
        @error('service_type')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Currency Selection -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Payment Currency <span class="text-red-500">*</span>
        </label>
        <div class="flex gap-4">
            <label class="inline-flex items-center px-4 py-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('payment_currency', $application->payment_currency ?? '') == 'gbp' ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }}">
                <input type="radio" name="payment_currency" value="gbp" 
                       {{ old('payment_currency', $application->payment_currency ?? '') == 'gbp' ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600" required onchange="updatePaymentDetails()">
                <span class="ml-2 font-medium">British Pound (£)</span>
            </label>
            <label class="inline-flex items-center px-4 py-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('payment_currency', $application->payment_currency ?? '') == 'eur' ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }}">
                <input type="radio" name="payment_currency" value="eur"
                       {{ old('payment_currency', $application->payment_currency ?? '') == 'eur' ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600" onchange="updatePaymentDetails()">
                <span class="ml-2 font-medium">Euro (€)</span>
            </label>
        </div>
        @error('payment_currency')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Payment Summary -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <span class="text-gray-700">Service Fee:</span>
            <span id="payment-amount" class="text-2xl font-bold text-blue-700">Select options above</span>
        </div>
        <div class="text-sm text-gray-600">
            <p>You will be able to upload your payment receipt after submitting this application.</p>
        </div>
    </div>

    <!-- Bank Account Details -->
    <div class="bg-white border-2 border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            Bank Transfer Details
        </h3>
        <p class="text-sm text-gray-600 mb-4">Transfer the exact amount to one of the following accounts:</p>

        <!-- GBP Bank Account (Wise) -->
        <div class="bg-gray-50 rounded-lg p-4 mb-4">
            <h4 class="font-medium text-gray-900 mb-3">🇬🇧 GBP Account Details (Wise)</h4>
            <div class="grid grid-cols-2 gap-2 text-sm">
                <span class="text-gray-600">Account Name:</span>
                <span class="font-medium">PLACEMENET I.K.E.</span>
                <span class="text-gray-600">Account Number:</span>
                <span class="font-medium font-mono">21126413</span>
                <span class="text-gray-600">Sort Code:</span>
                <span class="font-medium font-mono">23-08-01</span>
                <span class="text-gray-600">IBAN:</span>
                <span class="font-medium font-mono">GB52 TRWI 2308 0121 1264 13</span>
                <span class="text-gray-600">SWIFT / BIC:</span>
                <span class="font-medium font-mono">TRWIGB2LXXX</span>
                <span class="text-gray-600">Bank:</span>
                <span class="font-medium">Wise Payments Limited</span>
            </div>
            <p class="mt-3 text-xs text-gray-500">
                <strong>UK transfers:</strong> Use Account Number & Sort Code<br>
                <strong>International:</strong> Use IBAN & SWIFT/BIC
            </p>
        </div>

        <!-- EUR Bank Account (Wise) -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-medium text-gray-900 mb-3">🇪🇺 EUR Account Details (Wise)</h4>
            <div class="grid grid-cols-2 gap-2 text-sm">
                <span class="text-gray-600">Account Name:</span>
                <span class="font-medium">PLACEMENET I.K.E.</span>
                <span class="text-gray-600">IBAN:</span>
                <span class="font-medium font-mono">BE10 9677 3176 2104</span>
                <span class="text-gray-600">SWIFT / BIC:</span>
                <span class="font-medium font-mono">TRWIBEB1XXX</span>
                <span class="text-gray-600">Bank:</span>
                <span class="font-medium">Wise, Brussels, Belgium</span>
            </div>
            <p class="mt-3 text-xs text-gray-500">
                <strong>SEPA transfers:</strong> Use IBAN only<br>
                <strong>Outside SEPA:</strong> Use IBAN & SWIFT/BIC
            </p>
        </div>
    </div>

    <!-- Terms & Conditions -->
    <div class="space-y-4">
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input type="checkbox" name="terms_accepted" id="terms_accepted" 
                       {{ old('terms_accepted') ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 @error('terms_accepted') border-red-500 @enderror"
                       required>
            </div>
            <div class="ml-3 text-sm">
                <label for="terms_accepted" class="font-medium text-gray-700">
                    I agree to the <a href="/terms" target="_blank" class="text-blue-600 hover:underline">Terms and Conditions</a> <span class="text-red-500">*</span>
                </label>
                <p class="text-gray-500">I confirm that all information provided is accurate and complete.</p>
            </div>
        </div>
        @error('terms_accepted')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input type="checkbox" name="privacy_accepted" id="privacy_accepted" 
                       {{ old('privacy_accepted') ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 @error('privacy_accepted') border-red-500 @enderror"
                       required>
            </div>
            <div class="ml-3 text-sm">
                <label for="privacy_accepted" class="font-medium text-gray-700">
                    I agree to the <a href="/privacy" target="_blank" class="text-blue-600 hover:underline">Privacy Policy</a> <span class="text-red-500">*</span>
                </label>
                <p class="text-gray-500">I consent to the processing of my personal data for this application.</p>
            </div>
        </div>
        @error('privacy_accepted')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<script>
function updatePaymentDetails() {
    const serviceType = document.querySelector('input[name="service_type"]:checked')?.value;
    const currency = document.querySelector('input[name="payment_currency"]:checked')?.value;
    
    const prices = {
        normal: { gbp: 100, eur: 120 },
        urgent: { gbp: 150, eur: 180 }
    };
    
    const amountDisplay = document.getElementById('payment-amount');
    
    if (serviceType && currency) {
        const amount = prices[serviceType][currency];
        const symbol = currency === 'gbp' ? '£' : '€';
        amountDisplay.textContent = symbol + amount;
    }
    
    // Update checkmark visibility
    document.querySelector('.check-icon-normal').classList.toggle('invisible', serviceType !== 'normal');
    document.querySelector('.check-icon-urgent').classList.toggle('invisible', serviceType !== 'urgent');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', updatePaymentDetails);
</script>
@endsection