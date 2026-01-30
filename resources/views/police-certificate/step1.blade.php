@extends('police-certificate.layout')

@section('form-content')
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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror"
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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="If any">
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                Last Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="last_name" id="last_name" 
                   value="{{ old('last_name', $application->last_name ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror"
                   placeholder="As per passport" required>
            @error('last_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Father's Name -->
    <div>
        <label for="father_full_name" class="block text-sm font-medium text-gray-700 mb-1">
            Father's Full Name <span class="text-red-500">*</span>
        </label>
        <input type="text" name="father_full_name" id="father_full_name" 
               value="{{ old('father_full_name', $application->father_full_name ?? '') }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('father_full_name') border-red-500 @enderror"
               placeholder="Full name as per official documents" required>
        @error('father_full_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
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
                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                <span class="ml-2 text-gray-700">Male</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="gender" value="female"
                       {{ old('gender', $application->gender ?? '') == 'female' ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <span class="ml-2 text-gray-700">Female</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="gender" value="other"
                       {{ old('gender', $application->gender ?? '') == 'other' ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
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
        <input type="date" name="date_of_birth" id="date_of_birth" 
               value="{{ old('date_of_birth', $application->date_of_birth ?? '') }}"
               class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_of_birth') border-red-500 @enderror"
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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('place_of_birth_city') border-red-500 @enderror"
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
                   value="{{ old('place_of_birth_country', $application->place_of_birth_country ?? 'Pakistan') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('place_of_birth_country') border-red-500 @enderror"
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
               value="{{ old('nationality', $application->nationality ?? 'Pakistani') }}"
               class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nationality') border-red-500 @enderror"
               required>
        @error('nationality')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Marital Status -->
    <div>
        <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-1">
            Marital Status <span class="text-red-500">*</span>
        </label>
        <select name="marital_status" id="marital_status" 
                class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('marital_status') border-red-500 @enderror"
                required>
            <option value="">Select status</option>
            <option value="single" {{ old('marital_status', $application->marital_status ?? '') == 'single' ? 'selected' : '' }}>Single</option>
            <option value="married" {{ old('marital_status', $application->marital_status ?? '') == 'married' ? 'selected' : '' }}>Married</option>
            <option value="divorced" {{ old('marital_status', $application->marital_status ?? '') == 'divorced' ? 'selected' : '' }}>Divorced</option>
            <option value="widowed" {{ old('marital_status', $application->marital_status ?? '') == 'widowed' ? 'selected' : '' }}>Widowed</option>
        </select>
        @error('marital_status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
@endsection