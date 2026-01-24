@extends('layouts.app')

@section('title', 'Edit Profile')

<!-- International Phone CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Profile</h1>
        <p class="text-gray-600">Update your personal information</p>
    </div>

    <form action="{{ route('jobseeker.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Email (read-only) -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" value="{{ $user->email }}"
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" disabled>
                    <p class="mt-1 text-xs text-gray-500">Email cannot be changed</p>
                </div>

                <!-- International Phone Number -->
                <div class="md:col-span-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="hidden" name="country_code" id="country_code" value="{{ old('country_code', $user->country_code) }}">
                    <p class="mt-1 text-xs text-gray-500">Select your country code and enter your phone number</p>
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    <div id="phone-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    <div id="phone-valid" class="mt-1 text-sm text-green-600 hidden">✓ Valid phone number</div>
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth"
                           value="{{ old('date_of_birth', $user->profile?->date_of_birth?->format('Y-m-d')) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('date_of_birth') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Passport Number -->
            <div class="mt-6">
                <label for="passport_number" class="block text-sm font-medium text-gray-700">Passport Number</label>
                <input type="text" name="passport_number" id="passport_number" value="{{ old('passport_number', $user->profile?->passport_number) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('passport_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Bio -->
            <div class="mt-6">
                <label for="bio" class="block text-sm font-medium text-gray-700">Professional Summary</label>
                <textarea name="bio" id="bio" rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          placeholder="Write a brief professional summary about yourself...">{{ old('bio', $user->profile?->bio) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Max 1000 characters</p>
                @error('bio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Location -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Location</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    @php
                        $locationParts = $user->profile?->location ? explode(', ', $user->profile->location) : [];
                        $city = $locationParts[0] ?? '';
                        $oldCountry = $locationParts[1] ?? '';
                    @endphp
                    <input type="text" name="city" id="city" value="{{ old('city', $city) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="e.g., New York, Karachi, London">
                    @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Country of Residence -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700">Country of Residence</label>
                    <select name="country" id="country"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select Country</option>
                        @php
                        $countries = [
                            'AF' => 'Afghanistan', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AR' => 'Argentina',
                            'AU' => 'Australia', 'AT' => 'Austria', 'BD' => 'Bangladesh', 'BE' => 'Belgium',
                            'BR' => 'Brazil', 'CA' => 'Canada', 'CN' => 'China', 'CO' => 'Colombia',
                            'DK' => 'Denmark', 'EG' => 'Egypt', 'FR' => 'France', 'DE' => 'Germany',
                            'GR' => 'Greece', 'HK' => 'Hong Kong', 'IN' => 'India', 'ID' => 'Indonesia',
                            'IE' => 'Ireland', 'IT' => 'Italy', 'JP' => 'Japan', 'KE' => 'Kenya',
                            'MY' => 'Malaysia', 'MX' => 'Mexico', 'NL' => 'Netherlands', 'NZ' => 'New Zealand',
                            'NG' => 'Nigeria', 'NO' => 'Norway', 'PK' => 'Pakistan', 'PH' => 'Philippines',
                            'PL' => 'Poland', 'PT' => 'Portugal', 'RU' => 'Russia', 'SA' => 'Saudi Arabia',
                            'SG' => 'Singapore', 'ZA' => 'South Africa', 'KR' => 'South Korea', 'ES' => 'Spain',
                            'LK' => 'Sri Lanka', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'TH' => 'Thailand',
                            'TR' => 'Turkey', 'AE' => 'UAE', 'GB' => 'United Kingdom', 'US' => 'United States',
                            'VN' => 'Vietnam'
                        ];
                        $selectedCountryIso = old('country_iso', $user->profile?->country_iso);
                        @endphp
                        @foreach($countries as $code => $name)
                            <option value="{{ $code }}" {{ $selectedCountryIso == $code ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="country_iso" id="country_iso" value="{{ $selectedCountryIso }}">
                    @error('country') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Profile Photo -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Profile Photo</h2>

            <div class="flex items-center space-x-6">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile" class="w-20 h-20 rounded-full object-cover">
                @else
                    <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="text-2xl font-medium text-gray-500">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif

                <div>
                    <label for="avatar" class="block text-sm font-medium text-gray-700">Upload new photo</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*"
                           class="mt-1 block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF up to 2MB</p>
                    @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center">
            <a href="{{ route('jobseeker.profile.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
            <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                Save Changes
            </button>
        </div>
    </form>
</div>

<!-- International Phone JS -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.querySelector("#phone");
    const countryCodeInput = document.querySelector("#country_code");
    const phoneError = document.querySelector("#phone-error");
    const phoneValid = document.querySelector("#phone-valid");
    const countrySelect = document.querySelector("#country");
    const countryIsoInput = document.querySelector("#country_iso");

    // Initialize intl-tel-input
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "{{ $user->country_code ?? 'us' }}",
        preferredCountries: ['us', 'gb', 'pk', 'in', 'ae'],
        separateDialCode: true,
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
    });

    // Update hidden country code field when country changes
    phoneInput.addEventListener('countrychange', function() {
        const countryData = iti.getSelectedCountryData();
        countryCodeInput.value = countryData.iso2.toUpperCase();
    });

    // Validate phone on input
    phoneInput.addEventListener('blur', function() {
        phoneError.classList.add('hidden');
        phoneValid.classList.add('hidden');

        if (phoneInput.value.trim()) {
            if (iti.isValidNumber()) {
                phoneValid.classList.remove('hidden');
                phoneInput.classList.remove('border-red-500');
                phoneInput.classList.add('border-green-500');
            } else {
                phoneError.textContent = 'Please enter a valid phone number for the selected country';
                phoneError.classList.remove('hidden');
                phoneInput.classList.add('border-red-500');
                phoneInput.classList.remove('border-green-500');
            }
        } else {
            phoneInput.classList.remove('border-red-500', 'border-green-500');
        }
    });

    // Format phone number on form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (phoneInput.value.trim() && iti.isValidNumber()) {
            // Store in E.164 format
            phoneInput.value = iti.getNumber();
        }
    });

    // Handle country dropdown change
    countrySelect.addEventListener('change', function() {
        countryIsoInput.value = this.value;
    });
});
</script>
@endsection
